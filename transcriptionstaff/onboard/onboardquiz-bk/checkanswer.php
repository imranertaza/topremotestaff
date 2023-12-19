<?php

//var_dump($_POST);
//die();
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();
$allquestions = array();
$result = array();
				$getQuestions = mysqli_query($db, "SELECT * FROM bk_list_of_questions WHERE status='1' and withchoices='1' ORDER BY date_created ASC");
				$questionsResult = mysqli_fetch_all($getQuestions, MYSQLI_ASSOC);
				$score = 0;
				$totalQuestions = 0;

					if(mysqli_num_rows($getQuestions) > 0){ 
						$totalQuestions = count($questionsResult);
						for($q = 0; $q < count($questionsResult); $q++){ 
						
							$id = $questionsResult[$q]['id'];
							$comment = ($questionsResult[$q]['comment'] == NULL)? "":$questionsResult[$q]['comment'];
							$getChoices = mysqli_query($db, "SELECT * FROM bk_list_of_choices WHERE question_id='$id'");
							$choicsResult = mysqli_fetch_all($getChoices, MYSQLI_ASSOC);
							
							$staff_answer = $_POST['question'.$id];
							
							if(mysqli_num_rows($getChoices) > 0){
								for($c = 0; $c < count($choicsResult); $c++){
									if($choicsResult[$c]['correct'] > 0){

										$db_answer = $choicsResult[$c]['description'];	

										if($staff_answer == $db_answer){
											$score += 1;
											array_push($result, array($id,1,$db_answer,$comment)); // 1 correct
										}else{
											array_push($result, array($id,0,$db_answer,$comment)); // 0 wrong
										}

									}
								}
							}

						}
					}
				if($score == $totalQuestions){
					$finalscore = 1; //perfect
				}else{
					$finalscore = 0; // not perfect
				}
				
				echo json_encode(array("result"=>$result,"score"=>$finalscore));

?>