<?php
/** 
 * @plugin predigtarchiv
 * @since r4
 * @lastchage r4
 */
?>
<?php
  $predigt_db = "bk_predigt";
  
  function out_list() {
    $list = get_list();
    
    ?>
    <table>
    <?php foreach($list as $l) {?>
    <tr><td><?php echo $l["date"]; ?></td><td><?php echo $l["anlass"]; if(!empty($l["vers"])) {?> - <?php echo $l["vers"];} elseif(!empty($l["thema"])) {?> - <?php echo $l["thema"];} ?> - <?php echo $l["pfarrer"]; ?></td><td><?php echo $l["read"]; if(!empty($l["hear"])) {?></td><td><?php echo $l["hear"]; }?></td></tr>
    <?php } ?>
    </table>
    <?php
  }
?>