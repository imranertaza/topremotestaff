<?php 
	require 'config/url.php';
	require 'config/database.php';
	
	session_start();

	if(count($_SESSION) > 0){
		if(isset($_SESSION["admin_user_role"])){
			if($_SESSION["admin_user_role"] != 3 && $_SESSION["admin_user_role"] != 4){
				header('Location: sign-in.php');	
			}
		}
	}else{
		header('Location: sign-in.php');	
	}

	$crud = new Crud();
	$userid = $_SESSION["admin_id"];
	$getData = mysqli_query($db, "SELECT * FROM bkp_admin_users where id != '$userid' ORDER BY date_created DESC");	
	$result = mysqli_fetch_all($getData, MYSQLI_ASSOC);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/client-style.css" crossorigin="anonymous">
    <title>Admin Panel - Manage Staff</title>
	<style>
		table{
		    border: 1px solid #909090;
			background-color:#fff;
		}
		table thead{
			background-color: #5A5A5A;
			color: #fff;
		}
		table tbody tr td:nth-child(1),
		table thead tr th:nth-child(1),
		table tbody tr td:nth-child(2),
		table thead tr th:nth-child(2),
		table thead tr th:nth-child(3),
		table thead tr th:nth-child(4),
		table thead tr th:nth-child(5),
		table thead tr th:nth-child(6),
		table thead tr th:nth-child(7),
		table thead tr th:nth-child(8),
		table thead tr th:nth-child(9),
		table thead tr th:nth-child(10),
		table tbody tr td:nth-child(3),
		table tbody tr td:nth-child(4),
		table tbody tr td:nth-child(5),
		table tbody tr td:nth-child(6),
		table tbody tr td:nth-child(7),
		table tbody tr td:nth-child(8),
		table tbody tr td:nth-child(9),
		table tbody tr td:nth-child(10){
			border-right: 1px solid #909090;
		}
		table thead th,
		table tbody tr td{
			padding:8px 15px !important;
		    vertical-align: middle !important;
		}
		.search-wrapper{
			padding:1rem;
			width:40%;
			border-radius:6px;
			 background-color: #fff;
			-webkit-box-shadow: 0px 1px 2px 0px rgba(0,0,0,0.25);
			-moz-box-shadow: 0px 1px 2px 0px rgba(0,0,0,0.25);
			box-shadow: 0px 1px 2px 0px rgba(0,0,0,0.25);
		}
		.search-wrapper button{
			float:right;
			color: #fff;
			background-color: #db3145;
			border-radius: 45px;
			padding: 2px 20px;
			margin-top: -4px;
		}
		
		.search-wrapper button:hover{
			background-color:#b32737;
			color:#fff;
		}
		.search-wrapper input{
			height:24px;
		}
		.tbl-projects a {
			padding: 1px 15px;
		}
		.tbl-projects table button{
			color: #fff;
			background-color: #db3145;
			padding: 1px 15px;
			border-radius: 20px;
			font-size: 0.85rem;
		}
		.tbl-projects table button:hover{
			background-color:#b32737;
			color:#fff;
		}
	</style>
  </head>
  <body>
	<nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0">
			<a class="navbar-brand" href="admin-panel.php">
				<img src="img/logo.png" class="img-fluid">
			</a>
			<button class="navbar-toggler collapsed d-md-none d-lg-none d-sm-none mr-3" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-expanded="false">
				<span class="fa fa-bars"></span>
			</button>
			<ul class="navbar-nav px-3">
				<li class="nav-item text-nowrap px-3 my-auto active">
					<a href="manage-accounts.php" class="">Manage Staff</a>	
				</li>
				<li class="nav-item text-nowrap px-3 my-auto">
					<a href="unassigned-companies.php" class="text-dark">Unassigned Companies</a>	
				</li>
				<li class="nav-item text-nowrap px-3 my-auto">
					<a href="sign-out.php" class="btn btn-lg btn-logout text-white border-0">Log Out</a>	
				</li>
			</ul>
		</nav>
		<div class="container-fluid">
			<div class="mt-69">
				<div class="row">
					<main role="main" class="col-12 mt-2 mx-auto">
						<div class="mt-3">
							<h4 class="border-bottom">Add Account</h4>
							<div class="table-responsive tbl-projects">
								<?php if($alert == 1){ ?>
									<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
										<strong>Congratulations!</strong> <?php echo $alert_info; ?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
								<?php }else if($alert == 2){ ?>
									<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
										<strong>Error!</strong> <?php echo $alert_info; ?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
								<?php } ?>
								<form id="addAccounForm" method="post" action="manage-accounts.php">
									<table class="responsive table table-sm table-borderless">
										<thead>
											<tr class="text-center">
												<th>Email</th>
												<th>Password</th>
												<th>Set Status</th>
												<th>Set Account Type</th>
												<th>Full Name</th>
												<th>Phone</th>
												<th>Payment ID</th>
												<th>Payment Type</th>
												<th>Insert</th>
											</tr>
										</thead>
										<tbody class="pb-5">
											<tr>
												<td><input type="text" name="email" required></td>
												<td><input type="password" name="password" required></td>
												<td>
													<select name="status">
														<!--<option value="1">TRIAL</option>
														<option value="2">PENDING</option>-->
														<option value="3">ACTIVE</option>
														<option value="4">HOLD</option>
														<!--<option value="5">CANCELLED</option>-->
													</select>
												</td>
												<td>
													<select name="account_type">
														<option value="1">QC</option>
														<option value="2">BOOKKEEPER</option>
														<option value="3">ADMIN</option>
														<option value="4">SUPERUSER</option>
													</select>
												</td>
												<td><input type="text" name="full_name" required></td>
												<td><input type="text" name="phone_number" required></td>
												<td><input type="text" name="payment_id" required></td>
												<td>
													<select name="payment_type">
														<option></option>
														<option value="1">Upwork</option>
														<option value="2">Paypal</option>
													</select>
												</td>
												<td>
													<button type="button" class="btn btn-red" data-toggle="modal" data-target="#addAccountModal">Submit</button>
												</td>
											</tr>
										</tbody>
									</table>
								</form>
							</div>
						</div>
						<div class="mt-4">
							<h4 class="border-bottom">Account Details</h4>
							<div class="table-responsive tbl-projects">
								<table class="responsive table table-sm table-borderless">
									<thead>
										<tr class="text-center">
											<th style="width: 8%;">Staff ID</th>
											<th style="width: 8%;">Account Type</th>
											<th style="width: 15%;">Full Name</th>
											<th style="width: 15%;">Email</th>
											<th style="width: 8%;">Phone</th>
											<th>Payment ID</th>
											<th style="width: 7%;">Payment Type</th>
											<th style="width: 6%;">Status</th>
											<?php if($_SESSION["admin_user_role"] == 4){ ?>
												<th style="width: 5%;">Update</th>
												<th style="width: 5%;">Delete</th>
												<th>
													<button class="btn btn-red" onclick="showDeleteAllPendingModal()">DELETE ALL</button>
												</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody class="pb-5">
										<?php if(mysqli_num_rows($getData) > 0){ ?>
											<?php for($x = 0; $x < count($result); $x++){ ?>
												
												<tr>
													<td data-label="Account ID" class="align-middle text-center">
														<input type="hidden" name="id" id="id<?php echo $result[$x]['id']; ?>" value="<?php echo $result[$x]['id']; ?>">
														<?php echo $result[$x]['id']; ?>
													</td>
													<td class="align-middle">
														<select name="account_type" id="account_type<?php echo $result[$x]['id']; ?>">
															<option value="1" <?php if($result[$x]['user_role'] == 1 ) echo "selected"; ?>>QC</option>
															<option value="2" <?php if($result[$x]['user_role'] == 2 ) echo "selected"; ?>>BOOKKEEPER</option>
															<option value="3" <?php if($result[$x]['user_role'] == 3 ) echo "selected"; ?>>ADMIN</option>
															<option value="4" <?php if($result[$x]['user_role'] == 4 ) echo "selected"; ?>>SUPERUSER</option>
														</select>
													</td>
													<td class="align-middle fixed-td-width">
														<input type="text" name="full_name" id="full_name<?php echo $result[$x]['id']; ?>" value="<?php echo $result[$x]['full_name']; ?>" required>
													</td>
													<td class="align-middle fixed-td-width">
														<input type="text" name="email" id="email<?php echo $result[$x]['id']; ?>" value="<?php echo $result[$x]['email']; ?>" required>
													</td>
													<td class="align-middle fixed-td-width">
														<input type="text" name="phone_number" style="width:150px;" id="phone_number<?php echo $result[$x]['id']; ?>" value="<?php echo $result[$x]['phone_number']; ?>" required>
													</td>
													<td class="align-middle fixed-td-width">
														<input type="text" name="payment_id" id="payment_id<?php echo $result[$x]['id']; ?>" value="<?php echo $result[$x]['payment_id']; ?>" required>
													</td>
													<td class="align-middle fixed-td-width">
														<select name="payment_type" id="payment_type<?php echo $result[$x]['id']; ?>">
															<option <?php if($result[$x]['payment_type'] == 0 ) echo "selected"; ?>></option>
															<option value="1" <?php if($result[$x]['payment_type'] == 1 ) echo "selected"; ?>>Upwork</option>
															<option value="2" <?php if($result[$x]['payment_type'] == 2 ) echo "selected"; ?>>Paypal</option>
														</select>
													</td>
													<td class="align-middle fixed-td-width">
														<select name="status" id="status<?php echo $result[$x]['id']; ?>">
															<!--<option value="1" <?php if($result[$x]['status'] == 1 ) echo "selected"; ?>>TRIAL</option>
															<option value="2" <?php if($result[$x]['status'] == 2 ) echo "selected"; ?>>PENDING</option>-->
															<option value="3" <?php if($result[$x]['status'] == 3 ) echo "selected"; ?>>ACTIVE</option>
															<option value="4" <?php if($result[$x]['status'] == 4 ) echo "selected"; ?>>HOLD</option>
															<!--<option value="5" <?php if($result[$x]['status'] == 5 ) echo "selected"; ?>>CANCELLED</option>-->
														</select>
													</td>
													<?php if($_SESSION["admin_user_role"] == 4){ ?>
														<td>
															<a href="#" data-toggle="modal" data-target="#updateAccount<?php echo $result[$x]['id']; ?>" class="btn btn-red">Update</a>
															<div id="updateAccount<?php echo $result[$x]['id']; ?>" class="modal fade">
																<div class="modal-dialog">
																	<div class="modal-content">
																		 <div class="modal-header">
																			<h6 style="margin:0">Are you sure you want to update?</h6>
																			<span class="close" data-dismiss="modal" style="cursor:pointer">×</span>
																		 </div>
																		 <div class="modal-body">
																			<button type="button" onclick="updateNow(<?php echo $result[$x]['id']; ?>)" class="btn btn-success rounded px-3 py-2" style="font-size:1rem;background-color: #1e7e34;">Yes</button>
																			<button type="button" class="btn btn-default border bg-white text-dark rounded px-3 py-2" style="font-size:1rem;" data-dismiss="modal">No</button>
																		</div>
																	</div>
																</div>
															</div>
															
														</td>
														<td>
															<button class="btn btn-danger" data-toggle="modal" data-target="#deleteAccount<?php echo $result[$x]['id']; ?>">Delete</button>
															<div id="deleteAccount<?php echo $result[$x]['id']; ?>" class="modal fade">
																<div class="modal-dialog">
																	<div class="modal-content">
																		 <div class="modal-header">
																			<h6 style="margin:0">Are you sure you want to remove?</h6>
																			<span class="close" data-dismiss="modal" style="cursor:pointer">×</span>
																		 </div>
																		 <div class="modal-body">
																			<form method="post" action="remove_account.php">
																				<input type="hidden" name="id" value="<?php echo $result[$x]['id']; ?>">
																				<button type="submit" class="btn btn-danger rounded px-3 py-2" style="font-size:1rem;">Yes</button>
																				<button type="button" class="btn btn-default border bg-white text-dark rounded px-3 py-2" style="font-size:1rem;" data-dismiss="modal">No</button>
																			</form>
																		</div>
																	</div>
																</div>
															</div>
														</td>
														<td>
															<center><input type="checkbox" class="remove_all" name="remove_all[]" value="<?php echo $result[$x]['id']; ?>"></center>
														</td>
													<?php } ?>
												</tr>
											<?php }?>
										<?php }else{?>
											<tr>	
												<?php if($_SESSION["user_role"] == 4){ ?>
													<td colspan="10">No data.</td>
												<?php }else{ ?>
													<td colspan="8">No data.</td>
												<?php }?>
											</tr>
										<?php } ?>
										
									</tbody>
								</table>
							</div>
						</div>
					</main>
				</div>
			</div>
		</div>
	<!-- Add Account Modal -->
	<div id="addAccountModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-body">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p>Are you sure you want to add it?</p>
			<button type="button" class="btn btn-success" onclick="submitNow()">Submit</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>
	<div id="deleteAllModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 style="margin:0">Are you sure you want to remove all?</h6>
					<span class="close" data-dismiss="modal" style="cursor:pointer">×</span>
				</div>
				<div class="modal-body">
					<form method="post" action="remove_all_account.php">
						<input type="hidden" name="user_ids">
						<button type="submit" class="btn btn-danger" style="font-size:1rem;">Yes</button>
						<button type="button" class="btn btn-default border" style="font-size:1rem;" data-dismiss="modal">No</button>
					</form>
				</div>
			</div>
		</div>
	</div>
    <script src="js/jquery.min.js" crossorigin="anonymous"></script>
	<script src="js/popper.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){

			});
			function updateNow(id){
				var u_id = $("#id" + id).val();
				var full_name = $("#full_name" + id).val();
				var phone_number = $("#phone_number" + id).val();
				var email = $("#email" + id).val();
				var account_type = $("#account_type" + id).val();
				var payment_id = $("#payment_id" + id).val();
				var payment_type = $("#payment_type" + id).val();
				var status = $("#status" + id).val();
				
				$.ajax({
					type: "POST",
					url: "controller/editAdminAccount.php",
					dataType: "json",
					data:  {id:u_id,full_name:full_name,phone_number:phone_number,email:email,account_type:account_type,payment_id:payment_id,payment_type:payment_type,status:status} ,
					success:
						function(data) {
						
							if(data == true){
								window.location.reload();
							}
						},
					error:
						function(data){
							//console.log("error");						
						}
				});
			}
			function showDeleteAllPendingModal() {
			
				var checkedVals = $('.remove_all:checkbox:checked').map(function() {
					return this.value;
				}).get();
				
				$("#deleteAllModal").modal("show");
				$('input[name=user_ids]').val(checkedVals.join(","));
				
			}
			function submitNow(){
				$("#addAccounForm").submit();
			}
			function formatDate(d){
				var dateAdded = new Date(d);
				var year = dateAdded.getFullYear();
				var day = dateAdded.getDate();
				var hours = dateAdded.getHours();
				var min = dateAdded.getMinutes();
				var sec = dateAdded.getSeconds();
				var month;
				switch(dateAdded.getMonth()){
					case 0:
					month = "January";
					break;
					case 1:
					month = "February";
					break;
					case 2:
					month = "March";
					break;
					case 3:
					month = "April";
					break;
					case 4:
					month = "May";
					break;
					case 5:
					month = "June";
					break;
					case 6:
					month = "July";
					break;
					case 7:
					month = "August";
					break;
					case 8:
					month = "September";
					break;
					case 9:
					month = "October";
					break;
					case 10:
					month = "November";
					break;
					case 11:
					month = "December";
					break;
				}
				return month + " " + day + ", " + year + ", " + hours + ":" + min + ":" + sec;
			}

	</script>
  </body>
</html>