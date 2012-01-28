<?php
/** 
 * @since r1
 * @lastchage r4
 */
?>
<?php
  session_start();
  
  //Functionen laden
  include('admin-include.php');
  
  //Datenbankverbindung herstellen
  bk_db_connect();
  
  //User einloggen
  bk_user_logon();
  
  //Übergabewerte des AdminMenu bestimmen
  if(isset($_GET[ADMIN_GET_MENU_FUNC])) adminMenuFuncGet();
  
  //spezielle Funktionen des gerade aktiven Templates laden
  bk_template_function();
  
  //Ext. Libs laden
  inc_lib();
  
  //Plugins laden
  inc_plugin();
  exe_plugin();
  
  //Pfrüfen ob der User ein Gast ist
  //Wenn JA => kein Zugriff
  if(is_guest()) {
    admin_template_login();
  } //Wenn NEIN => Zugriff
  else {
    admin_template_index();
  }
?>