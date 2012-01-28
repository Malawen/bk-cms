<?php
/** 
 * @since r1
 * @lastchange r3
 */
?>
<?php
  global $template;
  $template = array(  "path" => BK_PATH.BK_PATH_TEMPLATE.SETTING_TEMPLATE_NAME.BK_PATH_SEPERATOR,
                      "cssfile" => array(),
                      "css" => array(),
                      "jsfile" => array(),
                      "js" => array());
  
  function bk_template_function() {
    
    global $template;
    $file = $template["path"].BK_TEMPLATE_FUNCTION;
    
    if(file_exists($file)) include($file);
  }
  
  function bk_template_call() {
    global $template;
    $file = $template["path"].BK_TEMPLATE_FIX;
    
    if(file_exists($file)) include($file);
  }
  
  //JS
  function add_js($js) {
    global $template;
    
    $i = count($template["js"]);

    $template["js"][$i] = $js;
  }
  
  function add_jsfile($file, $prio = 50) {
    global $template;
    
    $template["jsfile"][$prio][] = bk_complete_url($file);
  }
  
  function out_jsfile() {
    global $template;
    
    foreach($template["jsfile"] as $js) {
      foreach($js as $js2) {
        echo "<script type='text/javascript' src='$js2'></script>\r";
      }
    }  
  }
  
  function out_js() {
    global $template;
    
    if (!empty($template["js"])) {
      echo "<script type='text/javascript'>\r";
      for($i = 0; $i < count($template["js"]); $i++) {
        echo "{$template["js"][$i]}\r";
      }
      echo "</script>\r";
    }
  }
  
  //CSS
  function add_css($css) {
    global $template;
    
    $i = count($template["css"]);

    $template["css"][$i] = $css;
  }
  
  function add_cssfile($file, $prio = 50) {
    global $template;
    
    $template["cssfile"][$prio][] = bk_complete_url($file);
  }
  
  function out_cssfile() {
    global $template;
    
    foreach($template["cssfile"] as $css) {
      foreach($css as $css2) {
        echo "<link href='$css2' rel='stylesheet' type='text/css' />\r";
      }
    }  
  }
  
  function out_css() {
    global $template;
    
    if(!empty($template["css"])) {
      echo "<style type='text/css'>\r";
      for($i = 0; $i < count($template["css"]); $i++) {
        echo "{$template["css"][$i]}\r";
      }
      echo "</style>\r";
    }
  }
  
  function out_content() {
    global $template;
    
    if(!empty($_GET["template"])) $content = $_GET["template"];
    elseif(!empty($_GET["page"])) {
      $content = "page";
      $nr = $_GET["page"];
    }
    elseif(!empty($_GET["post"])) $content = "post";
    elseif(!empty($_GET["cat"])) {
      $content = "cat";
      $nr = $_GET["cat"];
    }
    else $content = "home";
    
    $file = $template["path"].$content.".php";
    
    if(file_exists($file)) include($file);
  }
?>