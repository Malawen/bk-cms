<?php
/**
 * @since r1
 * @lastchange r3
 * 
 * In dieser Datei werden, während der Installation, Einstellungen gespeichert, welche in der
 * Regel nicht mehr verändert werden sollen.
 * Sollten doch Änderungen an diesen Einstellungen vorgenommen werden wollen, wird
 * empfolen, soweit möglich, die erweiterten Einstellungen in Administrationsbereich
 * zu benutzen.
 */
?>
<?php

  //Allgemeine Einstellungen
  define("BK_PATH", "D:/XAMPP/htdocs/bk/"); //Pfad zum Hauptverteichnes|(STRING)
  define("BK_PATH_SEPERATOR", "/"); //Seperator|(STRING)
  define("BK_PATH_TEMPLATE", "bk-user/template/"); //Pfad vom Hauptverzeichnis zum Templateordner|(STRING)
  define("BK_PATH_PRERENDER", "bk-user/pre-render/"); //Pfad zum Ordner in welchem vorgerenderte Dateien gespeichert werden|(STRING)
  define("BK_PATH_FUNCTION", "bk-func/"); //Pfad zu den Funktionen|(STRING)
  define("BK_PATH_PLUGIN", "bk-func/plugin/"); //Pfad zu den Plugins|(STRING)
  define("BK_PATH_LIB", "bk-func/lib/"); //Pfad zu den externen Libaries|(STRING)
  define("BK_URL", "http://localhost/bk"); //Url der Webseite|(STRING)
  define("BK_URL_SEPERATOR", "/"); //Seperator für URLs|(STRING)
  
  //DB Einstellungen
  define("BK_DB_SERVER", "localhost"); //Adresse des Datenbank-Servers (in der Regel "localhost")|(STRING)
  define("BK_DB_USERNAME", "root"); //Benutzername|(STRING)
  define("BK_DB_PASSWORD", ""); //Password|(STRING)
  define("BK_DB_NAME", "bk"); //Datenbank|(STRING)
  define("BK_DB_TYPE", "mysql"); //Datenbanktyp|(LIST)mysql
  define("BK_DB_PRE", "bk_"); //Vorsilbe für Tabellen|(STRING)
  
  //User Einstellungen
  define("BK_USER_GAST_NAME", "Gast"); //Name des Gastbenutzers|(STRING)
  define("BK_USER_GAST_GROUP", 2); //ID der Gastgruppe|(INT)

?>