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

$getQuestions = mysqli_query($db, "SELECT * FROM ts_phoneagent_questions WHERE status='1' ORDER BY RAND() DESC LIMIT 20");
$questionResult = mysqli_fetch_all($getQuestions, MYSQLI_ASSOC);

$date = new DateTime();

$timestamp = $date->getTimestamp();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Examination - Transcription Staff</title>
    <link rel="shortcut icon" href="#"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1"/>
    <link rel="stylesheet" href="../css/bootstrap.min.css" crossorigin="anonymous">
    <link href="../css/custom.css" rel="stylesheet" />
    <link href="../css/typingtest.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet"/>

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
    } else if ($db->query($crud->getOrData('ts_phoneagent_users', array("email"), array($email)))->num_rows > 0) {
        $Err .= "Email existed<BR>";
    }
}


if (empty($_FILES["resume"]["name"])) {
    $Err .= "Uploading CV is required<BR>";
} else {
    $old_file_name = $_FILES["resume"]["name"];
    $file_name = 'resume_' . time() . '.pdf';
    $outputFile = $FP->tmpPath . $file_name;
    $ext = explode(".", $old_file_name);
    $extension = strtolower($ext[1]);

    if ($extension == 'pdf' || $extension == 'docx' || $extension == 'doc') {
        $file_temp_src = $_FILES["resume"]["tmp_name"];
        if (is_uploaded_file($file_temp_src)) {


            // File uploading to the tmp file
            if ($ext[1] == 'pdf') {
                $inputFile = $FP->tmpPath . $file_name;
                move_uploaded_file($_FILES["resume"]["tmp_name"], $FP->tmpPath . $file_name);
            } else {
                move_uploaded_file($_FILES["resume"]["tmp_name"], $FP->tmpPath . $old_file_name);

                // Converting a docx/doc file into PDF (Start)
                $inputFile = $FP->tmpPath . $old_file_name;
                $FP->convertDocToPDF($inputFile, $outputFile);
                // Converting a docx/doc file into PDF (End)
            }


            $_SESSION["file_name"] = $file_name;
            $_SESSION["inputFile"] = $inputFile;
            $_SESSION["outputFile"] = $outputFile;

        } else {
            $Err .= "File upload failed!";
        }
    } else {
        $Err .= "Sorry! Only PDF, DOCX and DOC file allowed.<BR>";
    }
}


if (empty($_FILES["audioVideo"]["name"])) {
    $Err .= "Uploading Audio Video is required<BR>";
} else {
    $old_file_name = $_FILES["audioVideo"]["name"];
    $ext = explode(".", $old_file_name);
    $extension = end($ext);

    $file_name = 'audioVideo_' . time() . '.' . $extension;
    $outputFile = $FP->tmpPath . $file_name;

    $extensionArray = array(
        'mp3', 'wav', 'aac', 'flac', 'ogg', 'wma', 'aiff', 'm4a', 'ac3', 'mp4', 'avi', 'mkv', 'wmv', 'mov', 'flv', '3gp', 'mpeg', 'mpg', 'webm', 'ogv', 'rm', 'asf'
    );
    if (in_array($extension, $extensionArray)) {
        if ($_FILES["audioVideo"]["size"] < 52428800) {
            $file_temp_src = $_FILES["audioVideo"]["tmp_name"];
            if (is_uploaded_file($file_temp_src)) {
                move_uploaded_file($_FILES["audioVideo"]["tmp_name"], $FP->tmpPath . $file_name);
                $_SESSION["file_name_audioVideo"] = $file_name;
                $_SESSION["outputFile_audioVideo"] = $outputFile;
            } else {
                $Err .= "File upload failed!";
            }
        } else {
            $Err .= "Sorry, your file is too large!";
        }
    } else {
        $Err .= "Sorry! Only mp3, mp4 file allowed.<BR>";
    }
}


if (!empty($Err)) {
    echo $Err;
    echo '<a href="' . getBaseUrl().'">Back</a>';
    exit;
}

?>
<div class="container mb-5 ">
    <center><a href="<?php print getBaseUrl(); ?>"><img src="../img/logo.svg" class="img-fluid" style="margin-top:1rem;"></a></center>
    <input type="hidden" name="timestamp" value="<?php echo $timestamp; ?>">
    <?php
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["fullname"] = $_POST["fullname"];
    $_SESSION["skype"] = $_POST["skype"];
    $_SESSION["phone"] = $_POST["phone"];
    ?>
    <div class=" px-4 py-2 mt-4">

        <h4 class="mt-4 mb-2 font-weight-bold">Typing Test</h4>

        <div class="stats">
            <p>Time: <span id="timer">0s</span></p>
            <p>Mistakes: <span id="mistakes">0</span></p>
        </div>
        <div id="quote" onmousedown="return false" onselectstart="return false"></div>
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

</div>

<script src="../admin/js/jquery.min.js"></script>
<script src="../admin/js/bootstrap.min.js"></script>
<script src="../js/scripttypingtest.js"></script>
<script>
    $(document).ready(function () {
        var countDownDate = new Date("<?php echo date("M j, Y G:i:s", ($timestamp + 1200)); ?>").getTime();
        var x = setInterval(function () {
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

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'AW-1001506790');
</script>

</body>
</html>
