<html>
    <head></head>
    <body>
        <table width="823">
            <tr>
                <td colspan="2" width="587" height="35" style="background-color:#CCC;font-size:16px;font-family:Tahoma, Geneva, sans-serif;">&nbsp;<?php echo $text['workflow'][0] . ' <b>' . $text['workflow'][1] . '</b>';?></td>
            </tr>
            <tr>
                <?php
                    $url = $serverPath.'/layout/linklogin/versionid/'.$workflowverion.'/workflowid/'.$workflow. '/userid/'.$userid.'/window/edit';
                ?>
                <td colspan="2" style="font-size:16px;font-family:Tahoma, Geneva, sans-serif;"><a href="<?php echo $url; ?>" target="_blank"><?php echo $linkto;?></a></td>
            </tr>
            <tr>
                <td height="20"></td>
                <td height="20"></td>
            </tr>
            <?php
            foreach($slots as $slot) {
                $fields = $slot['fields'];
                echo '<tr>';
                echo '<td colspan="2" height="20" style="background-color:#F90;font-size:15px;font-family:Tahoma, Geneva, sans-serif;">'.$text['workflow'][2] . ': ' .  $slot['slotname'].'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td colspan="2" height="10"></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td height="20" style="background-color:#F63;font-size:14px;font-family:Tahoma, Geneva, sans-serif;">'.$text['workflow'][5].'</td>';
                echo '<td height="20" style="background-color:#F63;font-size:14px;font-family:Tahoma, Geneva, sans-serif;">'.$text['workflow'][6].'</td>';
                echo '</tr>';
                foreach($fields as $field) {
                    if ($field['column'] == 'LEFT') {
                        $color = '#FF9';
                    }
                    else {
                       $color = '#FC9';
                    }

                    echo '<tr>';
                    echo '<td height="18" width="30%" style="background-color:'.$color.';font-size:12px;font-family:Tahoma, Geneva, sans-serif;">'.$field['fieldname'].': </td>';
                    echo '<td height="18" style="background-color:'.$color.';font-size:12px;font-family:Tahoma, Geneva, sans-serif;">';
                    if($field['type'] == 'COMBOBOX') {
                       foreach($field['items'] as $item) {
                           if($item['value'] == 1) {
                               echo $item['name'];
                           }
                       }
                    }
                    else if($field['type'] == 'RADIOGROUP') {
                        foreach($field['items'] as $item) {
                            if($item['value'] == 1) {
                                echo $item['name'];
                            }
                        }
                    }
                    else if ($field['type'] == 'CHECKBOXGROUP') {
                        foreach($field['items'] as $item) {
                            if($item['value'] == 1) {
                                echo $item['name'] . '; ';
                            }
                        }
                    }
                    else if ($field['type'] == 'FILE') {
                        if($slot['isdisabled'] == 0) {
                            echo '<a href="'.$field['items']['plainurl'].'" target="_blank">'.$field['items']['filename'].'</a>';
                        }
                    }
                    else if ($field['type'] == 'CHECKBOX') {
                        if($field['items']['value'] == 1) {
                            echo $text['workflow'][3];
                        }
                        else {
                            echo $text['workflow'][4];
                        }
                    }
                    else {
                        echo $field['items']['value'];
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                echo '<tr>';
                echo '<td colspan="2" height="35"></td>';
                echo '</tr>';
            }
            ?>
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