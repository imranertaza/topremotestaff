<?php
require '../admin/config/url.php';

	$value = "gsph";
	setcookie("ts_code", $value, time() + (86400 * 30),'/');
	header("Location: ".baseUrl."/transcription");

?>
