<?php
session_start();

require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

        function isJson($string) {
            json_decode($string);
            return json_last_error() === JSON_ERROR_NONE;
        }
		
		if($_POST['keyword_type'] == 1)
		{
            if (isJson($_POST['new_words'])){
                $data = array(
                    'keywords' => $_POST['new_words']
                );
            }else{
                $_SESSION["err_message"] = '<center><p style="color: red;">Keyword pattern does not match!</p></center> <br>';
                header('Location: staff.php?tab=test');
                die();
            }

		}else{
            if (isJson($_POST['new_words'])){
                $data = array(
                    'negative_keywords' => $_POST['new_words']
                );
            }else{
                $_SESSION["err_message"] = '<center><p style="color: red;">Keyword pattern does not match!</p></center> <br>';
                header('Location: staff.php?tab=test');
                die();
            }

		}
		$query = $crud->update('ts_test', $data, "id", $_POST['id']);
		$result = $db->query($query);
		
		if($result){
			header('Location: staff.php?tab=test');
		}


?>