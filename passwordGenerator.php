<?php

	function passwordGeteration ($num) {
		$simbols = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
		$password = '';
		for ($i=0; $i < $num; $i++) {
			$password .= $simbols[mt_rand(0, count($simbols)-1)];
		}
		return $password;
	}

	echo passwordGeteration(5);

?>

<script>

	function passGeneration (num) {
		var simbols = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
		var password = '';
		for (var i=0; i < num; i++) {
			var number = Math.floor(Math.random() * simbols.length)
			password += simbols[number];
		}
		return password;
	}

	document.body.innerHTML += '<br>' + passGeneration(5);

</script>