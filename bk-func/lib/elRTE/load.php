<?php
/**
 * @lib elRTE
 * @since r4
 * @lastchange r4
 */
?>
<?php
  function load_elRTE() {          
    add_jsfile(BK_URL."/bk-func/lib/elRTE/js/elrte.min.js");
    add_jsfile(BK_URL."/bk-func/lib/elRTE/js/i18n/elrte.de.js");
    add_cssfile(BK_URL."/bk-func/lib/elRTE/css/elrte.min.css");
    add_js("$().ready(function() {
    var opts = {
    cssClass : 'el-rte',
    lang     : 'de',
    height   : 450,
    toolbar  : 'complete',
    cssfiles : ['css/elrte-inner.css']
    }
    $('#elrte').elrte(opts);
    })");
  }
?>