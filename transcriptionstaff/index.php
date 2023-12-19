<?php
$file = fopen('countryprice.txt','r');
$ip = $_SERVER['REMOTE_ADDR'];
$price = "";
$default = "";
$contry = "";

if(!isset($_COOKIE["tcpstaff_country_cookie"])) {
	$details = json_decode(file_get_contents("https://ipinfo.io/{$ip}/json"));
	$contry = $details->country;
	setcookie("tcpstaff_country_cookie", $contry, time() + 315360000);
}else{
	$contry = $_COOKIE["tcpstaff_country_cookie"];
}

while(! feof($file))
{
	$result = explode(",",fgets($file));
	
	if($result[0] == "Default"){
		$default = trim(preg_replace('/\s\s+/', ' ', $result[1]));
	}	
	if($contry == $result[0]){
		$price = trim(preg_replace('/\s\s+/', ' ', $result[1]));
	$price = "US$26.50";
	}
}

if($price == ""){
	$price = $default;
	$price = "US$26.50";
}
fclose($file);			
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="css/home_style.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet" />
   <title>TranscriptionStaff.com - Transcription Job, Transcription Work, Work  at Home, Closed Caption Work, Closed Caption Job</title>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1001506790"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'AW-1001506790');
</script>




  </head>
  <body class="bg-white">
	<form id="saveStaffForm" method="post" action="test_audio.php">
	<div class="transcribe-panel">
		<div class="topbar inputting">
			<div class="title">Transcribe</div>
			<div class="controls">
				<div class="button play-pause">
					<i class="fa fa-play"></i><i class="fa fa-pause"></i>
					<div class="topbar-button-shortcut" data-shortcut="playPause">esc</div>
				</div>
				<div class="button skip-backwards">
					<i class="fa fa-backward"></i>
					<div class="topbar-button-shortcut" data-shortcut="backwards">f1</div>
				</div>
				<div class="button skip-forwards">
					<i class="fa fa-forward"></i>
					<div class="topbar-button-shortcut" data-shortcut="forwards">f2</div>
				</div>
				<div class="button speed">
					<i class="fa fa-dashboard"></i> <span data-l10n-id="speed">speed</span>
					<div class="speed-box">
						<span data-shortcut="speedDown">f3</span>
						<i class="slider-origin"></i>
						<input class="speed-slider" type="range" min="0.5" max="2.0" step="0.25" value="1" />
						<span data-shortcut="speedUp">f4</span>
					</div>
				</div>
				<div id="player-hook"></div>
				<div class="button player-time"></div>
				<div class="time-selection">
					<label>
						<span data-l10n-id="jump-to-time">Jump to time:</span>
						<input type="text" value="0:00" class="mousetrap" />
					</label>
				</div>
				<div class="button reset"><i class="fa fa-refresh"></i></div>
			</div>
		</div>

		<div class="textbox-container">
			<div class="input active">
				<div class="file-input-outer">
					<div class="file-input-wrapper">
						<button class="btn-file-input"><i class="fa fa-arrow-circle-o-up"></i>Choose audio (or video) file</button>
						<input type="file" accept="audio/*, video/*" value="https://s3.amazonaws.com/1KNMSA2TVPBQPAGWBQG2-myftp-content/transpuppy/live/55535_audioonly.m4a" />
					</div>
					<button class="alt-input-button">or YouTube video</button>
					<div class="ext-input-field">
						<div class="close-ext-input"><i class="fa fa-times"></i></div>
						<label>Enter YouTube video URL:<input type="text" /></label>
						<div class="ext-input-warning"></div>
					</div>
				</div>
				<div id="lastfile"></div>
				<div id="formats">Your browser supports mp3/ogg/webm/wav audio files and mp4/ogg/webm video files. You may need to <a href="https://media.io/">convert your file</a>.</div>
			</div>

			<div class="message-panel hidden">
				<div class="close-message-panel"><i class="fa fa-times"></i></div>
				<div class="message-content"></div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="p-4 border rounded-lg mt-5 ml-5 text-white h5" style="background-color:#4a4a4a">
						Format Example:<br/><br/>
						Interviewer:  Hello
						<br/><br/>
						Interviewee: How are [inaudible] you?
						<br/><br/>
						[END]
						<br/><br/>
						Transcribe as non-verbatim.  For words you can not understand put [inaudible], be sure to google it first.
					</div>
					<h6 class="text-white ml-5 pt-3">[ESC] - Play/Pause/Resume</h6>
				</div>
				<div class="col-8">
					<textarea name="content" id="textbox1" onkeyup="adjustHeight(this)" spellcheck="false" style="height: 740px;"></textarea>
					<div class="file-input-wrapperNew">
						<div class="alert alert-danger mb-0 p-2" id="alertTextbox" role="alert">
							Your application has been rejected, we do not accept partially complete application.
						</div>
						<button id="saveCallBtnSave" type="button" class="myButton saveCallBtnSave"><img src="submit.png" /></button>
					</div>
				</div>
			</div>
			
		</div>
		<div class="player-container"></div>
	</div>
	
	<nav class="navbar fixed-top navbar-expand-lg shadow-sm navbar-light pl-4 pr-4 py-2">
		<div class="container">
			<a class="navbar-brand" href="index.php">
				<img src="img/logo1.png" class="img-fluid">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse flex-column pt-2 pb-1" id="navbarToggler">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item mx-3 active">
						<a class="nav-link pt-2 pb-1 px-0 " href="#" onclick="scrollToDiv('.main-content')">Home</a>
					</li>
					<li class="nav-item mx-3">
						<a class="nav-link pt-2 pb-1 px-0" href="#" onclick="scrollToDiv('.sub-content-3')">Our Values</a>
					</li>
					<li class="nav-item mx-3">
						<a class="nav-link pt-2 pb-1 px-0" href="#" onclick="scrollToDiv('.sub-content-3 .row')">Features</a>
					</li>
					<li class="nav-item mx-3">
						<a class="nav-link pt-2 pb-1 px-0" href="#" onclick="scrollToDiv('.sub-content-4')">FAQ</a>
					</li>
					<li class="nav-item mx-3">
						<a class="nav-link pt-2 pb-1 px-0" href="#" data-toggle="modal" data-target="#contactUsModal">Contact Us</a>
					</li>
