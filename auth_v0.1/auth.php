<?php

require_once 'config.php';
session_start();

if ( isset( $_POST['login'] ) && isset( $_POST['password'] )) {
	// from $_POST
	$login = $_POST['login'];
	$password = $_POST['password'];

	if (!empty($login) && !empty($password)) {
		// DataBase connect
		// $mySql = new mysqli('localhost', 'slava', 'foma', 'db') or die('DataBase Error');
		$mySql = new mysqli($host, $dbuser, $dbpass, 'db');
		// query strings
		$queryLogin = "SELECT user_login FROM `users` WHERE user_login = '$login'";
		$queryPassword =  "SELECT user_password FROM `users` WHERE user_password = '$password'";
		// query to database
		$logRes = $mySql->query($queryLogin); // ->fetch_assoc()['user_login'];
		$passRes = $mySql->query($queryPassword); // ->fetch_assoc()['user_password'];

		if ($logRes && $passRes) {
			$originalLogin = $logRes->fetch_row()[0];
			$originalPassword = $passRes->fetch_row()[0];
			// validate
			if ( $login == $originalLogin && $password == $originalPassword ) {

				$_SESSION['is_auth'] = true;
				$_SESSION['login'] = $login;
				header( 'Location: page.php' );
				exit();

			} else {
				header( 'Location: index.php' );
				exit();
			}
		} else {
			header( 'Location: index.php' );
			exit();
		}
	} else {
		header( 'Location: index.php' );
		exit();
	}	
} else {
	header( 'Location: index.php' );
	exit();
}

?>