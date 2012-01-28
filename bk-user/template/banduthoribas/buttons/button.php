<?php
  define("DEAULT_FONT", "bandu");
  
  $text = $_GET["text"];
  if(isset($_GET["src"]) && !empty($_GET["src"])) 
    $font = $_GET["src"];
  else
    $font = DEAULT_FONT;
  
  // a new PNG will only be created if there isn't one with the same text
  if(!file_exists("./$font$text.png")) {
    $height = 0;
    $width = 0;
    $size = strlen($text);
    $char = array();
  
    for($i = 0; $i < $size; $i++) {
      $char[$i]["l"] = $text{$i};
      $char[$i]["f"] = "./$font/{$char[$i]["l"]}.png";
      if(!file_exists($char[$i]["f"])) $char[$i]["f"] = "./".DEAULT_FONT."/{$char[$i]["l"]}.png";
      list($char[$i]["w"], $char[$i]["h"]) = getimagesize($char[$i]["f"]);
      $width += $char[$i]["w"];
      if($height <  $char[$i]["h"]) $height = $char[$i]["h"];
    }
    //echo "<pre>"; print_r($char);
  
    $im = imagecreate($width, $height);
    $dst_x = 0;
    for($i = 0; $i < $size; $i++) {
      $src = imagecreatefrompng($char[$i]["f"]);
      $dst_y = $height - $char[$i]["h"];
      imagecopy($im, $src, $dst_x, $dst_y, 0, 0, $char[$i]["w"], $char[$i]["h"]);
      $dst_x += $char[$i]["w"];
      imagedestroy($src);
    }
    $test = imagepng($im, "./$font$text.png");
    //if($test == false) print("NEEEEEEEEIIIIINNNN!!!!!"); exit;
  } else {
    // load PNG if it already exists
    $im = imagecreatefrompng("./$font$text.png");
  }
  
  // output PNG
  header ("Content-type: image/png");
  imagepng($im);
?>