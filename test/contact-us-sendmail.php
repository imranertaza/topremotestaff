<?php
require './admin/email.php';

$email = new EmailSender();

        //$recipient = "cabalida.stephen@gmail.com";
        $recipient = "jteng@evolutionworldwide.com";
	//$recipient = "kenny.slayers@gmail.com";
        $subject = "TopRemoteStaff Enquiry";
        $bodyHtml = "<p><strong>Full Name:</strong> ".urlencode($_POST['fullname'])."<br/><strong>Phone:</strong> ".urlencode($_POST['phone'])."<br/><strong>Email:</strong> ".urlencode($_POST['email'])."<br/><strong>Message:</strong><br/><span style='white-space: pre-wrap'>".urlencode($_POST['message'])."</span></p>";
	$email->send($recipient, $subject, $bodyHtml);
	/*
        if($email->send($recipient, $subject, $bodyHtml)){
                header('Location: msgsuccess.php?sent=success');
	}
	 */

?>

