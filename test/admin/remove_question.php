<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

	$query1 = $crud->delete('ts_questions', "id", $_POST['question_id']);
	$query2 = $crud->delete('ts_question_choices', "question_id", $_POST['question_id']);
	$result = $db->query($query1);
	if($result){
		header('Location: staff.php?tab=proofread');	
	}
		
?>