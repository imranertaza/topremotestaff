<?php
require '../config/database.php';
require '../controller/crud.php';

$crud = new Crud();

		$data = array(
			'content' => urlencode($_POST['content']),
			'type' => $_POST['type'],
			'delayed_time' => $_POST['delayed_time'],
		);
		
		$query = $crud->add('ts_phoneagent_followup_email_template', $data);
		$result = $db->query($query);
		
		if($result){
			header('Location: staff.php?tab=email_template');
			
		}

?>