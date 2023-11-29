<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

class EmailSender{
	public function send($recipient, $subject, $bodyHtml) {
		
		$sender = 'newaccounts@topremotestaff.com';
                $senderName = 'TopRemoteStaff';

		$usernameSmtp = 'AKIAXUSA5SLTB4M4P56Y';

		$passwordSmtp = 'BOk1aZ3Ed2+sdk0hXFj0h/w85Lf2wU9VegrWLBPdqqYO';

		$host = 'email-smtp.us-east-1.amazonaws.com';
		$port = 587;

		$mail = new PHPMailer(true);

		try {
			// Specify the SMTP settings.
			$mail->isSMTP();
			$mail->setFrom($sender, $senderName);
			$mail->Username   = $usernameSmtp;
			$mail->Password   = $passwordSmtp;
			$mail->Host       = $host;
			$mail->Port       = $port;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = 'tls';
			//$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

			// Specify the message recipients.
			$mail->addAddress($recipient);
			// You can also add CC, BCC, and additional To recipients here.

			// Specify the content of the message.
			$mail->isHTML(true);
			$mail->Subject    = $subject;
			$mail->Body       = $bodyHtml;
			//$mail->AltBody    = $bodyText;
			 
			if($mail->Send()){
				//return true;
			}else{
			//	return false;
			}
		    echo "Email sent!" , PHP_EOL;
		} catch (phpmailerException $e) {
		    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
		   //return false;
		} catch (Exception $e) {
			echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
			//return false;
		}
	}
	public function sendToCompany($recipient, $subject, $bodyHtml) {
		
		$sender = 'newaccounts@topremotestaff.com';
		$senderName = 'TopRemoteStaff';

		$usernameSmtp = 'AKIAXUSA5SLTB4M4P56Y';

		$passwordSmtp = 'BOk1aZ3Ed2+sdk0hXFj0h/w85Lf2wU9VegrWLBPdqqYO';

		$host = 'email-smtp.us-east-1.amazonaws.com';
		$port = 587;


		$mail = new PHPMailer(true);

		try {
			// Specify the SMTP settings.
			$mail->isSMTP();
			$mail->setFrom($sender, $senderName);
			$mail->Username   = $usernameSmtp;
			$mail->Password   = $passwordSmtp;
			$mail->Host       = $host;
			$mail->Port       = $port;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = 'tls';
			//$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

			// Specify the message recipients.
			$mail->addAddress($recipient);
			// You can also add CC, BCC, and additional To recipients here.

			// Specify the content of the message.
			$mail->isHTML(true);
			$mail->Subject    = $subject;
			$mail->Body       = $bodyHtml;
			//$mail->AltBody    = $bodyText;
			 
			if($mail->Send()){
				return true;
			}else{
				return false;
			}
		   // echo "Email sent!" , PHP_EOL;
		} catch (phpmailerException $e) {
		    //echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
		   return false;
		} catch (Exception $e) {
			//echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
			return false;
		}
	}
	
}
?>

