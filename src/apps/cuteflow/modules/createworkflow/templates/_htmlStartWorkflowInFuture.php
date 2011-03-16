<html>
    <head></head>
    <body>
        <table width="823">
            <tr>
                <?php
                    $url = $serverPath . '/layout/linklogins/versionid/'.$workflow['id'].'/workflowid/'.$workflow['workflowtemplate_id'] . '/userid/'.$userid.'/window/follow';
                ?>
                <td width="587" height="35" style="background-color:#CCC;font-size:16px;font-family:Tahoma, Geneva, sans-serif;">&nbsp;<?php echo $text?> <a href="<?php echo $url; ?>" target="_blank"><b><?php echo $linkto?></b></a></td>
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
                            ?>
                        </a></center></td>
            </tr>
        </table>
    </body>
</html>