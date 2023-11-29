<?php
require 'email.php';
require 'config/database.php';
require 'controller/crud.php';

$email = new EmailSender();
$crud = new Crud();
$numberOfQuestions = 0;
$correctAnswers = 0;

	if(!empty($_POST)){
		
		$question = $_POST['question'];
		$numberOfQuestions = count($question);
		for($z = 0 ; $z < count($question); $z++){
			$question_id = $question[$z];
			
			if(!isset($_POST['choice'.$question_id.''])){
				header('Location: exam.php?error=true');
			}
		}

		for($x = 0 ; $x < count($question); $x++){
			$question_id = $question[$x];
			$choice = $_POST['choice'.$question_id.''];
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
		$accuracy = ($correctAnswers / $numberOfQuestions) * 100;
		echo "Correct Answer: " . $correctAnswers . "/" . $numberOfQuestions . " ($accuracy%)";

	}
	

	
?>