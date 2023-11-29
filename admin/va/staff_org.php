<?php
require 'config/database.php';
require 'controller/crud.php';

if(!isset($_COOKIE["staff_session_id"])) {
	if($_COOKIE["staff_session_id"] != 1){
		header('Location: login.php');
	}
}

$crud = new Crud();

$getData = mysqli_query($db, "SELECT * FROM ts_virtualassistant_users WHERE status='0' ORDER BY date_created DESC");
$result = mysqli_fetch_all($getData, MYSQLI_ASSOC);

$getApproved = mysqli_query($db, "SELECT * FROM ts_virtualassistant_users WHERE status='1' ORDER BY date_updated DESC");
$approveResult = mysqli_fetch_all($getApproved, MYSQLI_ASSOC);	

$getTest = mysqli_query($db, "SELECT * FROM ts_virtualassistant_test ORDER BY id DESC");
$testResult = mysqli_fetch_all($getTest, MYSQLI_ASSOC);

$getTestData = mysqli_query($db, "SELECT * FROM ts_virtualassistant_test WHERE id='2'");
$testDataResult = mysqli_fetch_all($getTestData, MYSQLI_ASSOC);

$getApproveEmailTemplate = mysqli_query($db, "SELECT * FROM ts_virtualassistant_approve_email_template");
$approveEmailTemplate = mysqli_fetch_all($getApproveEmailTemplate, MYSQLI_ASSOC);

$getFollowupEmailTemplate = mysqli_query($db, "SELECT * FROM ts_virtualassistant_followup_email_template");
$followupEmailTemplate = mysqli_fetch_all($getFollowupEmailTemplate, MYSQLI_ASSOC);

$getQuestions = mysqli_query($db, "SELECT * FROM ts_virtualassistant_questions WHERE status='1' ORDER BY date_created DESC");
$questionResult = mysqli_fetch_all($getQuestions, MYSQLI_ASSOC);

$getProofReadData = mysqli_query($db, "SELECT * FROM ts_virtualassistant_users WHERE status='0' ORDER BY date_created DESC");
$proofReadResult = mysqli_fetch_all($getProofReadData, MYSQLI_ASSOC);

$getProofReadApproved = mysqli_query($db, "SELECT * FROM ts_virtualassistant_users WHERE status='1' ORDER BY date_updated DESC");
$approveProofReadResult = mysqli_fetch_all($getProofReadApproved, MYSQLI_ASSOC);	
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Show Staff</title>
	<link rel="shortcut icon" href="#" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet" />
	<style>
		body{
			padding:0rem 2rem 1rem 2rem;
			font-family: 'Open Sans', sans-serif;
		}
		table{
			width:100%;
		}
		table thead{
			background-color:#ccc;
		}
		table tr th,
		table tr td{
			border:1px solid #000;
			text-align:left;
			padding:5px;
		}
		.btn-danger{
			color: #fff;
			background-color: #db3145;
			border-radius: 20px;
			padding: 5px 10px;
			font-size: 10px;
			font-weight: bold;
			cursor:pointer;
			border: 0;
			appearance: none;
		}
		#choices .row input[type=text]{
			width:94%;
		}
		.btn-success{
			color: #fff;
			background-color: #28a745;
			border-radius: 20px;
			padding: 5px 10px;
			font-size: 10px;
			font-weight: bold;
			cursor:pointer;
			border: 0;
			appearance: none;
		}
		.btn-default{
			color: #000;
			background-color: #aaa;
			border-radius: 20px;
			padding: 5px 10px;
			font-size: 10px;
			font-weight: bold;
			cursor:pointer;
			border: 0;
			appearance: none;
		}
		.modal {
			display: none;
			position: fixed;
			z-index: 1;
			padding-top: 100px;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgb(0,0,0);
			background-color: rgba(0,0,0,0.4);
		}
		.modal-content {
			position: relative;
			background-color: #fefefe;
			margin: auto;
			padding: 0;
			border: 1px solid #888;
			width: 30%;
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
			-webkit-animation-name: animatetop;
			-webkit-animation-duration: 0.4s;
			animation-name: animatetop;
			animation-duration: 0.4s;
		}
		.margin-top-5px{
			margin-top:5px;
		}
		.modal-header {
			padding: 10px 16px;
			border-bottom: 1px solid #000;
		}
		.modal-body {
			padding: 10px 16px;
		}
		
		@-webkit-keyframes animatetop {
		  from {top:-300px; opacity:0} 
		  to {top:0; opacity:1}
		}

		@keyframes animatetop {
		  from {top:-300px; opacity:0}
		  to {top:0; opacity:1}
		}

		.close {
		  color: #000;
		  float: right;
		  font-size: 28px;
		  font-weight: bold;
		  position:relative;  
		  top:-5px;
		}

		.close:hover,
		.close:focus {
		  color: #000;
		  text-decoration: none;
		  cursor: pointer;
		}
		
		.tab {
		  overflow: hidden;
		  border: 1px solid #ccc;
		  background-color: #f1f1f1;
		}

		.tab button {
		  background-color: inherit;
		  float: left;
		  border: none;
		  outline: none;
		  cursor: pointer;
		  padding: 14px 16px;
		  transition: 0.3s;
		  font-size: 17px;
		}

		.tab button:hover {
		  background-color: #ddd;
		}

		.tab button.active {
		  background-color: #ccc;
		}

		.tabcontent {
		  display: none;
		  padding: 6px 12px;
		  border: 1px solid #ccc;
		  border-top: none;
		}
		.show{
		  display: block;
		}
		.m-0{
			margin:0;
		}
		.p-1{
			padding:1rem;
		}
		.tooltip .tooltiptext span{
			color: #fff;
			font-size: 12px;
			background-color: #db3145;
			padding: 3px 8px;
			margin-left: 3px;
			margin-right: 3px;
			border-radius: 20px;
			display: inline-block;
			margin-top: 3px;
		}
		.tooltip {
		  position: relative;
		  display: inline-block;
		  
		}

		.tooltip .tooltiptext {
		  visibility: hidden;
		  max-width: 600px;
		  width: max-content;
		  background-color: #fff;
		  color: #fff;
		  border-radius: 6px;
		  padding: 10px;

		  /* Position the tooltip */
		  position: absolute;
		  z-index: 1;
		  -webkit-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.4);
		-moz-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.4);
		box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.4);
		}

		.tooltip:hover .tooltiptext {
		  visibility: visible;
		}
		.tooltip .tooltiptext {
		  top: -5px;
		  right: 108%;
		}
	</style>
