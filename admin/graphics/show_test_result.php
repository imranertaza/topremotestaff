<?php
require '../config/database.php';
require '../controller/crud.php';

$crud = new Crud();

	if(!empty($_POST)){
		$id = $_POST['id'];

		$getProofReadTestResult = mysqli_query($db, "SELECT * FROM ts_graphics_answers WHERE graphics_user_id='$id'");
		$proofReadTestResult = mysqli_fetch_all($getProofReadTestResult, MYSQLI_ASSOC);
		if(mysqli_num_rows($getProofReadTestResult) > 0){ 
			$allQuestions = json_decode($proofReadTestResult[0]['question_details']);
			$allAnswers = json_decode($proofReadTestResult[0]['answer_details']);
			for($q = 0; $q < count($allQuestions); $q++){
				
				$firstText = "";
				$secondText = "";
				
				$q_id = $allQuestions[$q];
				$getSpecificQuestion = mysqli_query($db, "SELECT * FROM ts_graphics_questions WHERE id='$q_id'");
				$specificQuestionResult = mysqli_fetch_all($getSpecificQuestion, MYSQLI_ASSOC);
				
				$firstText = '<p class="questions" style="margin-bottom:0px;"><span> ' . $q + 1 . ' </span> ' . $specificQuestionResult[0]['question'] . ' </p>';
				$secondText = '<ul style="margin-top:5px;display:inline;padding-left:5px;">';
				echo $firstText;
				echo '<ul style="margin-top:5px;display:inline;padding-left:5px;">';
				$getTestResultChoices = mysqli_query($db, "SELECT * FROM ts_graphics_question_choices WHERE question_id='$q_id'");
				$choicesResult = mysqli_fetch_all($getTestResultChoices, MYSQLI_ASSOC);
					if(mysqli_num_rows($getTestResultChoices) > 0){
						for($c = 0; $c < count($choicesResult); $c++){
							
							if(($allAnswers[$q] == $c && $choicesResult[$c]['correct'] == $allAnswers[$q]) || $choicesResult[$c]['correct'] != "") {
								echo "<li style='padding:0 1rem;display:inline;color:black;'>&#9675; <strong>" . $choicesResult[$c]['description'] . "</strong></li>";   
							} else if($allAnswers[$q] == $c) {
								echo "<li style='padding:0 1rem;display:inline;color:red;'>&#9675; <span>" . $choicesResult[$c]['description'] . "</span></li>";
							} else if($choicesResult[$c]['correct'] == NULL || $choicesResult[$c]['correct'] == "") {
								echo "<li style='padding:0 1rem;display:inline;'>&#9675; <span>" . $choicesResult[$c]['description'] . "</span></li>";
							}
						}
					}
					
				echo '</ul>';
			}
		}
		
	}
?>
