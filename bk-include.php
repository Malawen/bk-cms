<?php
/** 
 * @since r1
 * @lastchage r1
 * 
 * Mit dieser Datei werden alle anderen php-Dateien geladen, welche immer benötigt werden
 * und daher fest im CMS verankert sind.
 */
?>
<?php
include('bk-define.php');
include('bk-setting.php');
include('bk-setting-public.php');

include(BK_PATH_FUNCTION.'bk-db.php');
include(BK_PATH_FUNCTION.'bk-function.php');
include(BK_PATH_FUNCTION.'bk-plugin.php');
include(BK_PATH_FUNCTION.'bk-template.php');
include(BK_PATH_FUNCTION.'bk-user.php');
?>