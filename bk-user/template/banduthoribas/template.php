<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php out_jsfile(); ?>
<?php out_cssfile(); ?>
<?php out_css(); ?>
</head>
<body>
<div id="header"></div>
<?php get_menu(1, "menu"); ?>
<div id="content"><?php out_content(); ?></div>
</body>
</html>