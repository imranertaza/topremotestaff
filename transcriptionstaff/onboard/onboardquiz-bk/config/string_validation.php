<?php
	function string_validation($name, $data) {
	
		if (empty($data)) {
			$error = "$name is required";
			return array("status" => false, "data" => $error);
		} else {
			return array("status" => true, "data" => $data);
		}
	}
	function validate($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  return $data;
	}
?>