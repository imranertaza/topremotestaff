<?php
session_start();

require '../vendor/autoload.php';
require '../admin/config/url.php';
ini_set('display_errors', TRUE);
date_default_timezone_set('UTC');
require '../admin/config/database.php';
require '../admin/controller/crud.php';
require '../admin/includes/file_upload_library.php';

// Reset the error reporting level
error_reporting(E_ERROR);
//error_reporting(0);

$crud = new Crud();
$FP = new FileUpload();


$getQuestions = mysqli_query($db, "SELECT * FROM ts_livechat_questions WHERE status='1' ORDER BY RAND() DESC LIMIT 20");
$questionResult = mysqli_fetch_all($getQuestions, MYSQLI_ASSOC);

$date = new DateTime();

$timestamp = $date->getTimestamp();
?>
<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Examination - Transcription Staff</title>
		<link rel="shortcut icon" href="#" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1" />
		<link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
        <link href="css/exam_style.css" rel="stylesheet" />
        <link href="css/custom.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet" />

</head>
<body>
<center><a href="<?php print getBaseUrl(); ?>"><img src="img/logo.svg" class="img-fluid" style="margin-top:2rem;"></a></center>


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

		<?php
        $_SESSION["typing_test_accuracy"] = $_POST['typing_test_accuracy'];
        $_SESSION["typing_test_speed"] = $_POST['typing_test_speed'];

        if(mysqli_num_rows($getQuestions) > 0){ ?>
			<form action="save_staff.php" method="post">
				<input type="hidden" name="timestamp" value="<?php echo $timestamp; ?>">
				<input type="hidden" name="typing_test_accuracy" value="<?php echo $_POST['typing_test_accuracy']; ?>">
				<input type="hidden" name="typing_test_speed" value="<?php echo $_POST['typing_test_speed']; ?>">

				<div id="questionContainer" class="bg-white px-4 py-2 mt-4">
					
						<h4 class="mt-4 mb-2 font-weight-bold">Quiz: Multiple Choice (Time allowed: 20 minutes
						<span class="timerCount">Time Left: <b id="counter" style='color: black;'></b></span> )					
						</h4>
					<?php for($q = 0; $q < count($questionResult); $q++){ ?>
						<p class="questions pt-4"><span><?php echo $q + 1; ?>.</span> <?php echo $questionResult[$q]['question']; ?></p>
						<input type="hidden" name="question[]" value="<?php echo $questionResult[$q]['id']; ?>" />
						<div class="choices">
							<?php
								$id = $questionResult[$q]['id'];
								$getChoices = mysqli_query($db, "SELECT * FROM ts_livechat_question_choices WHERE question_id='$id'");
								$choicsResult = mysqli_fetch_all($getChoices, MYSQLI_ASSOC);
								
								if(mysqli_num_rows($getChoices) > 0){
									for($c = 0; $c < count($choicsResult); $c++){
										echo '<input type="radio"  name="choice' . $questionResult[$q]['id'] . '" value="'.$c.'" required"> '.$choicsResult[$c]['description'].'<br><br>';
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

     <script src="../admin/js/jquery.min.js"></script>
     <script src="../admin/js/bootstrap.min.js"></script>
	<script>
  		$(document).ready(function(){
			var countDownDate = new Date("<?php echo date("M j, Y G:i:s" , ($timestamp + 1200)); ?>").getTime();
			var x = setInterval(function() {
				var usaTime = new Date().toLocaleString("en-US", {timeZone: "<?php echo date_default_timezone_get(); ?>"});
	        		var now = new Date(usaTime).getTime();
				var distance = countDownDate - now;
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				document.getElementById("counter").innerHTML = minutes + ":" + seconds;
				if (distance <= 0) {
       	         			clearInterval(x);
					document.getElementById("counter").innerHTML = "Expired";
					window.location.href = "index.html";
        			}
			}, 1000);
		});
	</script>

<!-- Global site tag (gtag.js) - Google Ads: 1001506790 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1001506790"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-1001506790');
</script>

</body>
</html>
