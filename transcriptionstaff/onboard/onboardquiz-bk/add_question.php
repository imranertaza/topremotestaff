<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();
	if(!empty($_POST)){
		
		$question = $_POST['question'];
		$choices = $_POST['choices'];
		$answer = $_POST['answer'];
		$comment = $_POST['comment'];
		if(isset($_POST['withchoices'])){
			if($_POST['withchoices'] == "on"){
				$withchoices = 1;
			}
		}else{
			$withchoices = 0;
		}
		if(isset($_POST['required'])){
			if($_POST['required'] == "on"){
				$required = 1;
			}
		}else{
			$required = 0;
		}
		$points = 1;
		
		$question_data = array(
			'question' => $question,
			'withchoices' => $withchoices,
			'required' => $required,
			'points' => $points,
			'comment' => $comment,
			'status' => 1,
			'date_created' => date("Y-m-d H:i:s")
		);
				
		$question_query = $crud->add('bk_list_of_questions', $question_data);
		$question_result = $db->query($question_query);
					
		if($question_result){
			$insert_id = $db->insert_id;
			
			for($x = 0 ; $x < count($choices); $x++){
				
				if($answer == $x){
					$correct = 1;
				}else{
					$correct = 0;
				}
				
				$choices_data = array(
					'question_id' => $insert_id,
					'description' => $choices[$x],
					'correct' => $correct,
					'date_created' => date("Y-m-d H:i:s")
				);
							
				$choices_query = $crud->add('bk_list_of_choices', $choices_data);
				$db->query($choices_query);
					
			}
		}
		
	}
	
	header('Location: questionaire.php');
	
?>