<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

	$query = $crud->delete('ts_bookkeeping_users', "id", $_POST['id']);
	$result = $db->query($query);
	if($result){
		if($_POST['check'] == 2){
			header('Location: staff.php?tab=approved');
		}else{
			header('Location: staff.php');
		}
			
	}
		
?>