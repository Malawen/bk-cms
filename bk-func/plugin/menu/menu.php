<?php
/** 
 * @plugin menu
 * @since r1
 * @lastchage r4
 */
?>
<?php
    //------------------------------------
    //Datenbank Zugriff Funktionen
    //------------------------------------
    
    /*init_plugin("menu_add_menu", 50, "get", "newmenu");
    function menu_add_menu() {
      add_menu($_POST["menuname"]);
    }
    
    init_plugin("menu_update_menu", 50, "get", "updatemenu");
    function menu_update_menu() {
      update_menu($_GET["updatemenu"], $_POST["menuname"]);
    }
    
    init_plugin("menu_delete_menu", 50, "get", "delmenu");
    function menu_delete_menu() {
      delete_menu($_GET["deletemenu"]);
    }
    
    init_plugin("menu_add_entry", 50, "get", "newentry");
    function menu_add_entry() {
      $id = add_menu_entry($_POST["menuid"], $_POST["entry"], $_POST["value"]);
      
      $_GET["entryid"] = $id;
    }
    
    init_plugin("menu_update_entry", 50, "get", "updateentry");
    function menu_update_entry() {
      update_menu_entry($_POST["menuid"], $_GET["entryid"], $_POST["entry"], $_POST["value"]);
    }
    
    init_plugin("menu_delete_entry", 50, "get", "delentry");
    function menu_delete_entry() {
      delete_menu_entry($_GET["delentry"]);
    }
    
    init_plugin("menu_entry_up", 50, "get", "entryup");
    function menu_entry_up() {
      move_menu_entry_up($_GET["entryup"]);
    }
    
    init_plugin("menu_entry_down", 50, "get", "entrydown");
    function menu_entry_down() {
      move_menu_entry_down($_GET["entrydown"]);
    }*/
    
    //------------------------------------
    //Datenbank Querrys
    //------------------------------------
    //TODO: Standart DB-Namen in das normale Array dafuer verschieben
    global $menu_db;
    $menu_db = BK_DB_PRE."menu";
    global $menuname_db;
    $menuname_db = BK_DB_PRE."menuname";
    
    //TODO: functions-Namen aendern
    function add_menu($menuname) {
      global $menuname_db;
      bk_db_query("INSERT INTO $menuname_db (menuName) VALUES ('$menuname');");
    }
    
    function update_menu($id, $menuname) {
      global $menuname_db;
      bk_db_query("UPDATE $menuname_db SET menuName = '$menuname' WHERE ID = $id;");
    }
    
    function delete_menu($id) {
      global $menu_db;
      global $menuname_db;
      
      bk_db_query("DELETE FROM $menu_db WHERE menuID = $id;");
      bk_db_query("DELETE FROM $menuname_db WHERE ID = $id;");
    }
        
    /*function add_menu_entry($menuid, $entry, $value) {
        global $menu_db;
        $pos = bk_db_query("SELECT COUNT(1) pos FROM $menu_db WHERE menuID = '$menuid' ORDER BY pos DESC;", ARRAY_A);
        $pos["pos"]++;
        bk_db_query("INSERT INTO $menu_db (menuID, entry, value, pos) VALUES ('$menuid', '$entry', '$value', '{$pos["pos"]}');");
        //TODO: Eventuell nochmal den SQL-String ueberpruefen ob man den nicht abkuerzen kann. => LAST_INSERT_ID() AS ID
        $res = bk_db_query("SELECT ID FROM $menu_db WHERE ID = LAST_INSERT_ID();", ARRAY_A);
        return $res["ID"];
    }*/
    
    function bkMenu_db_newEntry($bez, $sel, $link, $html, $pos) {
    	global $menu_db;
    	
    	$query = "INSERT INTO $menu_db (entry, value, pos, HTMLattribute, autoValue) VALUES (\"$bez\", \"$link\", \"$pos\", \"$html\", \"$sel\";";
    	
    	bk_db_query($query);
    	$res = bk_db_query("SELECT LAST_INSERT_ID() AS ID FROM $menu_db;");
    	return $res["ID"];
    }
    
    function bkMenu_db_updateEntry($id, $bez, $sel, $link, $html, $pos) {
      $query = "UPDATE $menu_db SET entry = \"$bez\", value = \"$link\", pos = $pos, HTMLattribute = \"$html\", autoValue = \"$sel\" WHERE ID = $id;";
      
      global $menu_db;
      bk_db_query($query);
    }
    
    //Update der Pos, welche nicht schon anders geaendert wurden
    function bkMenu_admin_updatePos($pos) {
      global $menu_db;
      
      foreach($pos as $i => $p) {
        $query_pos_id[] = "pos = \"$p\" WHERE ID = $i"; 
      }
            
      $query = "UPDATE $menu_db SET ".implode(" AND ", $query_pos_id).";";
      
      bk_db_query($query);
    }
    
    function bkMenu_db_deleteEntry($id) {
      global $menu_db;
      bk_db_query("DELETE $menu_db WHERE ID = $id;");
    }
    
    /*function update_menu_entry($menuid, $entryid, $entry, $value) {
        global $menu_db;
        bk_db_query("UPDATE $menu_db SET menuID = '$menuid', entry = '$entry', value = '$value' WHERE ID = $entryid;");
    }
    
    function move_menu_entry_up($entryid) {
      global $menu_db;      
      $pos1 = bk_db_query("SELECT ID, pos, menuID FROM $menu_db WHERE ID = $entryid;", ARRAY_A);
      $pos2 = bk_db_query("SELECT ID, pos FROM $menu_db WHERE pos = {$pos1["pos"]}-1 AND menuID = {$pos1["menuID"]};", ARRAY_A);
      
      bk_db_query("UPDATE $menu_db SET pos = {$pos1["pos"]} WHERE ID = {$pos2["ID"]}");
      bk_db_query("UPDATE $menu_db SET pos = {$pos2["pos"]} WHERE ID = {$pos1["ID"]}");
    }
    
    function move_menu_entry_down($entryid) {
      global $menu_db;      
      $pos1 = bk_db_query("SELECT ID, pos, menuID FROM $menu_db WHERE ID = $entryid;", ARRAY_A);
      $pos2 = bk_db_query("SELECT ID, pos FROM $menu_db WHERE pos = {$pos1["pos"]}+1 AND menuID = {$pos1["menuID"]};", ARRAY_A);
      
      bk_db_query("UPDATE $menu_db SET pos = {$pos1["pos"]} WHERE ID = {$pos2["ID"]}");
      bk_db_query("UPDATE $menu_db SET pos = {$pos2["pos"]} WHERE ID = {$pos1["ID"]}");
    }
    
    function delete_menu_entry($entryid) {
        global $menu_db;
        bk_db_query("DELETE FROM $menu_db WHERE ID = $entryid;");
    }*/
    
    function select_menu_entry($entryid) {
        global $menu_db;
        $res = bk_db_query("SELECT menuID, entry, value FROM $menu_db WHERE ID = $entryid;", ARRAY_A);
        return $res;
    }
    
    function select_menu($menuid, $sort = "") {
        global $menu_db;
        $res = bk_db_query("SELECT ID, entry, value, pos, HTMLattribute, autoValue FROM $menu_db WHERE menuID = '$menuid' ORDER BY pos;", ARRAY_A);
        return $res;
    }
    
    function select_menu_names($id = "") {
      global $menuname_db;
      $query = "SELECT ID, menuName FROM $menuname_db";
      if(!empty($id)) $query .= " WHERE ID = \"$id\"";
      $query .= ";";
      $menu = bk_db_query($query, ARRAY_N);
      return $menu;
    }
    
    //------------------------------------
    //Administrations Menü
    //------------------------------------
    //TODO: defines sollten an einer anderen stelle stehen!!!
    define("MENU_MLINK", "mLink");
    define("MENU_EMPTY", "empty");
    define("MENU_HEADLINE", "headline");
        
    init_plugin("bkMenu_admin_submitSave", 50, "post", "menuSubmit_save");
    function bkMenu_admin_submitSave() {
      echo "<pre>"; var_dump($_POST); exit;
      
      $id = explode(";", $_POST["entry_pos"]);
      $idCount = count($id);
      $delCount = 0;
      $pos = $id;
      
      //ID, entry, value, pos, HTMLattribute, autoValue
      
      for($i = 0; $i < $idCount; $i++) {
        if((bool)$_POST["entry$id[$i]_del"] == true) { //loeschen
          bkMenu_db_deleteEntry((int)$id[$i]);
          unset($pos[$i]);
          $delCount++;
        } else { //alles was nicht geloescht wird, wird in $data geschrieben
          $data[$i]["ID"] = (int)$id[$i]; //TODO: geht so warscheinlich nicht!!! in $id kann auch der String-Wert "new" stehen pruefen, was bei der konventierung raus kommt
          $data[$i]["entry"] = $_POST["entry$id[$i]_bez"];
          $data[$i]["autoValue"] = $_POST["entry$id[$i]_sel"];
          $data[$i]["value"] = $_POST["entry$id[$i]_link"];
          $data[$i]["HTMLattribute"] = $_POST["entry$id[$i]_html"];
          $data[$i]["pos"] = $i+1-$delCount;
        }
      }
      
      for($i = 0; $i < $idCount; $i++) {
      	//TODO: SQL-Abfragen sammeln um nur eine Abfrage an den Server zu senden
      	//TODO: Eventuell nochmal das auto-http bearbeiten
        //auto http://
        if(!empty($data[$i]["value"]) && substr($data[$i]["value"], 0, 7) != "http://") {
          $data[$i]["value"] = "http://".$data[$i]["value"];
        }
        
        //Fehlende Eingaben ueberpruefen
        if((empty($data[$i]["entry"]) || empty($data[$i]["value"])) && $data[$i]["autoValue"] == MENU_MLINK) {
          $data[$i]["err"] = true;
          //TODO: Fehler Ausgabe
        }
        if(empty($data[$i]["entry"]) && $data[$i]["autoValue"] == MENU_HEADLINE) {
          $data[$i]["err"] = true;
          //TODO: Fehler Ausgabe
        }
        if(empty($data[$i]["entry"]) && ($data[$i]["autoValue"] != MENU_LINK || $data[$i]["autoValue"] != MENU_HEADLINE || $data[$i]["sel"] != MENU_EMPTY)) {
          $data[$i]["err"] = true;
          //TODO: Fehler Ausgabe
        }
        
        //wenn kein Fehler gefunden wurde
        if(!isset($data[$i]["err"]) || empty($data[$i]["err"])) {
          if(is_int($data[$i]["ID"])) { //neuer oder alter Eintrag
            bkMenu_db_updateEntry(); //alten Eintrag updaten
          } else {
            $id = bkMenu_db_newEntry(); //neuen Eintrag erstellen
            $data[$i]["ID"] = $id;
          }
          unset($pos[$i]);
        }
                  
      }
      
      //Positionierung: Wird nur ausgefuert wenn nur die Reihenfolge der Menueeintraege geaendert wurden.
      if(($_POST["entry_pos"] != $_POST["entry_oldPos"]) || $delCount > 0)  {
        bkMenu_admin_updatePos($pos);
      }
        
    }
    
    init_plugin("bkMenu_admin_preLoad", 50, "get", "adminfunc", "bkMenu_admin");
    function bkMenu_admin_preLoad() {
      //if(isset($_POST["menuSubmit_save"])) {echo "<pre>"; var_dump($_POST); exit;}
      
      $menuName = array_merge(array(array("new", "neues Men&uuml;")), select_menu_names());  
      
      //echo "<pre>"; var_dump($menuName); exit;
      
      add_jsfile(BK_PATH_PLUGIN."menu".BK_PATH_SEPERATOR."admin-menu.js");
      add_cssfile(BK_PATH_PLUGIN."menu".BK_PATH_SEPERATOR."admin-menu.css", 60);
      for($i = 0; $i < count($menuName); $i++) {
        adminMenuInit($menuName[$i][1], $menuName[$i][0], array("Menü"));
      }
    }
    
    if(function_exists("adminMenuInit")) adminMenuInit("Menü", "bkMenu_admin");
    function bkMenu_admin() {
      global $adminMenuGet;
      $menuID = $adminMenuGet[1];
      
      if($menuID == "new" || $menuID == NULL) {
        echo "<a id=\"menuAdminHeadline\">Neues Menü</a>\r";
        echo "<form method=\"post\" class=\"menu_new\">\r";
        echo "<label for=\"menu_name\" class=\"menu_new\">Name:</label>\r";
        echo "<input type=\"text\" name=\"menu_new_name\" value=\"\" class=\"menu_new\" id=\"menu_new_name\" /><br />\r";
        echo "<input type=\"submit\" name=\"menu_new_submit\" value=\"neues Men&uuml; anlegen\" class=\"menu_new\" id=\"submit\" />\r";
        echo "</form>\r";
      }
      else {
        $menuName = select_menu_names($menuID);
        $entry = select_menu($menuID);
        $entryCount = count($entry);
        $catList = select_cat_list();
        $pageList = select_page_list("no_cat");
        $oldPosList = "";
        
        echo "<a id=\"menuAdminHeadline\">$menuName[1]</a>\r";
        echo "<form class=\"menu_admin_entry\" method=\"post\" action=\"\">\r";
        echo "<ul id=\"menuAdminEntryList\">\r";
        for($i = 0; $i < $entryCount; $i++) {
          bkMenu_admin_singleEntryEdit($entry[$i], $catList, $pageList);
          $oldPosListArray[] = $entry[$i]["ID"];
        }
        $oldPosList = implode(";", $oldPosListArray);
        unset($oldPosListArray);
        echo "</ul>\r";
        echo "<input type=\"hidden\" id=\"menu_admin_entryPos\" name=\"entry_pos\" value=\"\" />\r";
        echo "<input type=\"hidden\" id=\"menu_admin_entryOldPos\" name=\"entry_posOld\" value=\"$oldPosList\" />\r";
        bkMenu_admin_editButtons();
        echo "</form>\r";
      }
    }
    
    function bkMenu_admin_editButtons() {
      echo "<input type=\"submit\" name=\"menuSubmit_new\" class=\"menuButtonNew\" value=\"Neuer Eintrag\" />\r";
      echo "<input type=\"submit\" name=\"menuSubmit_save\" class=\"menuButtonSave\" value=\"&Auml;nderungen speichern\" />\r";
      //echo "<input type=\"submit\" name=\"menuSubmit_reset\" class=\"menuButtonReset\" value=\"Reihenfolge zur&uuml;cksetzen\" />\r"; // Hat nicht so Funktioniert wie es sollte!
      echo "<input type=\"submit\" name=\"menuSubmit_delete\" class=\"menuButtonDelete\" value=\"Men&uuml; l&ouml;schen\" />\r";
    }
    
    function bkMenu_admin_singleEntryEdit($entry, $catList, $pageList) {
      echo "<li class=\"menu_admin_entry\" id=\"entry{$entry["ID"]}\">\r";
      //Positionierung
      echo "<div class=\"menu_admin_pos\">\r";
      echo "<a class=\"menu_admin_posOld\">alte Position: {$entry["pos"]}</a>\r";
      echo "<a class=\"menu_admin_posText\">Eintrag</a>\r";
      echo "<a class=\"menu_admin_posNum\">{$entry["pos"]}</a>\r";
      echo "</div>\r";
      //Menüeintrag
      echo "<div class=\"menu_admin_entry\">\r";
      echo "<label class=\"menu_admin_entry\">Bezeichnung:</label>\r";
      echo "<input type=\"text\" name=\"entry{$entry["ID"]}_bez\" class=\"menu_admin_entry\" value=\"{$entry["entry"]}\" /><br />\r";
      echo "<label class=\"menu_admin_entry\">Link:</label>\r";
      echo "<select name=\"entry{$entry["ID"]}_sel\" id=\"menuAdminSelect{$entry["ID"]}\" class=\"menu_admin_entry\">\r";
      echo "<option value=\"".MENU_MLINK."\" class=\"menu_admin_entry\">manueller Link</option>\r";
      echo "<option value=\"".MENU_HEADLINE."\" class=\"menu_admin_entry\">ohne Link</option>\r";
      echo "<option value=\"".MENU_EMPTY."\" class=\"menu_admin_entry\">leere Eintrag</option>\r";
      echo "<optgroup label=\"Kategorien\" class=\"menu_admin_entry\">\r";
      for($i = 0; $i < count($catList); $i++) {
        if($entry["autoValue"] == "c".$i) {
          $autoValue = " selected";
          $autoValueSet = true;
        }
        else $autoValue = "";
        echo "<option value=\"c{$catList[$i][0]}\" class=\"menu_admin_entry\"$autoValue>{$catList[$i][1]}</option>\r";
      }
      echo "</optgroup>\r";
      echo "<optgroup label=\"Seiten\" class=\"menu_admin_entry\">\r";
      for($i = 0; $i < count($pageList); $i++) {
        if($entry["autoValue"] == "p".$i) {
          $autoValue = " selected";
          $autoValueSet = true;
        }
        else $autoValue = "";
        echo "<option value=\"p{$pageList[$i][0]}\" class=\"menu_admin_entry\"$autoValue>{$pageList[$i][1]}</option>\r";
      }
      echo "</optgroup>\r";
      echo "</select>\r";
      echo "<br />\r";
      echo "<div id=\"menuAdminLink{$entry["ID"]}\">\r";
      echo "<label class=\"menu_admin_entry\"></label>\r";
      echo "<input type=\"text\" name=\"entry{$entry["ID"]}_link\" class=\"menu_admin_entry\" value=\"{$entry["value"]}\" /><br />\r"; //müsste eigentlich [type=url] sein jedoch gibt es Fehler da jeder Browser die Kontrolle der URL anders macht
      echo "</div>\r";
      echo "<label class=\"menu_admin_entry\">HTML-Atribute:</label>\r";
      echo "<input type=\"text\" name=\"entry{$entry["ID"]}_html\" class=\"menu_admin_entry\" value=\"".htmlentities($entry["HTMLattribute"], ENT_QUOTES)."\" /><br />\r";
      //Eintrag löschen
      echo "<label class=\"menu_admin_entry_delete\">Eintrag löschen:</label>\r";
      echo "<input type=\"checkbox\" name=\"entry{$entry["ID"]}_del\" class=\"menu_admin_entry_delete\" id=\"menuAdminDelete{$entry["ID"]}\" /><br />\r";
      echo "</div>\r";
      echo "<div class=\"clear-left\"><!-- left --></div>\r";
      echo "</li>\r";
    }
    
    /*
    function menu_admin_mod_list($list, $preID, $preName) {
      for($i = 0; $i < count($list); $i++) {
        $list[$i][0] = $preID.$list[$i][0];
        $list[$i][1] = $preName.$list[$i][1];
      }
      
      return $list;
    }
    
    function menu_admin_update_menu() {
      global $menuname_db;
      $res = bk_db_query("SELECT menuName FROM $menuname_db WHERE ID = {$_GET['menuid']};", ARRAY_A);
      
      ?>
      <form method="post" action="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_show&updatemenu=<?php echo $_GET["menuid"]; ?>">
      <label for="menuname">Name</label>
      <input type="text" name="menuname" value="<?php echo $res["menuName"]; ?>" /><br />
      <input type="submit" value="Speichern" /><a href="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_show">nicht Speichern</a>
      </form>
      <?php
    }
    
    function menu_admin_show_entry() {
      global $menu_db;
      $res = bk_db_query("SELECT ID, pos, entry, value FROM $menu_db WHERE menuID = {$_GET['menuid']} ORDER BY pos;", ARRAY_A);
      
      ?>
      <a href="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_new_entry&menuid=<?php echo $_GET["menuid"]; ?>">Neuer Eintrag</a>
      <table>
      <tr><td>ID</td><td>Bezeichnung</td><td>Wert</td><td></td><td></td></tr>
      <?php foreach($res as $r) {
        ?>
        <tr>
        <td><?php echo $r["pos"]; ?></td>
        <td><?php echo $r["entry"]; ?></td>
        <td><?php echo $r["value"]; ?></td>
        <td><a href="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_update_entry&menuid=<?php echo $_GET["menuid"]; ?>&entryid=<?php echo $r["ID"]; ?>">bearbeiten</a></td>
        <td><a href="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_show_entry&menuid=<?php echo $_GET["menuid"]; ?>&delentry=<?php echo $r["ID"]; ?>">l&ouml;schen</a></td>
        <td><a href="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_show_entry&menuid=<?php echo $_GET["menuid"]; ?>&entryup=<?php echo $r["ID"]; ?>">nach oben</a></td>
        <td><a href="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_show_entry&menuid=<?php echo $_GET["menuid"]; ?>&entrydown=<?php echo $r["ID"]; ?>">nach unten</a></td>
        </tr>
        <?php
      }
      ?>
        </table>
      <?php
    }
    
    function menu_admin_new_entry() {
      ?>
      <form method="post" action="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_update_entry&menuid=<?php echo $_GET["menuid"]; ?>&newentry=1">
      <label for="menuid">Menü ID</label>
      <input type="text" name="menuid" value="<?php echo $_GET["menuid"]; ?>" /><br />
      <label for="entry">Bezeichnung</label>
      <input type="text" name="entry" value="" /><br />
      <label for="value">Ziel</label>
      <input type="text" name="value" value="" /><br />
      <input type="submit" value="Speichern" /><a href="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_show_entry&menuid=<?php echo $_GET["menuid"]; ?>">nicht Speichern</a>
      </form>
      <?php
    }
    
    function menu_admin_update_entry() {
      global $menu_db;
      $res = bk_db_query("SELECT menuID, entry, value FROM $menu_db WHERE ID = {$_GET['entryid']};", ARRAY_A);
      
      ?>
      <form method="post" action="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_update_entry&menuid=<?php echo $_GET["menuid"]; ?>&entryid=<?php echo $_GET["entryid"]; ?>&updateentry=1">
      <label for="menuid">Men&uuml; ID</label>
      <input type="text" name="menuid" value="<?php echo $res["menuID"]; ?>" /><br />
      <label for="entry">Bezeichnung</label>
      <input type="text" name="entry" value="<?php echo $res["entry"]; ?>" /><br />
      <label for="value">Ziel</label>
      <input type="text" name="value" value="<?php echo $res["value"]; ?>" /><br />
      <input type="submit" value="Speichern" /><a href="?<?php echo ADMIN_GET_MENU_FUNC; ?>=menu_admin_show_entry&menuid=<?php echo $_GET["menuid"]; ?>">nicht Speichern</a>
      </form>
      <?php
    }
    */
    
    //------------------------------------
    //Output Funktionen
    //------------------------------------
    //TODO: Output Ausgaben komplett ueberarbeiten und ueber php selbst machen 
    function get_menu($menuid, $id, $addid = false, $sort = "") {
        $menu = select_menu($menuid, $sort);
        ?>
            <div id="<?php echo $id; ?>" class="menu">
        <?php
        if(count($menu) > 1) {
          foreach($menu as $entry) {
            if($entry["entry"] == "<empty>") {
              ?>
                <br /><!-- WORKAROUND: <div class="<?php echo $id."_empty"; ?>"></div>-->
              <?php
            }
            elseif($entry["value"] == "<seperator>") {
              ?>
                <div class="<?php echo $id."_seperator"; ?>">
                <a class="<?php echo $id."_seperator"; ?>"><?php echo $entry["entry"]; ?></a>
                </div>
              <?php
            }
            else {
              $http = $entry["value"]{0}.$entry["value"]{1}.$entry["value"]{2}.$entry["value"]{3};
              if(empty($entry["value"])) $entry["value"] = BK_URL.BK_URL_SEPERATOR."page-10"; //Verlinkung für noch nicht fertige Seiten
              elseif($http != "http") $entry["value"] = BK_URL.BK_URL_SEPERATOR.$entry["value"];
              
              ?>
                <div class="<?php echo $id."_entry"; ?>"<?php //if($addid) echo ' id="'.$id.'EntryDiv'.$i.'"'; ?>  <?php echo $entry["HTMLattribute"]; ?>>
                <a href="<?php echo $entry["value"]; ?>" class="<?php echo $id."_entry"; ?>"<?php //if($addid) echo ' id="'.$id.'EntryA'.$i.'"'; ?>><?php echo $entry["entry"]; ?></a>
                </div>   
              <?php
            }
            /*if($addid)
              $i = $i + 1;*/
          }
        }
        ?>
            </div>
        <?php  
    }
    
    
    //TODO: was hat get_menu_by_cat() hier zu suchen? bessere stelle im Code finden
    function get_menu_by_cat($id, $sort = "") {
        global $cat;
        if(!empty($cat)) get_menu($cat->menu, $id, $sort);
    }