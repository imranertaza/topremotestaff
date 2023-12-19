<?php
	require 'config/database.php';
	require 'controller/crud.php';	
	require 'config/url.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
	 
    <link rel="stylesheet" href="css/index.css" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet" />
   <title>OnboardQuiz</title>

  </head>
  <body>
	<section class="pt-3 pb-4">
		<div class="container">
		<form id="checkAnswerForm" method="post">
			<div class="row align-items-center justify-content-md-center">
				<div class="col-md-7 col-sm-8 col-xs-12 mt-2">
					<div class="border rounded bg-white px-4 pb-2 pt-3">
						<h2>Refresher</h2>
						<hr class="my-3"/>
						<!--<div class="form-group row">
							<label for="email" class="col-sm-1 col-form-label py-0">Email</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email" name="email" placeholder="Your email address" required style="height: 28px;">
							</div>
						</div>-->
						<p class="mb-0 text-danger">* Required</p>
					</div>
				</div>
				
				<?php
					$crud = new Crud();
					$allquestions = array();

						$getQuestions = mysqli_query($db, "SELECT * FROM list_of_questions WHERE status='1' ORDER BY date_created ASC");
						$questionsResult = mysqli_fetch_all($getQuestions, MYSQLI_ASSOC);
							
							if(mysqli_num_rows($getQuestions) > 0){ 
								for($q = 0; $q < count($questionsResult); $q++){ 
								
									if($questionsResult[$q]['withchoices'] == 0){
									
				?>
											<div class="col-md-7 col-sm-8 col-xs-12 mt-2">
												<div class="border rounded bg-white px-4 pb-2 pt-3">
													<div class="form-group">
														<label for="nochoices<?php echo $questionsResult[$q]['id']; ?>"><?php echo $questionsResult[$q]['question']; ?> <?php echo ($questionsResult[$q]['required'] == 1)? '<span class="text-danger">*</span>':''; ?></label>
														<input type="text" placeholder="Your answer" id="nochoices<?php echo $questionsResult[$q]['id']; ?>" name="nochoices<?php echo $questionsResult[$q]['id']; ?>" class="form-control pl-0 rounded-0 border-top-0 border-left-0 border-right-0" required>
													</div>
												</div>
											</div>
								<?php
									}else{
								?>
										<div class="col-md-7 col-sm-8 col-xs-12 mt-2">
											<div class="border rounded bg-white px-4 pb-2 pt-3">
												<div class="form-group">
													<label for="question2" class="w-100">
														<?php echo ($questionsResult[$q]['points'] > 0)? '<small class="pull-right text-secondary">'.$questionsResult[$q]['points'].' point/s</small>':''; ?>
														<span class="w-90 d-inline-block">
															<?php echo $questionsResult[$q]['question']; ?> <?php echo ($questionsResult[$q]['required'] == 1)? '<span class="text-danger">*</span>':''; ?>
														</span>
													</label>
													
												<?php
													$id = $questionsResult[$q]['id'];
													$getChoices = mysqli_query($db, "SELECT * FROM list_of_choices WHERE question_id='$id'");
													$choicsResult = mysqli_fetch_all($getChoices, MYSQLI_ASSOC);
													$choices = array();
															
													if(mysqli_num_rows($getChoices) > 0){
														for($c = 0; $c < count($choicsResult); $c++){
												?>
															<div class="form-check">
																<input class="form-check-input" type="radio" value="<?php echo $choicsResult[$c]['description']; ?>" name="question<?php echo $questionsResult[$q]['id']; ?>" id="question<?php echo $questionsResult[$q]['id']; ?>-<?php echo $choicsResult[$c]['id']; ?>" required>
																<label class="form-check-label pl-2" for="question<?php echo $questionsResult[$q]['id']; ?>-<?php echo $choicsResult[$c]['id']; ?>">
																	<?php echo $choicsResult[$c]['description']; ?>
																</label>
															</div>	
												
												<?php													
														}
													}
									
												?>
												</div>
												<div id="ques<?php echo $id; ?>"></div>
												<div id="comment<?php echo $id; ?>"></div>
											</div>
										</div>
						<?php		
									}
								}		
							}		
						?>
				<div class="col-md-7 col-sm-8 col-xs-12 mt-3">
					<!--<div class="border rounded bg-white px-4 pb-2 pt-3">
						<div class="form-group">
							<label for="comments">Comment</label>
							<textarea placeholder="Your answer" id="comments" name="comments" class="form-control pl-0 rounded-0 border-top-0 border-left-0 border-right-0"></textarea>
						</div>
					</div>-->
					<button class="btn btn-info px-4">Submit</button>
				</div>
			</div>
		</form>
		</div>
	</section>
	
	<script src="js/jquery.min.js" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
	    <script>
        $(document).ready(function() {
	
			$("#checkAnswerForm").submit(function(e){
				e.preventDefault();
				var fullname = $("#full_name").val();
				var email = $("#email").val();

					 $.ajax({
						type: "POST",
						dataType: "json",
						url: "checkanswer.php",
						data: $(this).serialize(),
						success: function (data) {
						//	console.log(data);
							var res = data.result;
							var score = data.score;
							
							for(var x=0;x<res.length;x++){
								if(res[x][1] == 1){
									$("#ques"+res[x][0]).html('<small class="text-success"><b>Correct!</b></small>');
								}else{
									$("#ques"+res[x][0]).html('<small class="text-danger"><b>Correct answer:<br>'+res[x][2]+'</b></small>');
									$("#comment"+res[x][0]).html('<small class="text-dark">Comment: '+res[x][3]+'</small>');
								}
							}
							
							if(score == 0){
								alert("Please review the correct answers.   You may proceed to account creation after getting the test 100% correct.");
							}else{
								window.location.href = "http://login.transcriptionstaff.com/createaccounts/";
							}
						}
					 });
					
			});
        });
     </script>
  </body>
</html>
