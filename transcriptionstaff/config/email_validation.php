<?php
	
	function email_validation($name, $data) {
		
		if (empty($data)) {
			$error = "$data is required.";
			return array("status" => false, "data" => $error);
		} else {
			$email = validate($data);
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $error = "Invalid email address format.";
			  return array("status" => false, "data" => $error);
			}else{
				return array("status" => true, "data" => $email);
			}
			
		}
	}
?>