</head>
<body>
	<a href="signout.php" class="btn-danger" style="float:right;text-decoration:none;font-size:15px">Sign Out</a>
	<h2>All Staff</h2>

	<div class="tab">
	<?php if(!empty($_GET)){ ?>
		<?php if($_GET['tab'] == "proofread"){ ?>
<!--			<button class="tablinks" id="tab_trans" onclick="openT(event, 'transcription')"><h5 class="m-0">Transcription</h5></button>  -->
			<button class="tablinks" id="tab_proof" onclick="openT(event, 'proofread')"><h5 class="m-0">Edit/Proofread</h5></button>
		<?php }else{ ?>
<!--			<button class="tablinks active" id="tab_trans" onclick="openT(event, 'transcription')"><h5 class="m-0">Transcription</h5></button>  -->
			<button class="tablinks active" id="tab_proof" onclick="openT(event, 'proofread')"><h5 class="m-0">Edit/Proofread</h5></button>
		<?php } ?>
	<?php }else{ ?>
<!--			<button class="tablinks active" id="tab_trans" onclick="openT(event, 'transcription')"><h5 class="m-0">Transcription</h5></button>  -->
			<button class="tablinks active" id="tab_proof" onclick="openT(event, 'proofread')"><h5 class="m-0">Edit/Proofread</h5></button>
	<?php } ?>
	</div>
	<?php if(!empty($_GET)){ ?>
		<?php if($_GET['tab'] == "proofread"){ ?>
			<div id="transcription" class="tabcontent p-1">
		<?php }else{ ?>
			<div id="transcription" class="tabcontent p-1 show"> 
		<?php } ?>
	<?php }else{ ?>
		<div id="transcription" class="tabcontent p-1 show" style="display: none;">
	<?php } ?>
		<div class="tab">
		 <?php if(!empty($_GET)){ ?>
			<?php if($_GET['tab'] == "approved"){ ?>
				<button class="tablinks" onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
				<button class="tablinks active" onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
				<button class="tablinks" onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
				<button class="tablinks" onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5></button>
			<?php }else if($_GET['tab'] == "test"){ ?>
				<button class="tablinks " onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
				<button class="tablinks" onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
				<button class="tablinks active" onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
				<button class="tablinks" onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5></button>
			<?php }else if($_GET['tab'] == "email"){ ?>
				<button class="tablinks " onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
				<button class="tablinks" onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
				<button class="tablinks " onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
				<button class="tablinks active" onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5></button>
			<?php }else{ ?>
				<button class="tablinks active" onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
				<button class="tablinks" onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
				<button class="tablinks" onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
				<button class="tablinks" onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5></button>
			<?php } ?>
		<?php }else{ ?>
<!--
				<button class="tablinks active" onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
				<button class="tablinks" onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
				<button class="tablinks" onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
				<button class="tablinks" onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5></button>
-->
		<?php } ?>
			
		</div>
		
		<?php if(!empty($_GET)){ ?>
			<?php if($_GET['tab'] == "approved"){ ?>
				<div id="pending" class="tabcontent p-1 ">
			<?php }else if($_GET['tab'] == "test"){ ?>
				<div id="pending" class="tabcontent p-1">
			<?php }else if($_GET['tab'] == "email"){ ?>
				<div id="pending" class="tabcontent p-1">
			<?php }else{ ?>
				<div id="pending" class="tabcontent show p-1 ">
			<?php } ?>
		<?php }else{ ?>
				<div id="pending" class="tabcontent show p-1 ">
		<?php } ?>
				</div>
		
		<?php if(!empty($_GET)){ ?>
			<?php if($_GET['tab'] == "approved"){ ?>
				<div id="approved" class="tabcontent p-1 show">
			<?php }else if($_GET['tab'] == "test"){ ?>
				<div id="approved" class="tabcontent p-1">
			<?php }else if($_GET['tab'] == "email"){ ?>
				<div id="approved" class="tabcontent p-1">	
			<?php }else{ ?>
				<div id="approved" class="tabcontent p-1">
			<?php } ?>
		<?php }else{ ?>
				<div id="approved" class="tabcontent p-1">
		<?php } ?>
				</div>
		<?php if(!empty($_GET)){ ?>
			<?php if($_GET['tab'] == "test"){ ?>
				<div id="audio_test" class="tabcontent show p-1">
			<?php }else if($_GET['tab'] == "approved"){ ?>
				<div id="audio_test" class="tabcontent p-1">
			<?php }else if($_GET['tab'] == "email"){ ?>
				<div id="audio_test" class="tabcontent p-1">	
			<?php }else{ ?>
				<div id="audio_test" class="tabcontent p-1">
			<?php } ?>
		<?php }else{ ?>
				<div id="audio_test" class="tabcontent p-1">
		<?php } ?>
				</div>
