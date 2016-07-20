<?php
session_start();
if (isset($_SESSION['is_auth'])) {
	header('Location: index.php');
} else {
	echo 
	'<form action="register.php" method="POST">
		Новый логин:
		<br>
		<input type="text" name="login">
		<br>
		Новый пароль:
		<br>
		<input type="text" name="password">
		<br>
		<input type="submit" name="subm" value="Зарегистрироваться">
	</form>';
}
?>