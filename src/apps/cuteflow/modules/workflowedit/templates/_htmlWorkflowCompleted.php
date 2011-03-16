<html>
    <head></head>
    <body>
        <table width="823">
            <tr>
                <td width="587" height="35" style="background-color:#CCC;font-size:16px;font-family:Tahoma, Geneva, sans-serif;"><?php echo $text['workflow'][0] . ' <b>' .  $text['workflow'][1] . '</b> ' . $text['workflow'][2]?></td>
            </tr>
            <tr>
                <?php
                    $url = url_for('layout/linklogin',true).'/versionid/'.$workflowverion.'/workflowid/'.$workflow. '/userid/'.$userid.'/window/follow';
                ?>
                <td height="35" style="font-size:16px;font-family:Tahoma, Geneva, sans-serif;"><a href="<?php echo $url; ?>" target="_blank"><?php echo $linkto;?></a></td>
            </tr>
            <tr>
                <td height="40"><center>
                        <a href="http://www.cuteflow.org" target="_blank">
                            <?php
                                $request = sfContext::getInstance()->getRequest();
                                $host =  $request->getHost();
                                $script = $request->getScriptName();
                                $url = 'http://' . $host . $script . '/images/icons/cuteflow_email.png';
                                echo '<img src="'.sfConfig::get('sf_web_dir') . '/images/icons/cuteflow_email.png'.'" />';
                                #echo '<img src="/images/icons/cuteflow_email.png" />';
                            ?>
                        </a></center></td>
            </tr>
        </table>
    </body>
</html>