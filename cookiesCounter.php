<?php

cookies();

function cookies(){
	if (!isset($_COOKIE['visit'])) {
		$count = 0;
	} else {
		$count = $_COOKIE['visit'];
	}

	$count++;
	setcookie('visit', $count, time() + 3600);
}

?>