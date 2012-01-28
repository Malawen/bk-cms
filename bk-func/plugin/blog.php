<?php
/**
 * @plugin blog
 * @since r1
 * @lastchange r4
 */
?>
<?php

  global $db_blog;
  $db_blog = "bk_blog";
  
  //Editor laden
  init_plugin("load_elrte", 50, "get", "adminfunc", "blog_admin_new");
  init_plugin("load_elrte", 50, "get", "adminfunc", "blog_admin_update");
  //init_plugin("load_openwysiwyg", 50, "get", "adminfunc", "page_admin_new");
  //init_plugin("load_openwysiwyg", 50, "get", "adminfunc", "page_admin_update");
  
  ##############################################
  ##############################################  
  
  init_plugin("blog_new_blog", 50, "get", "blognew");
  function blog_new_blog() {
    global $db_blog;
    $query = "INSERT INTO $db_blog (headline, content, mkdate, cat, userID) VALUES ('{$_POST["headline"]}', '{$_POST["content"]}', '".time()."', '{$_POST["cat"]}', '{$_POST["userID"]}');";
    bk_db_query($query);
    
    $res = bk_db_query("SELECT ID FROM $db_blog WHERE ID = LAST_INSERT_ID();", ARRAY_A);
    $_GET["blog"] = $res["ID"];
  }
  
  init_plugin("blog_update_blog", 50, "get", "blogupdate");
  function blog_update_blog() {
    global $db_blog;
    bk_db_query("UPDATE $db_blog SET headline = '{$_POST["headline"]}', content = '{$_POST["content"]}', cat = '{$_POST["cat"]}' WHERE ID = {$_GET["blogupdate"]};");
    
    $_GET["blog"] = $_GET["blogupdate"];
  }
  
  init_plugin("blog_delete_blog", 50, "get", "blogdel");
  function blog_delete_blog() {
    global $db_blog;
    bk_db_query("DELETE FROM $db_blog WHERE ID = {$_GET["blogdel"]};");
  }

  function blog_load_blog($count, $cat, $order = "DESC") {
    
    global $db_blog;
    if($count > 0) $query = "SELECT ID, headline, content, mkdate, cat, userID FROM $db_blog";
    else $query = "SELECT ID, headline, content, mkdate, userID FROM $db_blog";
    if(count($cat) > 1 && is_array($cat)) {
      $query .= " WHERE ";
      for($i = 0; $i < count($cat); $i++) {
        $query .= " cat = '{$cat[$i]}'";
        if($i <= count($cat)-2) $query .= " AND";
      }
    }
    elseif(!is_array($cat) && $cat != "") {
      $query .= " WHERE cat = $cat";
    }
    $query .= " ORDER BY mkdate $order;";
    
    
    
    $res = bk_db_query($query, ARRAY_A);
    
    
    return $res;
  }
  
  function get_blog($count, $cat) {
    $blog = blog_load_blog($count, $cat);
    
    //echo "<pre>"; var_dump($blog); exit;
    
    if(isset($blog["ID"])) {
      ?>
        <div class="blog">
        <div class="blog_headline">
        <a class="blog_headline"><?php echo $blog["headline"]; ?></a>
        <a class="blog_date"><?php echo date("d.m.y H:i", $blog["mkdate"]); ?></a>
        </div>
        <div class="blog_content">
        <?php echo $blog["content"]; ?>
        </div>
        </div>
      <?php
    }
    elseif(is_array($blog)) {
      for($i = 0; $i < count($blog); $i++) {
        ?>
          <div class="blog">
          <div class="blog_headline">
          <a class="blog_headline"><?php echo $blog[$i]["headline"]; ?></a>
          <a class="blog_date"><?php echo date("d.m.y H:i", $blog[$i]["mkdate"]); ?></a>
          </div>
          <div class="blog_content">
          <a class="blog_content"><?php echo $blog[$i]["content"]; ?></a>
          </div>
          </div>
        <?php
      }
    }
  }
  
  function blog_admin_new() {
    ?>
      <form method="post" action="?<?php echo ADMIN_GET_MENU_FUNC; ?>=blog_admin_update&blognew=1">
      <label for="headline">&Uuml;berschrift</label>
      <input type="text" name="headline" value="" /><br />
      <label for="cat">Kategorien</label>
      <input type="text" name="cat" value="" /><br />
      <label for="content">Inhalt</label>
      <div id="elrte" name="content"></div><br />
      <input type="hidden" value="<?php echo get_userinfo("ID"); ?>" name="userID" />
      <input type="submit" value="Speichern" /><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=blog_admin_show">nicht Speichern</a>
      </form>
    <?php
  }
  
  if(function_exists("adminMenuInit")) adminMenuInit("Blog", "blog_admin_show");
  //if(function_exists("admin_menu_init")) admin_menu_init("Blog", "blog_admin_show");
  function blog_admin_show() {
    $blog = blog_load_blog(0, "");
    ?>
    <a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=blog_admin_new">neuer Eintrag</a>
    <table>
      <tr><td>ID</td><td>Bezeichnung</td><td></td><td></td></tr>
      <?php foreach($blog as $r) {
        ?>
          <tr>
          <td><?php echo $r["ID"]; ?></td>
          <td><?php echo $r["headline"]; ?></td>
          <td><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=blog_admin_update&blog=<?php echo $r["ID"]; ?>">&auml;ndern</a></td>
          <td><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=blog_admin_show&blogdel=<?php echo $r["ID"]; ?>">l&ouml;schen</a></td>
          </tr>
        <?php
      }
      ?>
        </table>
      <?php
  }
  
  function blog_admin_update() {
    global $db_blog;
    $blog = bk_db_query("SELECT ID, headline, cat, content FROM $db_blog WHERE ID = {$_GET["blog"]};", ARRAY_A);
    
    ?>
      <form method="post" action="?<?php echo ADMIN_GET_MENU_FUNC; ?>=blog_admin_update&blogupdate=<?php echo $blog["ID"]; ?>">
      <label for="headline">&Uuml;berschrift</label>
      <input type="text" name="headline" value="<?php echo $blog["headline"]; ?>" /><br />
      <label for="cat">Kategorien</label>
      <input type="text" name="cat" value="<?php echo $blog["cat"]; ?>" /><br />
      <label for="content">Inhalt</label>
      <div id="elrte" name="content"><?php echo $blog["content"]; ?></div><br />
      <input type="submit" value="Speichern" /><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=blog_admin_show">nicht Speichern</a>
      </form>
    <?php
  }

?>