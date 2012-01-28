/********************************************************************
 * openWYSIWYG settings file Copyright (c) 2006 openWebWare.com
 * Contact us at devs@openwebware.com
 * This copyright notice MUST stay intact for use.
 *
 * $Id: wysiwyg-settings.js,v 1.4 2007/01/22 23:05:57 xhaggi Exp $
 ********************************************************************/

/*
 * Full featured setup used the openImageLibrary addon
 *
var full = new WYSIWYG.Settings();
//full.ImagesDir = "images/";
//full.PopupsDir = "popups/";
//full.CSSFile = "styles/wysiwyg.css";
full.Width = "85%"; 
full.Height = "250px";
// customize toolbar buttons
full.addToolbarElement("font", 3, 1); 
full.addToolbarElement("fontsize", 3, 2);
full.addToolbarElement("headings", 3, 3);
// openImageLibrary addon implementation
full.ImagePopupFile = "addons/imagelibrary/insert_image.php";
full.ImagePopupWidth = 600;
full.ImagePopupHeight = 245;
*/
/*
 * Small Setup Example
 *
var small = new WYSIWYG.Settings();
small.Width = "350px";
small.Height = "100px";
small.DefaultStyle = "font-family: Arial; font-size: 12px; background-color: #AA99AA";
small.Toolbar[0] = new Array("font", "fontsize", "bold", "italic", "underline"); // small setup for toolbar 1
small.Toolbar[1] = ""; // disable toolbar 2
small.StatusBarEnabled = false;
*/

/*
 * bk-cms Editor
 */
var bk = new WYSIWYG.Settings();
bk.ImagesDir = "bk-func/lib/openwysiwyg/images/";
bk.PopupsDir = "bk-func/lib/openwysiwyg/popups/";
bk.CSSFile = "bk-func/lib/openwysiwyg/styles/wysiwyg.css";
bk.Width = "744px"; 
bk.Height = "300px";
bk.DefaultStyle = "font-family: sans-serif; font-size: 12px;";
bk.Toolbar[0] = new Array("font", "fontsize", "headings",	"bold", "italic", "underline", "strikethrough", "seperator", "forecolor", "backcolor", "seperator", "justifyfull", "justifyleft", "justifycenter", "justifyright", "seperator", "unorderedlist", "orderedlist", "outdent", "indent");
bk.Toolbar[1] = new Array("subscript", "superscript", "seperator", "cut", "copy", "paste", "seperator", "undo", "redo", "seperator", "inserttable", "insertimage", "createlink", "seperator", "preview", "viewSource");

var bk_admin = new WYSIWYG.Settings();
bk_admin.ImagesDir = "../bk-func/lib/openwysiwyg/images/";
bk_admin.PopupsDir = "../bk-func/lib/openwysiwyg/popups/";
bk_admin.CSSFile = "../bk-func/lib/openwysiwyg/styles/wysiwyg.css";
bk_admin.Width = "744px"; 
bk_admin.Height = "300px";
bk_admin.DefaultStyle = "font-family: sans-serif; font-size: 15px;";
bk_admin.Toolbar[0] = new Array("font", "fontsize", "headings",	"bold", "italic", "underline", "strikethrough", "seperator", "forecolor", "backcolor", "seperator", "justifyfull", "justifyleft", "justifycenter", "justifyright", "seperator", "unorderedlist", "orderedlist", "outdent", "indent");
bk_admin.Toolbar[1] = new Array("subscript", "superscript", "seperator", "cut", "copy", "paste", "seperator", "undo", "redo", "seperator", "inserttable", "insertimage", "createlink", "seperator", "preview", "viewSource");
