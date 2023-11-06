<?php
	if(empty($_POST)){
		header('Location: login.php');
	}else{
		if($_POST['password'] == "passchk999"){
			setcookie("staff_session_id", "1", 2147483647);
			header('Location: staff.php');
		}else{
			header('Location: login.php?status=0');
		}
	}
?>