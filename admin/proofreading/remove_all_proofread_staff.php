<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

    //deleting question answer
    $queryQu = $crud->deleteAll('ts_proofread_answers', "proofread_user_id", $_POST['staff_ids']);
    $db->query($queryQu);
    //deleting question answer


	$query = $crud->deleteAll('ts_proofread_users', "id", $_POST['staff_ids']);
	$result = $db->query($query);
	
	if($result){
		header('Location: staff.php?tab=pending');
	}
		
?>