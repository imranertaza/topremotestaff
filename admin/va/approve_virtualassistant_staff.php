<?php
require '../../vendor/autoload.php';
require 'email.php';
require 'config/database.php';
require 'controller/crud.php';
require '../includes/file_upload_library.php';
date_default_timezone_set('UTC');

$email = new EmailSender();
$crud = new Crud();
$FileUpload = new FileUpload();

	if($_POST['status'] == 0){

		// Deleting CV from the S3 storage server (Start)
		$selectQuery = $crud->getSelectedData('cv', 'ts_virtualassistant_users', "id", $_POST['id']);
		$getResult = $db->query($selectQuery);
		$FileUpload->deletefilefromstorage($getResult->fetch_assoc()['cv']);
		// Deleting CV from the S3 storage server (End)


		// Deleting CV from the S3 storage server (Start)
		$selectQuery = $crud->getSelectedData('voice_record', 'ts_virtualassistant_users', "id", $_POST['id']);
		$getResult = $db->query($selectQuery);
		$FileUpload->folder = 'voicerecording/';
		$FileUpload->deletefilefromstorage($getResult->fetch_assoc()['voice_record']);
		// Deleting CV from the S3 storage server (End)



		$query = $crud->delete('ts_virtualassistant_users', "id", $_POST['id']);
		$result = $db->query($query);
		if($result){
			$data = array(
				'email' => $_POST['email'],
				'skype' => $_POST['skype'],
				'paypal' => $_POST['paypal']
			);
	
			$queryReject = $crud->add('ts_virtualassistant_blacklist', $data);
			$resultReject = $db->query($queryReject);


			if($resultReject){
				$recipient = $_POST['email'];
				$subject = "TopRemoteStaff Registration";
				$bodyHtml = "<p>Dear ".urldecode($_POST['fullname']).",<br/><br/>Thank you for your application,  unfortunately  we can not accept your application at this moment.<br/><br/>Yours Sincerely,<br/><br/>Management<br/>TopRemoteStaff.com</p>";
				$email->send($recipient, $subject, $bodyHtml);
				header('Location: staff.php');
			}
		}
		
		
	}else{
		$date = new DateTime();

		$getTranscriberEmailContent = mysqli_query($db, "SELECT * FROM ts_virtualassistant_approve_email_template WHERE type='1'");
		$transcriberResult = mysqli_fetch_all($getTranscriberEmailContent, MYSQLI_ASSOC);

                $transcriberContent = str_replace("%24name",urldecode($_POST['fullname']),$transcriberResult[0]['content']);
                $transcriberContent = str_replace("%24email",$_POST['email'],$transcriberContent);
                $transcriberContent = htmlentities(urldecode($transcriberContent));


		$getProofreaderEmailContent = mysqli_query($db, "SELECT * FROM ts_virtualassistant_approve_email_template WHERE type='2'");
		$proofreaderResult = mysqli_fetch_all($getProofreaderEmailContent, MYSQLI_ASSOC);

                $proofreaderContent = str_replace("%24name",urldecode($_POST['fullname']),$proofreaderResult[0]['content']);
                $proofreaderContent = str_replace("%24email",$_POST['email'],$proofreaderContent);
                $proofreaderContent = htmlentities(urldecode($proofreaderContent));
		
		
		$data = array(
			'status' => 1,
			'date_updated' => $date->getTimestamp(),
			'account_type' => $_POST['account_type']
		);

//		$bodyHtml = "";
		if($_POST['account_type'] == 1){
                        $bodyHtml = "<p style='white-space: pre-line;'>" . $transcriberContent . "</p>";

                }else{
                        $bodyHtml = "<p style='white-space: pre-line;'>" . $proofreaderContent . "</p>";
                }

		$query = $crud->update('ts_virtualassistant_users', $data, "id", $_POST['id']);
		$result = $db->query($query);
		
		if($result){
			
			$subject = "TopRemoteStaff Job Application Successful";
			$email->sendToCompany($_POST['email'], $subject, $bodyHtml);
			header('Location: staff.php?tab=pending');
			
		}
		
	}

?>
