<?php

session_start();

if ( isset($_GET['exit']) ) {
	$_SESSION = [];
	session_destroy();
}

header('Location: index.php');

?>