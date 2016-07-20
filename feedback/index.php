<?php
	mb_internal_encoding("UTF-8");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Feedback</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="feedback.css">
	<script type="text/javascript" src="feedback.js" define></script>
</head>
<body>
<div id="feeddiv">
	<form id="forma" action="feedback.php" method="POST" onsubmit="formValidate()">
		<input type="text" name="tema" id="feedinp" placeholder="Topic" autofocus><br>
		<textarea id="feedtextarea" placeholder="Massage" name="textar"></textarea><br>
		<input type="submit" name="subm" id="subm">
	</form>
</div>
</body>
</html>