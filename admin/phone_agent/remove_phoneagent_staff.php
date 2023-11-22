<?php
require '../../vendor/autoload.php';
require '../config/database.php';
require '../controller/crud.php';
require '../includes/file_upload_library.php';

    $crud = new Crud();
    $FileUpload = new FileUpload();


    // Deleting CV from the S3 storage server (Start)
    $selectQuery = $crud->getSelectedData('cv', 'ts_phoneagent_users', "id", $_POST['id']);
    $getResult = $db->query($selectQuery);
    $FileUpload->deletefilefromstorage($getResult->fetch_assoc()['cv']);
    // Deleting CV from the S3 storage server (End)


    // Deleting CV from the S3 storage server (Start)
    $selectQuery = $crud->getSelectedData('voice_record', 'ts_phoneagent_users', "id", $_POST['id']);
    $getResult = $db->query($selectQuery);
    $FileUpload->folder = 'voicerecording/';
    $FileUpload->deletefilefromstorage($getResult->fetch_assoc()['voice_record']);
    // Deleting CV from the S3 storage server (End)

    //deleting question answer
    $queryQu = $crud->delete('ts_phoneagent_answers', "phoneagent_user_id", $_POST['id']);
    $db->query($queryQu);
    //deleting question answer

    $query = $crud->delete('ts_phoneagent_users', "id", $_POST['id']);
	$result = $db->query($query);
	if($result){
		if($_POST['check'] == 2){
			header('Location: staff.php?tab=pending');
		}else{
			header('Location: staff.php');
		}

	}
		
?>