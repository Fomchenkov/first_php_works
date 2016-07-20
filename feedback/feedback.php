<?php
mb_internal_encoding("UTF-8");

if (!empty($_POST['tema']) && !empty($_POST['textar'])) {
	$myMail = 'spamtospam@yandex.ru';
	$topic = trim(strip_tags($_POST['tema']));
	$textar =  trim(strip_tags($_POST['textar']));

	@$mailto = mail($myMail, $topic, $textar, 'my test site', "Content-type:text/html;charset=UTF-8");
	
	if ($mailto) {
		echo "<!DOCTYPE html>\n";
		echo "<meta charset=\"utf-8\">";
		echo "<script src=\"feedbackanswer.js\" defer></script>\n";
		echo "<body>\nВаше письмо успешно отправленo<br>";
		echo "Через <span id=\"spancount\">3</span> секунды вы вернетесь на главную страницу\n</body>";
	} else {
		echo "<!DOCTYPE html>\n";
		echo "<meta charset=\"utf-8\">";
		echo "<script src=\"feedbackanswer.js\" defer></script>\n";
		echo 'Произошла ошибка. Пожалуйста, попробуйте ещё раз.<br>';
		echo "Через <span id=\"spancount\">3</span> секунды вы вернетесь на главную страницу\n<br>";
		echo "<a href=\"index.php\">Index page</a>\n<body>";
	}
} else {
	header('Location: index.php');
}