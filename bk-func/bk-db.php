<?php
/**
 * @since r1
 * @lastchage r1
 */
?>
<?php
  function bk_db_connect() {
    global $db;
    
    $sql_type = BK_DB_TYPE;
    $db = new $sql_type();
  }
  
  function bk_db_query($query, $return_type = RESULT) {
    global $db;
    
    $result = $db->query($query);
    $return = NULL;
    
    switch($return_type) {
      case RESULT:
        $return = $result;
      break;
        
      case ARRAY_A:
        if(!is_bool($result)) {
          while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		        $return[] = $row;
          }
          if(count($return) == 1) {
            $return = $return[0];
          }
        }
      break;
        
      case ARRAY_N:
        if(!is_bool($result)) {
          while($row = mysql_fetch_array($result, MYSQL_NUM)) {
		        $return[] = $row;
          }
          if(count($return) == 1) {
            $return = $return[0];
          }
        }
      break;
      
      case ARRAY_AN:
        if(!is_bool($result)) {
          while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
		        $return[] = $row;
          }
          if(count($return) == 1) {
            $return = $return[0];
          }
        }
      break;
      
      case OBJECT_A:
        if(!is_bool($result)) {
          while($row = myysql_fetch_object($result)) {
		        $return[] = $row;
          }
          if(count($return) == 1) {
            $return = $return[0];
          }
        }
      break;
    }
    return $return;
  }

  class mysql {
    public $connection;
    public $query_count;
    public $user;
    public $group;
    public $plugin;
    
      function __construct() {
        $this->user = BK_DB_PRE.BK_TABLE_USER;
        $this->group = BK_DB_PRE.BK_TABLE_GROUP;
        $this->plugin = BK_DB_PRE.BK_TABLE_PLUGIN;
        
        $this->connection = mysql_connect(BK_DB_SERVER, BK_DB_USERNAME, BK_DB_PASSWORD);
        mysql_select_db(BK_DB_NAME, $this->connection);
      }
      
      public function query($query) {
        $this->query_count++;
        
        return mysql_query($query, $this->connection);
      }
  }
  
  function bk_db_name($name) {
    global $db;
    
    return $db->$name;
  }

?>