<?php

require_once 'config.php';

$sql = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);

if (isset($_GET['article']))
{
	echo "<p><a href=\"index.php\">Return to index page</a></p>";

	$article = $_GET['article'];

	$query = "SELECT * FROM `articles` WHERE article_id = '$article'";

	$result = $sql->query($query);

	while ($row = $result->fetch_row()) 
	{
		echo 
		"<div>
			<p>Post number: $row[0]</p>
			<p>$row[1]</p>
			<p>$row[2]</p>
		</div>";
	}

	createButtions('article');
}
else
{
	echo '<a href="addarticle.php">Add new article in blog</a>';

	$query = "SELECT * FROM `articles` ORDER BY article_id DESC LIMIT 10";

	if (isset($_GET['page']))
	{
		$page = $_GET['page'];

		if ($page <= 0) $page = 1;

		$minArt = $page * $pageViewsCount - $pageViewsCount;
		$maxArt = $page * $pageViewsCount;
		$query = "SELECT * FROM `articles` ORDER BY article_id DESC LIMIT $minArt, $maxArt";
	}

	$result = $sql->query($query);

	while ($row = $result->fetch_row()) 
	{
		if (strlen($row[2]) > $maxSymbolsViews)
		{
			$row[2] = mb_strimwidth($row[2], 0, $maxSymbolsViews, '... ')
			. "<a href=\"?article=$row[0]\">Read fully</a>";
		}

		echo 
		"<br>
		<div>
			<p><a href=\"?article=$row[0]\"><p>$row[1]</a></p>
			<p>$row[2]</p>
		</div>";
	}

	createButtions('page');
}

function createButtions($who = 'article')
{
	$now = $_GET[$who] ?? 1;

	$next = $now + 1;
	$prev = $now - 1;

	$nextButton = "<a href=\"?$who=$next\">Next</a>";
	$prevButtion = "<a href=\"?$who=$prev\">Prev</a>";

	echo "<p>$prevButtion $nextButton</p>";
}
