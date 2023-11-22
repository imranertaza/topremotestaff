<?php
require '../config/database.php';
require '../controller/crud.php';

$crud = new Crud();

		$data = array(
			'audio_link' => $_POST['new_link'],
		);

		$query = $crud->update('ts_phoneagent_test', $data, "id", $_POST['id']);
		$result = $db->query($query);
		
		if($result){
			header('Location: staff.php?tab=test');
			
		}


?>