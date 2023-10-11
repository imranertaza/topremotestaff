<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();

//$getQuestions = mysqli_query($db, "SELECT * FROM ts_questions WHERE status='1' ORDER BY date_created DESC LIMIT 15");
$getQuestions = mysqli_query($db, "SELECT * FROM ts_questions WHERE status='1' ORDER BY RAND() DESC LIMIT 15");
$questionResult = mysqli_fetch_all($getQuestions, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Examination - Transcription Staff</title>
		<link rel="shortcut icon" href="#" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1" />
		<link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet" />
		<style>
			body {
	  			font-family: 'Montserrat', sans-serif;
			}
			.w-100{
				width: 100%;
				display: block;
			}
			.left-panel {
				width: 32%;
				position: fixed;
				top: 0;
				left: 0;
				background-color: #121212;
			}
			.right-panel {
				width: 68%;
				float: right;
				background-color: #232323;
			}
			.margin-top{
				margin-top:1rem;
			}
			.text-right{
				text-align:right;
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
			.replace-panel{
				display:none;
				width: 280px;
				padding: 1rem;
				background-color: #fff;
				border: 1px solid #909090;
				position: fixed;
				top: 100px;
				right: 100px;
				font-size: 14px;
			}
			.cursor-pointer{
				cursor:pointer;
			}
			#lastfile{
				opacity:0;
			}
			.textbox-container{
				background-color:#121212;
			}
			.text-panel{
				opacity:1;
			}
			.text-panel .sbutton{
				color:#fff;
			}
			#textbox1{
				box-shadow:none;
				resize: none;
				font-size: 15px;
				line-height: 20px;
				font-family: Arial;
				margin: 50px auto;
				display: block;
				border: none;
				outline: none;
				background: #fff;
				padding: 50px;
				min-height: 700px;
				color: #262626;
				width: 50%;
			}
			.file-input-wrapperNew{
   				width: 660px;
    			padding: 20px;
				overflow: hidden;
				position: relative;
				margin: 20px auto;
				border-radius: 5px;
				line-height: 1.4;
				border: 0;
				color: #fff;
				background-color: #4a4a4a;
				text-indent: 0;
				text-align: center;
				font-size: 13px;			
			}
			.saveCallBtnSave{
				position:relative;
				top:8px;
				background-color:transparent;
				border:0;
				cursor:pointer;
			}
			.saveCallBtnSave img{
				max-width:100px;
			}
			#textbox .timestamp {
				 color: inherit !Important; 
				border-radius: 5px;
				border-left: 0 !Important;
				border-right: 0 !important;
				padding: 0 3px;
				margin: 0 3px;
			}
			.addTime .clockPlus img{
				max-width:20px;
			}
			.addTime .clockPlus{
			font-size: 0 !important;
				padding: 3px 3px 4px 3px !important;
			}
		</style>
		<style>

		/* The Modal (background) */
		.modal {
		  display: none; /* Hidden by default */
		  position: fixed; /* Stay in place */
		  z-index: 1; /* Sit on top */
		  padding-top: 100px; /* Location of the box */
		  left: 0;
		  top: 0;
		  width: 100%; /* Full width */
		  height: 100%; /* Full height */
		  overflow: auto; /* Enable scroll if needed */
		  background-color: rgb(0,0,0); /* Fallback color */
		  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		}

		/* Modal Content */
		.modal-content {
		  position: relative;
		  background-color: #fefefe;
		  margin: auto;
		  padding: 0;
		  border: 1px solid #888;
		  width: 30%;
		  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
		  -webkit-animation-name: animatetop;
		  -webkit-animation-duration: 0.4s;
		  animation-name: animatetop;
		  animation-duration: 0.4s
		}

		/* Add Animation */
		@-webkit-keyframes animatetop {
		  from {top:-300px; opacity:0} 
		  to {top:0; opacity:1}
		}

		@keyframes animatetop {
		  from {top:-300px; opacity:0}
		  to {top:0; opacity:1}
		}

		/* The Close Button */
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

		.modal-header {
			padding: 10px 16px;
			border-bottom: 1px solid #000;
		}

		.modal-body {padding:10px 16px;}

		.modal-footer {
		  padding: 2px 16px;
		  background-color: #5cb85c;
		  color: white;
		}

		</style>
		<style>
		.signup-staff{
			padding:2rem;
			width:320px;
			margin:0 auto;
		}
		.signup-staff label{
			font-weight:bold;
			font-size:0.8rem;
		}
		.signup-staff input{
			margin:0.5rem 0 1rem 0;
			padding:0.3rem 0.5rem;
			font-size:1rem;
		}
		.signup-staff #nextStep{
			text-decoration:none;
			padding:0.5rem 2rem;
			color:#fff;
			background-color:#EB4156;
			border-radius:20px;
		}
		.alert-danger{
			color:#EB4156;
			padding-bottom:0.75rem;
		}
		.signup-staff h4{
			font-weight:bold;
			padding-bottom:1.25rem;
		}
		.transcribe-panel{
			display:none
		}
		a img{
			display:block;
			margin:2rem auto 0 auto;
		}
		.question-container{
			max-width:60%;
			margin:0 auto;
		}
		.question-container .choices{
			padding: 12px 0px;
			border-bottom: 1px solid #000;
		}
		.question-container .choices input[type=radio]:nth-child(1){
			margin-left: 15px;
		}
		.question-container .choices input[type=radio]{
			margin-left: 25px;
		}
		.btn-success {
			color: #fff;
			background-color: #28a745;
			border-radius: 20px;
			padding: 5px 10px;
			font-size: 14px;
			font-weight: bold;
			cursor: pointer;
			border: 0;
			appearance: none;
		}
		#questionContainer{
			display:none;
		}
		#infoContainer{
			max-width: 50%;
			margin: 0 auto;
		}

		</style>
