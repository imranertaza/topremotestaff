<?php
require '../email.php';
require '../config/database.php';
require '../controller/crud.php';

	$crud = new Crud();

	$count_all_set = $_POST['count_all_set'];
	$name = $_POST['name'];
	$link = $_POST['link'];
	
	$keywords = array();

	for($x=1;$x<=$count_all_set;$x++){
		
		$p_data = $_POST['primary_keywords_' . $x];
		$a_data = "";
		$alternative_keywords = $_POST['alternative_keywords_' . $x];
		
		for($y=0;$y < count($alternative_keywords);$y++){
			
			if($y < 1){
				$a_data = $a_data . $alternative_keywords[$y];
			}else{
				$a_data = $a_data . "|" . $alternative_keywords[$y];
			}
		}
		if($a_data != ""){
			$data = $p_data . "|" . $a_data;
		}else{
			$data = $p_data;
		}
		
		array_push($keywords,$data);
	}
	
	$query_data = array(
		'name' => $name,
		'audio_link' => $link,
		'keywords' => json_encode($keywords),
	);

	$query = $crud->add('ts_livechat_test', $query_data);

	$result = $db->query($query);
			
	if($result){
		header('Location: staff.php?tab=test');
	}
?>