<?php
/**
 * Class checks at which date, the cronjonnb can run
 */
class CheckSubstituteRun {

    public $context;

    public function __construct(sfContext $context) {
        $this->context = $context;
    }

    /**
     * Function checks if the current day can run a cronjob and is between to and from
     *
     * @param String $days, binary code for days, when Cron can run
     * @param String $from, time from
     * @param String $to, time to
     * @return boolean, true if the current time is between to and from, false if not
     */
    public function checkRun($days, $from, $to) {
        $hour = date("H",time());
        $hour = $this->checkDate($hour);
        $from = $this->checkDate($from);
        $to = $this->checkDate($to);
        if($this->checkDays($days) == 1) {
            if($hour >= $from AND $hour <= $to) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    /**
     *
     *
     * @param String $days, days in binary string
     * @return boolean $write, 1 can run, 0 cannot run
     */
    public function checkDays($days) {
        $result = array();
        $result = $this->getRunningDays($days, 7);
        $dateDay = getdate();
        $today = strtolower($dateDay['weekday']);
        $write = 0;
        switch($today) {
            case 'monday':
                if($result[6] == 1) {
                    $write = 1;
                }
                break;
            case 'tuesday':
                if($result[5] == 1) {
                    $write = 1;
                }
                break;
            case 'wednesday':
                if($result[4] == 1) {
                    $write = 1;
                }
                break;
            case 'thursday':
                if($result[3] == 1) {
                    $write = 1;
                }
                break;
            case 'friday':
                if($result[2] == 1) {
                    $write = 1;
                }
                break;
            case 'saturday':
                if($result[1] == 1) {
                    $write = 1;
                }
                break;
            case 'sunday':
                if($result[0] == 1) {
                    $write = 1;
                }
                break;
        }
        return $write;
    }

    /**
     * remomves 0 from 09, or 08 , 07 etc
     *
     * @param string $date, a day in a month
     * @return string
     */
    public function checkDate($date) {
        $firstChar = substr($date, 0, 1);
        if($firstChar == 0) {
            return substr($date, 1, 2);
        }
        else {
            return $date;
        }
    }

    /**
     * Build out of the Binary String, days where CJ can run
     *
     * @param String $number, binary String
     * @param int $count, mount of elements, not needed here
     * @return array $array, 7 days where CJ can run or not
     */
    public function getRunningDays($number, $count = 5) {
        $bin =  decbin ($number);
        
	$a = strlen($bin);
	for($a = strlen($bin);$a<$count;$a++) {
		$bin = '0' . $bin;
	}
	$array = str_split ($bin);
	return $array;
    }



}
?>
