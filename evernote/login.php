<?php

session_start();

if (isset($_POST['exit']))
{
	session_destroy();
	header('Location: index.php');
}
else if (isset($_SESSION['is_auth']))
{
	header('Location: index.php');
}
else if (isset($_POST['log']))
{
	require_once 'config.php';

	$mysqli = new Mysqli($host, $user, $password, $dbname);

	$login = $_POST['login'];
	$password = $_POST['password'];

	// Проверка на заполненые поля
	if (strlen($login) < 6 || strlen($password) < 6)
	{
		echo '<p>Не все поля формы заполнены или длина логина/пароля меньше 6 символов</p>';
		echo getLoginForm();
		exit(); 
	}

	$password = md5($password);

	// Поиск в базе введенных логина и пароля
	$sql = "SELECT user_login FROM `users` 
	WHERE user_login = '$login' AND user_password = '$password'";

	// Если логин и пароль найдены успешно
	if ($mysqli->query($sql)->fetch_row())
	{
		$_SESSION['login'] = $login;
		$_SESSION['is_auth'] = true;
		header('Location: index.php');
	}
	else
	{
		echo 'Неверный логин или пароль';
		echo getLoginForm();
		exit();
	}
}
else
{
	echo getLoginForm();
}

function getLoginForm()
{
	return
	'<p>Вход на сайт</p>
	<form action="login.php" method="POST">
		<p>Логин</p>
		<input type="text" name="login">
		<p>Пароль</p>
		<input type="text" name="password">
		<p><input type="submit" name="log" value="Войти"></p>
	</form>
	<p><a href="index.php">Или зарегистрируйтесь</a></p>';
}
