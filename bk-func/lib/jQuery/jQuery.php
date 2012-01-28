<?php
/**
 * @lib jQuery
 * @since r4
 * @lastchange r4 
 */
?>
<?php
  function jQuery($ui = true, $template = true, $templatePath = "") {
    $url = BK_URL."/bk-func/lib/jQuery/";
    
    $jquery = "jquery-1.5.1.js";
    $jqueryUi = "jquery-ui-1.8.11.js";
    if(!empty($templatePath))$jqueryUiTemplate = $templatePath;
    else $jqueryUiTemplate = $url."jquery-ui-1.8.11.bk.css";
    
    echo "<script type=\"text/javascript\" src=\"$url$jquery\"></script>\r";
    if($ui) echo "<script type=\"text/javascript\" src=\"$url$jqueryUi\"></script>\r";
    if($template) echo "<link href=\"$jqueryUiTemplate\" rel=\"stylesheet\" type=\"text/css\" />\r";
  }
?>