<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

	$query = $crud->delete('ts_virtualassistant_followup_email_template', "id", $_POST['id']);
	$result = $db->query($query);
		
	if($result){
		header('Location: staff.php?tab=email');
			
	}

?>