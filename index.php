<?php
/**
 * @since r1
 * @lastchage r2
 */
?>
<?php
  error_reporting(E_ALL ^ E_NOTICE);
  
  session_start();
  
  //Functionen laden
  include("bk-include.php");
  
  //Datenbankverbindung herstellen
  bk_db_connect();
  
  //User einloggen
  bk_user_logon();
  
  //spezielle Funktionen des gerade aktiven Templates laden
  bk_template_function();
  
  //Ext. Libs laden
  inc_lib();
  
  //Plugins laden
  inc_plugin();
  exe_plugin();
  
  //Templage ausgeben
  bk_template_call();
?>