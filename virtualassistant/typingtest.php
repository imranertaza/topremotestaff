<?php
session_start();
//session_destroy();
//var_dump($_SESSION);
//exit();
require '../vendor/autoload.php';
require '../admin/config/url.php';
ini_set('display_errors', TRUE);
date_default_timezone_set('UTC');
require 'admin/config/database.php';
require 'admin/controller/crud.php';
require '../admin/includes/file_upload_library.php';

// Reset the error reporting level
error_reporting(E_ERROR);
//error_reporting(0);

$crud = new Crud();
$FP = new FileUpload();

//$getQuestions = mysqli_query($db, "SELECT * FROM ts_questions WHERE status='1' ORDER BY date_created DESC LIMIT 15");
$getQuestions = mysqli_query($db, "SELECT * FROM ts_virtualassistant_questions WHERE status='1' ORDER BY RAND() DESC LIMIT 20");
$questionResult = mysqli_fetch_all($getQuestions, MYSQLI_ASSOC);

$date = new DateTime();
/*
if(!isset($_SESSION['timestamp']) || empty($_SESSION['timestamp'])) {
	$_SESSION['timestamp'] = $date->getTimeStamp();
}
 */
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
    <link href="../css/typingtest.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #c80000 !important;
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

        .timerCount {
            position: fixed;
            top: 93vh;
            left: 8%;
        }
        #counter {
            display: block;
            margin-top: 5px;
            text-align: left;
        }
        .questions {
            font-size: 17px;
            font-weight: 600;
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
        /*
                .question-container .choices{
                    padding: 12px 0px 12px 10px;
                    border-bottom: 1px solid #000;
                }
                .question-container .choices input[type=radio]:nth-child(1){
                    margin-left: 15px;
                }
                .question-container .choices input[type=radio]{
                    margin-left: 25px;
                }
        */
        .question-container .choices {
            padding: 12px 0px 12px 10px;
        }
        .question-container .choices input[type="radio"]:nth-child(1) {
            margin-left: 0px;
        }
        .question-container .choices input[type="radio"] {
            margin-left: 0px;
        }
        .btn-success {
            background-color: #C80000;
            font-size: 14px;
            cursor: pointer;
            appearance: none;
            display: block;
            color: #ffffff;
            width: fit-content;
            padding: 13px 35px;
            border: 2px solid #C80000;
            border-radius: 6px;
            white-space: nowrap;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-success:hover{
            background-color: #ffffff;
            color:#C80000;
        }
        .btn-success.focus, .btn-success:focus {
            background-color: #fff !important;
            border-color: #C80000 !important;
            box-shadow: none !important;
            outline: 0;
            color: #C80000;
        }


        /*
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
        */
        #infoContainer{
            max-width: 50%;
            margin: 0 auto;
        }

    </style>
</head>
<body>

<?php
$Err = '';
if (empty($_POST["fullname"])) {
    $Err .= "Name is required<BR>";
}
if (empty($_POST["email"])) {
    $Err .= "Email is required<BR>";
} else {
    $email = $_POST["email"];
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $Err .= "Invalid email format<BR>";
    } else if($db->query($crud->getOrData('ts_virtualassistant_users', array("email"), array($email)))->num_rows > 0) {
        $Err .= "Email existed<BR>";
    }
}


if(empty($_FILES["resume"]["name"])){
    $Err .= "Uploading CV is required<BR>";
}else {
    $old_file_name = $_FILES["resume"]["name"];
    $file_name = 'resume_'.time().'.pdf';
    $outputFile = $FP->tmpPath.$file_name;
    $ext = explode(".", $old_file_name);
    $extension = strtolower($ext[1]);

    if($extension == 'pdf' || $extension == 'docx' || $extension == 'doc') {
        $file_temp_src = $_FILES["resume"]["tmp_name"];
        if(is_uploaded_file($file_temp_src)){


            // File uploading to the tmp file
            if($ext[1] == 'pdf') {
                $inputFile = $FP->tmpPath.$file_name;
                move_uploaded_file($_FILES["resume"]["tmp_name"], $FP->tmpPath . $file_name);
            }else {
                move_uploaded_file($_FILES["resume"]["tmp_name"], $FP->tmpPath . $old_file_name);

                // Converting a docx/doc file into PDF (Start)
                $inputFile = $FP->tmpPath.$old_file_name;
                $FP->convertDocToPDF($inputFile, $outputFile);
                // Converting a docx/doc file into PDF (End)
            }


            $_SESSION["file_name"] = $file_name;
            $_SESSION["inputFile"] = $inputFile;
            $_SESSION["outputFile"] = $outputFile;

        }else{
            $Err .= "File upload failed!";
        }
    }else {
        $Err .= "Sorry! Only PDF, DOCX and DOC file allowed.<BR>";
    }
}



