<?php

    function getEndAction($number, $count = 5) {
	$bin = decbin ($number);
	$a = strlen($bin);
	for($a = strlen($bin);$a<$count;$a++) {
		$bin .= 0;
	}
	$array = str_split ($bin);
	return $array;
    }
?>
