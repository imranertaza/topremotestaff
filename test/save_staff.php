<?php
require './admin/email.php';
require './admin/config/database.php';
require './admin/controller/crud.php';

date_default_timezone_set('UTC');
$email = new EmailSender();
$crud = new Crud();
session_start();
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
			$getAnswer = mysqli_query($db, "SELECT correct FROM ts_question_choices WHERE question_id='$question_id'");
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
		$checkEmail = $db->query($crud->getOrData('ts_proofread_users', array("email"), array($_POST['email'])));
		$checkBlackList = $db->query($crud->getOrData('ts_proofread_blacklist', array("email"), array($_POST['email'])));
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
					'fullname' => $_POST['fullname'],
					'email' => $_POST['email'],
					'phone' => $_POST['phone'],
					'skype' => $_POST['skype'],
					'paypal' => "",
					'source' => (isset($_COOKIE["sourceURL"]) ? str_replace("'" , "\'" , trim($_COOKIE["sourceURL"])) : ""),
					'test_score' => $score,
					'status' => 0,
					//'date_created' => date("Y-m-d H:i:s")
					'date_created' => date("Y-m-d H:i:s" , $date->getTimestamp())
				);
				
				$query = $crud->add('ts_proofread_users', $data);

				$result = $db->query($query);
					
				if($result){
					
					$insert_id = $db->insert_id;
					$answer_data = array(
						'proofread_user_id' => $insert_id,
						'question_details'  => json_encode($question),
						'answer_details'    => json_encode($answers),
						//'date_created'      => date("Y-m-d H:i:s")
						'date_created' => date("Y-m-d H:i:s" , $date->getTimestamp())
					);
					$db->query($crud->add('ts_proofread_answers', $answer_data));
					
					header('Location: successful.php');
				}

			}
		}	
		
	}
?>
