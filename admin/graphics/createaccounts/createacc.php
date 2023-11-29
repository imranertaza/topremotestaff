<?php
define("CODE", "123213123");
if(isset($_GET)){
	$code = $_GET['code'];
	$role = urldecode($_GET['acctype']);
	$name = urldecode($_GET['name']);
	$email = urldecode($_GET['email']);
	$paypal = urldecode($_GET['paypal']);
	$password = urldecode($_GET['password']);
	
	$query = false;  //database response after adding the user
	if($code == CODE){
		if($query){
			echo "created if1001";
		}else{
			echo "failed";
		}
	}else{
		echo "failed";
	}
	
}
?>