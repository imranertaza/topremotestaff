<?php
require 'config/url.php';
?>

<html>
<head>
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1001506790"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'AW-1001506790');
	</script>


<!-- Event snippet for Submit lead form conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-1001506790/7zX6CI_wk98BEOaPx90D'});
</script>
<title>TranscriptionStaff.com - Registration Successful</title>
<style>
	@font-face {
		font-family: 'Product Sans Regular';
		src: url('fonts/ProductSans-Regular.woff2') format('woff2'),
			url('fonts/ProductSans-Regular.woff') format('woff');
		font-weight: normal;
		font-style: normal;
		font-display: swap;
	}


	@font-face {
		font-family: 'Product Sans Black';
		src: url('fonts/ProductSans-Black.woff2') format('woff2'),
			url('fonts/ProductSans-Black.woff') format('woff');
		font-weight: 900;
		font-style: normal;
		font-display: swap;
	}

</style>
</head>
<body>
	<center>
		<a href="<?php print getBaseUrl(); ?>index.php"><img src="img/logo1.png" style="margin-top:2rem;"></a>
		<h3 style="font-family: 'Product Sans Black';">Application Successful!</h3>
		<p style="font-family: 'Product Sans Regular';">If your application is sucessful, we will contact you in the next 30 days.<br/>Look out for an email with the subject "TranscriptionStaff Job Application Successful" in your inbox.<br/>It may go to your spam folder.<br><br><font color=red>We will NOT contact you if your application is not sucessful.</font></p>
	</center>
</body>
</html>