if(empty($_FILES["audioVideo"]["name"])){
    $Err .= "Uploading Audio Video is required<BR>";
}else {
    $old_file_name = $_FILES["audioVideo"]["name"];
    $ext = explode(".", $old_file_name);
    $extension = end($ext);

    $file_name = 'audioVideo_'.time().'.'.$extension;
    $outputFile = $FP->tmpPath.$file_name;

    $extensionArray = array(
        'mp3' ,'wav','aac','flac','ogg','wma' ,'aiff','m4a','ac3','mp4','avi','mkv','wmv','mov','flv','3gp','mpeg','mpg' ,'webm','ogv','rm','asf'
    );
    if (in_array($extension, $extensionArray)){
        if ($_FILES["audioVideo"]["size"] < 52428800) {
            $file_temp_src = $_FILES["audioVideo"]["tmp_name"];
            if (is_uploaded_file($file_temp_src)) {
                move_uploaded_file($_FILES["audioVideo"]["tmp_name"], $FP->tmpPath . $file_name);
                $_SESSION["file_name_audioVideo"] = $file_name;
                $_SESSION["outputFile_audioVideo"] = $outputFile;
            } else {
                $Err .= "File upload failed!";
            }
        }else{
            $Err .= "Sorry, your file is too large!";
        }
    }else {
        $Err .= "Sorry! Only mp3, mp4 file allowed.<BR>";
    }
}


if(!empty($Err)) {
    echo $Err;
    echo '<a href="'.baseUrl.'virtualassistant/">Back</a>';
    exit;
}

?>
<div class="container mb-5 ">
    <center><a href="<?php print getBaseUrl(); ?>"><img src="img/logo.svg" class="img-fluid" style="margin-top:1rem;"></a></center>


<!--        <form action="save_staff.php" method="post">-->
            <input type="hidden" name="timestamp" value="<?php echo $timestamp; ?>">
            <?php
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["fullname"] = $_POST["fullname"];
            $_SESSION["skype"] = $_POST["skype"];
            $_SESSION["phone"] = $_POST["phone"];

//            $filled_arr = array('email','fullname','skype','phone');
//            foreach($filled_arr as $value) {
//                echo '<input type="hidden" name="'.$value.'" value="'.$_POST["$value"].'">';
//            }
            ?>
            <div class=" px-4 py-2 mt-4">

                <h4 class="mt-4 mb-2 font-weight-bold">Typing Test</h4>

                    <div class="stats">
                        <p>Time: <span id="timer">0s</span></p>
                        <p>Mistakes: <span id="mistakes">0</span></p>
                    </div>
                    <div
                            id="quote"
                            onmousedown="return false"
                            onselectstart="return false"
                    ></div>
                    <textarea
                            rows="3"
                            id="quote-input"
                            placeholder="Type here when the test starts.."
                    ></textarea>
                    <button id="start-test" onclick="startTest()">Start Test</button>
                    <button id="stop-test" onclick="displayResult()">Stop Test</button>
                    <div class="result">
                        <form action="exam.php" method="post">
                        <h3>Result</h3>
                        <div class="wrapper">
                            <p>Accuracy: <span id="accuracy"></span></p>
                            <p>Speed: <span id="wpm"></span></p>
                            <input type="hidden" name="typing_test_accuracy" id="accuracyinput">
                            <input type="hidden" name="typing_test_speed" id="wpminput">
                            <br>
                            <button type="submit" class="btn-success px-2 my-3">SUBMIT NOW</button>
                        </div>
                        </form>
                    </div>

                <br/>
            </div>
<!--        </form>-->

</div>

<script src="../admin/js/jquery.min.js"></script>
<script src="../admin/js/bootstrap.min.js"></script>
<script src="../js/scripttypingtest.js"></script>
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
