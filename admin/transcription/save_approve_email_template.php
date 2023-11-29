<?php
require '../config/database.php';
require '../controller/crud.php';

$crud = new Crud();

		$data = array(
			'content' => urlencode($_POST['content']),
		);
		
		$query = $crud->update('ts_approve_email_template', $data, "id", $_POST['id']);
		$result = $db->query($query);
		
		if($result){
			header('Location: staff.php?tab=email');
			
		}


?>