<!--
		<?php if(!empty($_GET)){ ?>
			<?php if($_GET['tab'] == "email"){ ?>
				<div id="email_template" class="tabcontent show p-1">
			<?php }else if($_GET['tab'] == "approved"){ ?>
				<div id="email_template" class="tabcontent p-1">
			<?php }else if($_GET['tab'] == "email"){ ?>
				<div id="email_template" class="tabcontent p-1">	
			<?php }else{ ?>
				<div id="email_template" class="tabcontent p-1">
			<?php } ?>
		<?php }else{ ?>
				<div id="email_template" class="tabcontent p-1">
		<?php } ?>
			<p><strong>EMAILS</strong></p>
			<table style="border:0;">
				<tbody>
					<tr>
						<td style="width:40%;vertical-align: top;border:0;">
							<small>APPROVE EMAIL</small>&ensp;<strong style="font-size: 12px;">JOB TYPE: TRANSCRIBER</strong>
							<br/>
							<form action="save_approve_email_template.php" method="post"> 
								<input type="hidden" name="id" value="1">
								<input type="hidden" name="type" value="1">
								<textarea name="content" rows="15" style="width:100%;"><?php echo htmlentities(urldecode($approveEmailTemplate[0]['content'])); ?></textarea>
								<button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
							</form>
							<br/>
							<small>APPROVE EMAIL</small>&ensp;<strong style="font-size: 12px;">JOB TYPE: PROOFREADER</strong>
							<br/>
							<form action="save_approve_email_template.php" method="post"> 
								<input type="hidden" name="id" value="2">
								<input type="hidden" name="type" value="2">
								<textarea name="content" rows="15" style="width:100%;"><?php echo htmlentities(urldecode($approveEmailTemplate[1]['content'])); ?></textarea>
								<button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
							</form>
						</td>
						<td style="width:40%;vertical-align: top;border:0" class="follow-up-email-container">
							<?php for($d = 0; $d < count($followupEmailTemplate); $d++){ ?>
								<div class="follow-up-emails">
									<small>FOLLOW UP EMAILS</small>
									<br/>
									<form action="save_followup_email_template.php" method="post">
										<textarea name="content" rows="15" style="width:100%;"><?php echo htmlentities(urldecode($followupEmailTemplate[$d]['content'])); ?></textarea>
										<br/>
										<small>Delayed Time </small><input type="number" value="<?php echo $followupEmailTemplate[$d]['delayed_time']; ?>" min="1" max="9999999" name="delayed_time" required> <small>hrs</small>
										&ensp;<select name="type" required>followupEmailTemplate
											<option value="1" <?php if($followupEmailTemplate[$d]['type'] == 1) echo "selected"; ?>>Transcriber</option>
											<option value="2" <?php if($followupEmailTemplate[$d]['type'] == 2) echo "selected"; ?>>Proofreader</option>
										</select>
										<input type="hidden" name="id" value="<?php echo $followupEmailTemplate[$d]['id']; ?>" >
										<div style="float:right">
											<button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
											<button class="btn-danger" type="button" style="font-size:12px;" onclick="showModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">DELETE</button>
										</div>
									</form>
									
									<div id="deleteFollowupModal<?php echo $followupEmailTemplate[$d]['id']; ?>" class="modal">
										<div class="modal-content">
											 <div class="modal-header">
												<span class="close" onclick="closeModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">×</span>
												<h3 style="margin:0">Are you sure you want to remove?</h3>
											 </div>
											 <div class="modal-body">
												<form method="post" action="delete_followup_email.php">
													<input type="hidden" name="id" value="<?php echo $followupEmailTemplate[$d]['id']; ?>">
													<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
													<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">No</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								<br/>
							<?php } ?>
							<button class="btn-default btn-add-follow-up-email" onclick="addNewFollowupEmail()" type="button">+ ADD NEW FOLLOW UP EMAIL</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
-->
	</div>
	<?php if(!empty($_GET)){ ?>
		<?php if($_GET['tab'] == "proofread"){ ?>
			<div id="proofread" class="tabcontent p-1 show">
		<?php }else{ ?>
			<div id="proofread" class="tabcontent p-1">
		<?php } ?>
	<?php }else{ ?>
		<div id="proofread" class="tabcontent p-1" style="display: block;">
	<?php } ?>
	
		<div class="tab">
			<button class="tablinks active" onclick="openTab(event, 'proofread_pending')"><h5 class="m-0">PENDING STAFF</h5></button>
			<button class="tablinks" onclick="openTab(event, 'proofread_approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
			<button class="tablinks" onclick="openTab(event, 'multiple_test')"><h5 class="m-0">MULTIPLE CHOICE TEST</h5></button>
			<button class="tablinks" onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5></button>
		</div>
		
		<div id="proofread_pending" class="tabcontent show p-1 ">
			<table cellspacing="0">
