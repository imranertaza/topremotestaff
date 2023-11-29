<?php
require '../../vendor/autoload.php';
require '../config/database.php';
require '../controller/crud.php';
require '../includes/file_upload_library.php';

$crud = new Crud();
$FileUpload = new FileUpload();


    $allIds = explode(",", $_POST['staff_ids']);



    // Deleting CV from the S3 storage server (Start)
    foreach($allIds as $id) {
        $selectQuery = $crud->getSelectedData('cv', 'ts_phoneagent_users', "id", $id);
        $getResult = $db->query($selectQuery);
        $FileUpload->deletefilefromstorage($getResult->fetch_assoc()['cv']);
    }
    // Deleting CV from the S3 storage server (End)


    // Deleting CV from the S3 storage server (Start)
    foreach($allIds as $id) {
        $selectQuery = $crud->getSelectedData('voice_record', 'ts_phoneagent_users', "id", $id);
        $getResult = $db->query($selectQuery);
        $FileUpload->folder = 'voicerecording/';
        $FileUpload->deletefilefromstorage($getResult->fetch_assoc()['voice_record']);
    }
    // Deleting CV from the S3 storage server (End)

    //deleting question answer
    $queryQu = $crud->deleteAll('ts_phoneagent_answers', "phoneagent_user_id", $_POST['staff_ids']);
    $db->query($queryQu);
    //deleting question answer

	$query = $crud->deleteAll('ts_phoneagent_users', "id", $_POST['staff_ids']);
	$result = $db->query($query);

    header('Location: staff.php?tab=pending');

//	if($result){
//		header('Location: staff.php?tab=pending');
//	}
		
?>