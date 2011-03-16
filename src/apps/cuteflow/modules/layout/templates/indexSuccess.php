
<?php
    // loading mask -.-
    echo '<div id="loading"><div id="loading-message" style="border:solid;"><table><tr><td><img src="/images/icons/loading.gif" /></td><td>' . __('Loading CuteFlow. Please wait...','','layout') . '</td></tr></table></div></div>';
    $filepath = sfConfig::get('sf_app_dir') . '/config/template.yml';
    $cacheEnabled = sfYAML::Load($filepath);
    if($cacheEnabled['enableJavaScriptCache']['isEnabled'] == 1) { // caching is enabled
        $ccCache = new TemplateCaching();
        $ccCache->checkCacheDir();
        $ccCache->setFiles();
        $lastModified = $ccCache->getLastModifiedFile();
        $cacheCreated = $ccCache->getCurrentCacheStamp();

        if($lastModified > $cacheCreated OR $cacheCreated == '') {
            if($cacheCreated == '') {
                $cacheCreated = $lastModified;
            }
            $ccCache->createCache($lastModified, $cacheCreated);
        }
        $dir = array_diff(scandir(sfConfig::get('sf_cache_dir') . '/javaScriptCache'), Array());
        echo ' <script type="text/javascript" src="/djs/cache/'.$dir[count($dir)-1].'"></script>' . "\n";
    }
    else { // caching is off
        echo '<script type="text/javascript" src="/djs/namespace/main.js"></script>';
        $files = new JavaScriptLoader();
        $jsFiles = $files->getAllFiles();
        foreach($jsFiles['djs'] as $singeFile) {
            echo '<script type="text/javascript" src="'.$singeFile.'"></script>' . "\n";
        }
    }
?>

<input type="hidden" id="version_id" value="<?php echo $version_id?>">
<input type="hidden" id="workflow_id" value="<?php echo $workflow_id?>">
<input type="hidden" id="window" value="<?php echo $window?>">
<?php
    if($theTheme != 'DEFAULT') {
        echo '<link rel="stylesheet" type="text/css" media="screen" href="/themes/'.$theTheme.'" />';
    }
 ?>
<script type="text/javascript" src="/js/i18n/<?php echo Login::buildExtjsLanguage($sf_user->getCulture());?>/ext-lang.js"/>


