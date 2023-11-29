<?php
require '../email.php';
require '../config/database.php';
require '../controller/crud.php';

date_default_timezone_set('UTC');
$email = new EmailSender();
$crud = new Crud();
$numberOfQuestions = 0;
$correctAnswers = 0;

$date = new DateTime();

	if(!empty($_POST)){
		
		$question = $_POST['question'];
		$answers = array();
		$numberOfQuestions = count($question);
		for($z = 0 ; $z < count($question); $z++){
			$question_id = $question[$z];
			
			if(!isset($_POST['choice'.$question_id.''])){
				header('Location: index.php?exam=error');
			}
		}

		for($x = 0 ; $x < count($question); $x++){
			$question_id = $question[$x];
			$choice = $_POST['choice'.$question_id.''];
			array_push($answers,$choice);
			$getAnswer = mysqli_query($db, "SELECT correct FROM ts_frontendprogrammer_question_choices WHERE question_id='$question_id'");
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
		$checkEmail = $db->query($crud->getOrData('ts_frontendprogrammer_users', array("email"), array($_POST['email'])));
		$checkBlackList = $db->query($crud->getOrData('ts_frontendprogrammer_blacklist', array("email"), array($_POST['email'])));
		
		if ($checkEmail->num_rows > 0) {
			header('Location: index.php?email=error');
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
					'test_score' => $score,
					'status' => 0,
					//'date_created' => date("Y-m-d H:i:s")
					'date_created' => date("Y-m-d H:i:s" , $date->getTimestamp())
				);
				
				$query = $crud->add('ts_frontendprogrammer_users', $data);

				$result = $db->query($query);
					
				if($result){
					
					$insert_id = $db->insert_id;
					$answer_data = array(
						'frontendprogrammerg_user_id' => $insert_id,
						'question_details'  => json_encode($question),
						'answer_details'    => json_encode($answers),
						//'date_created'      => date("Y-m-d H:i:s")
						'date_created' => date("Y-m-d H:i:s" , $date->getTimestamp())
					);
					$db->query($crud->add('ts_frontendprogrammer_answers', $answer_data));
					
					header('Location: successful.php');
				}

			}
		}	
		
	}
?>
