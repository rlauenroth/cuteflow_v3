<?php echo $text['workflow'] . "\n"?>
<?php
    $url = url_for('layout/linklogin',true).'/versionid/'.$workflowverion.'/workflowid/'.$workflow. '/userid/'.$userid.'/window/follow';
    echo $linkto . ': ' . $url . "\n\n";
?>
<?php echo $text['currentslot'][0]?>: "<?php echo $text['currentslot'][1]?>" <?php echo $text['currentslot'][2] . "\n"?>
<?php echo $text['nextSlot'][0]?>: "<?php echo $text['nextSlot'][1]?>" <?php echo $text['nextSlot'][2]?>







