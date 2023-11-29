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
        $selectQuery = $crud->getSelectedData('cv', 'ts_backendprogrammer_users', "id", $id);
        $getResult = $db->query($selectQuery);
        $FileUpload->deletefilefromstorage($getResult->fetch_assoc()['cv']);
    }
    // Deleting CV from the S3 storage server (End)

    //deleting question answer
    $queryQu = $crud->deleteAll('ts_backendprogrammer_answers', "id", $_POST['staff_ids']);
    $db->query($queryQu);
    //deleting question answer

	$query = $crud->deleteAll('ts_backendprogrammer_users', "id", $_POST['staff_ids']);

	$result = $db->query($query);

    header('Location: staff.php?tab=pending');

//	if($result){
//		header('Location: staff.php?tab=pending');
//	}
		
?>