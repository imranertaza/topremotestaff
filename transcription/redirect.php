<?php
	$value = "gsph";
	setcookie("ts_code", $value, time() + (86400 * 30),'/');
	header("Location: http://topremotestaff.dn/transcription/");

?>
