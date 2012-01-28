<?php
/** 
 * @plugin adminuser
 * @version r1
 * @since r1
 */
?>
<?php
  init_plugin("adminuser_changepaswd", 50, "post", "adminuser_submit");
  function adminuser_changepaswd() {
    if(isset($_POST["adminuser_oldpaswd"]) && isset($_POST["adminuser_newpaswd1"]) && isset($_POST["adminuser_newpaswd2"])) {
      $oldpasswd = $_POST["adminuser_oldpaswd"];
      $newpaswd[0] = $_POST["adminuser_newpaswd1"];
      $newpaswd[1] = $_POST["adminuser_newpaswd2"];
      
      if(check_user_password($oldpasswd)) {
        if($oldpasswd != $newpaswd[0]) {
          if($newpaswd[0] == $newpaswd[1]) {
            global $db;
            global $user;
            $newpaswd[0] = bk_user_code_password($newpaswd[0]);
        
            bk_db_query("UPDATE $db->user SET password = '$newpaswd[0]' WHERE ID = '$user->ID';");
            header("Refresh: 5; ".ADMIN_URL."?logout=1");
            add_css("div.adminuser {\rborder: 3px solid #CC3344;\rbackground: #FFFFFF;\rmargin: 20px 5px 0px 5px;\rfloat: left;\r}");
            ?>
            <div class="adminuser">
            Ihr Passwort wurde erfolgreich ge&auml;ndert.<br /> <!--TODO:als Fehlerausgabe machen-->
            Bitte klicken Sie <a href="<?php echo ADMIN_URL; ?>?logout=1">hier</a>.
            </div>
            <?php
          }
        }
      }
    }
  }

  init_plugin("adminuser_css", 50, "get", "adminfunc", "adminuser");
  function adminuser_css() {
    add_css("form.adminuser {\rtext-align: center;\r}");
    add_css("label.adminuser, input.adminuser, select.adminuser {\rdisplay: block;\rfloat: left;\rwidth: 250px;\rmargin: 2px 0px;\r}");
    add_css("label.adminuser {\rtext-align: right;\rpadding-right: 5px;\r}");
    add_css("form.adminuser br {\r clear: left;\r}");
    add_css("input#submit {\rtext-align: center;\rfloat: none;\rwidth: 150px;\rmargin: 2px auto;\r}");

  }
  
  if(function_exists("adminMenuInit")) adminMenuInit("Benutzereinstellungen", "adminuser");
  //if(function_exists("admin_menu_init")) admin_menu_init("Benutzereinstellungen", "adminuser");
  function adminuser() {   
    ?>
<!--TODO:Fehlerausgabe: die beiden Passwörter stimmen nciht überein-->
<form method="post" class="adminuser">
<label for="adminuser_oldpaswd" class="adminuser">altes Passwort:</label>
<input type="password" name="adminuser_oldpaswd" value="" id="adminuser_oldpaswd" class="adminuser" /><br />
<label for="adminuser_newpaswd1" class="adminuser">neues Passwort:</label>
<input type="password" name="adminuser_newpaswd1" value="" id="adminuser_newpaswd1" class="adminuser" /><br />
<label for="adminuser_newpaswd2" class="adminuser">neues Passwort (Wiederholung):</label>
<input type="password" name="adminuser_newpaswd2" value="" id="adminuser_newpaswd2" class="adminuser" /><br />
<input type="submit" name="adminuser_submit" value="Passwort &auml;ndern" id="submit" class="adminuser" />
</form>
    <?php
  }
?>