<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Sign In - Transcription Staff</title>
		<link rel="shortcut icon" href="#" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1" />
		<link rel="stylesheet" href="../css/bootstrap.min.css" crossorigin="anonymous">
        <link href="../css/login.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />


</head>
<body>
		<a href="index.php">
			<img src="../img/logo1.png" class="img-fluid">
		</a>
		<form method="post" action="login_staff.php">
			
			<div class="signup-staff">
				<center><h4><strong>Staff Login</strong></h4></center>
				<?php if(!empty($_GET)){ ?>
					<?php if($_GET['status'] == 0){ ?>
						<p class="alert-danger" style="font-size:14px;">Password does not match.</p>
					<?php } ?>
				<?php } ?>
				<div class="form-group">
					<label>Password</label><br/>
					<input type="password" class="form-control" name="password" placeholder="Enter the password" required>
				</div>
				
				<center><button type="submit" class="btn-danger" style="font-size:1rem;background-color:#18AACF;padding: 0.5rem 2rem;">SIGN IN</button></center>
			</div>
		</form>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet" />

</body>
</html>
