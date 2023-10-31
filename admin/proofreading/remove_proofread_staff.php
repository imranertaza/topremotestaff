<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

    //deleting question answer
    $queryQu = $crud->delete('ts_proofread_answers', "proofread_user_id", $_POST['id']);
    $db->query($queryQu);
    //deleting question answer

	$query = $crud->delete('ts_proofread_users', "id", $_POST['id']);
	$result = $db->query($query);
	if($result){
		if($_POST['check'] == 2){
			header('Location: staff.php?tab=proofread');
		}else{
			header('Location: staff.php');
		}
			
	}
		
?>