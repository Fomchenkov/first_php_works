<?php

session_start();

if (isset($_POST['add']))
{
	require_once 'config.php';

	$mysqli = new Mysqli($host, $user, $password, $dbname);

	$header = $_POST['header'];
	$text = $_POST['text'];
	$login = $_SESSION['login'];

	if (empty($header))
	{
		$header = "Безымянная записка";
	}

	$sql = "SELECT user_id FROM `users` WHERE user_login = '$login'";
	$id = $mysqli->query($sql)->fetch_row()[0];

	$sql = "INSERT INTO `table$id` 
	(note_header, note_text)
	VALUES
	('$header', '$text')";

	if (!$mysqli->query($sql))
	{
		echo "<p>Не удается добавить заметку. Попробуйте еще раз</p>";
		echo getAddNoteForm();
		exit();
	}
	
	echo "<p>Заметка успешно добавлена</p>";
	echo '<p><a href="index.php">Перейти к заметкам</a></p>';
}
else if (isset($_SESSION['is_auth']))
{
	echo getAddNoteForm();
}
else
{
	header('Location: index.php');
}

function getAddNoteForm()
{
	return
	'<form action="" method="POST">
		<p>Заголовок</p>
		<input type="text" name="header"></p>
		<p>Описание</p>
		<p><textarea name="text"></textarea></p>
		<p><input type="submit" name="add" value="Добавить заметку"></p>
	</form>';
}
