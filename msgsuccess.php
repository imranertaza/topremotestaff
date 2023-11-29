<?php
if($_REQUEST['sent'] != 'success') {
	echo 'Restricted';
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>TopRemoteStaff</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=0, shrink-to-fit=no">
        <base href="">
        <meta property="og:title" content="TopRemoteStaff">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:site_name" content="TopRemoteStaff">
        <meta property="og:image" content="./img/iconx.png">
        <link rel="shortcut icon" href="./img/iconx.png" type="image/x-icon">
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <header class="header home" id="home">
                <div class="container">
                    <div class="header__body">
                        <a class="header__logo" href="/">
                            <img class="header__logo-img" src="./img/logo.svg" loading="lazy" decoding="async" srcset="./img/logo.svg" title="TopRemoteStaff" alt="TopRemoteStaff" width="184" height="35" >
                        </a>
                        <nav class="header__menu menu">
                            <ul class="menu__list">
                                <li class="menu__item"><a class="menu__link menu__link--active menu__nav" data-nav="home" href="#home">Home</a></li>
                                <li class="menu__item"><a class="menu__link menu__nav" data-nav="jobs_we_offer" href="#jobs_we_offer">Jobs We Offer</a></li>
                                <li class="menu__item"><a class="menu__link menu__nav" data-nav="our_values" href="#our_values">Our Values</a></li>
                                <li class="menu__item"><a class="menu__link menu__nav" data-nav="faq" href="#faq">FAQ</a></li>
                                <li class="menu__item"><a class="menu__link contact-us" href="#">Contact Us</a></li>
                            </ul>
                        </nav>
                        <div class="header__button button">
                            <a class="button__btn button__btn--header menu__nav" data-nav="jobs_we_offer" href="#jobs_we_offer">Apply Now</a>
                        </div>
                        <div class="header__burger"><span></span></div>
                    </div>
                </div>
            </header>
            <main class="main">
                <section class="section section-work">
                    <div class="container">
                        <div class="section-work__body">
                            <div class="section-work__content">
                                <h1 class="section__h1">Message sent successfully.</h1>
                                <p class="section__text"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></p>
                            </div>
                        </div>
                    </div>
                </section>
	    </main>
	</div>
    </body>
</html>
