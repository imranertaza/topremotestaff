<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

	$query = $crud->deleteAll('ts_users', "id", $_POST['staff_ids']);
	$result = $db->query($query);

    $queryTest = $crud->deleteAll('ts_user_test', "user_id", $_POST['staff_ids']);
    $db->query($queryTest);
	
	if($result){
		header('Location: staff.php');		
	}
		
?>