<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

	$query = $crud->delete('ts_users', "id", $_POST['id']);
	$result = $db->query($query);

    $querytest = $crud->delete('ts_user_test', "user_id", $_POST['id']);
    $db->query($querytest);

	if($result){
		if($_POST['check'] == 2){
			header('Location: staff.php?tab=approved');
		}else{
			header('Location: staff.php');
		}
			
	}
		
?>