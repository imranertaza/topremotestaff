<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


session_start();
require 'email.php';
require 'config/database.php';
require 'controller/crud.php';

$email = new EmailSender();
$crud = new Crud();


if(!empty($_POST)) {
	$checkEmail = $db->query($crud->getOrData('ts_users', array("email"), array(trim($_POST['email']))));
	$checkBlackList = $db->query($crud->getOrData('ts_blacklist', array("email"), array(trim($_POST['email']))));
//	$checkFingerprintId = $db->query($crud->getOrData('ts_users', array("fingerprint_id"), array($_POST['fingerprint_id'])));
//
//	if ($checkFingerprintId->num_rows > 0) {
//		header('Location: failed.php');
//		die();
//	}

	if ($checkEmail->num_rows > 0) {
		header('Location: failed.php');
	}else{
		if ($checkBlackList->num_rows > 0) {
			header('Location: failed.php');
		}else{

			//Validation
			function validStrLen($str, $min, $max){
				$len = strlen($str);
				if($len < $min){
					return false;
				}
				elseif($len > $max){
					return false;
				}
				return TRUE;
			}

			$nameValidation = validStrLen($_POST['fullname'], 0, 32);
			$phoneValidation = validStrLen($_POST['phone'], 5, 15);
			$skypeValidation = validStrLen($_POST['skype'], 0, 30);
			$content_1Validation = validStrLen(urlencode($_POST['video_content_1']), 0, 3000);
			$content_2Validation = validStrLen(urlencode($_POST['video_content_2']), 0, 3000);
			$content_3Validation = validStrLen(urlencode($_POST['video_content_3']), 0, 3000);
			$content_4Validation = validStrLen(urlencode($_POST['video_content_4']), 0, 3000);
			$content_5Validation = validStrLen(urlencode($_POST['video_content_5']), 0, 3000);

			if (($nameValidation == false) || ($phoneValidation == false) || ($skypeValidation == false) || ($content_1Validation == false) || ($content_2Validation == false) || ($content_3Validation == false) || ($content_4Validation == false) || ($content_5Validation == false) ){
				header('Location: failed.php');
			}

			if (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
					$ip = $_SERVER['REMOTE_ADDR'];
				}
			}

			$code = isset($_COOKIE["ts_code"]) ? $_COOKIE["ts_code"] : "";

			$data = array(
				'fullname' => urlencode($_POST['fullname']),
				'email' => $_POST['email'],
				'phone' => urlencode($_POST['phone']),
				'skype' => urlencode($_POST['skype']),
				'fingerprint_id' => $_POST['fingerprint_id'],
				'ip_address' => $ip,
				'code' => $code,
				'paypal' => "",
				'status' => 0,
				'date_created' => date("Y-m-d H:i:s")
			);


			$query = $crud->add('ts_users', $data);
			$db->query($query);
			$last_id = $db->insert_id;

			$dataTest = array(
				'user_id' => $last_id,
				'test_1_id' => $_POST['video_id_1'],
				'test_2_id' => $_POST['video_id_2'],
				'test_3_id' => $_POST['video_id_3'],
				'test_4_id' => $_POST['video_id_4'],
				'test_5_id' => $_POST['video_id_5'],
				'test_1_content' => urlencode($_POST['video_content_1']),
				'test_2_content' => urlencode($_POST['video_content_2']),
				'test_3_content' => urlencode($_POST['video_content_3']),
				'test_4_content' => urlencode($_POST['video_content_4']),
				'test_5_content' => urlencode($_POST['video_content_5']),
			);


			$queryTest = $crud->add('ts_user_test', $dataTest);
			$result = $db->query($queryTest);


			if ($result) {
				unset($_COOKIE['ts_code']);
				setcookie('ts_code', null, -1, '/', '/');

				header('Location: successful.php');
			}

		}
	}



}
?>
