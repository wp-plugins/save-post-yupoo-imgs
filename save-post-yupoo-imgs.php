<?php
/*
Plugin Name: Save Post Yupoo Imgs
Plugin URI: http://www.brunoxu.com/save-post-yupoo-imgs.html
Description: 文章中如果有又拍(yupoo)图片引用，先保存到本地目录，再更新数据库中数据，永久改变图片引用地址。
Author: Bruno Xu
Author URI: http://www.brunoxu.com/
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

$upload_dir = wp_upload_dir();
$save_post_yupoo_imgs_path = $upload_dir['basedir'] . '/yupoo_imgs/';
$save_post_yupoo_imgs_purl = $upload_dir['baseurl'] . '/yupoo_imgs/';

add_filter('the_content', 'save_post_yupoo_imgs_handler', 0);
function save_post_yupoo_imgs_handler($post_content) {
	if ( !(is_single() || is_page()) ) {
		return $post_content;
	}

	if (stripos($post_content, 'http://pic.yupoo.com/') === FALSE) {
		return $post_content;
	}

	global $wpdb,$save_post_yupoo_imgs_purl,$post;

	$content = $post_content;

	$regexp = "/<a[^<>]+href=['\"](http:\/\/pic.yupoo.com\/[^'\"]+)['\"][^<>]*>/i";
	$content = preg_replace_callback(
		$regexp,
		"save_post_yupoo_imgs_str_handler",
		$content
	);

	$regexp = "/<img[^<>]+src=['\"](http:\/\/pic.yupoo.com\/[^'\"]+)['\"][^<>]*>/i";
	$content = preg_replace_callback(
		$regexp,
		"save_post_yupoo_imgs_str_handler",
		$content
	);

	if ($post_content != $content) {
		$post_content = $content;

		$wpdb->query("
		UPDATE `$wpdb->posts`
		SET post_content=REPLACE(post_content,'http://pic.yupoo.com/','$save_post_yupoo_imgs_purl')
		WHERE ID=$post->ID
		");
	}

	return $post_content;
}

function save_post_yupoo_imgs_str_handler($matches)
{	
	$str = $matches[0];
	$img_src = $matches[1];
	$newimg_src = save_post_yupoo_imgs_str_handler_2($img_src);
	
	if ($img_src == $newimg_src) {
		return $str;
	} else {
		return str_replace($img_src, $newimg_src, $str);
	}
}

/*
a  http://pic.yupoo.com/xiaoxu125634/Cw6swQp5/ZQTxk.jpg
img  http://pic.yupoo.com/xiaoxu125634/Cw6swQp5/medium.jpg
*/
function save_post_yupoo_imgs_str_handler_2($img_src)
{
	global $save_post_yupoo_imgs_path, $save_post_yupoo_imgs_purl;

	$newimg_subname = str_ireplace('http://pic.yupoo.com/','',$img_src); 
	$newimg_path = $save_post_yupoo_imgs_path.$newimg_subname;
	$newimg_src = $save_post_yupoo_imgs_purl.$newimg_subname;
	$newimg_folder = substr($newimg_path, 0, strrpos($newimg_path,'/')+1);

	if (file_exists($newimg_path)) {
		return $newimg_src;
	}

	if (! file_exists($newimg_folder)) {
		mkdir($newimg_folder, 0755, true);
	}
	$get_file = file_get_contents($img_src);
	if (! $get_file) {
		return $img_src;
	}
	$fp = fopen($newimg_path, 'w');
	fwrite($fp, $get_file);
	fclose($fp);

	return $newimg_src;
}
