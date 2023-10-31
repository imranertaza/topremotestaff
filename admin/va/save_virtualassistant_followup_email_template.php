<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

		$data = array(
			'content' => urlencode($_POST['content']),
			'type' => $_POST['type'],
			'delayed_time' => $_POST['delayed_time'],
		);
		
		$query = $crud->update('ts_virtualassistant_followup_email_template', $data, "id", $_POST['id']);
		$result = $db->query($query);
		
		if($result){
			header('Location: staff.php?tab=email_template');
			
		}


?>
