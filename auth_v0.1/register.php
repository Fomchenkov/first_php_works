<?php

require_once 'config.php';
session_start();

if ( isset($_POST['login']) && isset($_POST['password']) ) {

	$newLogin = $_POST['login'];
	$newPassword = $_POST['password'];

	if ( strlen( $newLogin ) >= 5 && strlen( $newPassword ) >= 5 ) {
		// conenct
 		// $mySql = new mysqli('localhost', 'slava', 'foma', 'db') or die('DataBase Error');
 		$mySql = new mysqli($host, $dbuser, $dbpass, 'db');
		// query string
 		$dataQuery = "INSERT INTO `users` (user_login, user_password) 
 		VALUES ('$newLogin', '$newPassword')";
 		// database query
 		if ($mySql->query($dataQuery)) {
 			// select new login/password
 			$queryLogin = "SELECT user_login FROM `users` WHERE user_password = '$newPassword'";
			$queryPassword ="SELECT user_password FROM `users` WHERE user_login = '$newLogin'";

			$log = $mySql->query($queryLogin);
			$pass = $mySql->query($queryPassword);

			if ($log && $pass) {
				success($log->fetch_row()[0], $pass->fetch_row()[0]);
				exit();
			} else {
				header('Location: register_form.php');
				// 'fail: can not write to database';
			}

 		} else {
 			header('Location: register_form.php');
 			// echo 'uncorrect database query';
 		}

	} else {
		header('Location: register_form.php');
		// echo 'fail: strlen < 5';
		exit();
	}
} else {
	header('Location: index.php');
	exit();
}

function success($login, $password)
{
	echo 'Registration success <br>';
	echo " Your login: " . $login . "<br>";
	echo " Your password: " . $password . "<br>";
	echo '<a href="index.php"> Return to Index </a>';
}

?>