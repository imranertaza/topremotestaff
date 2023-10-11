<?php 
	require 'config/url.php';
	require 'config/database.php';
	require 'controller/crud.php';

	$crud = new Crud();

	$getQCQuestions = mysqli_query($db, "SELECT * FROM pr_list_of_questions WHERE status='1' ORDER BY date_created ASC");
	$qcQuestion = mysqli_fetch_all($getQCQuestions, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <title>OnboardQuiz - Add Questions - Proofreading</title>
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
		table tbody tr td:nth-child(3){
			border-right: 1px solid #909090;
		}
		table thead th,
		table tbody tr td{
			padding:8px 15px !important;
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
		.not-btn{
		    color: #000 !important;
			text-decoration:underline;
			background-color: transparent !important;
			padding: 0 !important;
			border-radius: 0 !important;
		}
	</style>
  </head>
  <body>
		
		<div class="container-fluid">
			
			<div class="mt-1 mb-4">
				<div class="row">
					<main role="main" class="col-12 mt-2 mx-auto">
						<h3>List of Questions</h3>
						<div class="mt-2">
							<button type='button' class="btn btn-sm btn-success" data-toggle="modal" data-target="#addQuestionModal">Add Question</button>
							
							<div class="row mt-2">
								<div class="col-12">
									<?php if(mysqli_num_rows($getQCQuestions) > 0){ ?>
										<?php for($q = 0; $q < count($qcQuestion); $q++){ ?>
											<p class="questions mb-0 pt-2"><span><?php echo $q + 1; ?>.</span> <?php echo $qcQuestion[$q]['question']; ?> <button type="button" onclick="showRemoveQuestion(<?php echo $qcQuestion[$q]['id']; ?>)" class=" btn btn-sm btn-danger" style="font-size:10px">Remove</button></p>
											<ul class="mt-1 mb-0 pl-1 list-unstyled">
												<?php
													$id = $qcQuestion[$q]['id'];
													$getChoices = mysqli_query($db, "SELECT * FROM pr_list_of_choices WHERE question_id='$id'");
													$choicsResult = mysqli_fetch_all($getChoices, MYSQLI_ASSOC);
													
													if(mysqli_num_rows($getChoices) > 0){
														for($c = 0; $c < count($choicsResult); $c++){
															if($choicsResult[$c]['correct'] == 0){
																echo "<li class='px-3 py-0'>&#9675; <span>" . $choicsResult[$c]['description'] . "</span></li>";
															}else{
																echo "<li class='px-3 py-0'><span style='font-size:25px;line-height:1'>&#9679;</span></strong> <strong>" . $choicsResult[$c]['description'] . "</strong></li>";
															}
														}
													}
												?>
											</ul>
											<form method="post" class="mt-3" action="savecomment.php">
												<span style="margin-left:1rem;">Comment:</span><button class="btn btn-sm btn-success ml-2 px-2 py-1" type="submit">SAVE</button><br/>
												<input type="hidden" name="question_id" value="<?php echo $qcQuestion[$q]['id']; ?>">
												<textarea name="comment" class="ml-3 mt-1" style="width:60%;font-size:13px;"><?php echo $qcQuestion[$q]['comment']; ?></textarea>
											</form>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
						</div>
					</main>
				</div>
			</div>
		</div>
	<div id="deleteQuestionModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 style="m-0">Are you sure you want to remove?</h6>
					<span class="close" data-dismiss="modal" style="cursor:pointer">×</span>
				</div>
				<div class="modal-body">
					<form method="post" action="remove_question.php">
						<input type="hidden" name="question_id">
						<button type="submit" class="btn btn-danger" style="font-size:1rem;">Yes</button>
						<button type="button" class="btn btn-default border" style="font-size:1rem;" data-dismiss="modal">No</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div id="addQuestionModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="m-0">Add Question</h5>
					<span class="close" data-dismiss="modal" style="cursor:pointer">×</span>
					
				</div>
				<div class="modal-body">
					<form method="post" action="add_question.php">
						<div>
							<label><strong>Question</strong></label><br/>
							<textarea name="question" style="width:100%"></textarea><br/>
						</div>
						<div>
							<input type="checkbox" name="withchoices"> <label><strong>With Choices?</strong></label>
						</div>
						<div>
							<input type="checkbox" name="required"> <label><strong>Required?</strong></label>
						</div>
						<div>
							<label><strong>Comment</strong></label><br/>
							<textarea name="comment" style="width:100%"></textarea><br/>
						</div>						
						<div>
							<label><strong>Add Choices</strong></label>
							<button type="button" class="btn btn-primary px-2 py-0" id="addMoreChoices">+</button>
							<br/>
							<small><i>Click the radio for correct answer.</i></small>
							<br/>
							<br/>
							<div id="choices">
							</div>
						</div>
						<br/>
						<button type="submit" class="btn btn-success" style="font-size:1rem;">SAVE</button>
					</form>
				</div>
			</div>
		</div>
	</div>
    <script src="js/jquery.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script>
		var count_choices = 0;
		function showRemoveQuestion(id) {
			
				//document.getElementById('deleteQuestionModal').style.display = "block";
				$("#deleteQuestionModal").modal("show");
				$('#deleteQuestionModal input[name=question_id]').val(id);
				
			}
		
		$(document).ready(function(){
			$("#addMoreChoices").click(function(){
				$('#choices').append('<div class="form-group"><input style="width:90%" type="text" name="choices[]"> <input type="radio" name="answer" value='+ count_choices +' required></div>');
				count_choices += 1;
			});
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
		});
	</script>
  </body>
</html>