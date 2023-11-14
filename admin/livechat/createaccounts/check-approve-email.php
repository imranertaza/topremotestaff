<?php
require 'config/database.php';
session_start();
	if(empty($_POST)){
		header('Location: '.$_SERVER['PHP_SELF']);
	}else{
		$email = $_POST['email'];
		$getApproved = mysqli_query($db, "SELECT * FROM ts_proofread_users WHERE status='1' and email='$email' ORDER BY date_updated DESC");
		$approveResult = mysqli_fetch_all($getApproved, MYSQLI_ASSOC);	
		
		
		 if(mysqli_num_rows($getApproved) > 0){
			$name = $approveResult[0]['fullname'];
			$role = $approveResult[0]['account_type'];
			$_SESSION["name"] =  $name;
			$_SESSION["email"] =  $email;
			$_SESSION["role"] =  $role;
			$_SESSION["auto_create_account_status"] = 1;
			header('Location: index.php');  
		 }else{
			 $_SESSION["auto_create_account_status"] = 0;
			header('Location: index.php'); 
		 }
	}
?>
