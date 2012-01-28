<?php
/**
 * @since r1
 * @lastchage r1
 */
?>
<?php

  function bk_convert_to_bool(&$var) {
    $bool_f = array(  'false',
                      'False',
                      'FALSE',
                      'no',
                      'No',
                      'NO',
                      'n',
                      'N',
                      '0',
                      'off',
                      'Off',
                      'OFF',
                      false,
                      0,
                      null);
                    
    $bool_t = array(  'true',
                      'True',
                      'TRUE',
                      'yes',
                      'Yes',
                      'YES',
                      'y',
                      'Y',
                      '1',
                      'on',
                      'On',
                      'ON',
                      true,
                      1);
    
    if(in_array($var, $bool_f, true)) {
      unset($var);
      $var = false;
      return true;
    } 
    elseif(in_array($var, $bool_t, true)) {
      unset($var);
      $var = true;
      return true;
    }
    else {
      return false;
    }
  }
  
  function bk_complete_url($url) {
    if($url{0} == "/") {
      $r = BK_URL.$url;
    }
    elseif($url{0}.$url{1} == "./") {
      $r = BK_URL.substr($url,1);
    }
    elseif($url{0}.$url{1}.$url{2}.$url{3} == "http") {
      $r = $url;
    }
    else {
      $r = BK_URL.BK_URL_SEPERATOR.$url;
    }
    
    return $r;
  }

?>