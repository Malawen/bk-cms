<?php
/** 
 * @plugin page
 * @since r1
 * @lastchage r4
 */
?>
<?php
  global $page_db;
  $page_db = "bk_page";
  
  //Editor laden
  init_plugin("load_elrte", 50, "get", "adminfunc", "page_admin_new");
  init_plugin("load_elrte", 50, "get", "adminfunc", "page_admin_update");
  //init_plugin("load_openwysiwyg", 50, "get", "adminfunc", "page_admin_new");
  //init_plugin("load_openwysiwyg", 50, "get", "adminfunc", "page_admin_update");

##########
##########
  init_plugin("load_page_by_get", 50, "get", "page");
  function load_page_by_get() {
    global $page;
    $page = load_page($_GET["page"]);
  }

  function load_page($page) {
    $pageobj = new page($page);
    return $pageobj;
  }
  
  init_plugin("save_new_page", 50, "get", "pagenew");
  function save_new_page() {
    $id = page_new_page($_POST["headline"], $_POST["content"], $_POST["userID"]);
    
    global $page;
    $page= load_page($id);
  }
  
  init_plugin("update_page", 50, "get", "pageupdate");
  function update_page() {
    page_update_page($_GET["pageupdate"], $_POST["headline"], $_POST["content"]);
    
    global $page;
    $page= load_page($_GET["pageupdate"]);
  }
  
  init_plugin("delete_page", 50, "get", "pagedel");
  function delete_page() {
    page_delete_page($_GET["pagedel"]);
  }
  
  class page {
    public $ID;
    public $headline;
    public $content;
    public $autor;
    
    function __construct($id) {
      global $page_db;
      
      $res = bk_db_query("SELECT ID, headline, content, autorID FROM $page_db WHERE ID = $id;", ARRAY_A);
      
      $this->ID = $res["ID"];
      $this->headline = $res["headline"];
      $this->content = $res["content"];
      $this->autor = get_user((int)$res["autorID"]);
    }
  }
  
  function page_new_page($headline, $content, $autor) {
    global $page_db;
    bk_db_query("INSERT INTO $page_db (headline, content, autorID) VALUES ('$headline', '$content', $autor);");
    $res = bk_db_query("SELECT ID FROM $page_db WHERE ID = LAST_INSERT_ID();", ARRAY_A);
    return $res["ID"];    
  }
  
  function page_update_page($id, $headline, $content) {
    global $page_db;
    if(!empty($headline) && !empty($content)) {
      bk_db_query("UPDATE $page_db SET headline = '$headline', content = '$content' WHERE ID = $id;");
    }
  }
  
  function page_delete_page($id) {
    global $page_db;
    bk_db_query("DELETE FROM $page_db WHERE ID = $id;");
  }
  
  if(function_exists("adminMenuInit")) adminMenuInit("Seiten", "page_admin_show");
  //if(function_exists("admin_menu_init")) admin_menu_init("Seiten", "page_admin_show");
  function page_admin_show() {
    global $page_db;
    $res = bk_db_query("SELECT ID, headline FROM $page_db ORDER BY ID;", ARRAY_A);
    
    ?>
      <a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=page_admin_new">neue Seite</a>
      <table>
      <tr><td>ID</td><td>Bezeichnung</td><td></td><td></td></tr>
      <?php foreach($res as $r) {
        ?>
          <tr>
          <td><?php echo $r["ID"]; ?></td>
          <td><?php echo $r["headline"]; ?></td>
          <td><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=page_admin_update&page=<?php echo $r["ID"]; ?>">&auml;ndern</a></td>
          <td><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=page_admin_show&pagedel=<?php echo $r["ID"]; ?>">l&ouml;schen</a></td>
          </tr>
        <?php
      }
      ?>
        </table>
    <?php
  }
  
  function page_admin_new() {
    ?>
      <form method="post" action="?<?php echo ADMIN_GET_MENU_FUNC; ?>=page_admin_update&pagenew=1">
      <label for="headline">&Uuml;berschrift</label>
      <input type="text" name="headline" value="" /><br />
      <label for="content">Inhalt</label>
      <div id="elrte" name="content"></div><br />
      <input type="hidden" value="<?php echo get_userinfo("ID"); ?>" name="userID" />
      <input type="submit" value="Speichern" /><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=page_admin_show">nicht Speichern</a>
      </form>
    <?php
  }
  
  function page_admin_update() {
    global $page;
    
    ?>
      <form method="post" action="?<?php echo ADMIN_GET_MENU_FUNC; ?>=page_admin_update&pageupdate=<?php echo $page->ID; ?>">
      <label for="headline">&Uuml;berschrift</label>
      <input type="text" name="headline" value="<?php echo $page->headline; ?>" /><br />
      <label for="content">Inhalt</label>
      <div id="elrte" name="content"><?php echo $page->content; ?></div><br />
      <input type="submit" value="Speichern" /><a href="<?php echo ADMIN_URL; ?>?<?php echo ADMIN_GET_MENU_FUNC; ?>=page_admin_show">nicht Speichern</a>
      </form>
    <?php
  }
  
  function page($id) {
    global $page;
    
    $page = load_page($id);
  }
  
  function get_page($type) {
    global $page;
    if(!empty($page)) echo $page->$type; 
  }
  
  function select_page_list($opt = "") {
    if($opt == "no_cat") return bk_db_query("SELECT ID, headline FROM bk_page WHERE ID NOT IN (SELECT info FROM bk_cat);", ARRAY_N);
    else return bk_db_query("SELECT ID, headline FROM bk_page;", ARRAY_N);
  }
  
  function get_autoValue_link($value) {
    $v = bk_db_query("SELECT ID, cat, cleanlink FROM bk_page WHERE ID = (SELECT ID FROM bk_menu WHERE autoValue = '".$value."');", ARRAY_A);
  }
?>