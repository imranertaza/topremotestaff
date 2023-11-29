<?php
session_start();
require 'email.php';
require 'config/database.php';
require 'controller/crud.php';
date_default_timezone_set('UTC');
$emailLib = new EmailSender();
$crud = new Crud();

	if(empty($_POST)){
		if(isset($_SESSION["auto_create_account_status"])){
			$_SESSION['auto_create_account_status'] = 1;
		}
		header('Location: index.php');
	}else{
		$email = preg_replace('/\s+/', '', $_SESSION["email"]);
		$checkUser = mysqli_query($db, "SELECT * FROM ts_proofread_users WHERE email='$email'");
		$userRes = mysqli_fetch_all($checkUser, MYSQLI_ASSOC);

		if(mysqli_num_rows($checkUser) > 0){
			$checkPaypal = preg_match("/^[a-z0-9._\-]+@[a-z0-9]+([-_\.]?[a-zA-Z0-9])+\.[a-z]{2,4}/", $_POST['paypal']);
			if($checkPaypal > 0){
				if($_POST['password'] == $_POST['vpassword']){
					if($_POST['paypal'] == $_POST['vpaypal']){
						if(ctype_alnum($_POST['password']) && strlen($_POST['password']) > 5){
							$email = urlencode($email);
							$name = urlencode($_SESSION["name"]);
							$paypal = preg_replace('/\s+/', '', $_POST['paypal']);
							$paypal = urlencode($paypal);
							$password = urlencode($_POST['password']);
							$role = urlencode($_SESSION["role"]);
							//echo "$email - $paypal - $password - $role<BR>";
							$url = 'http://proofreading.topremotestaff.com/ppcreateacc.php?code=123213123&action=createacc&acctype='.$role.'&name='.$name.'&email='.$email.'&paypal='.$paypal.'&password='.$password;
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $url); 
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.7) Gecko/20050414 Firefox/1.0.3");
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
							$result = curl_exec ($ch); 
							curl_close ($ch);
							
							$response = explode(" ",$result);
							
							if(count($response) > 1){
								$check = $response[0];
								$login = $response[1];
								if($check == "CREATED" || $check == "created"){
									$check = true;
								}
							}else{
								if($response[0] == "FAILED" || $response[0] == "failed"){
									$check = false;
								}
							}
							
							if($check){
								if($_SESSION["role"] == 1){
									$getEmailContent = mysqli_query($db, "SELECT * FROM ts_approve_email_template WHERE type='3'");
								}else{
									$getEmailContent = mysqli_query($db, "SELECT * FROM ts_approve_email_template WHERE type='4'");
								}
								$emailResult = mysqli_fetch_all($getEmailContent, MYSQLI_ASSOC);

								$emailContent = str_replace("%24name",$name,$emailResult[0]['content']);
								$emailContent = str_replace("%24login",$login,$emailContent);
								$emailContent = str_replace("%24password",$_POST['password'],$emailContent);
								$emailContent = htmlentities(urldecode($emailContent));
									
								$bodyHtml = "<p style='white-space: pre-line;'>" . $emailContent . "</p>";
								$subject = "TopRemoteStaff Account Successful Created";
								
								$query = $crud->delete('ts_proofread_users', "email", $_SESSION["email"]);
								$db->query($query);
							
								$emailLib->sendToCompany($_SESSION["email"], $subject, $bodyHtml);
								echo '<style>body{font-family:Arial;}</style><a href="index.php"><img src="img/logo1.png" style="display: block;margin: 1.5rem auto 0 auto;" class="img-fluid"></a><h2 style="text-align:center">Welcome to TopRemoteStaff</h2><p style="text-align:center">We have created your account and sent you a welcome email with your login details. Please read it carefully.  <br>If you can not find your welcome email, be sure to check your spam folder.  You can also reach the help desk at help@topremotestaff.com.</p>';
								
								unset($_SESSION['name']);	
								unset($_SESSION['email']);	
								unset($_SESSION['role']);	
								unset($_SESSION['auto_create_account_status']);	
								
							}else{
								$query = $crud->delete('ts_proofread_users', "email", $_SESSION["email"]);
								$db->query($query);
								
								$_SESSION["auto_create_account_status"] = 2; 
								header('Location: index.php'); 
							}
						}else{
							$_SESSION["auto_create_account_status"] = 5;
							header('Location: index.php'); 
						}
						 
					}else{
						$_SESSION["auto_create_account_status"] = 4;
						header('Location: index.php'); 
					}
				}else{
					$_SESSION["auto_create_account_status"] = 3;
					header('Location: index.php'); 
				}
			}else{
				$_SESSION["auto_create_account_status"] = 6;
				header('Location: index.php'); 
			}
			
		}else{
			$_SESSION["auto_create_account_status"] = 2; 
			header('Location: index.php'); 
		}
	}
?>