</head>
<body>
	<a href="index.php">
		<img src="img/logo1.png" class="img-fluid">
	</a>
	<div class="question-container mb-4">
		
		<?php if(!empty($_GET) > 0){ ?>
			<?php if($_GET['error'] == true){ ?>
				<div class="alert alert-danger" role="alert">
				  Please answer all questions.
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
			<?php } ?>
		<?php } ?>
		<?php if(mysqli_num_rows($getQuestions) > 0){ ?>
			<form action="save_staff.php" method="post">
				<div id="infoContainer" class="bg-white px-4 py-2 mt-4">
					<h5 class="mt-4 mb-3 font-weight-bold">Please fill out your personal details.</h5>
					<label for="fullname">Full Name *</label>
					<input type="text" class="form-control mt-2 mb-3" id="fullname" name="fullname" required>
					
					<label for="email">Email Address *</label>
					<input type="text" class="form-control mt-2 mb-3" id="email" name="email" required>
					
					<label for="phone">Phone</label>
					<input type="text" class="form-control mt-2 mb-3" id="phone" name="phone" >
					
					<label for="skype">Skype</label>
					<input type="text" class="form-control mt-2" id="skype" name="skype" >
					
					<button type="button" class="btn-success pDetails px-2 my-3">TAKE EXAM</button>
				</div>
				<div id="questionContainer" class="bg-white px-4 py-2 mt-4">
					<h4 class="mt-4 mb-2 font-weight-bold">Examination: Multiple Choice</h4>
					<?php for($q = 0; $q < count($questionResult); $q++){ ?>
						<p class="questions pt-4"><span><?php echo $q + 1; ?>.</span> <?php echo $questionResult[$q]['question']; ?></p>
						<input type="hidden" name="question[]" value="<?php echo $questionResult[$q]['id']; ?>" />
						<div class="choices">
							<?php
								$id = $questionResult[$q]['id'];
								$getChoices = mysqli_query($db, "SELECT * FROM ts_question_choices WHERE question_id='$id'");
								$choicsResult = mysqli_fetch_all($getChoices, MYSQLI_ASSOC);
								
								if(mysqli_num_rows($getChoices) > 0){
									for($c = 0; $c < count($choicsResult); $c++){
										echo '<input type="radio" name="choice' . $questionResult[$q]['id'] . '" value="'.$c.'" required"> '.$choicsResult[$c]['description'].'<p></p>';
									}
								}
							?>
						</div>
					<?php } ?>
					<br/>
					<button type="submit" class="btn-success px-2 my-3">SUBMIT NOW</button>
				</div>
			</form>
		<?php } ?>
	</div>

     <script src="js/jquery.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
		  $(".pDetails").click(function(){
				if($("#fullname").val() != "" && $("#email").val() != ""){
					$("#infoContainer").hide();
					$("#questionContainer").show();
				}
		  });
		});
	</script>
</body>
</html>
