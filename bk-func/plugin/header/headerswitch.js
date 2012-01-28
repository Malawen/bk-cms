<?php
/**
 * @plugin header
 * @since r1
 * @lastchage r1
 */
?>

/*$(document).ready(function() {
  $("div.mainmenu_entry").hover(function() {
    header.change(this.id);
  },
  function() {
    header.old(this.id);
  });
});

var header = {
  change : function() {
    switch("")
  },
  
  old : function() {
    
  }
}*/

function overwriteHeader(newPic) {
  var img = "<img class='headpic' src='./bk-user/template/badkoenig/banner/" + newPic + "' />";
  
  document.getElementById("headpic").innerHTML = img;
}

function delHeader() {
  document.getElementById("headpic").innerHTML = "";
}