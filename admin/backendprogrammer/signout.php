<?php


setcookie("staff_session_id", "", time() - 3600);
header('Location: index.php');


?>