<?php

session_start();

require_once 'config.php';

$mysqli = new Mysqli($host, $user, $password, $dbname);

if (isset($_SESSION['is_auth']))
{
	$login = $_SESSION['login'];
	$sql = "SELECT user_id FROM `users` WHERE user_login = '$login'";
	$id = $mysqli->query($sql)->fetch_row()[0];

	if (isset($_GET['view_note']))
	{
		$note_id = $_GET['view_note'];

		$sql = "SELECT * FROM `table$id` WHERE note_id = '$note_id'";
		$row = $mysqli->query($sql)->fetch_row();

		echo "<p>$row[1]</p>";
		echo "<p>$row[2]</p>";
		echo "<p><a href=\"index.php?delete_note=$row[0]\">Удалить заметку</a></p>";
		echo "<p><a href=\"index.php\">К заметкам</a></p>";

		exit();
	}

	if (isset($_GET['delete_note']))
	{
		$id = $_GET['delete_note'];
		$login = $_SESSION['login'];

		$sql = "SELECT user_id FROM `users` WHERE user_login = '$login'";
		$table = 'table' . $mysqli->query($sql)->fetch_row()[0];
		$sql = "DELETE FROM `$table` WHERE `note_id` = '$id'";

		if ($mysqli->query($sql))
		{
			echo "Заметка успешно удалена";
		}
		else
		{
			echo "Ошибка при удалении заметки";
		}

		echo "<p><a href=\"index.php\">К заметкам</a></p>";

		exit();
	}

	echo "<p>Вы вошли как " . $_SESSION['login'] . "</p>";
	echo 
	'<form action="login.php" method="POST">
		<input type="submit" name="exit" value="Выйти">
	</form>';
	echo '<p><a href="addnote.php">Добавить заметку</a></p>';

	// Высчитываем, какие звметки нужно показать
	$pageViewsCount = 10;
	$page = $_GET['page'] ?? 1;
	if ($page <= 0) $page = 1;
	$minArt = $page * $pageViewsCount - $pageViewsCount;
	$maxArt = $page * $pageViewsCount;

	// Показать записи пользователя
	$sql = "SELECT * FROM `table$id` ORDER BY note_id DESC LIMIT $minArt, $maxArt";
	$result = $mysqli->query($sql);

	while ($row = $result->fetch_row())
	{
		if (strlen($row[2]) > 300)
		{
			$row[2] = substr($row[2], 0, 300) . '...';
		}

		echo
		"<div>
			<p><a href=\"index.php?view_note=$row[0]\">$row[1]</a></p>
			<p>$row[2]</p>
		</div>";
	}

	createButtions();
}
else if (isset($_POST['reg']))
{
	$login = $_POST['login'];
	$password = $_POST['password'];

	// Проверка на заполненые поля
	if (strlen($login) < 6 || strlen($password) < 6)
	{
		echo '<p>Не все поля формы заполнены или длина логина/пароля меньше 6 символов</p>';
		echo getRegisterForm();
		exit(); 
	}

	$password = md5($password);

	// Проверить, есть ли уже такой логин в базе
	$sql = "SELECT user_login FROM `users` WHERE user_login = '$login'";

	if ($mysqli->query($sql)->fetch_row())
	{
		echo "<p>Пользователь с таким логином уже существует</p>";
		echo "<p>Придумайте другой логин</p>";
		echo getRegisterForm();
		exit();
	}

	// Занести логин в базу
	$sql = "INSERT INTO `users` 
	(user_login, user_password)
	VALUES
	('$login', '$password')";

	if (!$mysqli->query($sql))
	{
		echo "<p>Ошибка при регистрации</p>";
	}
	// При успешной регистрации пользователя
	else
	{
		$createTableForRegistredUser = function() use ($login, $password, $mysqli) {
			// id пользователя, для которого
			// нужно создать таблицу записок
			$id;

			$sql = "SELECT user_id FROM `users` 
			WHERE user_login='$login' AND user_password='$password'";

			if ($result = $mysqli->query($sql))
			{
				while ($row = $result->fetch_row())
				{
					$id = $row[0];
				}
			}

			$sql = 
			"CREATE TABLE table$id (
			  note_id INT NOT NULL AUTO_INCREMENT,
			  note_header VARCHAR(50) NOT NULL,
			  note_text TEXT(100000) NOT NULL,
			  PRIMARY KEY (note_id)
			) CHARACTER SET utf8
			";

			if ($mysqli->query($sql))
			{
				return true;
			}

			return false;
		};

		// При успешном создании таблицы для заметок пользователя
		if ($createTableForRegistredUser())
		{
			$_SESSION['login'] = $login;
			$_SESSION['is_auth'] = true;
			echo "<p>Вы успешно зарегистрированы</p>";
			echo "<a href='index.php'>Начать работу</a>";
			// Отправить на почту логин и пароль
			#
		}
		// Удалить только что созданного пользователя
		else
		{
			$sql = "DELETE FROM `users` 
			WHERE `users`.`user_login` = '$login'";
			$mysqli->query($sql);
		}
	}
}
else
{
	echo "<p>Это главаная страница Evernote</p>";
	echo '<p>Зарегистрируйтесь</p>';
	echo getRegisterForm();
}

function getRegisterForm()
{
	return 
	'<form action="" method="POST">
		<p>Придумайте логин</p>
		<input type="text" name="login">
		<p>Придумайте пароль</p>
		<input type="text" name="password">
		<p><input type="submit" name="reg" value="Регистрация"></p>
	</form>
	<p><a href="login.php">Или войдите</a></p>';
}

function createButtions()
{
	$now = $_GET['page'] ?? 1;
	$next = $now + 1;
	$prev = $now - 1;
	$nextButton = "<a href=\"?page=$next\">Next</a>";
	$prevButtion = "<a href=\"?page=$prev\">Prev</a>";
	echo "<p>$prevButtion $nextButton</p>";
}
