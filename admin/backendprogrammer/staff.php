<?php
require '../config/database.php';
require '../controller/crud.php';

if(!isset($_COOKIE["staff_session_id"])) {
	if($_COOKIE["staff_session_id"] != 1){
		header('Location: login.php');
	}
}

$crud = new Crud();

if(!isset($_GET['tab']) || (isset($_GET['tab']) && $_GET['tab'] == "pending")) {
	$getBackendprogrammerData = mysqli_query($db, "SELECT * FROM ts_backendprogrammer_users WHERE status='0' ORDER BY date_created DESC");
	$BackendprogrammerResult = mysqli_fetch_all($getBackendprogrammerData, MYSQLI_ASSOC);
}
if(isset($_GET['tab']) && $_GET['tab'] == "approved") {
	$getBackendprogrammerApproved = mysqli_query($db, "SELECT * FROM ts_backendprogrammer_users WHERE status='1' ORDER BY date_updated DESC");
	$approveBackendprogrammerResult = mysqli_fetch_all($getBackendprogrammerApproved, MYSQLI_ASSOC);
}
if(isset($_GET['tab']) && $_GET['tab'] == "mc_questions") {
	$getQuestions = mysqli_query($db, "SELECT * FROM ts_backendprogrammer_questions WHERE status='1' ORDER BY date_created DESC");
	$questionResult = mysqli_fetch_all($getQuestions, MYSQLI_ASSOC);
}
if(isset($_GET['tab']) && $_GET['tab'] == "email_template") {
	$getApproveEmailTemplate = mysqli_query($db, "SELECT * FROM ts_backendprogrammer_approve_email_template");
	$approveEmailTemplate = mysqli_fetch_all($getApproveEmailTemplate, MYSQLI_ASSOC);

	$getFollowupEmailTemplate = mysqli_query($db, "SELECT * FROM ts_backendprogrammer_followup_email_template");
	$followupEmailTemplate = mysqli_fetch_all($getFollowupEmailTemplate, MYSQLI_ASSOC);
}

$tab_array = array('pending' => 'PENDING STAFF' ,'approved' => 'APPROVED STAFF' ,'mc_questions' => 'MULTIPLE CHOICE TEST','email_template' => 'EMAIL TEMPLATE');

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Show Staff</title>
	<link rel="shortcut icon" href="#" />
    <link rel="stylesheet" href="./css/stylesheet.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet" />
	<style>

	</style>
