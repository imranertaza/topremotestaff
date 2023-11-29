<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();
		
		if($_POST['keyword_type'] == 1)
		{
			$data = array(
				'keywords' => $_POST['new_words']
			);
		}else{
			$data = array(
				'negative_keywords' => $_POST['new_words']
			);
		}
		$query = $crud->update('ts_test', $data, "id", $_POST['id']);
		$result = $db->query($query);
		
		if($result){
			header('Location: staff.php?tab=test');
			
		}


?>