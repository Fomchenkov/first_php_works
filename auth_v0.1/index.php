<?php

session_start();

if ( isset($_SESSION['is_auth']) ) {
	header( 'Location: page.php' );
} else {
	header( 'Location: auth_form.php' );
}

?>