<?php
$name = "save-text.txt";
$file = "/var/www/html/otranscribe/save/" . $name;

echo json_encode(file_get_contents($file,$_POST['content']));
?>