test5
				<thead>
					<tr>
						<th style="width:20%">Full Name</th>
						<th style="width:20%">Email</th>
						<th style="width:10%">Phone</th>
						<th style="width:11%">Skype</th>
						<th style="width:15%">Paypal</th>
						<th style="width:12px">Score</th>
						<th style="width:7%">Test</th>
						<th style="width:6%">Action</th>
						<th style="width:6%">Delete</th>
						<th><button class="btn-danger" onclick="showDeleteAllPendingProofReadModal()">REMOVE ALL</button></th>
					</tr>
				</thead>
				<tbody>
					<?php if(mysqli_num_rows($getProofReadData) > 0){ ?>
						<?php for($x = 0; $x < count($proofReadResult); $x++){ ?>
							<tr>	
								<td><?php echo $proofReadResult[$x]['fullname']; ?></td>
								<td><?php echo $proofReadResult[$x]['email']; ?></td>
								<td><?php echo $proofReadResult[$x]['phone']; ?></td>
								<td><?php echo $proofReadResult[$x]['skype']; ?></td>
								<td><?php echo $proofReadResult[$x]['paypal']; ?></td>
								<td class="score-total"><?php echo $proofReadResult[$x]['test_score']; ?>%</td>
								<td>
									<button class="btn-default" onclick="showModal(<?php echo "viewTestModal" . (string)$proofReadResult[$x]['id']; ?>)">View Test</button>
									<div id="viewTestModal<?php echo $proofReadResult[$x]['id']; ?>" class="modal">
										<div class="modal-content" style="width: 45%;">
											 <div class="modal-header">
												<span class="close" style="top: -10px;" onclick="closeModal(<?php echo "viewTestModal" . (string)$proofReadResult[$x]['id']; ?>)">×</span>
												<h4 style="margin:0">Test Result: Multiple Choice</h4>
											 </div>
											 <div class="modal-body" style="padding-bottom:24px">
												<p style="margin-top:0;">Score: <span style="color:#18AACF;font-weight:bold;"><?php echo $proofReadResult[$x]['test_score']; ?>%</span></p>
												<?php
													$id = $proofReadResult[$x]['id'];
													$getProofReadTestResult = mysqli_query($db, "SELECT * FROM ts_virtualassistant_answers WHERE proofread_user_id='$id'");
													$proofReadTestResult = mysqli_fetch_all($getProofReadTestResult, MYSQLI_ASSOC);
													
													if(mysqli_num_rows($getProofReadTestResult) > 0){ 
														$allQuestions = json_decode($proofReadTestResult[0]['question_details']);
														$allAnswers = json_decode($proofReadTestResult[0]['answer_details']);
													}
												
												?>
													<?php for($q = 0; $q < count($allQuestions); $q++){ ?>
													<?php
														$q_id = $allQuestions[$q];
														$getSpecificQuestion = mysqli_query($db, "SELECT * FROM ts_virtualassistant_questions WHERE id='$q_id'");
														$specificQuestionResult = mysqli_fetch_all($getSpecificQuestion, MYSQLI_ASSOC);
													?>
															<p class="questions" style="margin-bottom:0px;"><span><?php echo $q + 1; ?>.</span> <?php echo $specificQuestionResult[0]['question']; ?></p>
															<ul style="margin-top:5px;display:inline;padding-left:5px;">
																<?php
																	
																	$getTestResultChoices = mysqli_query($db, "SELECT * FROM ts_virtualassistant_question_choices WHERE question_id='$q_id'");
																	$choicesResult = mysqli_fetch_all($getTestResultChoices, MYSQLI_ASSOC);
																	
																	if(mysqli_num_rows($getTestResultChoices) > 0){
																		for($c = 0; $c < count($choicesResult); $c++){
																			if($choicesResult[$c]['correct'] == NULL || $choicesResult[$c]['correct'] == ""){
																				echo "<li style='padding:0 1rem;display:inline;'>&#9675; <span>" . $choicesResult[$c]['description'] . "</span></li>";
																			}else{
																				echo "<li style='padding:0 1rem;display:inline;'>&#9679; <strong>" . $choicesResult[$c]['description'] . "</strong></li>";
																			}
																			
																		}
																	}
																?>
															</ul>
													<?php } ?>
											</div>
										</div>
									</div>
								</td>
								<td>
									<button class="btn-success" onclick="showModal(<?php echo "approveProofReadmodal" . (string)$proofReadResult[$x]['id']; ?>)">APPROVE</button>
									<button class="btn-danger" onclick="showModal(<?php echo "declineProofReadmodal" . (string)$proofReadResult[$x]['id']; ?>)">DECLINE</button>
									<div id="approveProofReadmodal<?php echo $proofReadResult[$x]['id']; ?>" class="modal">
										<div class="modal-content">
											 <div class="modal-header">
												<span class="close" onclick="closeModal(<?php echo "approveProofReadmodal" . (string)$proofReadResult[$x]['id']; ?>)">×</span>
												<h3 style="margin:0">Are you sure you want to approve?</h3>
											 </div>
											 <div class="modal-body">
													<form method="post" action="approve_virtualassistant_staff.php" style="display:inline">
														<input type="hidden" name="id" value="<?php echo $proofReadResult[$x]['id']; ?>">
														<input type="hidden" name="email" value="<?php echo $proofReadResult[$x]['email']; ?>">
														<input type="hidden" name="fullname" value="<?php echo $proofReadResult[$x]['fullname']; ?>">
														<input type="hidden" name="account_type" value="1">
														<input type="hidden" name="status" value="1">
														<button type="submit" class="btn-success" style="font-size:12px;">YES</button>
													</form>
											</div>
										</div>
									</div>
									<div id="declineProofReadmodal<?php echo $proofReadResult[$x]['id']; ?>" class="modal">
										<div class="modal-content">
											 <div class="modal-header">
												<span class="close" onclick="closeModal(<?php echo "declineProofReadmodal" . (string)$proofReadResult[$x]['id']; ?>)">×</span>
												<h3 style="margin:0">Are you sure you want to decline?</h3>
											 </div>
											 <div class="modal-body">
												<form method="post" action="approve_virtualassistant_staff.php">
													<input type="hidden" name="id" value="<?php echo $proofReadResult[$x]['id']; ?>">
													<input type="hidden" name="skype" value="<?php echo $proofReadResult[$x]['skype']; ?>">
													<input type="hidden" name="email" value="<?php echo $proofReadResult[$x]['email']; ?>">
													<input type="hidden" name="paypal" value="<?php echo $proofReadResult[$x]['paypal']; ?>">
													<input type="hidden" name="fullname" value="<?php echo $proofReadResult[$x]['fullname']; ?>">
													<input type="hidden" name="status" value="0">
													<button type="submit" class="btn-danger" style="font-size:1rem;">Reject</button>
													<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeModal(<?php echo "declineProofReadmodal" . (string)$proofReadResult[$x]['id']; ?>)">No</button>
												</form>
											</div>
										</div>
									</div>
								</td>
								<td>
									<button class="btn-danger" onclick="showModal(<?php echo "deletePendingProofReadModal" . (string)$proofReadResult[$x]['id']; ?>)">REMOVE</button>
									<div id="deletePendingProofReadModal<?php echo $proofReadResult[$x]['id']; ?>" class="modal">
										<div class="modal-content">
											 <div class="modal-header">
												<span class="close" onclick="closeModal(<?php echo "deletePendingProofReadModal" . (string)$proofReadResult[$x]['id']; ?>)">×</span>
												<h3 style="margin:0">Are you sure you want to remove?</h3>
											 </div>
											 <div class="modal-body">
												<form method="post" action="remove_virtualassistant_staff.php">
													<input type="hidden" name="id" value="<?php echo $proofReadResult[$x]['id']; ?>">
													<input type="hidden" name="check" value="1">
													<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
													<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeModal(<?php echo "deletePendingProofReadModal" . (string)$result[$x]['id']; ?>)">No</button>
												</form>
											</div>
										</div>
									</div>
								</td>
								<td>
									<center><input type="checkbox" class="remove_all" name="remove_all[]" value="<?php echo $proofReadResult[$x]['id']; ?>"></center>
								</td>
							</tr>
						<?php }?>
					<?php }else{?>
						<tr>	
							<td colspan="10">No pending staff.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		
		</div>
		<div id="proofread_approved" class="tabcontent p-1">
			<table cellspacing="0">
test6
				<thead>
					<tr>
						<th style="width:18%">Full Name</th>
						<th style="width:19%">Email</th>
						<th style="width:10%">Phone</th>
						<th style="width:13%">Skype</th>
						<th style="width:14%">Paypal</th>
						<th style="width:10%">Timestamp</th>
						<th style="width:6%">Score</th>
						<th style="width:8%">Test</th>
						<th style="width:6%">Delete</th>
						<th><button class="btn-danger" onclick="showDeleteAllApprovedProofReadModal()">REMOVE ALL</button></th>
					</tr>
				</thead>
				<tbody>
					
					<?php if(mysqli_num_rows($getProofReadApproved) > 0){ ?>
						<?php for($x = 0; $x < count($approveProofReadResult); $x++){ ?>
							<tr>	
								<td><?php echo $approveProofReadResult[$x]['fullname']; ?></td>
								<td><?php echo $approveProofReadResult[$x]['email']; ?></td>
								<td><?php echo $approveProofReadResult[$x]['phone']; ?></td>
								<td><?php echo $approveProofReadResult[$x]['skype']; ?></td>
								<td><?php echo $approveProofReadResult[$x]['paypal']; ?></td>
								<td>
									<?php
										echo date('Y-m-d H:i:s', $approveProofReadResult[$x]['date_updated']);
										
									?>
								</td>
								<td class="score-total"><?php echo $approveProofReadResult[$x]['test_score']; ?>%</td>
								<td>
									<button class="btn-default" onclick="showModal(<?php echo "viewApproveTestModal" . (string)$approveProofReadResult[$x]['id']; ?>)">View Test</button>
									<div id="viewApproveTestModal<?php echo $approveProofReadResult[$x]['id']; ?>" class="modal">
										<div class="modal-content" style="width: 45%;">
											 <div class="modal-header">
												<span class="close" style="top: -10px;" onclick="closeModal(<?php echo "viewApproveTestModal" . (string)$approveProofReadResult[$x]['id']; ?>)">×</span>
												<h4 style="margin:0">Test Result: Multiple Choice</h4>
											 </div>
											 <div class="modal-body" style="padding-bottom:24px">
												<p style="margin-top:0;">Score: <span style="color:#18AACF;font-weight:bold;"><?php echo $approveProofReadResult[$x]['test_score']; ?>%</span></p>
												<?php
													$id = $approveProofReadResult[$x]['id'];
													$getProofReadTestResult = mysqli_query($db, "SELECT * FROM ts_virtualassistant_answers WHERE proofread_user_id='$id'");
													$proofReadTestResult = mysqli_fetch_all($getProofReadTestResult, MYSQLI_ASSOC);
													
													if(mysqli_num_rows($getProofReadTestResult) > 0){ 
														$allQuestions = json_decode($proofReadTestResult[0]['question_details']);
														$allAnswers = json_decode($proofReadTestResult[0]['answer_details']);
													}
												
												?>
													<?php for($q = 0; $q < count($allQuestions); $q++){ ?>
													<?php
														$q_id = $allQuestions[$q];
														$getSpecificQuestion = mysqli_query($db, "SELECT * FROM ts_virtualassistant_questions WHERE id='$q_id'");
														$specificQuestionResult = mysqli_fetch_all($getSpecificQuestion, MYSQLI_ASSOC);
													?>
															<p class="questions" style="margin-bottom:0px;"><span><?php echo $q + 1; ?>.</span> <?php echo $specificQuestionResult[0]['question']; ?></p>
															<ul style="margin-top:5px;display:inline;padding-left:5px;">
																<?php
																	
																	$getTestResultChoices = mysqli_query($db, "SELECT * FROM ts_virtualassistant_question_choices WHERE question_id='$q_id'");
																	$choicesResult = mysqli_fetch_all($getTestResultChoices, MYSQLI_ASSOC);
																	
																	if(mysqli_num_rows($getTestResultChoices) > 0){
																		for($c = 0; $c < count($choicesResult); $c++){
																			if($choicesResult[$c]['correct'] == NULL || $choicesResult[$c]['correct'] == ""){
																				echo "<li style='padding:0 1rem;display:inline;'>&#9675; <span>" . $choicesResult[$c]['description'] . "</span></li>";
																			}else{
																				echo "<li style='padding:0 1rem;display:inline;'>&#9679; <strong>" . $choicesResult[$c]['description'] . "</strong></li>";
																			}
																			
																		}
																	}
																?>
															</ul>
													<?php } ?>
											</div>
										</div>
									</div>
								</td>
								<td>
									<button class="btn-danger" onclick="showModal(<?php echo "deleteApprovedProofReadModal" . (string)$approveProofReadResult[$x]['id']; ?>)">REMOVE</button>
									<div id="deleteApprovedProofReadModal<?php echo $approveProofReadResult[$x]['id']; ?>" class="modal">
										<div class="modal-content">
											 <div class="modal-header">
												<span class="close" onclick="closeModal(<?php echo "deleteApprovedProofReadModal" . (string)$approveProofReadResult[$x]['id']; ?>)">×</span>
												<h3 style="margin:0">Are you sure you want to remove?</h3>
											 </div>
											 <div class="modal-body">
												<form method="post" action="remove_virtualassistant_staff.php">
													<input type="hidden" name="id" value="<?php echo $approveProofReadResult[$x]['id']; ?>">
													<input type="hidden" name="check" value="2">
													<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
													<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeModal(<?php echo "deleteApprovedProofReadModal" . (string)$approveProofReadResult[$x]['id']; ?>)">No</button>
												</form>
											</div>
										</div>
									</div>
								</td>
								<td>
								<?php
									$num_days = 30;
									$per_day = 24 * 60 * 60;
									$checkDate = new DateTime();
									$today_timestamp = $checkDate->getTimestamp();
									$approvedDate = ($num_days * $per_day) + $approveProofReadResult[$x]['date_updated'];
									$approvedPlusDays = $approvedDate - $today_timestamp;
									
									if($approvedPlusDays <= 0){
								?>
									<center><input type="checkbox" class="remove_all_approved" name="remove_all_approved[]" value="<?php echo $approveProofReadResult[$x]['id']; ?>" checked></center>
								<?php }else{ ?> 
									<center><input type="checkbox" class="remove_all_approved" name="remove_all_approved[]" value="<?php echo $approveProofReadResult[$x]['id']; ?>"></center>
								<?php } ?>
									
								</td>
							</tr>
						<?php }?>
					<?php }else{?>
						<tr>	
							<td colspan="10">No approved staff.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		
		</div>
		<div id="multiple_test" class="tabcontent p-1 ">
test7
			<button type="button" class="btn-success" style="font-size:1rem;" onclick="showModal(addQuestionModal)">Add Question</button>
			<br/>
			<h4>List of Questions</h4>
			<?php if(mysqli_num_rows($getQuestions) > 0){ ?>
				<?php for($q = 0; $q < count($questionResult); $q++){ ?>
					<p class="questions" style="margin-bottom:0px"><span><?php echo $q + 1; ?>.</span> <?php echo $questionResult[$q]['question']; ?> <button type="button" onclick="showRemoveQuestion(<?php echo $questionResult[$q]['id']; ?>)" class="btn-danger">Remove</button></p>
					<ul style="margin-top:5px;display:inline;padding-left:5px;">
						<?php
							$id = $questionResult[$q]['id'];
							$getChoices = mysqli_query($db, "SELECT * FROM ts_virtualassistant_question_choices WHERE question_id='$id'");
							$choicsResult = mysqli_fetch_all($getChoices, MYSQLI_ASSOC);
							
							if(mysqli_num_rows($getChoices) > 0){
								for($c = 0; $c < count($choicsResult); $c++){
									if($choicsResult[$c]['correct'] == NULL || $choicsResult[$c]['correct'] == ""){
										echo "<li style='padding:0 1rem;display:inline;'>&#9675; <span>" . $choicsResult[$c]['description'] . "</span></li>";
									}else{
										echo "<li style='padding:0 1rem;display:inline;'>&#9679; <strong>" . $choicsResult[$c]['description'] . "</strong></li>";
									}
									
								}
							}
						?>
					</ul>
				<?php } ?>
			<?php } ?>
			
		</div>
<!--start email template-->
		<div id="email_template" class="tabcontent p-1">
testemail
                        <p><strong>EMAILS</strong></p>
                        <table style="border:0;">
                                <tbody>
                                        <tr>
                                                <td style="width:40%;vertical-align: top;border:0;">
                                                        <small>APPROVE EMAIL</small>&ensp;<strong style="font-size: 12px;">JOB TYPE: TRANSCRIBER</strong>
                                                        <br/>
                                                        <form action="save_approve_email_template.php" method="post">
                                                                <input type="hidden" name="id" value="1">
                                                                <input type="hidden" name="type" value="1">
                                                                <textarea name="content" rows="15" style="width:100%;"><?php echo htmlentities(urldecode($approveEmailTemplate[0]['content'])); ?></textarea>
                                                                <button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
                                                        </form>
                                                        <br/>
                                                        <small>APPROVE EMAIL</small>&ensp;<strong style="font-size: 12px;">JOB TYPE: PROOFREADER</strong>
                                                        <br/>
                                                        <form action="save_approve_email_template.php" method="post">
                                                                <input type="hidden" name="id" value="2">
                                                                <input type="hidden" name="type" value="2">
                                                                <textarea name="content" rows="15" style="width:100%;"><?php echo htmlentities(urldecode($approveEmailTemplate[1]['content'])); ?></textarea>
                                                                <button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
                                                        </form>
                                                </td>
                                                <td style="width:40%;vertical-align: top;border:0" class="follow-up-email-container">
                                                        <?php for($d = 0; $d < count($followupEmailTemplate); $d++){ ?>
                                                                <div class="follow-up-emails">
                                                                        <small>FOLLOW UP EMAILS</small>
                                                                        <br/>
                                                                        <form action="save_followup_email_template.php" method="post">
                                                                                <textarea name="content" rows="15" style="width:100%;"><?php echo htmlentities(urldecode($followupEmailTemplate[$d]['content'])); ?></textarea>
                                                                                <br/>
                                                                                <small>Delayed Time </small><input type="number" value="<?php echo $followupEmailTemplate[$d]['delayed_time']; ?>" min="1" max="9999999" name="delayed_time" required> <small>hrs</small>
                                                                                &ensp;<select name="type" required>followupEmailTemplate
                                                                                        <option value="1" <?php if($followupEmailTemplate[$d]['type'] == 1) echo "selected"; ?>>Transcriber</option>
                                                                                        <option value="2" <?php if($followupEmailTemplate[$d]['type'] == 2) echo "selected"; ?>>Proofreader</option>
                                                                                </select>
                                                                                <input type="hidden" name="id" value="<?php echo $followupEmailTemplate[$d]['id']; ?>" >
                                                                                <div style="float:right">
                                                                                        <button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
                                                                                        <button class="btn-danger" type="button" style="font-size:12px;" onclick="showModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">DELETE</button>
                                                                                </div>
                                                                        </form>

                                                                        <div id="deleteFollowupModal<?php echo $followupEmailTemplate[$d]['id']; ?>" class="modal">
                                                                                <div class="modal-content">
                                                                                         <div class="modal-header">
                                                                                                <span class="close" onclick="closeModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">×</span>
                                                                                                <h3 style="margin:0">Are you sure you want to remove?</h3>
                                                                                         </div>
                                                                                         <div class="modal-body">
                                                                                                <form method="post" action="delete_followup_email.php">
                                                                                                        <input type="hidden" name="id" value="<?php echo $followupEmailTemplate[$d]['id']; ?>">
                                                                                                        <button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
                                                                                                        <button type="button" class="btn-default" style="font-size:1rem;" onclick="closeModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">No</button>
                                                                                                </form>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <br/>
                                                        <?php } ?>
                                                        <button class="btn-default btn-add-follow-up-email" onclick="addNewFollowupEmail()" type="button">+ ADD NEW FOLLOW UP EMAIL</button>
                                                </td>
                                        </tr>
                                </tbody>
                        </table>
                </div>
<!--end email template-->

	</div>
	
	
	<div id="deleteAllModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close" onclick="closeDeleteAllModal()">×</span>
				<h3 style="margin:0">Are you sure you want to remove all?</h3>
			</div>
			<div class="modal-body">
				<form method="post" action="remove_all_staff.php">
					<input type="hidden" name="staff_ids">
					<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
					<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeDeleteAllModal()">No</button>
				</form>
			</div>
		</div>
	</div>
	<div id="deleteAllProofReadModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close" onclick="closeDeleteAllProofReadModal()">×</span>
				<h3 style="margin:0">Are you sure you want to remove all?</h3>
			</div>
			<div class="modal-body">
				<form method="post" action="remove_all_virtualassistant_staff.php">
					<input type="hidden" name="staff_ids">
					<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
					<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeDeleteAllProofReadModal()">No</button>
				</form>
			</div>
		</div>
	</div>
	<div id="deleteQuestionModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close" onclick="closeDeleteQuestionModal()">×</span>
				<h3 style="margin:0">Are you sure you want to remove?</h3>
			</div>
			<div class="modal-body">
				<form method="post" action="remove_question.php">
					<input type="hidden" name="question_id">
					<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
					<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeDeleteQuestionModal()">No</button>
				</form>
			</div>
		</div>
	</div>
	<div id="addQuestionModal" class="modal">
		<div class="modal-content" style="width:40%">
			<div class="modal-header">
				<span class="close" onclick="closeModal(addQuestionModal)">×</span>
				<h3 style="margin:0">Add Question</h3>
			</div>
			<div class="modal-body">
				<form method="post" action="add_question.php">
					<div>
						<label><strong>Question</strong></label>
						<br/>
						<textarea name="question" style="width:100%"></textarea>
					</div>
					<br/>
					<div>
						<label><strong>Add Choices</strong></label>
						<button type="button" id="addMoreChoices">+</button>
						<br/>
						<small><i>Click the radio for correct answer.</i></small>
						<br/>
						<br/>
						<div id="choices">
						</div>
					</div>
					<br/>
					<button type="submit" class="btn-success" style="font-size:1rem;">SAVE</button>
				</form>
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js" crossorigin="anonymous"></script>
	<script>
		var cnt = 7;
		var count_choices = 0;
		$(document).ready(function(){
			$("#addMoreChoices").click(function(){
				$('#choices').append('<div class="row"><input type="text" name="choices[]"><input type="radio" name="answer" value='+ count_choices +' required></div>');
				count_choices += 1;
			});
		});
		function addNewFollowupEmail() {
			$(".btn-add-follow-up-email").before('<div class="follow-up-emails"> <small>FOLLOW UP EMAILS</small> <br/><form action="add_followup_email_template.php" method="post"><textarea name="content" rows="15" style="width:100%;"></textarea><br/> <small>Delayed Time </small><input type="number" min="1" max="9999999" name="delayed_time" required> <small>hrs</small> &ensp;<select name="type" required>followupEmailTemplate<option value="1">Transcriber</option><option value="2">Proofreader</option> </select><div style="float:right"> <button type="submit" class="btn-success" style="font-size:12px;">SAVE</button></div></form></div> <br/>');
		}
		function addKeyword() {
			$(".keywords-container").append('<div class="keywords-holder"><input type="text" name="primary_keywords_'+cnt+'" placeholder="Primary Keyword '+cnt+'" required /> <input type="text" name="alternative_keywords_'+cnt+'[]" placeholder="Alternative Keyword '+cnt+'" /> <button type="button" class="btn-'+cnt+'" onclick="addMoreAlternative('+cnt+')">+</button></div>');
			$("#count_all_set").val(cnt);
			cnt += 1;
		}
		function addMoreAlternative(n){
			$(".btn-"+n+"").before(' <input type="text" name=alternative_keywords_'+n+'[] placeholder="Alternative Keyword '+n+'" /> ');
			//$(".alternative_keywords_"+n+"").append('<input type="text" name=alternative_keywords_'+n+'[] placeholder="Alternative Keyword" />');
		}
		function showModal(id) {
			id.style.display = "block";
		}

		function showDeleteAllApprovedModal() {
			
			var checkedVals = $('.remove_all_approved:checkbox:checked').map(function() {
				return this.value;
			}).get();
			
			document.getElementById('deleteAllModal').style.display = "block";
			$('input[name=staff_ids]').val(checkedVals.join(","));
			
		}
		function showDeleteAllApprovedProofReadModal() {
			
			var checkedVals = $('#proofread_approved .remove_all_approved:checkbox:checked').map(function() {
				return this.value;
			}).get();
			
			document.getElementById('deleteAllProofReadModal').style.display = "block";
			$('input[name=staff_ids]').val(checkedVals.join(","));
			
		}
		function showDeleteAllPendingProofReadModal() {
			
			var checkedVals = $('#proofread_pending .remove_all:checkbox:checked').map(function() {
				return this.value;
			}).get();
			
			document.getElementById('deleteAllProofReadModal').style.display = "block";
			$('input[name=staff_ids]').val(checkedVals.join(","));
			
		}
		function showRemoveQuestion(id) {
			
			document.getElementById('deleteQuestionModal').style.display = "block";
			$('#deleteQuestionModal input[name=question_id]').val(id);
			
		}
		function closeDeleteQuestionModal() {
			
			document.getElementById('deleteQuestionModal').style.display = "none";
			
		}
		function showDeleteAllPendingModal() {
			
			var checkedVals = $('.remove_all:checkbox:checked').map(function() {
				return this.value;
			}).get();
			
			document.getElementById('deleteAllModal').style.display = "block";
			$('input[name=staff_ids]').val(checkedVals.join(","));
			
		}
		function closeDeleteAllModal() {
			document.getElementById('deleteAllModal').style.display = "none";
		}
		function closeDeleteAllProofReadModal() {
			document.getElementById('deleteAllProofReadModal').style.display = "none";
		}
		function showInputField(field, button, editBtn){
			field.style.display = "block";
			button.style.display = "block";
			editBtn.style.display = "none";
		}
		function closeModal(id) {
			id.style.display = "none";
		}
		function openTab(evt, cityName) {
		  var i, tabcontent, tablinks;
		  tabcontent = document.getElementsByClassName("tabcontent");
		  for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		  }
		  tablinks = document.getElementsByClassName("tablinks");
		  for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }
		  document.getElementById(cityName).style.display = "block";
		  if(cityName == "proofread_approved" || cityName == "proofread_pending" || cityName == "multiple_test" || cityName == "email_template" || cityName == "proofread"){
			 document.getElementById("proofread").style.display = "block"; 
			 document.getElementById("tab_proof").className += " active";
		  }else{
			document.getElementById("transcription").style.display = "block";  
			/*
			document.getElementById("proofread").style.display = "block";
                         document.getElementById("tab_proof").className += " active";
			 */
		  }
		  
		  evt.currentTarget.className += " active";
		}
		function openT(evt, cityName) {

			  var i, tabcontent, tablinks;
			  tabcontent = document.getElementsByClassName("tabcontent");
			  for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			  }
			  tablinks = document.getElementsByClassName("tablinks");
			  for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			  }
			  document.getElementById(cityName).style.display = "block";
			  if(cityName == "transcription"){
				document.getElementById("pending").style.display = "block";
			  }
			  evt.currentTarget.className += " active";
		}
	</script>
</body>
</html>
