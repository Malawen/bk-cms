<div class="cattpl_content"><?php get_cat("info"); ?></div>
<div class="cattpl_news">
<?php
if(get_cat("ID", R) != 1) get_blog(5, get_cat("ID", R));
else get_blog(15, "");
?>
</div>