<?php
session_start();
if (isset($_SESSION['is_auth'])) {
	header('Location: index.php');
} else {
	echo
	'<form method="POST" action="auth.php">
		<input type="text" name="login">
		<br>
		<input type="text" name="password">
		<br>
		<input type="submit" name="enter" value="Log In">
		<br>
		<a href="register_form.php">Registration</a>
	</form>';
}
?>