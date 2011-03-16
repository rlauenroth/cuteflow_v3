<?php


    function createDayOutOfTimestampSince($timestamp) {
        $diff = ( strtotime('now') - strtotime($timestamp)) / 86400;
        return round($diff);
        
    }


    /**
     * Calculate days between 2 dates
     *
     * @param Date $date, Date in form : 2009-11-20 -> yyyy-mm-dd
     * @return string $diff, difference rounded in days
     */
    function createDayOutOfDateSince($date) {
        $date = explode(' ', $date);
        $diff = ( strtotime('now') - strtotime($date[0])) / 86400;
        return floor($diff);
    }

?>