<!--
					<li class="nav-item mx-2">
						<a class="nav-link border-0 py-1 pb-1 px-0" data-toggle="modal" data-target="#loginModal" href="#"><button class="btn btn-blue-outline">Login</button></a>
					</li>
-->
					<li class="nav-item mx-2">
						<a class="nav-link border-0 py-1 pb-1 px-0" href="#" onclick="scrollToDiv('.sub-content-2')"><button class="btn btn-blue">Apply Now</button></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	
	<section class="main-content">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-xl-8 col-lg-8 col-md-7 col-sm-7 col-xs-12 p-0 mt-2">
					
					<h1 class="p1 pl-3">Work From Home<br/>Earn Money with Transcription Jobs</h1>
					<div class="m-text-center"><a href="#" onclick="scrollToDiv('.sub-content-2')" class="btn btn-blue px-5 py-3 mt-3 ml-3"><h5 class="m-0">Apply Now</h5></a></div>
				</div>
			</div>
		</div>
	</section>
	<section class="sub-content-1">
		<div class="container">
			<h1 class="text-center"><strong>Start Making Money in 3 Easy Steps</strong></h1>
			<div class="row align-items-center justify-content-md-center connecting-line pt-4">
				<div class="col-md-4 col-sm-4 col-xs-12 mt-2">
					<div class="display-none-mobile">
						<p><img src="img/step1.png" class="bg-white img-fluid m-auto d-block"></p>
						<h5 class="text-center pt-1">Signup by completing a simple form</h5>
					</div>
					<div class="media d-none display-flex-mobile">
						<img src="img/step1.png" class="img-fluid d-block mr-3">
						<div class="media-body">
							<h5 class="pt-1">Signup by completing a simple form</h5>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 mt-2">
					<div class="display-none-mobile">
						<p><img src="img/step2.png" class="bg-white img-fluid m-auto d-block"></p>
						<h5 class="text-center pt-1">Complete a 2-minute Transcription Test</h5>
					</div>
					<div class="media d-none display-flex-mobile">
						<img src="img/step2.png" class="img-fluid d-block mr-3">
						<div class="media-body">
							<h5 class="pt-1">Complete a 2-minute Transcription Test</h5>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 mt-2">
					<div class="display-none-mobile">
						<p><img src="img/step3.png" class="bg-white img-fluid m-auto d-block"></p>
						<h5 class="text-center pt-1">If successful, your account manager will contact you for further details</h5>
					</div>
					<div class="media d-none display-flex-mobile">
						<img src="img/step3.png" class="img-fluid d-block mr-3">
						<div class="media-body">
							<h5 class="pt-1">If successful, the Account Manager will contact you for further details</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="sub-content-2">
		<div class="container">
			<div class="row align-items-center justify-content-md-center">
				<div class="col-md-5 col-sm-5 col-xs-12 mt-2">
					<div class="row align-items-center justify-content-md-center">
						<div class="col-6">
							<div class="m-3 text-center p-4 rounded-lg bg-white">
								<p><img src="img/value1.png" class="img-fluid" /></p>
								<p class="pt-2 mb-0">Work From Home</p>
							</div>
						</div>
						<div class="col-6">
							<div class="m-3 text-center p-4 rounded-lg bg-white">
								<p><img src="img/value2.png" class="img-fluid" /></p>
								<p class="pt-2 mb-0">Flexible Work Schedule</p>
							</div>
						</div>
					</div>
					<div class="row align-items-center justify-content-md-center">
						<div class="col-6">
							<div class="m-3 text-center p-4 rounded-lg bg-white">
								<p><img src="img/value3.png" class="img-fluid" /></p>
								<p class="pt-2 mb-0">Weekly PayPal Payments</p>
							</div>
						</div>
						<div class="col-6">
							<div class="m-3 text-center p-4 rounded-lg bg-white">
								<p><img src="img/value4.png" class="img-fluid" /></p>
								<?php
									echo '<p class="pt-2 mb-0">Earn up to ' . $price . '/Audio Hour</p>';
								?>
							</div>
						</div>
					</div>
					<div class="row align-items-center justify-content-md-center">
						<div class="col-6">
							<div class="m-3 text-center p-4 rounded-lg bg-white">
								<p><img src="img/value5.png" class="img-fluid" /></p>
								<p class="pt-2 mb-0">Personal Account Manager </p>
							</div>
						</div>
						<div class="col-6">
							<div class="m-3 text-center p-4 rounded-lg bg-white">
								<p><img src="img/value6.png" class="img-fluid" /></p>
								<p class="pt-2 mb-0">Choose Your Own Projects</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-12 mt-2"></div>
				<div class="col-md-6 col-sm-6 col-xs-12 mt-2 text-center">
					
						<div class="signup-staff bg-white rounded">
							<h3 class="color-blue"><strong>Apply to be Transcriptionist</strong></h3>
							<p class="pt-2">Fill out the form and take a 2-minute test. We'll reach out if you're successful. </p>
							<p class="alert-danger">Please fill out all fields.</p>
							<div class="form-group pt-2">
								<input type="text" class="form-control p-4" name="fullname" placeholder="Full Name*" required>
                                <span class="d-block text-left" style="margin-bottom: 10px;color: red;font-size: 14px" id="nameERR"></span>

							</div>
							<div class="form-group">
								<input type="text" class="form-control p-4" name="email" placeholder="Email*" required>
                                <span id="emailERR" class="d-block text-left" style="margin-bottom: 10px;color: red;font-size: 14px" ></span>
							</div>
							<div class="form-group">
								<input type="text" class="form-control p-4" name="phone" placeholder="Phone">
							</div>
							<div class="form-group">
								<input type="text" class="form-control p-4" name="skype" placeholder="Skype">
							</div>
							<!--<div class="form-group">
								<input type="text" class="form-control p-4" name="paypal" placeholder="PayPal">
							</div>-->
							<p class="pt-2 mb-0"><button type="button" class="btn btn-blue btn-block rounded-lg py-2" id="nextStep_2" >Apply</button></p>
						</div>
						

				</div>
			</div>
		</div>
	</section>
    </form>
	<section class="sub-content-3">
		<div class="container">
			<h1 class="text-center">Do you Share Our Values?</h1>
			<p class="mb-0 pt-3 text-center w-50 mx-auto">TranscriptionStaff.com is a leading BPO wholesale supplier of transcription services to the leading transcription companies worldwide. We deliver the highest quality work for our enterprise clients. If you share the same values with us, you are welcome to apply and be a part of the growing team! At TranscriptionStaff.com, quality is our ultimate priority, and we accept no compromise!</p>
			<div class="row justify-content-md-center align-items-center mt-5">
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-3">
					<div class="text-center rounded-lg border px-4 py-5 bg-white">
						<p><img src="img/feature1.png" class="img-fluid" /></p>
						<h5 class="pt-2">Work From Home</h5>
						<h6 class="pt-2 mb-0">All you need to accomplish your tasks include: A computer, Internet Connection and Headset</h6><br/><br/>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-3">
					<div class="text-center px-4 py-5 rounded-lg border bg-white">
						<p><img src="img/feature2.png" class="img-fluid" /></p>
						<h5 class="pt-2">Flexible Work Schedule</h5>
						<h6 class="pt-2 mb-0">You can work as much or as little as you want, any time you want. Just complete <b>at least 2 audio hours</b> every week to keep your account active.</h6>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-3">
					<div class="text-center rounded-lg border px-4 py-5 bg-white">
						<p><img src="img/feature3.png" class="img-fluid" /></p>
						<?php
							echo '<h5 class="pt-2">Earn up to ' . $price . '/Audio Hour</h5>';
						?>
						<h6 class="pt-2 mb-0">We pay a competitive price based on the difficulty and urgency of the audio. Earn up to 
						<?php
							echo $price . '/Audio Hour.';
						?>
						</h6><br/>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-4">
					<div class="text-center rounded-lg border px-4 py-5 bg-white">
						<p><img src="img/feature4.png" class="img-fluid" /></p>
						<h5 class="pt-2">Weekly PayPal Payments</h5>
						<h6 class="pt-2 mb-0">We offer weekly payments like clockwork with a minimum payment of <b>$3 USD</b>.</h6>
						<br/>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-4">
					<div class="text-center rounded-lg border px-4 py-5 bg-white">
						<p><img src="img/feature5.png" class="img-fluid" /></p>
						<h5 class="pt-2">Personal Account Managers</h5>
						<h6 class="pt-2 mb-0">Our account managers will support you 24/7 in real-time. You are just a click away from help!</h6>
						<br/>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-4">
					<div class="text-center rounded-lg border px-4 py-5 bg-white">
						<p><img src="img/feature6.png" class="img-fluid" /></p>
						<h5 class="pt-2">Choose Your Own Projects</h5>
						<h6 class="pt-2 mb-0">Join TranscriptionStaff.com today and choose only projects in which you are interested.</h6>
						<br/><br/>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="sub-content-4">
		<div class="container">
			<h1 class="text-center"><strong>Frequently Asked Questions</strong></h1>
			<div class="accordion pt-5" id="accordion1">
				<div class="row justify-content-md-center pt-4">
					<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="card mb-4 border bg-white rounded-lg">
								<div class="card-header border-0 rounded-lg collapsed bg-white px-4 py-4" id="head1" data-toggle="collapse" data-target="#col1" aria-expanded="false">
									<h5 class="mb-0">Where do start? <span class="pull-right h6 mb-0"><i class="fa color-blue fa-plus"></i></span></h5>
								</div>
								<div id="col1" class="collapse" aria-labelledby="head1" data-parent="#accordion1" style="">
									<div class="card-body px-4 py-1">
										<h6 class="pb-2 line-height-1-5">Click <a href="#" onclick="scrollToDiv('.sub-content-2')" class="color-blue">here</a> to apply by completing a 2-minute test and wait for a response through your e-mail.</h6>
									</div>
								</div>
							</div>
							<div class="card mb-4 border bg-white rounded-lg">
								<div class="card-header border-0 rounded-lg collapsed bg-white px-4 py-4" id="head2" data-toggle="collapse" data-target="#col2" aria-expanded="false">
									<h5 class="mb-0">Do you need the experience to become a transcriber? <span class="pull-right h6 mb-0"><i class="fa color-blue fa-plus"></i></span></h5>
								</div>
								<div id="col2" class="collapse" aria-labelledby="head2" data-parent="#accordion1" style="">
									<div class="card-body px-4 py-1">
										<h6 class="pb-2 line-height-1-5">We offer the highest pay rates to experienced transcribers with 50+ WPM typing speed. If you type slower, your payment will be lower as we pay a fixed price per job.</h6>
									</div>
								</div>
							</div>
							<div class="card mb-4 border bg-white rounded-lg">
								<div class="card-header border-0 rounded-lg collapsed bg-white px-4 py-4" id="head3" data-toggle="collapse" data-target="#col3" aria-expanded="false">
									<h5 class="mb-0">How many transcription jobs do you have? <span class="pull-right h6 mb-0"><i class="fa color-blue fa-plus"></i></span></h5>
								</div>
								<div id="col3" class="collapse" aria-labelledby="head3" data-parent="#accordion1" style="">
									<div class="card-body px-4 py-1">
										<h6 class="pb-2 line-height-1-5">We have 100-250 jobs a day.</h6>
									</div>
								</div>
							</div>
							<div class="card mb-4 border bg-white rounded-lg">
								<div class="card-header border-0 rounded-lg collapsed bg-white px-4 py-4" id="head4" data-toggle="collapse" data-target="#col4" aria-expanded="false">
									<h5 class="mb-0">How do I know when a new job becomes available? <span class="pull-right h6 mb-0"><i class="fa color-blue fa-plus"></i></span></h5>
								</div>
								<div id="col4" class="collapse" aria-labelledby="head4" data-parent="#accordion1" style="">
									<div class="card-body px-4 py-1">
										<h6 class="pb-2 line-height-1-5">You’ll receive an e-mail notification when new work is available.</h6>
									</div>
								</div>
							</div>
						
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="card mb-4 border bg-white rounded-lg">
								<div class="card-header border-0 rounded-lg collapsed bg-white px-4 py-4" id="head5" data-toggle="collapse" data-target="#col5" aria-expanded="false">
									<h5 class="mb-0">How will I get paid? <span class="pull-right h6 mb-0"><i class="fa color-blue fa-plus"></i></span></h5>
								</div>
								<div id="col5" class="collapse" aria-labelledby="head5" data-parent="#accordion1" style="">
									<div class="card-body px-4 py-1">
										<h6 class="pb-2 line-height-1-5">We make weekly payments via PayPal.</h6>
									</div>
								</div>
							</div>
							<div class="card mb-4 border bg-white rounded-lg">
								<div class="card-header border-0 rounded-lg collapsed bg-white px-4 py-4" id="head6" data-toggle="collapse" data-target="#col6" aria-expanded="false">
									<h5 class="mb-0">What happens when I fail the test? <span class="pull-right h6 mb-0"><i class="fa color-blue fa-plus"></i></span></h5>
								</div>
								<div id="col6" class="collapse" aria-labelledby="head6" data-parent="#accordion1" style="">
									<div class="card-body px-4 py-1">
										<h6 class="pb-2 line-height-1-5">We will only contact you if your application is successful.   You cannot reapply for six months.</h6>
									</div>
								</div>
							</div>
							<div class="card mb-4 border bg-white rounded-lg">
								<div class="card-header border-0 rounded-lg collapsed bg-white px-4 py-4" id="head7" data-toggle="collapse" data-target="#col7" aria-expanded="false">
									<h5 class="mb-0">What happens when I pass the test? <span class="pull-right h6 mb-0"><i class="fa color-blue fa-plus"></i></span></h5>
								</div>
								<div id="col7" class="collapse" aria-labelledby="head7" data-parent="#accordion1" style="">
									<div class="card-body px-4 py-1">
										<h6 class="pb-2 line-height-1-5">You will receive an e-mail from us to let you know how to contact your account manager to set you up.</h6>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
			<h5 class="text-center pt-4">More questions? <a href="#" class="color-blue" data-toggle="modal" data-target="#contactUsModal">Contact Us</a></h5>
			<center><a href="#" onclick="scrollToDiv('.sub-content-2')" class="text-center btn btn-blue px-5 py-3 mt-3"><h5 class="m-0">Apply Now</h5></a></center>
		</div>
	</section>
	<section class="sub-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<p class="mb-0"><a href="index.php"><img src="img/logo2.png" class="img-fluid" /></a></p>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div class="mr-5">
								<h5 class="pb-2"><strong>Company</strong></h5>
								<p><a class="" href="#" onclick="scrollToDiv('.main-content')">Home</a></p>
								<p><a class="" href="#" onclick="scrollToDiv('.sub-content-3 .row')">Features</a></p>
								<p class="mb-0"><a class="" href="#" data-toggle="modal" data-target="#contactUsModal">Contact Us</a></p>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div class="mr-5">
								<h5 class="pb-2">&nbsp;</h5>
								<p><a class="" href="#" onclick="scrollToDiv('.sub-content-3')">Our Values</a></p>
								<p><a class="" href="#" onclick="scrollToDiv('.sub-content-4')">FAQ</a></p>
							<!--	<p class="mb-0"><a class="" href="#" data-toggle="modal" data-target="#loginModal">Log in</a></p> -->
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<h5 class="pb-2"><strong>To be a Transcriptionist?</strong></h5>
							<center><a href="#" onclick="scrollToDiv('.sub-content-2')" class="text-center btn btn-blue px-5 py-3 mt-3 color-white"><h5 class="m-0">Apply Now</h5></a></center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	 <footer>
		<div class="container">
			<h6 class="pt-5 d-inline">&copy; Copyright 2021 - Premier Level Typing Services</h6>
			<!--<h6 class="pull-right d-inline">Terms & Conditions</h6>
			<h6 class="pull-right d-inline pr-5">Privacy Policy</h6>-->
		</div>
	 </footer>
	 <!-- Modal -->
	 <?php if(!empty($_GET)){ ?>
		<?php if($_GET['sent'] == "success"){ ?>
				<input type="hidden" id="emailSuccess" value="1">
			<?php }else{ ?>
				<input type="hidden" id="emailSuccess" value="0">
			<?php } ?>
	<?php }else{ ?>
				<input type="hidden" id="emailSuccess" value="0">
			<?php } ?>
	<?php if(!empty($_GET)){ ?>
		<?php if($_GET['application'] == "error"){ ?>
				<input type="hidden" id="application_error" value="1">
			<?php }else{ ?>
				<input type="hidden" id="application_error" value="0">
			<?php } ?>
	<?php }else{ ?>
				<input type="hidden" id="application_error" value="0">
	<?php } ?>
	
	<?php if(!empty($_GET)){ ?>
		<?php if($_GET['email'] == "error"){ ?>
				<input type="hidden" id="email_error" value="1">
			<?php }else{ ?>
				<input type="hidden" id="email_error" value="0">
			<?php } ?>
	<?php }else{ ?>
				<input type="hidden" id="email_error" value="0">
	<?php } ?>
	<div class="modal show" id="emailErrorModal" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-body p-4">
					<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
					<h6 class="text-center">Email is already taken.</h6>
					
				  </div>
				</div>
			  </div>
			</div>
	<div class="modal show" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-body p-4">
					<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
					<h6 class="text-center">Please fill out all required fields and the content must be greater than or equal to 800 characters.</h6>
					
				  </div>
				</div>
			  </div>
			</div>
	<div class="modal show" id="sucessModal" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-body p-4">
					<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
					<h6 class="text-center">Thank you for contacting us.  We will get back to you within a few days.</h6>
					
				  </div>
				</div>
			  </div>
			</div>
	<div class="modal fade" id="contactUsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body p-4">
			<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="text-center"><strong>Send Us a Message</strong></h4>
			

		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body p-4">
			<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="text-center"><strong>Sign In As Staff</strong></h4>
			
			<form method="post" action="https://transcriptionstaff.com/ph/index.php">
				<div class="row">
					<div class="col-12">
						<input type="text" class="form-control p-4 mt-3" name="username" placeholder="Enter your username" required="">
					</div>
					<div class="col-12">
						<input type="password" class="form-control p-4 mt-3" name="password" placeholder="Enter your password" required="">
					</div>
				</div>
				<button type="submit" class="btn btn-blue h4 mt-3 px-5 py-2">Login</button>
			</form>
		  </div>
		</div>
	  </div>
	</div>

	<script src="js/jquery.min.js" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>


     <script type="text/javascript">
         function validateEmail(email) {
             const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
             return emailRegex.test(email);
         }

         $(document).ready(function () {

             $("#nextStep_2").click(function () {
                 
                 $("#nameERR").text("");
                 $("input[name=fullname]").css('border', '2px solid  #ced4da');

                 $("#emailERR").text("");
                 $("input[name=email]").css('border', '2px solid  #ced4da');

                 if ($("input[name=fullname]").val() === "") {
                     $("#nameERR").text("Name field is required");
                     $("input[name=fullname]").css('border', '2px solid red');
                 }else if($("input[name=fullname]").val().length > 32){
                     $("#nameERR").text("Your value is too large");
                     $("input[name=fullname]").css('border', '2px solid red');
                 }else if($("input[name=email]").val() === ""){
                     $("#emailERR").text("Email field is required");
                     $("input[name=email]").css('border', '2px solid red');
                 }else if(!validateEmail($("input[name=email]").val())){
                     $("#emailERR").text("Email is not valid");
                     $("input[name=email]").css('border', '2px solid red');
                 } else {
                      $("#saveStaffForm").submit();
                 }
             });
         });

     </script>


  </body>
</html>