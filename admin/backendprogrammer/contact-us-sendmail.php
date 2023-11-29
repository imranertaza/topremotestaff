<?php
require '../email.php';

$email = new EmailSender();

	//$recipient = "cabalida.stephen@gmail.com";
	$recipient = "jteng@evolutionworldwide.com";
	$subject = "Transcription Staff Enquiry";
	$bodyHtml = "<p><strong>Full Name:</strong> ".$_POST['fullname']."<br/><strong>Phone:</strong> ".$_POST['phone']."<br/><strong>Email:</strong> ".$_POST['email']."<br/><strong>Message:</strong><br/><span style='white-space: pre-wrap'>".$_POST['message']."</span></p>";
	if($email->send($recipient, $subject, $bodyHtml)){
		header('Location:index.php?sent=success');
	}

?>