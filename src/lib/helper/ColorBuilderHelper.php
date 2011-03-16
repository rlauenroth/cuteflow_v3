<?php
    function addColor ($daysinprogress, $red, $orange, $yellow) {
        $color = 'green';
        if($daysinprogress < $yellow) {
            $color = 'green';
        }
        elseif($daysinprogress >= $yellow AND $daysinprogress < $orange) {
            $color = 'yellow';
        }
        elseif($daysinprogress >= $orange AND $daysinprogress < $red) {
            $color = 'orange';
        }
        else {
            $color = 'red';
            
        }
        return '<b><font color="'.$color.'">' . $daysinprogress . '</font></b>';
    }








?>