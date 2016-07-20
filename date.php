<?php

echo mydate();

function mydate()
{
	$now = getdate();

	$day = $now['wday'];
	$date = $now['mday'];
	$monthmy = $now['mon'];

	$weekdays = ['Воскресенье', 'Понедельник', 'Вторник', 
	'Среда', 'Четверг', 'Пятинца', 'Суббота'];

	$monthes = ['Декабря','Января','Февраля','Марта','Апреля',
	'Мая','Июня','Июнля','Августа','Сентября','Октября','Ноября'];

	return $weekdays[$day] . ', ' . $date . ' ' . $monthes[$monthmy];
}

?>