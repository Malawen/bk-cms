<?php
/**
 * @lib openwysiwyg
 * @since r2
 * @lastchange r2
 */
?>
<?php
  function load_openwysiwyg() {
    add_jsfile(BK_URL."/bk-func/lib/openwysiwyg/scripts/wysiwyg.js");
    add_jsfile(BK_URL."/bk-func/lib/openwysiwyg/scripts/wysiwyg-settings.js");
    add_js("WYSIWYG.attach('openwysiwyg_bk', bk_admin);");
  }
?>