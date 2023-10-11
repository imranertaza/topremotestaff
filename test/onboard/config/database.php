<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
//$host = 'localhost';
$host = 'transcriptionpuppy.caxj9bvmdmvc.us-east-1.rds.amazonaws.com';

if($host == 'localhost'){
	$username = 'root';
	$password = '';
	$dbname = 'questionnairepuppy';
}else{
	$username = '';
	$password = '';
	$dbname = 'tsquiz';	
}

$db = new mysqli($host, $username, $password, $dbname);

?>
