<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Transcription Staff Registration</title>
	<link rel="shortcut icon" href="#" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1" />
	<link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
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
				box-shadow: none;
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
				width: 75%;
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
			.transcribe-panel * {
    box-sizing: initial;
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
			max-width: 350px;
			margin: 0 auto;
		}
		.signup-staff label{
			font-weight:bold;
			font-size:0.8rem;
		}
		.signup-staff input{
			margin:0.5rem 0 1rem 0;
			padding:0.3rem 0.5rem;
			font-size:1rem;
			width:285px;
		}
		.signup-staff #nextStep{
			text-decoration:none;
			padding:0.5rem 2rem;
			color:#fff;
			background-color:#18AACF;
			border-radius:20px;
		}
		.alert-danger{
			display:none;
			color:#EB4156;
			padding-bottom:0.75rem;
		}
		.signup-staff h4{
			font-weight:bold;
			padding-bottom:1.25rem;
			text-align:center;
			margin-top:2rem;
		}
		.transcribe-panel{
			display:none
		}
		.signup-staff img{
			display:block;
			margin:0 auto;
		}

		</style>
</head>
<body>
        <script src="l10n.js"></script>
        <script src="jakecache.js" charset="utf-8"></script>
		<form id="saveStaffForm" method="post" action="http://transcriptionstaff.com/save_staff.php">
			<div class="signup-staff">
				
					<a href="index.php">
						<img src="img/logo1.png" class="img-fluid">
					</a>
					<h4><strong>Staff Registration Form</strong></h4>
					<p class="alert-danger">Please fill out all fields.</p>
				
					<div class="form-group">
						<label>Full Name</label><br/>
						<input type="text" name="fullname" class="form-control" placeholder="Enter your full name*" required>
					</div>
					<div class="form-group">
						<label>Email</label><br/>
						<input type="text" name="email" class="form-control" placeholder="Enter your email address*" required>
					</div>
					<div class="form-group">
						<label>Phone</label><br/>
						<input type="text" name="phone" class="form-control" placeholder="Enter your phone number">
					</div>
					<!--<div class="form-group">
						<label>Skype</label><br/>
						<input type="text" name="skype" class="form-control" placeholder="Enter your skype id" required>
					</div>
					<div class="form-group">
						<label>Paypal</label><br/>
						<input type="text" name="paypal" class="form-control" placeholder="Enter your paypal account" required>
					</div>-->
					<br/><br/>
					
					<center><p><a href="#" id="nextStep">Apply</a></p></center>
				
			</div>
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
						<input type="file" accept="audio/*, video/*" value="http://s3.amazonaws.com/1KNMSA2TVPBQPAGWBQG2-myftp-content/transpuppy/live/55535_audioonly.m4a" />
					</div>
					<button class="alt-input-button">or YouTube video</button>
					<div class="ext-input-field">
						<div class="close-ext-input"><i class="fa fa-times"></i></div>
						<label>Enter YouTube video URL:<input type="text" /></label>
						<div class="ext-input-warning"></div>
					</div>
				</div>
				<div id="lastfile"></div>
				<div id="formats">Your browser supports mp3/ogg/webm/wav audio files and mp4/ogg/webm video files. You may need to <a href="http://media.io/">convert your file</a>.</div>
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
					<textarea name="content" id="textbox1" onkeyup="adjustHeight(this)" spellcheck="false" style="height: 740px;" required></textarea>
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
	
		</form>
		<!-- The Modal -->
		<div id="myModal" class="modal">

			<!-- Modal content -->
			<div class="modal-content">
				 <div class="modal-header">
						 <span class="close">&times;</span>
						 <h2>Set "Burnt-in Timecode" start time:</h2>
				 </div>
				 <div class="modal-body">
						<label for="minAdd">Minutes</label>
					<input type="number" id="minAdd" name="minAdd" min="0" max="999" />
					<label for="secAdd">Seconds</label>
					<input type="number" id="secAdd" name="secAdd" min="0" max="59" />
					<button type="button" onclick="ts.insert();">Submit</button>
					</div>
			</div>

		</div>
        <script type="text/javascript" src="progressor.min.js"></script>
	<script type="text/javascript" src="otplayer.js"></script>
	<script src="js/jquery.min.js" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script type="text/javascript">
		var modal = document.getElementById("myModal");
		var chckModal = 0;
		var addMin = 0, addSec = 0;
			loadMedia();
			$(document).ready(function(){
				$("#nextStep").click(function(){
					if($("input[name=fullname]").val() == "" || $("input[name=email]").val() == ""){
						$(".signup-staff .alert-danger").show();
					}else{
						$(".signup-staff").hide();
						$(".navbar").hide();
						$(".transcribe-panel").show();
					}
				});
				if($("#emailSuccess").val() == 1){
					$("#sucessModal").modal("show");
				}
				
				$("#saveCallBtnSave").click(function(){
					var count = $("#textbox1").val().length;
					
					if(count < 800){
						$("#alertTextbox").show();
					}else{
						$("#saveStaffForm").submit();
					}
				});
			});
			function scrollToDiv(id) {
				 $('html, body').animate({
					scrollTop: $(id).offset().top
				}, 1000);
			}
			
			function countWords(str) {
			  return str.trim().split(/\s+/).length;
			}
			function wordInString(s, words, replacement){ 
			 return s.split(words).join(replacement);
			}
			function adjustHeight(el){
				if(el.scrollHeight > el.clientHeight){
					el.style.height = (el.scrollHeight) + "px"; 
				}
			}
			function gTime(){
				var time = oT.media.e().currentTime  
        			var minutes = Math.floor(time / 60);
        			var seconds = ("0" + Math.round( time - minutes * 60 ) ).slice(-2);
        			return minutes+":"+seconds;
			}
			function tStamp(){
				document.execCommand('insertHTML',false,
	 		 	'<span class="timestamp" contenteditable="false" lang="'+gTime()+'" >(' + gTime() + ')</span>&nbsp;'
        			);
        			$('.timestamp').each(function( index ) {
        		  	  $( this )[0].contentEditable = false;
        			});
			}
			function getExtension(filename) {
  				var parts = filename.split('.');
  				return parts[parts.length - 1];
			}
			function isVideo(filename) {
 				 var ext = getExtension(filename);
  				switch (ext.toLowerCase()) {
    					case 'm4v':
   					case 'avi':
    					case 'mpg':
    					case 'mp4':
      					return true;
  				}
  				return false;
			}	
			function loadMedia(){
				var files = ['http://161.35.224.115/transcriptionstaff/audio1.mp3','http://161.35.224.115/transcriptionstaff/audio2.mp3','http://161.35.224.115/transcriptionstaff/audio3.mp3','http://161.35.224.115/transcriptionstaff/audio4.mp3','http://161.35.224.115/transcriptionstaff/audio5.mp3'];
				var audioNum = randomIntFromInterval(0, 4);
				
				var file = files[audioNum];
				var opts = {
						source: file ,	
					 container: $('#player-hook')[0],
					 startpoint: 0,
						buttons: {
							playPause: '.play-pause'

						}
				}
				var filename = file.replace(/^.*[\\\/]/, '');

				 if (window.player) { window.player.reset(); }
				 window.player = new oTplayer(opts);
				player.pause();

				if(isVideo(filename) == true){
					 var jqProgressBar = new Progressor({
							media : $('video')[0],
							bar : $('#player-hook')[0],
							text : filename,  
							 time : $('.player-time')[0]   
					 });
					$('video').addClass('video-player');
				}else{
					var jqProgressBar = new Progressor({
							media : $('audio')[0],
							bar : $('#player-hook')[0],
							text : filename,  
							 time : $('.player-time')[0]   
					 });
				}
			}
			function randomIntFromInterval(min, max) {
			  return Math.floor(Math.random() * (max - min + 1) + min);
			}
			var ts = {
				split : function(hms){
					var a = hms.split(':');
					var seconds = (+a[0]) * 60 + (+a[1]); 
					return seconds;
				},
				setFrom : function(clickts, element){
					if (element.childNodes.length == 1) {
						player.setTime(ts.split(clickts));
					}
				},
				get : function(){
					// get timestap
					addMin = document.getElementById('minAdd').value;
					addSec = document.getElementById('secAdd').value;
					var time = player.getTime();
					var minutes = Math.floor(time / 60);
					var seconds = ("0" + Math.round( (time - minutes * 60) + Number(addSec) ) ).slice(-2);
					return (minutes + Number(addMin))+":"+seconds;
				},
				insert : function(){
					modal.style.display = "none";
					document.execCommand('insertHTML',false,
				 // '<span class="timestamp" contenteditable="false" lang="'+ts.get()+'" >(' + ts.get() + ')</span>'
					'<span>[[' + ts.get() + ']]</span>'
					);
				}
			}
			$('.skip-backwards').click(function(){
				player.skip('backwards');
			});
			 $(document).on('click', ".timestamp", function() {
				 ts.setFrom($(this).attr('lang'), this);        
			   });
			$('.skip-forwards').click(function(){
				player.skip('forwards');
			});
			$('.reset').click(function(){
					player.reset();
				 loadMedia();
			});
			$(".speed-slider").change(function() {
					player.speed(this.valueAsNumber);
			   });
			$(".collapse.show").each(function(){
				$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
			});
			
			$(".collapse").on('show.bs.collapse', function(){
				$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
			}).on('hide.bs.collapse', function(){
				$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
			});
			document.addEventListener("keydown", function(event) {
				
				if(event.which == 27){
					player.playPause();
				}
				else if(event.ctrlKey == true && event.keyCode == 74){
					event.preventDefault();
					ts.insert();
				}

				else if(event.which == 112){
					event.preventDefault();
					 player.skip('backwards');
				}
				else if(event.which == 113){
					 player.skip('forwards');	
				}
				else if(event.which == 114){
					 player.speed('down');	
				}else if(event.which == 115){
					player.speed('up');	
				}
				$(".speed-slider").val(player.getSpeed());
			});
	</script>
</body>
</html>
