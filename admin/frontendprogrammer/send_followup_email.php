<?php
require '../email.php';
require '../config/database.php';
require '../controller/crud.php';

$crud = new Crud();
$email = new EmailSender();

$getStaff = mysqli_query($db, "SELECT * FROM ts_frontendprogrammerg_users WHERE status='1'");
$staff = mysqli_fetch_all($getStaff, MYSQLI_ASSOC);

$getEmailContent = mysqli_query($db, "SELECT * FROM ts_frontendprogrammerg_followup_email_template");
$emailContent = mysqli_fetch_all($getEmailContent, MYSQLI_ASSOC);

$getEmailSent = mysqli_query($db, "SELECT * FROM ts_frontendprogrammerg_email_sent");
$emailSent = mysqli_fetch_all($getEmailSent, MYSQLI_ASSOC);

for($x = 0; $x < count($staff) ; $x++){
	
	$staff_id = $staff[$x]['id'];
	$staff_email = $staff[$x]['email'];
	$staff_name = $staff[$x]['fullname'];
	$staff_type = $staff[$x]['account_type'];

	$dt = DateTime::createFromFormat('Y-m-d H:i:s', $staff[$x]['date_updated']);
	$check = $dt && $dt->format('Y-m-d H:i:s') == $staff[$x]['date_updated'];
	
	if($check === TRUE){
		
		$approveDate = new DateTime($staff[$x]['date_updated']);
		$staff_approve_timestamp = $approveDate->getTimestamp();
		
	}else{
		
		$staff_approve_timestamp  = $staff[$x]['date_updated'];		
	}
	
	for($y = 0; $y < count($emailContent) ; $y++){
		
		$content_id = $emailContent[$y]['id'];
		$content_type = $emailContent[$y]['type'];
		$content_delayed = $emailContent[$y]['delayed_time'];
		
		$content = str_replace("%24name",$staff_name,$emailContent[$y]['content']);
		$content = str_replace("%24email",$staff_email,$content);
		$content = htmlentities(urldecode($content));
		
		$checkEmailSent = $db->query($crud->getData('ts_frontendprogrammerg_email_sent', array("user_id","email_template_id"), array($staff_id,$content_id)));
		
		if ($checkEmailSent->num_rows === 0){
			
			if ($content_type == $staff_type){
			
				$todayDate = new DateTime();
				$today_timestamp = $todayDate->getTimestamp();
				
				$checkTimestamp = $staff_approve_timestamp + ($content_delayed * 3600);
				
				if($today_timestamp > $checkTimestamp){
					
					$bodyHtml = "<p style='white-space: pre-line;'>" . $content . "</p>";
					$subject = "TranscriptionStaff Job Application";
					
					if($email->sendToCompany($staff_email, $subject, $bodyHtml)){
						
						$sentData = array(
							'user_id' => $staff_id,
							'email_template_id' => $content_id,
						);
						
						$sentDataQuery = $crud->add('ts_frontendprogrammerg_email_sent', $sentData);
						$db->query($sentDataQuery);
					}
				}
			
			}
		}
		
	}
}
?>