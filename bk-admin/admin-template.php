<?php
/** 
 * @since r1
 * @lastchage r4
 */
?>
<?php

// START - Template

  function admin_template_login() {
    add_cssfile(ADMIN_URL.BK_URL_SEPERATOR.ADMIN_CSSFILE);
    ?>
      <?php admin_template_header(); ?>
      <?php #error("login_userpass"); ?> <!--TODO:Fehlerausgabe-->
      <div class="admin_login">
      <img class="admin_login_logo" src="<?php echo ADMIN_URL.BK_URL_SEPERATOR.ADMIN_IMG_PATH.BK_URL_SEPERATOR.ADMIN_LOGO; ?>" />
      <form method="post">
      <div class="admin_user_login">
      <label for="<?php echo BK_POST_LOGIN_USERNAME; ?>" class="admin_user_login">Benutzer</label><br />
      <input type="text" name="<?php echo BK_POST_LOGIN_USERNAME; ?>" value="<?php echo $_POST[BK_POST_LOGIN_USERNAME]; ?>" id="admin_user_login" class="admin_user_login" />
      </div>
      <div class="admin_user_password">
      <label for="<?php echo BK_POST_LOGIN_PASSWORD; ?>" class="admin_user_password">Passwort</label><br />
      <input type="password" name="<?php echo BK_POST_LOGIN_PASSWORD; ?>" value="<?php echo $_POST[BK_POST_LOGIN_PASSWORD]; ?>" id="admin_user_password" class="admin_user_password" />
      </div>
      <input type="submit" name="<?php echo BK_POST_LOGIN_SUBMIT; ?>" value="Login" id="admin_user_submit" class="admin_user_submit" /> <!--TODO:Value in Settings-->
      </form>
      </div>
      <?php admin_template_footer(); ?>
    <?php
  }
  
  function admin_template_header() {
    ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Administration</title> <!--TODO:Titel in Settings aufnehmen-->
<?php
 jQuery();
 out_jsfile();
 out_js();
 out_cssfile();
 out_css(); ?>
</head>
<body>
<div class="admin_headerbar">
<?php back_to_mainpage_link(); ?>
<?php admin_user_link(); ?>
</div>
<?php
  }
  
  function admin_template_footer() {
    ?>
</body>
</html>
<?php
  }

  function admin_template_index() {
    add_cssfile(ADMIN_URL.BK_URL_SEPERATOR.ADMIN_CSSFILE);
    //add_js("function initDocLoad() {\r  for(var i = 0; i < onloadFunc.length; i++) {\r    ret = eval(onloadFunc[i]);\r  }\r}");
    global $admin_tab;
    
    admin_template_header();
    ?>
      <div id="admin-overallcontent">
      <?php adminMenuBuild("adminMenu"); ?>
      <div id="admin-content">
      <?php adminContentBuild(); ?>
      </div>
      <?php #if(!empty($admin_tab)) echo $admin_tab; ?>
      <div class="clear-left"><!-- left --></div>
      </div>
      
    <?php
    
    admin_template_footer();
  }
  
  function adminContentBuild() {
    global $adminMenuGet;
    
    if(!empty($adminMenuGet[0])) {
      $func = (string)$adminMenuGet[0];
      $func();
    }
  }
  
  /*
  //Alte Funktion zur Ausgabe des Content
  function admin_content_build() {
    //TODO: Berechtigung prüfen, ob die Funktion ausgeführt werden darf
    if(isset($_GET[ADMIN_GET_MENU_FUNC]) && !empty($_GET[ADMIN_GET_MENU_FUNC])) {
      $func = (string)$_GET[ADMIN_GET_MENU_FUNC];
      $func();
    }
  }
  */
  
