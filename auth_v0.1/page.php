<?php

session_start();

if (isset($_SESSION['is_auth'])) {
	echo "Hello, " . $_SESSION['login'] . ".";
	echo '<form method="GET" action="exit.php">
			<input type="submit" name="exit" value="Exit">
		</form>';
} else {
	header('Location: index.php');
}

?>