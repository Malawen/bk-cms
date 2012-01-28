<?php
/** 
 * @since r1
 * @lastchage r1
 * 
 * In dieser php-Datei sind alle Einstellungen des CMS vorhanden, welche vom Benutzer
 * in Normalfall nicht verändert werden sollten.
 * Eine Änderung an den Einstellungen kann dazu führen, dass Teile des CMS, oder das
 * komplette CMS nicht mehr richtig funktioniert.
 */
?>
<?php

  //Login-Definitionen
  define("BK_LOGIN_SEPERATOR", "@"); //Zeichen zum Trennen von Username, Password und Remember im Cookie
  define("BK_LOGIN_USERNAME_ALLOWED_CHARS", "[A-Za-z0-9\-\_]"); //Erlaubte Zeichen im Username
  
  //GET-Definitionen
  define("BK_GET_LOGOUT", "logout"); //GET-Variable welche beim Ausloggen übertragen wird
  
  //POST-Definitionen
  define("BK_POST_LOGIN_USERNAME", "bk_login_user"); //POST-Variable zum Übertragen des Usernamen
  define("BK_POST_LOGIN_PASSWORD", "bk_login_pass"); //POST-Variable zum Übertragen des Password
  define("BK_POST_LOGIN_REMEMBER", "bk_login_remember"); //POST-Variable um zu Übertragen ob der User über eine Session eingeloggt bleiben soll
  define("BK_POST_LOGIN_SUBMIT", "bk_login_submit");
  
  //SESSION-Definitionen
  define("BK_SESSION_LOGIN", "bk_login"); //SESSION-Variable für den Userlogin  
  
  //COOKIE-Definitionen
  define("BK_COOKIE_LOGIN", "bk_login"); //COOKIE für den Userlogin
  define("BK_COOKIE_LOGIN_LIFETIME", "604800"); //Dauer, wie lange ein User eingeloggt bleiben kann
  
  //Tabellennamen
  define("BK_TABLE_USER", "user"); //Datenbanktabelle für User
  define("BK_TABLE_GROUP", "usergroup"); //Datenbanktabelle für Usergruppen
  define("BK_TABLE_PLUGIN", "plugin"); //Datenbanktabelle für Plugins
  
  //Template
  define("BK_TEMPLATE_DEFAULT", "default"); //Standart-Template welches verwedet wird wenn kein anders Template verfügbar ist
  define("BK_TEMPLATE_FUNCTION", "function.php"); //php-Datei mit Funktionen welche zum Template gehören
  define("BK_TEMPLATE_FIX", "template.php"); //php-Datei welche den festen Teil des Templates vorgibt (Header, Sidebar, Footer, usw.)
  
?>