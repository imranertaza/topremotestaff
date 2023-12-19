<?php
require 'config/url.php';
date_default_timezone_set('UTC');
session_start();
unset($_SESSION['timestamp']);
echo '<center><a href="'.getBaseUrl().'index.php"><img src="img/logo1.png" style="margin-top:2rem;"></a><br><br>';
echo '<b>Please fill out all of the required fields correctly</b></center>';
?>


