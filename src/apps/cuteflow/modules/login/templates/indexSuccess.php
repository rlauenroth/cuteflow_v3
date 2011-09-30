<form>
    <input type="hidden" id="hidden_url" value="<?php echo url_for(''); ?>"> 
    <input type="hidden" id="hidden_login" value="<?php echo url_for('login/DoLogin'); ?>"> 
    <input type="hidden" id="hidden_changelanguage" value="<?php echo url_for('login/ChangeLanguage'); ?>"> 
    <input type="hidden" id="hidden_loadlanguage" value="<?php echo url_for('login/LoadLanguage'); ?>">
    <input type="hidden" id="version_id" value="<?php echo $version_id ?>">
    <input type="hidden" id="workflow_id" value="<?php echo $workflow_id ?>">
    <input type="hidden" id="window" value="<?php echo $window ?>">
</form>
<?php
if ($theTheme != 'DEFAULT') {
    echo '<link rel="stylesheet" type="text/css" media="screen" href="/themes/' . $theTheme . '" />';
}
?>
