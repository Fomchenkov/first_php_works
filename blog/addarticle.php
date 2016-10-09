<?php

require_once 'config.php';

echo "<p><a href=\"index.php\">Return to index page</a></p>";

if (isset($_POST['sbm']))
{
	$sql = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);

	$topic = validateStringToNull($_POST['topic']);
	$text = validateStringToNull($_POST['text']);

	if (!$topic || !$text)
	{
		echo "<p>Write in all fields</p>";
		echoForm();
		exit();
	}

	$query = "
	INSERT INTO `articles` (article_topic, article_text)
	VALUES 
	('$topic', '$text')";

	if (!$sql->query($query))
	{
		echo "<p>Can not post message in blog</p>";
	}
	else
	{
		echo "<p>Message posted in blog</p>";
	}
}
else
{
	echoForm();
}

function validateStringToNull($str)
{
	if ($str == '' || $str == null)
	{
		return false;
	}

	return $str;
}

function echoForm()
{
	echo 
	'<form method="POST">
		<p>Topic:</p>
		<input type="text" name="topic">
		<p>Text message</p>
		<textarea name="text"></textarea>
		<p><input type="submit" name="sbm" value="Post in blog"></p>
	</form>';
}
