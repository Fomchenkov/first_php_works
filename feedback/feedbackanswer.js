/*
	Через 3 секунды c feedback.php возвращаемся на index.php
*/

function interval () {
	if (sec > 1) {
		sec--;
		document.getElementById('spancount').innerHTML = sec;
	} else {
		clearInterval(timer);
		window.location = "index.php";
	}
}

var sec = 3;
var timer = setInterval(function () {interval()}, 1000)