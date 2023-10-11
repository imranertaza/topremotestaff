<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

		$data = array(
			'keywords' => $_POST['new_words'],
		);

		$query = $crud->update('ts_bookkeeping_test', $data, "id", $_POST['id']);
		$result = $db->query($query);
		
		if($result){
			header('Location: staff.php?tab=test');
			
		}


?>