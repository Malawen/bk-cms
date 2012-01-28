<?php
/** 
 * @plugin cat
 * @since r1
 * @lastchage r1
 */
?>
<?php  
  /*admin_menu_init("Categorien", "cat_admin");
  function cat_admin() {
    if(isset($_GET["cat"]) && $_GET["cat"] != "") {
      
    }
    else {
      $catlist = get_cat_list();
    }
  }*/

  /*function get_cat_list() {
    
  }*/
  
  init_plugin("load_cat_by_get", 100, "get", "cat");
  function load_cat_by_get() {
    global $cat;

    $cat = load_cat($_GET["cat"]);
  }
  
  function load_cat($cat) {
    $catobj = new cat($cat);
    
    return $catobj;
  }
  
  class cat {
    private $db;
    
    public $ID;
    public $name;
    public $menu;
    public $infoID;
    public $info;
    public $headerpic;
    
    function __construct($cat) {
      $this->db = BK_DB_PRE."cat";
      
      if(is_numeric($cat)) $res = bk_db_query("SELECT ID, catname, menu, info, headerpic FROM $this->db WHERE ID = $cat;", ARRAY_A);
      else $res = bk_db_query("SELECT ID, catname, menu, info, headerpic FROM $this->db WHERE catname = '$cat';", ARRAY_A);
      
      $this->ID = $res["ID"];
      $this->name = $res["catname"];
      $this->menu = $res["menu"];
      $this->infoID = $res["info"];
      $this->headerpic = $res["headerpic"];
      
      $infopage = load_page($this->infoID);
      $this->info = $infopage->content;
    }
  }
  
 function get_cat($id, $return = E) {
  global $cat;
  
  if(!empty($cat)) {
    if($return == E) echo $cat->$id;
    else return $cat->$id;
  }
 }
 
  function select_cat_list() {
    global $cat;
    global $db;
    
    $cat = bk_db_query("SELECT ID, catname FROM bk_cat;", ARRAY_N);
    
    return $cat;
  }
  
?>