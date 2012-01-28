<?php
/** 
 * @since r1
 * @lastchage r2
 */
?>
<?php
  $plugin = array(  "func" => array(),
                    "name" => array(),
                    "nr" => 0);
                    

  function init_plugin($funcname, $prio = 50, $triggertyp = NULL, $trigger = NULL, $triggervalue = NULL) {
    global $plugin;
    
    $plugin["func"]["$prio"][$plugin["nr"]]["funcname"] = $funcname;
    $plugin["func"]["$prio"][$plugin["nr"]]["triggertyp"] = $triggertyp;
    $plugin["func"]["$prio"][$plugin["nr"]]["trigger"] = $trigger;
    $plugin["func"]["$prio"][$plugin["nr"]]["triggervalue"] = $triggervalue;
    
    $plugin["nr"]++;
  }
  
  function exe_plugin() {
    global $plugin;
    
    krsort($plugin["func"]);
    foreach($plugin["func"] as $p) {
      foreach($p as $f) {
        if(plugin_trigger($f["triggertyp"], $f["trigger"], $f["triggervalue"]) == true) {
          $func = "{$f["funcname"]}"; 
          $func();
        }
      }
    }
  }
  
  function plugin_trigger($typ, $trigger, $triggervalue) {
    switch($typ) {
      case "get":
      case "GET":
        if(isset($_GET[$trigger]) && ($triggervalue == NULL || $_GET[$trigger] == $triggervalue))
          return true;
        else
            return false;
      break;
      
      case "post":
      case "POST":
        if(isset($_POST[$trigger]) && ($triggervalue == NULL || $_POST[$trigger] == $triggervalue))
            return true;
        else
            return false;
      break;
      
      default:
        return true;
      break;
    }
  }
  
  function inc_plugin() {
    include("plugin/inc-plugins.php");
  }
  
  function inc_lib() {
    include("lib/inc-lib.php");
  }
?>