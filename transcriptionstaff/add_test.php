<?php
require 'email.php';
require 'config/database.php';
require 'controller/crud.php';

	$crud = new Crud();

	$count_all_set = $_POST['count_all_set'];
	$negativecount_all_set = $_POST['negativecount_all_set'];
	$name = $_POST['name'];
	$link = $_POST['link'];
	
	$keywords = array();
	$negativekeywords = array();

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
	
	for($x=1;$x<=$negativecount_all_set;$x++){
		
		$p_data = $_POST['negativeprimary_keywords_' . $x];
		$a_data = "";
		$alternative_keywords = $_POST['negativealternative_keywords_' . $x];
		
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
		
		array_push($negativekeywords,$data);
	}
	
	$query_data = array(
		'name' => $name,
		'audio_link' => $link,
		'keywords' => json_encode($keywords),
		'negative_keywords' => json_encode($negativekeywords)
	);

	$query = $crud->add('ts_test', $query_data);

	$result = $db->query($query);
			
	if($result){
		header('Location: staff.php?tab=test');
	}
?>