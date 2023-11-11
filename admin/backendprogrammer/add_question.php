<?php
require '../email.php';
require '../config/database.php';
require '../controller/crud.php';

date_default_timezone_set('UTC');
$email = new EmailSender();
$crud = new Crud();


	if(!empty($_POST)){
		
		$question = $_POST['question'];
		$choices = $_POST['choices'];
		$answer = $_POST['answer'];

		$date = new DateTime();

		$question_data = array(
			'question' => $question,
			'status' => 1,
			//'date_created' => date("Y-m-d H:i:s")
			'date_created' => date("Y-m-d H:i:s" , $date->getTimestamp())
		);
				
		$question_query = $crud->add('ts_backendprogrammer_questions', $question_data);
		$question_result = $db->query($question_query);
					
		if($question_result){
			$insert_id = $db->insert_id;
			
			for($x = 0 ; $x < count($choices); $x++){
				
				if($answer == $x){
					$correct = $answer;
				}else{
					$correct = "";
				}
				
				$choices_data = array(
					'question_id' => $insert_id,
					'description' => $choices[$x],
					'correct' => $correct,
					//'date_created' => date("Y-m-d H:i:s")
					'date_created' => date("Y-m-d H:i:s" , $date->getTimestamp())
				);
							
				$choices_query = $crud->add('ts_backendprogrammer_question_choices', $choices_data);
				$db->query($choices_query);
					
			}
		}
		
	}
	
	header('Location: staff.php?tab=mc_questions');
	
?>
