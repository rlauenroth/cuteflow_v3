<html>
    <head></head>
    <body>
        <table width="823">
            <tr>
                <td colspan="2" width="587" height="35" style="background-color:#CCC;font-size:16px;font-family:Tahoma, Geneva, sans-serif;"><b>&nbsp;<?php echo $text?></b></td>
            </tr>
            <tr>
                <td height="20"></td>
                <td height="20"></td>
            </tr>
            <tr>
                <td style="background-color:#F90;font-size:14px;font-family:Tahoma, Geneva, sans-serif;"><b><?php echo $workflowname?></b></td>
                <td style="background-color:#F90;font-size:14px;font-family:Tahoma, Geneva, sans-serif;"><b><?php echo $linkto?></b></td>
            </tr>
            <tr>
                <td colspan="2" height="7"></td>
            </tr>
            <?php
                $colorFlag = '#FF9';
                foreach ($workflow as $wf) {
                    switch($colorFlag) {
                        case '#FC0':
                            $colorFlag = '#FF9';
                            break;
                        case '#FF9':
                            $colorFlag = '#FC0';
                            break;
                    }

                    echo '<tr>';
                    echo '<td style="background-color:'.$colorFlag.';font-size:14px;font-family:Tahoma, Geneva, sans-serif;">'.$wf['name'].'</td>';
                    echo '<td style="background-color:'.$colorFlag.';font-size:14px;font-family:Tahoma, Geneva, sans-serif;"><a href="'.$serverPath.'/layout/linklogin/versionid/'.$wf['workflow_version_id'].'/workflowid/'.$wf['workflow_id'].'/userid/'.$userid.'/window/edit" target="_blank">'.$linkto.'</a></td>';
                    echo '</tr>';
                }

            ?>
            <tr>
                <td colspan="2" height="40"></td>
            </tr>
            <tr>
                <td colspan="2" height="40"><center>
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