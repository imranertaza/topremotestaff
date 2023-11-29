<?php
require '../config/database.php';
require '../controller/crud.php';

$crud = new Crud();

	$query = $crud->deleteAll('ts_users', "id", $_POST['staff_ids']);

	$result = $db->query($query);
	
	if($result){
		header('Location: staff.php');		
	}
		
?>