</head>
<body>
	<a href="signout.php" class="btn-danger" style="float:right;text-decoration:none;font-size:15px">Sign Out</a>
	<h2>Backend programmer</h2>
	<div id="backendprogrammer" class="tabcontent p-1" style="display: block;">
		<div class="tab">
		<?php 
		if(!empty($_GET)){ 
			foreach($tab_array as $value => $desc) {
		?>
			<form action="" method="get"><button type="submit" name="tab" value="<?php echo $value; ?>" class="tablinks <?php echo ($_GET['tab'] == $value ? 'active' : ''); ?>" onclick="openTab(event, '<?php echo $value; ?>')"><h5 class="m-0"><?php echo $desc; ?></h5></button></form>
		<?php
			}
		} else {
			foreach($tab_array as $value => $desc) {
		?>
			<form action="" method="get"><button type="submit" name="tab" value="<?php echo $value; ?>" class="tablinks <?php echo ($value == 'pending' ? 'active' : ''); ?>" onclick="openTab(event, '<?php echo $value; ?>')"><h5 class="m-0"><?php echo $desc; ?></h5></button></form>	
		<?php
			}	
		}
		?>
		</div>
		
		<?php if(empty($_GET) || $_GET['tab'] == "pending"){ ?>
            <div id="pending" class="tabcontent p-1 show">
				<table cellspacing="0">
					<thead>
						<tr>
							<th style="width:20%">Full Name</th>
							<th style="width:15%">Email</th>
							<th style="width:10%">Phone</th>
							<th style="width:11%">Skype</th>
							<th style="width:15%">Source</th>
							<th style="width:15%">CV</th>
							<th style="width:12px">Score</th>
							<th style="width:7%">Test</th>
							<th style="width:6%">Action</th>
							<th style="width:6%">Delete</th>
							<th><button class="btn-danger" onclick="showDeleteAllPendingBackendprogrammerModal()">REMOVE ALL</button></th>
						</tr>
					</thead>
					<tbody>
					<?php if(!isset($_GET['tab']) || $_GET['tab'] == "pending"){ ?>
						<?php if(mysqli_num_rows($getBackendprogrammerData) > 0){ ?>
							<?php for($x = 0; $x < count($BackendprogrammerResult); $x++){ ?>
								<tr>	
									<td><?php echo urldecode($BackendprogrammerResult[$x]['fullname']); ?></td>
									<td><?php echo $BackendprogrammerResult[$x]['email']; ?></td>
									<td><?php echo $BackendprogrammerResult[$x]['phone']; ?></td>
									<td><?php echo $BackendprogrammerResult[$x]['skype']; ?></td>
									<td><?php echo $BackendprogrammerResult[$x]['source']; ?></td>
									<td>
                                        <button class="showCV" onclick="showCVModal('<?php print$BackendprogrammerResult[$x]['cv']; ?>')"  id="myBtn">View CV</button>
                                    </td>
									<td class="score-total"><?php echo $BackendprogrammerResult[$x]['test_score']; ?>%</td>
									<td>
										<button class="btn-default" onclick="showTestResultModal(<?php echo $BackendprogrammerResult[$x]['id']; ?>)">View Test</button>
										<div id="viewTestResultModal<?php echo $BackendprogrammerResult[$x]['id']; ?>" class="modal">
											<div class="modal-content" style="width: 45%;">
												 <div class="modal-header">
													<span class="close" style="top: -10px;" onclick="closeModal(<?php echo "viewTestResultModal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">×</span>
													<h4 style="margin:0">Test Result: Multiple Choice</h4>
												 </div>
												 <div class="modal-body" style="padding-bottom:24px">
													<p style="margin-top:0;">Score: <span style="color:#18AACF;font-weight:bold;"><?php echo $BackendprogrammerResult[$x]['test_score']; ?>%</span></p>
													<div id="test_result_<?php echo $BackendprogrammerResult[$x]['id']; ?>"></div>
												</div>
											</div>
										</div>
									</td>
									<td>
										<button class="btn-success" onclick="showModal(<?php echo "approveBackendprogrammermodal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">APPROVE</button>
										<button class="btn-danger" onclick="showModal(<?php echo "declineBackendprogrammermodal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">DECLINE</button>
										<div id="approveBackendprogrammermodal<?php echo $BackendprogrammerResult[$x]['id']; ?>" class="modal">
											<div class="modal-content">
												 <div class="modal-header">
													<span class="close" onclick="closeModal(<?php echo "approveBackendprogrammermodal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">×</span>
													<h3 style="margin:0">Are you sure you want to approve?</h3>
												 </div>
												 <div class="modal-body">
														<form method="post" action="approve_backendprogrammer_staff.php" style="display:inline">
															<input type="hidden" name="id" value="<?php echo $BackendprogrammerResult[$x]['id']; ?>">
															<input type="hidden" name="email" value="<?php echo $BackendprogrammerResult[$x]['email']; ?>">
															<input type="hidden" name="fullname" value="<?php echo $BackendprogrammerResult[$x]['fullname']; ?>">
															<input type="hidden" name="account_type" value="1">
															<input type="hidden" name="status" value="1">
															<button type="submit" class="btn-success" style="font-size:12px;">YES, as BACKEND DEVELOPER</button>
														</form>
														<form method="post" action="approve_backendprogrammer_staff.php" style="display:inline">
															<input type="hidden" name="id" value="<?php echo $BackendprogrammerResult[$x]['id']; ?>">
															<input type="hidden" name="email" value="<?php echo $BackendprogrammerResult[$x]['email']; ?>">
															<input type="hidden" name="fullname" value="<?php echo $BackendprogrammerResult[$x]['fullname']; ?>">
															<input type="hidden" name="account_type" value="2">
															<input type="hidden" name="status" value="1">
															<button type="submit" class="btn-success" style="font-size:12px;">Yes, as BACKEND DEVELOPER QC</button>
														</form>
												</div>
											</div>
										</div>
										<div id="declineBackendprogrammermodal<?php echo $BackendprogrammerResult[$x]['id']; ?>" class="modal">
											<div class="modal-content">
												 <div class="modal-header">
													<span class="close" onclick="closeModal(<?php echo "declineBackendprogrammermodal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">×</span>
													<h3 style="margin:0">Are you sure you want to decline?</h3>
												 </div>
												 <div class="modal-body">
													<form method="post" action="approve_backendprogrammer_staff.php">
														<input type="hidden" name="id" value="<?php echo $BackendprogrammerResult[$x]['id']; ?>">
														<input type="hidden" name="skype" value="<?php echo $BackendprogrammerResult[$x]['skype']; ?>">
														<input type="hidden" name="email" value="<?php echo $BackendprogrammerResult[$x]['email']; ?>">
														<input type="hidden" name="paypal" value="<?php echo $BackendprogrammerResult[$x]['paypal']; ?>">
														<input type="hidden" name="fullname" value="<?php echo $BackendprogrammerResult[$x]['fullname']; ?>">
														<input type="hidden" name="status" value="0">
														<button type="submit" class="btn-danger" style="font-size:1rem;">Reject</button>
														<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeModal(<?php echo "declineBackendprogrammermodal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">No</button>
													</form>
												</div>
											</div>
										</div>
									</td>
									<td>
										<button class="btn-danger" onclick="showModal(<?php echo "deletePendingBackendprogrammerModal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">REMOVE</button>
										<div id="deletePendingBackendprogrammerModal<?php echo $BackendprogrammerResult[$x]['id']; ?>" class="modal">
											<div class="modal-content">
												 <div class="modal-header">
													<span class="close" onclick="closeModal(<?php echo "deletePendingBackendprogrammerModal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">×</span>
													<h3 style="margin:0">Are you sure you want to remove?</h3>
												 </div>
												 <div class="modal-body">
													<form method="post" action="remove_backendprogrammer_staff.php">
														<input type="hidden" name="id" value="<?php echo $BackendprogrammerResult[$x]['id']; ?>">
														<input type="hidden" name="check" value="1">
														<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
														<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeModal(<?php echo "deletePendingBackendprogrammerModal" . (string)$BackendprogrammerResult[$x]['id']; ?>)">No</button>
													</form>
												</div>
											</div>
										</div>
									</td>
									<td>
										<center><input type="checkbox" class="remove_all" name="remove_all[]" value="<?php echo $BackendprogrammerResult[$x]['id']; ?>"></center>
									</td>
								</tr>
							<?php }?>
						<?php }else{?>
							<tr>	
								<td colspan="11">No pending staff.</td>
							</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
				</table>
			
			</div>
		<?php } ?>
		
		<?php if(!empty($_GET) && $_GET['tab'] == "approved"){ ?>
            <div id="approved" class="tabcontent p-1 show">
				<table cellspacing="0">
					<thead>
						<tr>
							<th style="width:18%">Full Name</th>
							<th style="width:19%">Email</th>
							<th style="width:10%">Phone</th>
							<th style="width:13%">Skype</th>
							<th style="width:14%">Paypal</th>
							<th style="width:14%">JobTitle</th>
							<th style="width:10%">Timestamp</th>
							<th style="width:6%">Score</th>
							<th style="width:8%">Test</th>
							<th style="width:6%">Delete</th>
							<th><button class="btn-danger" onclick="showDeleteAllApprovedBackendprogrammerModal()">REMOVE ALL</button></th>
						</tr>
					</thead>
					<tbody>
					<?php if(!isset($_GET['tab']) || $_GET['tab'] == "approved"){ ?>
						<?php if(!empty($approveBackendprogrammerResult)){ ?>
							<?php for($x = 0; $x < count($approveBackendprogrammerResult); $x++){ ?>
								<tr>	
									<td><?php echo urldecode($approveBackendprogrammerResult[$x]['fullname']); ?></td>
									<td><?php echo $approveBackendprogrammerResult[$x]['email']; ?></td>
									<td><?php echo $approveBackendprogrammerResult[$x]['phone']; ?></td>
									<td><?php echo $approveBackendprogrammerResult[$x]['skype']; ?></td>
									<td><?php echo $approveBackendprogrammerResult[$x]['paypal']; ?></td>
									<td>
																		<?php
																			if($approveBackendprogrammerResult[$x]['account_type'] == 1){
																						echo "BACKEND DEVELOPER";
																					}else{
																							echo "BACKEND DEVELOPER QC";
																					}
																			?>
																	</td>
									<td>
										<?php
											echo date('Y-m-d H:i:s', $approveBackendprogrammerResult[$x]['date_updated']);
											
										?>
									</td>
									<td class="score-total"><?php echo $approveBackendprogrammerResult[$x]['test_score']; ?>%</td>
									<td>
										<button class="btn-default" onclick="showTestResultApprovedModal(<?php echo $approveBackendprogrammerResult[$x]['id']; ?>)">View Test</button>
										<div id="viewApproveTestModal<?php echo $approveBackendprogrammerResult[$x]['id']; ?>" class="modal">
											<div class="modal-content" style="width: 45%;">
												 <div class="modal-header">
													<span class="close" style="top: -10px;" onclick="closeModal(<?php echo "viewApproveTestModal" . (string)$approveBackendprogrammerResult[$x]['id']; ?>)">×</span>
													<h4 style="margin:0">Test Result: Multiple Choice</h4>
												 </div>
												 <div class="modal-body" style="padding-bottom:24px">
													<p style="margin-top:0;">Score: <span style="color:#18AACF;font-weight:bold;"><?php echo $approveBackendprogrammerResult[$x]['test_score']; ?>%</span></p>
													<div id="approved_test_result_<?php echo $approveBackendprogrammerResult[$x]['id']; ?>"></div>
												</div>
											</div>
										</div>
									</td>
									<td>
										<button class="btn-danger" onclick="showModal(<?php echo "deleteApprovedBackendprogrammerModal" . (string)$approveBackendprogrammerResult[$x]['id']; ?>)">REMOVE</button>
										<div id="deleteApprovedBackendprogrammerModal<?php echo $approveBackendprogrammerResult[$x]['id']; ?>" class="modal">
											<div class="modal-content">
												 <div class="modal-header">
													<span class="close" onclick="closeModal(<?php echo "deleteApprovedBackendprogrammerModal" . (string)$approveBackendprogrammerResult[$x]['id']; ?>)">×</span>
													<h3 style="margin:0">Are you sure you want to remove?</h3>
												 </div>
												 <div class="modal-body">
													<form method="post" action="remove_backendprogrammer_staff.php">
														<input type="hidden" name="id" value="<?php echo $approveBackendprogrammerResult[$x]['id']; ?>">
														<input type="hidden" name="check" value="2">
														<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
														<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeModal(<?php echo "deleteApprovedBackendprogrammerModal" . (string)$approveBackendprogrammerResult[$x]['id']; ?>)">No</button>
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
										$approvedDate = ($num_days * $per_day) + $approveBackendprogrammerResult[$x]['date_updated'];
										$approvedPlusDays = $approvedDate - $today_timestamp;
										
										if($approvedPlusDays <= 0){
									?>
										<center><input type="checkbox" class="remove_all_approved" name="remove_all_approved[]" value="<?php echo $approveBackendprogrammerResult[$x]['id']; ?>" checked></center>
									<?php }else{ ?> 
										<center><input type="checkbox" class="remove_all_approved" name="remove_all_approved[]" value="<?php echo $approveBackendprogrammerResult[$x]['id']; ?>"></center>
									<?php } ?>
										
									</td>
								</tr>
							<?php }?>
						<?php }else{?>
							<tr>	
								<td colspan="11">No approved staff.</td>
							</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
		
		<?php if(!empty($_GET) && $_GET['tab'] == "mc_questions"){ ?>
             <div id="mc_questions" class="tabcontent show p-1">
				<button type="button" class="btn-success" style="font-size:1rem;" onclick="showModal(addQuestionModal)">Add Question</button>
				<br/>
				<h4>List of Questions</h4>
				<?php if(mysqli_num_rows($getQuestions) > 0){ ?>
					<?php for($q = 0; $q < count($questionResult); $q++){ ?>
						<p class="questions" style="margin-bottom:0px"><span><?php echo $q + 1; ?>.</span> <?php echo $questionResult[$q]['question']; ?> <button type="button" onclick="showRemoveQuestion(<?php echo $questionResult[$q]['id']; ?>)" class="btn-danger">Remove</button></p>
						<ul style="margin-top:5px;display:inline;padding-left:5px;">
							<?php
								$id = $questionResult[$q]['id'];
								$getChoices = mysqli_query($db, "SELECT * FROM ts_backendprogrammer_question_choices WHERE question_id='$id'");
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
		<?php } ?>
		
		<?php if(!empty($_GET) && $_GET['tab'] == "email_template"){ ?>
            <div id="email_template" class="tabcontent show p-1">
                        <p><strong>EMAILS</strong></p>
                        <table style="border:0;">
                                <tbody>
                                        <tr>
                                                <td style="width:40%;vertical-align: top;border:0;">
                                                        <small>APPROVE EMAIL</small>&ensp;<strong style="font-size: 12px;">JOB TYPE: BACKEND DEVELOPER</strong>
                                                        <br/>
                                                        <form action="save_backendprogrammer_approve_email_template.php" method="post">
                                                                <input type="hidden" name="id" value="1">
                                                                <input type="hidden" name="type" value="1">
                                                                <textarea name="content" rows="15" style="width:100%;"><?php if (array_key_exists(0, $approveEmailTemplate)) { echo htmlentities(urldecode($approveEmailTemplate[0]['content'])); } ?></textarea>
                                                                <button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
                                                        </form>
                                                        <br/>
                                                        <small>APPROVE EMAIL</small>&ensp;<strong style="font-size: 12px;">JOB TYPE: BACKEND DEVELOPER QC</strong>
                                                        <br/>
                                                        <form action="save_backendprogrammer_approve_email_template.php" method="post">
                                                                <input type="hidden" name="id" value="2">
                                                                <input type="hidden" name="type" value="2">
                                                                <textarea name="content" rows="15" style="width:100%;"><?php if (array_key_exists(1, $approveEmailTemplate)) { echo htmlentities(urldecode($approveEmailTemplate[1]['content'])); } ?></textarea>
                                                                <button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
                                                        </form>
							                            <br/>
                                                        <small>AUTO CREATE ACCOUNT</small>&ensp;<strong style="font-size: 12px;">JOB TYPE: BACKEND DEVELOPER</strong>
                                                        <br/>
                                                        <form action="save_backendprogrammer_approve_email_template.php" method="post">
                                                                <input type="hidden" name="id" value="3">
                                                                <input type="hidden" name="type" value="3">
                                                                <textarea name="content" rows="15" style="width:100%;"><?php if (array_key_exists(2, $approveEmailTemplate)) { echo htmlentities(urldecode($approveEmailTemplate[2]['content'])); } ?></textarea>
                                                                <button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
                                                        </form>
                                                        <br/>
                                                        <small>AUTO CREATE ACCOUNT</small>&ensp;<strong style="font-size: 12px;">JOB TYPE: BACKEND DEVELOPER QC</strong>
                                                        <br/>
                                                        <form action="save_backendprogrammer_approve_email_template.php" method="post">
                                                                <input type="hidden" name="id" value="4">
                                                                <input type="hidden" name="type" value="4">
                                                                <textarea name="content" rows="15" style="width:100%;"><?php if (array_key_exists(2, $approveEmailTemplate)) { echo htmlentities(urldecode($approveEmailTemplate[3]['content'])); } ?></textarea>
                                                                <button type="submit" class="btn-success" style="font-size:12px;">UPDATE</button>
                                                        </form>
                                                </td>
                                                <td style="width:40%;vertical-align: top;border:0" class="follow-up-email-container">
                                                        <?php for($d = 0; $d < count($followupEmailTemplate); $d++){ ?>
                                                                <div class="follow-up-emails">
                                                                        <small>FOLLOW UP EMAILS</small>
                                                                        <br/>
                                                                        <form action="save_backendprogrammer_followup_email_template.php" method="post">
                                                                                <textarea name="content" rows="15" style="width:100%;"><?php echo htmlentities(urldecode($followupEmailTemplate[$d]['content'])); ?></textarea>
                                                                                <br/>
                                                                                <small>Delayed Time </small><input type="number" value="<?php echo $followupEmailTemplate[$d]['delayed_time']; ?>" min="1" max="9999999" name="delayed_time" required> <small>hrs</small>
                                                                                &ensp;<select name="type" required>followupEmailTemplate
                                                                                        <option value="1" <?php if($followupEmailTemplate[$d]['type'] == 1) echo "selected"; ?>>BACKEND DEVELOPER</option>
                                                                                        <option value="2" <?php if($followupEmailTemplate[$d]['type'] == 2) echo "selected"; ?>>BACKEND DEVELOPER QC</option>
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
		<?php } ?>
    </div>
<!--end email template-->
	
	
	<div id="deleteAllModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close" onclick="closeDeleteAllModal()">×</span>
				<h3 style="margin:0">Are you sure you want to remove all?</h3>
			</div>
			<div class="modal-body">
				<form method="post" action="remove_all_backendprogrammer_staff.php">
					<input type="hidden" name="staff_ids">
					<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
					<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeDeleteAllModal()">No</button>
				</form>
			</div>
		</div>
	</div>
    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close close_cv_modal">&times;</span>
            <embed id="embedPDF" src="<?php //echo "https://topremotestaff.us-east-1.linodeobjects.com/cv/".$BackendprogrammerResult[$x]['cv']; ?>" type="application/pdf" width="100%" height="600px" />
        </div>

    </div>
	<div id="deleteAllBackendprogrammerModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<span class="close" onclick="closeDeleteAllBackendprogrammerModal()">×</span>
				<h3 style="margin:0">Are you sure you want to remove all?</h3>
			</div>
			<div class="modal-body">
				<form method="post" action="remove_all_backendprogrammer_staff.php">
					<input type="hidden" name="staff_ids">
					<button type="submit" class="btn-danger" style="font-size:1rem;">Yes</button>
					<button type="button" class="btn-default" style="font-size:1rem;" onclick="closeDeleteAllBackendprogrammerModal()">No</button>
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
			$(".btn-add-follow-up-email").before('<div class="follow-up-emails"> <small>FOLLOW UP EMAILS</small> <br/><form action="add_followup_email_template.php" method="post"><textarea name="content" rows="15" style="width:100%;"></textarea><br/> <small>Delayed Time </small><input type="number" min="1" max="9999999" name="delayed_time" required> <small>hrs</small> &ensp;<select name="type" required>followupEmailTemplate<option value="1">BACKEND DEVELOPER</option><option value="2">BACKEND DEVELOPER QC</option> </select><div style="float:right"> <button type="submit" class="btn-success" style="font-size:12px;">SAVE</button></div></form></div> <br/>');
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
		function showTestResultModal(id){
		
			const formD = new FormData();
			formD.append('id', id);

			jQuery.ajax({
				type: 'POST',
				url: 'show_test_result.php',
				data: formD,
				processData: false,
				contentType: false
			}).done(function(res) {
				//var data = JSON.parse(res);
				//console.log(res);
				$("#test_result_"+id).html(res);
				var element = "#viewTestResultModal" + id;
				$(element).show();
			}); 
		}
		
		function showTestResultApprovedModal(id){
			const formD = new FormData();
			formD.append('id', id);

			jQuery.ajax({
				type: 'POST',
				url: 'show_approved_test_result.php',
				data: formD,
				processData: false,
				contentType: false
			}).done(function(res) {
				//var data = JSON.parse(res);
				//console.log(res);
				$("#approved_test_result_"+id).html(res);
				var element = "#viewApproveTestModal" + id;
				$(element).show();
			}); 
		}

		function showDeleteAllApprovedModal() {
			
			var checkedVals = $('.remove_all_approved:checkbox:checked').map(function() {
				return this.value;
			}).get();
			
			document.getElementById('deleteAllModal').style.display = "block";
			$('input[name=staff_ids]').val(checkedVals.join(","));
			
		}
		function showDeleteAllApprovedBackendprogrammerModal() {
			
			var checkedVals = $('#approved .remove_all_approved:checkbox:checked').map(function() {
				return this.value;
			}).get();
			
			document.getElementById('deleteAllBackendprogrammerModal').style.display = "block";
			$('input[name=staff_ids]').val(checkedVals.join(","));
			
		}
		function showDeleteAllPendingBackendprogrammerModal() {
			
			var checkedVals = $('#pending .remove_all:checkbox:checked').map(function() {
				return this.value;
			}).get();
			
			document.getElementById('deleteAllBackendprogrammerModal').style.display = "block";
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
		function closeDeleteAllBackendprogrammerModal() {
			document.getElementById('deleteAllBackendprogrammerModal').style.display = "none";
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
		  if(cityName == "approved" || cityName == "pending" || cityName == "mc_questions" || cityName == "email_template" || cityName == "Backendprogrammer"){
			 document.getElementById("Backendprogrammer").style.display = "block";
//			 document.getElementById("tab_proof").className += " active";
		  }else{
			document.getElementById("transcription").style.display = "block";  
			/*
			document.getElementById("backendprogrammer").style.display = "block";
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




        // Get the modal
        var modal = document.getElementById("myModal");
        var embededURL = document.getElementById("embedPDF");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var close_span = document.getElementsByClassName("close_cv_modal")[0];

        // When the user clicks the button, open the modal
        // btn.onclick = function() {
        //     modal.style.display = "block";
        // }
        function showCVModal(fileName){
            modal.style.display = "block";
            embededURL.setAttribute("src", "https://topremotestaff.us-east-1.linodeobjects.com/cv/"+fileName);
        }

        // When the user clicks on <span> (x), close the modal
        close_span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
	</script>
</body>
</html>