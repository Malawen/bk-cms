/**
 * @plugin menu
 * @since r1
 * @lastchage r1
 */

$(document).ready(function() {
  $("select.menu_admin_entry").each(function() {
    menuAdmin.hideShowLink(this.id, 0);
  });
  
  $("select.menu_admin_entry").change(function() {
    menuAdmin.hideShowLink(this.id, 0);
  });
  
  $(".menu_admin_entry_delete").change(function () {
    menuAdmin.deleteChange(this.id);
    
    $("#entry"+this.id.substr(15)+" a.menu_admin_posNum").toggle(0);
    $("#entry"+this.id.substr(15)+" a.menu_admin_posText").toggle(0);
    
    menuAdmin.writePos();
  });
  
  $(".menuButtonDelete").click(function() {
    return false;
  });
  
  $(".menuButtonSave").click(function() {
    menuAdmin.getNewOrder();
  });
  
  $(".menuButtonNew").click(function() {
    return false;
  });
  
  //Sort  
  $(".menu_admin_posOld").hide();
  
  $("#menuAdminEntryList").sortable({
    placeholder: "menuAdminEntryListPlaceholder",
    opacity: 0.8,
    axis: 'y',
    update: function(event, ui) {
      menuAdmin.writePos();
    }
  });
});

var menuAdmin = {
  //START - NewEntry
  NewEntry : function(id, pos) {
	var r = "<li class=\"menu_admin_entry\" id=\"entry"+id+"\">\r";
    //Positionierung
    r += "<div class=\"menu_admin_pos\">\r";
    r += "<a class=\"menu_admin_posOld\">alte Position: "+pos+"</a>\r";
    r += "<a class=\"menu_admin_posText\">Eintrag</a>\r";
    r += "<a class=\"menu_admin_posNum\">"+pos+"</a>\r";
    r += "</div>\r";
    //Menueeintrag
    r += "<div class=\"menu_admin_entry\">\r";
    r += "<label class=\"menu_admin_entry\">Bezeichnung:</label>\r";
    r += "<input type=\"text\" name=\"entry{$entry["ID"]}_bez\" class=\"menu_admin_entry\" value=\"{$entry["entry"]}\" /><br />\r";
    r += "<label class=\"menu_admin_entry\">Link:</label>\r";
    r += "<select name=\"entry{$entry["ID"]}_sel\" id=\"menuAdminSelect{$entry["ID"]}\" class=\"menu_admin_entry\">\r";
    r += "<option value=\"".MENU_MLINK."\" class=\"menu_admin_entry\">manueller Link</option>\r";
    r += "<option value=\"".MENU_HEADLINE."\" class=\"menu_admin_entry\">ohne Link</option>\r";
    r += "<option value=\"".MENU_EMPTY."\" class=\"menu_admin_entry\">leere Eintrag</option>\r";
    r += "<optgroup label=\"Kategorien\" class=\"menu_admin_entry\">\r";
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
    echo "</li>\r"
  },
  //END - NewEntry
		
  //START - Sort  
  getNewOrder : function() {
    var order = $("#menuAdminEntryList").sortable('toArray');
    var orderSerial = order[0].substr(5);
    
    for(var i = 1; i < order.length; i++) {
      orderSerial = orderSerial+";"+order[i].substr(5);
    }
    
    $("#menu_admin_entryPos").val(orderSerial);
  },
  
  writePos : function() {
    var i = 0;
    $(".menu_admin_posOld").show(0);
    $(".menu_admin_posNum:visible").each(function() {
      i++;
      this.text = i;
    }); 
  },
  
  //END - Sort  
  //START - Link
  hideShowLink : function(id, speed) {
    if($("#"+id).val() == "mLink") {
      this.hideLink(id.substr(15), speed);
    } else {
      this.showLink(id.substr(15), speed);
    }
  },
  
  hideLink : function(id, speed) {
    $("#menuAdminLink"+id).show(speed);
    $("#menuAdminLink"+id+" input").removeAttr('disabled');
  },
  
  showLink : function(id, speed) {
    $("#menuAdminLink"+id).hide(speed);
    $("#menuAdminLink"+id+" input").attr('disabled', true);
  },
  //END - Link
  
  //START - Delete
  deleteChange : function(id) {
    if($("#"+id).attr("checked")) {
      this.deleteChecked(id.substr(15));
    } else {
      this.deleteUnChecked(id.substr(15));
    }
  },
  
  deleteChecked : function(id) {
    $("#entry"+id+" .menu_admin_entry").eq(1).attr('disabled', true);
    for(var i = 1; i < $("#entry"+id+" label.menu_admin_entry").size(); i++) {
      $("#entry"+id+" label.menu_admin_entry").eq(i).hide();
      $("#entry"+id+" input.menu_admin_entry, #entry"+id+" select.menu_admin_entry").eq(i).hide();
      $("#entry"+id+" br").eq(i).hide();
    }
  },
  
  deleteUnChecked : function(id) {
    $("#entry"+id+" .menu_admin_entry").eq(1).removeAttr('disabled');
    for(var i = 1; i < $("#entry"+id+" .menu_admin_entry").size(); i++) {
      $("#entry"+id+" label.menu_admin_entry").eq(i).show();
      $("#entry"+id+" input.menu_admin_entry, #entry"+id+" select.menu_admin_entry").eq(i).show();
      $("#entry"+id+" br").eq(i).show();
    }
  },
  //END - Delete
  
  //START - DeleteMenu
  deleteMenuClick : function() {
    alert("Wirklich löschen? - Hier muss noch was anderes hin... Der 'Alert' ist nur mal zum überbrücken!");
  }
  //END - DeleteMenu
}