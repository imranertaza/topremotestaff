<?php
session_start();

require '../vendor/autoload.php';
require '../admin/email.php';
require '../admin/config/database.php';
require '../admin/controller/crud.php';
require 'admin/includes/file_upload_library.php';


date_default_timezone_set('UTC');
$email = new EmailSender();
$crud = new Crud();
$FP = new FileUpload();

$numberOfQuestions = 0;
$correctAnswers = 0;

$date = new DateTime();
	if(!isset($_REQUEST['timestamp']) || empty($_REQUEST['timestamp'])) {
		header('Location: exam.php');
	} else if(($date->getTimestamp() - $_REQUEST['timestamp']) > 1260) {
		header('Location: failed.php');
	}
	if(!empty($_POST)){

		$question = $_POST['question'];
		$answers = array();
		$numberOfQuestions = count($question);
		for($z = 0 ; $z < count($question); $z++){
			$question_id = $question[$z];
			
			if(!isset($_POST['choice'.$question_id.''])){
				header('Location: exam.php?mc=error');
			}
		}
		for($x = 0 ; $x < count($question); $x++){
			$question_id = $question[$x];
			$choice = $_POST['choice'.$question_id.''];
			array_push($answers,$choice);
			$getAnswer = mysqli_query($db, "SELECT correct FROM ts_virtualassistant_question_choices WHERE question_id='$question_id'");
			$answerResult = mysqli_fetch_all($getAnswer, MYSQLI_ASSOC);

			if(mysqli_num_rows($getAnswer) > 0){
				for($y = 0; $y < count($answerResult) ; $y++){
					if(!empty($answerResult[$y]['correct']) || $answerResult[$y]['correct'] >= 0){
						
						if($choice === $answerResult[$y]['correct']){
							$correctAnswers += 1;
						}
						
					}
				}
			}
				
			
		}
		$score = ($correctAnswers / $numberOfQuestions) * 100;
		$score = round($score,2);


		$checkEmail = $db->query($crud->getOrData('ts_virtualassistant_users', array("email"), array($_SESSION['email'])));
		$checkBlackList = $db->query($crud->getOrData('ts_virtualassistant_blacklist', array("email"), array($_SESSION['email'])));
//		print_R(json_encode($question));
//		print_R(json_encode($answers));
//		exit;
		if ($checkEmail->num_rows > 0) {
			header('Location: exam.php?email=error');
		}else{
			if($checkBlackList->num_rows > 0) {
				header('Location: successful.php');
			}else{

				$data = array(
					'fullname' => $_SESSION['fullname'],
					'email' => $_SESSION['email'],
					'phone' => $_SESSION['phone'],
					'skype' => $_SESSION['skype'],
					'typing_test_accuracy' => $_POST["typing_test_accuracy"],
					'typing_test_speed' => $_POST["typing_test_speed"],
					'voice_record' => $_SESSION["file_name_audioVideo"],
					'paypal' => "",
					'source' => (isset($_COOKIE["sourceURL"]) ? str_replace("'" , "\'" , trim($_COOKIE["sourceURL"])) : ""),
					'cv' => $_SESSION["file_name"],
					'test_score' => $score,
					'status' => 0,
					'account_type' => 0,
					//'date_created' => date("Y-m-d H:i:s")
					'date_created' => date("Y-m-d H:i:s" , $date->getTimestamp())
				);

				$query = $crud->add('ts_virtualassistant_users', $data);

				$result = $db->query($query);
					
				if($result){
					
					$insert_id = $db->insert_id;
					$answer_data = array(
						'virtualassistant_user_id' => $insert_id,
						'question_details'  => json_encode($question),
						'answer_details'    => json_encode($answers),
						//'date_created'      => date("Y-m-d H:i:s")
						'date_created' => date("Y-m-d H:i:s" , $date->getTimestamp())
					);
					$db->query($crud->add('ts_virtualassistant_answers', $answer_data));



					// Attached CV is uploading to storage server. (Start)
					$file_name = $_SESSION["file_name"];
					$outputFile = $_SESSION["outputFile"];
					$FP->folder = 'cv/';
					$uploadToStorage = $FP->uploadfiletostorage($file_name, $outputFile);
					if($uploadToStorage == true){
						$status = 'success';
						$statusMsg = "File was uploaded to the S3 bucket successfully!";
						unlink($_SESSION["outputFile"]);
						unlink($_SESSION["inputFile"]);
					}else{
						$statusMsg = "failed";
					}
					// Attached CV is uploading to storage server. (End)


					// Attached Voice Recode file is uploading to storage server. (Start)
					$file_name = $_SESSION["file_name_audioVideo"];
					$outputFile = $_SESSION["outputFile_audioVideo"];
					$FP->folder = 'voicerecording/';
					$uploadToStorage = $FP->uploadfiletostorage($file_name, $outputFile);
					if($uploadToStorage == true){
						$status = 'success';
						$statusMsg = "File was uploaded to the S3 bucket successfully!";
						unlink($_SESSION["outputFile_audioVideo"]);
//						unlink($_SESSION["inputFile"]);
					}else{
						$statusMsg = "failed";
					}
					// Attached Voice Recode file is uploading to storage server. (End)


					session_destroy();

					header('Location: successful.php');
				}

			}
		}	
		
	}

?>
