<?php
require 'config/database.php';
require 'controller/crud.php';
$crud = new Crud();

$question_id = $_POST['question_id'];

	$data = array(
		'comment' => $_POST['comment']
	);
		
	$query = $crud->update('pr_list_of_questions', $data, 'id', $question_id);
	$db->query($query);
		
	
	$db->close();

	header("Location: questionaire.php");	

?>