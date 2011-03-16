<?php

    function AddStateIcon($state) {
        switch ($state) {
            case 'WAITING':
                return '<img src="/images/icons/hourglass.png" />';
            break;
            case 'SKIPPED':
                return '<img src="/images/icons/state_skip.png" />';
            break;
            case 'USERAGENTSET':
                return '<img src="/images/icons/state_skip.png" />';
            break;
            case 'STOPPEDBYADMIN':
                return '<img src="/images/icons/user_red.png" />';
            break;
            case 'STOPPEDBYUSER':
                return '<img src="/images/icons/user.png" />';
            break;
            case 'DONE':
                return '<img src="/images/icons/accept.png" />';
            case 'DELETED':
                return '<img src="/images/icons/delete.png" />';
            case 'ARCHIVED':
                return '<img src="/images/icons/disk.png" />';
            break;
        }

    }

?>
