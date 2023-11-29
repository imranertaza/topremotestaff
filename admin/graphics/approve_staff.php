<?php
require '../email.php';
require '../config/database.php';
require '../controller/crud.php';
date_default_timezone_set('UTC');

$email = new EmailSender();
$crud = new Crud();

	if($_POST['status'] == 0){
		
		$query = $crud->delete('ts_graphics_users', "id", $_POST['id']);
		$result = $db->query($query);
		if($result){
			$data = array(
				'email' => $_POST['email'],
				'skype' => $_POST['skype'],
				'paypal' => $_POST['paypal']
			);
	
			$queryReject = $crud->add('ts_graphics_blacklist', $data);
			$resultReject = $db->query($queryReject);
			
			if($resultReject){
				$recipient = $_POST['email'];
				$subject = "Transcription Staff Registration";
				$bodyHtml = "<p>Dear ".$_POST['fullname'].",<br/><br/>Thank you for your application,  unfortunately  we can not accept your application at this moment.<br/><br/>Yours Sincerely,<br/><br/>Management<br/>TopRemoteStaff.com</p>";
				$email->send($recipient, $subject, $bodyHtml);
				header('Location: staff.php');
			}
		}
		
		
	}else{
		$date = new DateTime();

		$getTranscriberEmailContent = mysqli_query($db, "SELECT * FROM ts_graphics_approve_email_template WHERE type='1'");
		$transcriberResult = mysqli_fetch_all($getTranscriberEmailContent, MYSQLI_ASSOC);

		$transcriberContent = str_replace("%24name",$_POST['fullname'],$transcriberResult[0]['content']);
		$transcriberContent = str_replace("%24email",$_POST['email'],$transcriberContent);
		$transcriberContent = htmlentities(urldecode($transcriberContent));

		$getProofreaderEmailContent = mysqli_query($db, "SELECT * FROM ts_graphics_approve_email_template WHERE type='2'");
		$proofreaderResult = mysqli_fetch_all($getProofreaderEmailContent, MYSQLI_ASSOC);
		
		$proofreaderContent = str_replace("%24name",$_POST['fullname'],$proofreaderResult[0]['content']);
		$proofreaderContent = str_replace("%24email",$_POST['email'],$proofreaderContent);
		$proofreaderContent = htmlentities(urldecode($proofreaderContent));

		
		$data = array(
			'status' => 1,
			'date_updated' => $date->getTimestamp(),
			'account_type' => $_POST['account_type']
		);

		if($_POST['account_type'] == 1){
			$bodyHtml = "<p style='white-space: pre-line;'>" . $transcriberContent . "</p>";
			
		}else{
			$bodyHtml = "<p style='white-space: pre-line;'>" . $proofreaderContent . "</p>";
		}
		
		$query = $crud->update('ts_graphics_users', $data, "id", $_POST['id']);
		$result = $db->query($query);
		
		if($result){
			
			$subject = "TranscriptionStaff Job Application Successful";
			$email->sendToCompany($_POST['email'], $subject, $bodyHtml);
			header('Location: staff.php');
			
		}
		
	}

?>