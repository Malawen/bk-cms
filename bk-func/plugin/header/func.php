<?php
/**
 * @plugin header
 * @since r1
 * @lastchange r2
 */
?>
<?php

  init_plugin("get_header_by_cat", 50, "get", "cat");
  function get_header_by_cat() {
    $pic = get_cat("headerpic", R);
    
    if(!empty($pic))
      $css = "#headpic { background-image: url(".bk_complete_url(BK_PATH_TEMPLATE.SETTING_TEMPLATE_NAME."/banner/$pic")."); }";
    
    add_css($css);
    
    add_jsfile("./bk-func/plugin/header/headerswitch.js");
  }

?>