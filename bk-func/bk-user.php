<?php
/** 
 * @since r1
 * @lastchage r1
 */
?>
<?php
  $user = (object)user;

  /**
   * Die Funktion stellt fest ob ein User eingeloggt ist oder nicht. Ist der User nicht eingeloggt wird er eingeloggt,
   * wenn der Benutzername und das Password stimmen.
   * Außerdem läd die Funktion die Klasse user.
   * 
   * @since r1
   * @lastchage r1
   * @access public
   * 
   * @globalvar $user
   * @usesfunction split_login_cookie()
   * @usesfunction convert_to_bool()
   * @usesfunction bk_db_query()
   * @usesclass user
   */

  function bk_user_logon() {
    if(isset($_GET[BK_GET_LOGOUT])) bk_user_logout();


    if(isset($_SESSION[BK_SESSION_LOGIN])) $session = $_SESSION[BK_SESSION_LOGIN]; else $session = array();
    if(isset($_COOKIE[BK_COOKIE_LOGIN])) $cookie = $_COOKIE[BK_COOKIE_LOGIN]; else $cookie = "";
    
    if(empty($session)) { //Keine Session
      if(empty($cookie)) { //Kein Cookie
        if(isset($_POST[BK_POST_LOGIN_USERNAME])) {
          $session["username"] = $_POST[BK_POST_LOGIN_USERNAME];
          if(isset($_POST[BK_POST_LOGIN_PASSWORD])) {
            $session["password"] = bk_user_code_password($_POST[BK_POST_LOGIN_PASSWORD]);
            if(isset($_POST[BK_POST_LOGIN_REMEMBER]) && SETTING_ALLOW_USER_REMEMBER == TRUE) {
              $session["remember"] = $_POST[BK_POST_LOGIN_REMEMBER];
              if(!bk_convert_to_bool($session["remember"])) unset($session["remember"]);
            } 
          }
        }
      } 
      else { //Cookie existiert
        list($session["username"], $session["password"], $session["remember"]) = bk_user_split_login_cookie($cookie);
        if(!bk_convert_to_bool($session["remember"])) unset($session["remember"]);
      }
    }
    
    if(!empty($session["username"]) && !empty($session["password"])) {
      global $db;
      
      list($userid) = bk_db_query("SELECT ID FROM $db->user WHERE username = '{$session['username']}' AND password = '{$session['password']}';", ARRAY_N);
      if($userid == NULL) {
        //TODO:Fehlerausgabe - Username oder Password falsch
      }
      else {
        $_SESSION[BK_SESSION_LOGIN] = $session;
        setcookie(BK_COOKIE_LOGIN, bk_user_make_login_cookie($session), time()+(int)BK_COOKIE_LOGIN_LIFETIME);
      }
    }
    
    global $user; 
    $user = new user($userid);
    
  }
  
  function bk_user_logout() {
    unset($_SESSION[BK_SESSION_LOGIN]);
    unset($_COOKIE[BK_COOKIE_LOGIN]);
    setcookie(BK_COOKIE_LOGIN, "", time()-1);
  }
  
  /**
   * Ermittelt den Password-Hash zu einem übergebenen String.
   * 
   * @since r1
   * @lastchage r1
   * @access public
   * 
   * @param (STRING)$pass - der String von welchem der Password-Hash ermittelt werden soll.
   * @return  (STRING) - der ermittelte Password-Hash
   */
  function bk_user_code_password($pass) {
    return md5($pass);
  }
  
  /**
   * Ermittelt aus dem übergebenen Wert (in der Regel der des Cookies für den Login) die einzelnen Werte.
   * 
   * @since r1
   * @lastchage r1
   * @access public
   * 
   * @param (STRING)$cookie - die Daten des Login-Cookies
   * @return (ARRAY) - [0] => username, [1] => passwordhash, [2] => remember
   */  
  function bk_user_split_login_cookie($cookie) {
    return explode(BK_LOGIN_SEPERATOR, $cookie, 3);
  }
  
  function bk_user_make_login_cookie($cookie) {
    return implode(BK_LOGIN_SEPERATOR, $cookie);
  }
  
  class user {
    private $groupid;
    
    public $ID;
    public $username;
    public $group;
    public $right = array();
    
    function __construct($id = NULL) {
      if(empty($id)) $this->load_guest();
      else $this->load_user($id);
      
      $this->load_group();
    }
    
    private function load_user($id) {
      global $db;
      
      $user = bk_db_query("SELECT * FROM $db->user WHERE ID = '$id';", ARRAY_A);
      
      unset($user["password"]);
      
      $this->array_to_object($user);
    }
        
    private function load_guest() {
      $user = array(  "ID" => NULL,
                      "username" => BK_USER_GAST_NAME,
                      "groupid" => BK_USER_GAST_GROUP);
                      
      $this->array_to_object($user);
    }
    
    private function load_group() {
      global $db;
      
      $group = bk_db_query("SELECT * FROM $db->group WHERE ID = $this->groupid;", ARRAY_A);
      $this->group = $group["name"];
      unset($group["name"]);
      unset($group["ID"]);
      $this->right = $group;
    }
    
    private function array_to_object($user) {
      $this->ID = $user["ID"];
      $this->username = $user["username"];
      $this->groupid = $user["groupid"];
    }
  }
  
  function check_user_password($pass) {
    global $user;
    global $db;
    
    $pass = bk_user_code_password($pass);
    
    list($userid) = bk_db_query("SELECT ID FROM $db->user WHERE username = '$user->username' AND password = '$pass';", ARRAY_N);
    if($userid == $user->ID) {
      return true;
    }
    else {
      return false;
    }
  }
  
###################################################################################################
###################################################################################################
  function get_user($id) {
    $user = new user($id);
    
    return $user;
  }
  
  
  function get_userinfo($type) {
    global $user;
    
    return $user->$type;
  }
  
  function is_guest() {
    if(NULL == get_userinfo('ID')) return true;
    else return false;
  }
  
  function is_user() {
    if(!is_guest()) return true;
    else return false;
  }
  
  function get_userright($type) {
    global $user;
    
    return $user->right[$type];
  }
  
###################################################################################################
###################################################################################################

  function logout_link($class) {
    ?><a href="?<?php echo BK_GET_LOGOUT; ?>=1" class="<?php echo $class; ?>">Logout</a><!--TODO:Text über Settings--><?php
  }
?>