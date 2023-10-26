<?php
require '../../vendor/autoload.php';
require 'config/database.php';
require 'controller/crud.php';
require '../includes/file_upload_library.php';

    $crud = new Crud();
    $FileUpload = new FileUpload();

    // Deleting CV from the S3 storage server (Start)
    $selectQuery = $crud->getSelectedData('cv', 'ts_bookkeeping_users', "id", $_POST['id']);
    $getResult = $db->query($selectQuery);
    $FileUpload->deletefilefromstorage($getResult->fetch_assoc()['cv']);
    // Deleting CV from the S3 storage server (End)

    $query = $crud->delete('ts_bookkeeping_users', "id", $_POST['id']);
	$result = $db->query($query);
	if($result){
		if($_POST['check'] == 2){
			header('Location: staff.php?tab=pending');
		}else{
			header('Location: staff.php');
		}

	}
		
?>