// END - Template
// START - MenüNeu ### Klasse und Hilfsfunktionen für das Administrations Menü 
  class adminContentmenu {
    private $bez;
    private $child;
    private $children;
    private $func;
    private $link;
    
    public function __construct($bez, $func = "", $link = "") {
      $this->bez = $bez;
      $this->child = array();
      $this->children = 0;
      $this->func = $func;
      $this->link = $this->linkGen($func, $link);
    }
    
    public function newChild($bez, $func = "", $parents = array()) {
      if(!empty($parents)) {
        $parentName = array_shift($parents);
      } else {
        $parentName = NULL;
      }
      if($parentName != NULL && isset($this->child[$parentName])) {
        return $this->child[$parentName]->newChild($bez, $func, $parents);
      } elseif($parentName != NULL && !isset($this->child[$parentName])) {
        return FALSE;
      } else {
        $this->child[$this->children] = new adminContentmenu($bez, $func, $this->link);
        $this->child[$bez] = &$this->child[$this->children]; 
        $this->children++;
        return TRUE;
      }
    }
    
    public function output($id, $echoRoot = FALSE, $echoFirst = TRUE, $idMod = 0) {
      if($echoFirst) echo "<div id=\"$id\">\r";
      if($echoRoot) {
        echo "<a class=\"$id$idMod\" href=\"$this->link\">$this->bez</a>\r";
      }
      $idMod++;
      for($i = 0; $i < $this->children; $i++) {
        $this->child[$i]->output($id, TRUE, FALSE, $idMod);
      }
      if($echoFirst) echo "</div>\r";     
    }
    
    private function linkGen($func, $link) {
      if($link == "javascript: return false;") $link = "";
      if(empty($link) && !empty($func)) {
        $link = ADMIN_URL.BK_URL_SEPERATOR."?".ADMIN_GET_MENU_FUNC."=".$func;
      } elseif(!empty($link) && !empty($func)) {
        $link .= ";".$func;
      } elseif(empty($func) && !empty($link)) {
        $link = $link;
      } else {        
        $link = "javascript: return false;";
      }
      return $link;
    }
  }  

  /**
   * @name adminMenuInit
   * @functype Hilfsfunktion - class adminContentmenu
   * @param $bez - Name des Menüeintrags
   * @param $func - Name der auszuführenden php-Funktion
   * @param $parents - Namen der übergeordneten Menüeintrage als Array
   * 
   * Erstellt einen neuen Menüeintrag.
   * Wenn noch kein Menüeintrag existiert, wird das Menü neu angelegt.
   */
  function adminMenuInit($bez, $func = "", $parents = array()) {
    global $adminMenu;
    if(empty($adminMenu)) $adminMenu = new adminContentmenu("Administration Menü");
    $adminMenu->newChild($bez, $func, $parents);
  }
  
  /**
   * @name adminMenuBuild
   * @functype Hilfsfuntion - class adminContentmenu
   * @param $id - CSS-id oder CSS-class Bezeichnung, welche verwendet werden soll
   * @param $echoRoot - Eintrag ausgeben
   * @param $echoFirst - erster Eintrag?
   * @param $idMod - Level der Menüverschachtelung
   * 
   * Gibt das zuvor erstellte Menü aus.
   * Wenn kein Menü vorhanden ist, wird ein leerer div-Container ausgegebn.
   */
  function adminMenuBuild($id, $echoRoot = FALSE, $echoFirst = true, $idMod = 0) {
    global $adminMenu;
    if(!empty($adminMenu)) {
      $adminMenu->output($id, $echoRoot, $echoFirst, $idMod);
    } else {
      echo "<div id=\"$id\">\r";
      echo "</div>\r";
    }
    
  }
  
  /**
   * @name adminMenuFuncGet
   * @functype Hilfsfunktion - class adminContentmenu
   * 
   * Trennt die vom Menü übergenen Werte in ein Array.
   */
  function adminMenuFuncGet() {
    global $adminMenuGet;
    
    $adminMenuGet = explode(";", $_GET[ADMIN_GET_MENU_FUNC]);
    //Workaroud um noch Plugins zu laden!!!
    $_GET[ADMIN_GET_MENU_FUNC] = $adminMenuGet[0];
  }
  
// END - MenüNeu
// START - Menü
//
//  $admin_menu = array();
//  
//  function admin_menu_init($name, $func, $parrent = "") {
//    global $admin_menu;
//    
//    //if(empty($parent)) {
//      $admin_menu[$name] = $func;
//    /*}
//    else {
//      $admin_menu[$parent][$name] = $func;
//    }*/
//    
//  }
//  
//  function admin_menu_build() {
//    global $admin_menu;
//    global $user;
//       
//    foreach($admin_menu as $name => $func) {
//      if($user->right["adminmenu_".$func] == 1) {
/*        ?><div class="admin_menu_entry"><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=<?php echo $func; ?>" class="admin_menu_entry"><?php echo $name; ?></a></div>
//      <?php
//      }
//    }
//  }
*/
// END - Menü
// START - Tab (wieder raus genommen, vll brauchen wir es nochmal später)
  
/*function admin_content_tab($tabs, $plugin) {
    global $admin_tab;
    
    $tabsCount = count($tabs);
    
    if(!isset($_GET["tab"])) $_GET["tab"] = "t".$tabs[0][0];
    add_css("div.admin_tab#".$_GET["tab"]." {\rborder-left: none;\rbackground: #FFFFFF;\rpadding-left: 4px;\r}");
    add_css("div.admin_content {\rmin-height: ".($tabsCount*48)."px;\r}");
        
    $admin_tab .= '<div class="admin_tabs">'."\r";

    for($i = 0; $i < $tabsCount; $i++) {
      $admin_tab .= '<a href="'.ADMIN_URL.'?'.ADMIN_GET_MENU_FUNC.'='.$plugin.'&tab=t'.$tabs[$i][0].'" class="admin_tab"><div class="admin_tab" id="t'.$tabs[$i][0].'">'.$tabs[$i][1].'</div></a>'."\r";
    }
    $admin_tab .= '</div>'."\r";
  }
  
  function admin_content_tab_get_id() {
    return substr($_GET["tab"], 1);
  }
*/
  // END - Tab
  
###################################################################################################
###################################################################################################  
  
  function back_to_mainpage_link() {
    ?>
      <a href="<?php echo BK_URL; ?>" class="admin_back_to_mainpage_link">zur Hauptseite</a> <!--TODO:Text in Settings-->
    <?php
  }
  
  function admin_user_link() {
    if(is_user()) {
      ?>
      <span class="admin_user_link">Angemeldet als &raquo;<a class="admin_user_link"><?php echo get_userinfo("username"); ?></a>&laquo; (<?php logout_link("admin_logoutlink"); ?>)</span>
      <?php
    }
  }
  
  /*function admin_url_praser($get, $echo = TRUE) {
    $url = ADMIN_URL."?";
    $get_count = count($get);
    
    for($i = 0; $i < $get_count; $i++) {
      $url .= $get[$i][0]."=".$get[$i][1];
      if(($i+1) < $get_count) $url .= "&";
    }
    
    if($echo) echo $url;
    else return $url; 
  }*/
?>