<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php out_jsfile(); ?>
<?php out_cssfile(); ?>
<?php out_css(); ?>
</head>
<body>
<div id="headline"><a class="headline">Evangelische Kirchengemeinde Bad K&ouml;nig</a></div>
<div id="headpic"></div>
<?php get_menu(1, "mainmenu"); ?>
<div id="bigcontent">
<?php get_menu_by_cat("catmenu"); ?>
<div id="content">
<?php out_content(); ?>
</div>
<img src="<?php echo BK_URL; ?>/bk-user/template/badkoenig/img/facettenkreuz.jpg" id="facettenkreuz" />
</div>
<?php get_menu(2, "submenu"); ?>
</body>
</html>