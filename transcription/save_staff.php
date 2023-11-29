<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);


session_start();
require '../admin/email.php';
require '../admin/config/database.php';
require '../admin/controller/crud.php';

$email = new EmailSender();
$crud = new Crud();


if(!empty($_POST)) {
	$checkEmail = $db->query($crud->getOrData('ts_users', array("email"), array($_POST['email'])));
	$checkBlackList = $db->query($crud->getOrData('ts_blacklist', array("email"), array($_POST['email'])));

	if ($checkEmail->num_rows > 0) {
		header('Location: index.html?email=error');
	}else{
		if ($checkBlackList->num_rows > 0) {
			header('Location: successful.php');
		}else{
			if(strlen($_POST['content']) >= 800){
				$encode_content = urlencode($_POST['content']);
				if (isset($_SERVER['HTTP_CLIENT_IP'])){
						$ip = $_SERVER['HTTP_CLIENT_IP'];
				}else {
					if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
						$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
					}else {
						$ip = $_SERVER['REMOTE_ADDR'];
					}
				}

				$code =  isset($_COOKIE["ts_code"]) ? $_COOKIE["ts_code"] : "";

				$data = array(
					'fullname' => $_POST['fullname'],
					'email' => $_POST['email'],
					'phone' => $_POST['phone'],
					'skype' => $_POST['skype'],
					'test_id' => $_POST['audioId'],
					'ip_address' => $ip,
					'code' => $code,
					'paypal' => "",
					'content' => $encode_content,
					'status' => 0,
					'date_created' => date("Y-m-d H:i:s")
				);


				$query = $crud->add('ts_users', $data);

				$result = $db->query($query);

				if($result){
					unset($_COOKIE['ts_code']);
					setcookie('ts_code', null, -1, '/', '/');

					header('Location: successful.php');
				}

			}else{
				header('Location: index.html?application=error');
			}
		}
	}

	die();

}
?>
