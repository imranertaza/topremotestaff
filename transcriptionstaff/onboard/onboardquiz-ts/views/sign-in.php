<?php 
	require 'config/url.php'; 
	
	if(count($_SESSION) > 0){
		if(isset($_SESSION["admin_loggedin"])){
			if($_SESSION["admin_loggedin"] == TRUE){
			header('Location: manage-task.php');
			}
		}
	}
	
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/owl.carousel.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/owl.theme.default.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css" crossorigin="anonymous">
    <title>Sign In</title>
  </head>
  <body class="bg-white">
	
	<section class="sign-in">
		<div class="container">
			<p class="text-center"><a href="home.php"><img src="img/logo.png" class="img-fluid" /></a></p>
			<div class="row justify-content-md-center align-items-center mt-4">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<h3 class="pt-4 text-center"><strong>Sign In</strong></h3>
					<?php if($alert == 1){ ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Error!</strong> <?php echo $alert_info; ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php }?>
					<form class="pt-4" action="<?php echo getBaseUrl(); ?>sign-in.php" method="post">
						<div class="row justify-content-md-center align-items-center">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label><strong>Email Address</strong></label>
									<input type="email" name="email" class="form-control border-bottom border-top-0 border-right-0 border-left-0 rounded-0 px-0" placeholder="Enter your email" required>
								</div>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
								<div class="form-group">
									<label><strong>Password</strong></label>
									<input type="password" name="password" class="form-control border-bottom border-top-0 border-right-0 border-left-0 rounded-0 px-0" placeholder="Enter your password" required>
								</div>
								<a href="forgot-password.php" class="text-right color-gray-1 d-block"><u>Forgot Password?</u></a>
								<div class="mt-4"><button class="btn btn-red py-2 px-5 d-block h6 w-100" type="submit">SIGN IN</button></div>
								<p class="text-center pt-4">Don’t have an account? <a href="sign-up.php" class="color-red">Sign Up</a></p>
							</div>
						</div>
					</form>
				</div>
			</div>
	</section>
	
	<script src="js/jquery.min.js" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="js/owl.carousel.min.js" crossorigin="anonymous"></script>
    <script>
            $(document).ready(function() {
              
            });
     </script>

  </body>
</html>