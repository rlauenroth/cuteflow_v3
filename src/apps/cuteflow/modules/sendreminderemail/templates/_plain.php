<?php echo $text . "\n"?>

<?php
    foreach ($workflow as $wf) {
        echo $wf['name'] . ': ' . $serverPath . '/layout/linklogin/versionid/'.$wf['workflowversion_id'].'/workflowid/'.$wf['workflow_id'] . '/userid/'.$userid.'/window/edit'."\n";
    }

?>