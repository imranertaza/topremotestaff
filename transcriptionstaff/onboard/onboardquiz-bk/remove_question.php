<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

	$query1 = $crud->delete('bk_list_of_questions', "id", $_POST['question_id']);
	$query2 = $crud->delete('bk_list_of_choices', "question_id", $_POST['question_id']);
	$result = $db->query($query1);
	$result2 = $db->query($query2);
	if($result && $result2){
		header('Location: questionaire.php');	
	}
		
?>