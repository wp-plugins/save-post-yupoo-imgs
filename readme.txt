=== Save Post Yupoo Imgs ===
Contributors: xiaoxu125634
Donate link: http://www.brunoxu.com/
Tags: yupoo, images, save yupoo images, save post yupoo images, 又拍图片下载, 又拍图片保存, 又拍图片流量超过
Requires at least: 3.0
Tested up to: 4.0
Stable tag: trunk

文章中如果有又拍(yupoo)图片引用，先保存到本地目录，再更新数据库中数据，永久改变图片引用地址。

== Description ==

[插件首页](http://www.brunoxu.com/save-post-yupoo-imgs.html) | [插件作者](http://www.brunoxu.com/)

前面做了<a href="http://www.brunoxu.com/save-yupoo-imgs-to-local.html" target="_blank">Save Yupoo Imgs To Local</a>插件，可以保存又拍图片到本地，页面显示的时候替换成本地地址，文章的实际内容没变，还是引用的yupoo图片，换种说法是数据库中的数据没变，如果需要永久改成文章中的Yupoo图片引用地址，就需要用到文中的SQL语句了。

而Save Post Yupoo Imgs插件加入了更新图片引用地址的功能，也可以说是自带了SQL语句的功能，对于确定脱离yupoo的朋友来说，可以用这个插件。

两个插件还有一个差别在于涉及图片的范围，Save Yupoo Imgs To Local插件能做到"所有页面+全页面"检查并下载到本地，而Save Post Yupoo Imgs只能做到"文章页+文章内容"检查并下载到本地，原因在于Save Post Yupoo Imgs需要更新文章实际内容，只能绑定到文章页进行处理。

PS: 文中说的文章页，包含post和page。

== Installation ==

1. Upload `save-post-yupoo-imgs` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress background.

== Changelog ==

= 1.0 =
* 2014-09-03
* Plugin released.
