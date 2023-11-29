
<?php

require '../admin/config/database.php';
require '../admin/controller/crud.php';

$crud = new Crud();

$audio = $db->query($crud->getAll('ts_test'));
$result = mysqli_fetch_all($audio, MYSQLI_ASSOC);

if (isset($_SERVER['HTTP_CLIENT_IP'])){
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}else {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
}
setcookie("ts_ip", $ip, time() + (86400 * 30),'/');

$ipLast =  isset($_COOKIE["ts_ip"]) ? $_COOKIE["ts_ip"] : "";
//
//print $code;
//
//die();
?>





<html lang="en">
<head>
    <title>TopRemoteStaff</title>
    <meta charset="UTF-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=0, shrink-to-fit=no">
    <base href="">
    <meta property="og:title" content="TopRemoteStaff">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="TopRemoteStaff">
    <meta property="og:image" content="./img/iconx.png">
    <link rel="shortcut icon" href="./img/iconx.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css">


    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet"/>


</head>
<body>

<form id="saveStaffForm" method="post" action="save_staff.php">

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
                        <input class="speed-slider" type="range" min="0.5" max="2.0" step="0.25" value="1"/>
                        <span data-shortcut="speedUp">f4</span>
                    </div>
                </div>
                <div id="player-hook"></div>
                <div class="button player-time"></div>
                <div class="time-selection">
                    <label>
                        <span data-l10n-id="jump-to-time">Jump to time:</span>
                        <input type="text" value="0:00" class="mousetrap"/>
                    </label>
                </div>
                <div class="button reset"><i class="fa fa-refresh"></i></div>
            </div>
        </div>

        <div class="textbox-container">
            <div class="input active">
                <div class="file-input-outer">
                    <div class="file-input-wrapper">
                        <button class="btn-file-input"><i class="fa fa-arrow-circle-o-up"></i>Choose audio (or video)
                            file
                        </button>
                        <input type="file" accept="audio/*, video/*"
                               value="https://s3.amazonaws.com/1KNMSA2TVPBQPAGWBQG2-myftp-content/transpuppy/live/55535_audioonly.m4a"/>
                    </div>
                    <button class="alt-input-button">or YouTube video</button>
                    <div class="ext-input-field">
                        <div class="close-ext-input"><i class="fa fa-times"></i></div>
                        <label>Enter YouTube video URL:<input type="text"/></label>
                        <div class="ext-input-warning"></div>
                    </div>
                </div>
                <div id="lastfile"></div>
                <div id="formats">Your browser supports mp3/ogg/webm/wav audio files and mp4/ogg/webm video files. You
                    may need to <a href="https://media.io/">convert your file</a>.
                </div>
            </div>

            <div class="message-panel hidden">
                <div class="close-message-panel"><i class="fa fa-times"></i></div>
                <div class="message-content"></div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="p-4 border rounded-lg mt-5 ml-5 text-white h5" style="background-color:#4a4a4a">
                        Format Example:<br/><br/>
                        Interviewer: Hello
                        <br/><br/>
                        Interviewee: How are [inaudible] you?
                        <br/><br/>
                        [END]
                        <br/><br/>
                        Transcribe as non-verbatim. For words you can not understand put [inaudible], be sure to google
                        it first.
                    </div>
                    <h6 class="text-white ml-5 pt-3">[ESC] - Play/Pause/Resume</h6>
                </div>
                <div class="col-8">
                    <textarea name="content" id="textbox1" onkeyup="adjustHeight(this)" spellcheck="false"
                              style="height: 740px;"></textarea>
                    <div class="file-input-wrapperNew">
                        <div class="alert alert-danger mb-0 p-2" id="alertTextbox" role="alert">
                            Your application has been rejected, we do not accept partially complete application.
                        </div>
                        <button id="saveCallBtnSave" type="button" class="myButton saveCallBtnSave"><img
                                src="submit.png"/></button>
                    </div>

                    <input type="hidden" class="modal__input" name="fullname" value="<?php echo $_POST['fullname'];?>" >
                    <input type="hidden" class="modal__input" name="email" value="<?php echo $_POST['email'];?>" >
                    <input type="hidden" class="modal__input" name="phone" value="<?php echo $_POST['phone'];?>" >
                    <input type="hidden" class="modal__input" name="skype" value="<?php echo $_POST['skype'];?>" >
                </div>
            </div>

        </div>
        <div class="player-container"></div>
    </div>



</form>

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
    $(document).ready(function () {
       

        $(".transcribe-panel").show();

        loadMedia();
        $("#saveCallBtnSave").click(function () {
            var count = $("#textbox1").val().length;

            if (count < 800) {
                $("#alertTextbox").show();
            } else {
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

    function wordInString(s, words, replacement) {
        return s.split(words).join(replacement);
    }

    function gTime() {
        var time = oT.media.e().currentTime
        var minutes = Math.floor(time / 60);
        var seconds = ("0" + Math.round(time - minutes * 60)).slice(-2);
        return minutes + ":" + seconds;
    }

    function tStamp() {
        document.execCommand('insertHTML', false,
            '<span class="timestamp" contenteditable="false" lang="' + gTime() + '" >(' + gTime() + ')</span>&nbsp;'
        );
        $('.timestamp').each(function (index) {
            $(this)[0].contentEditable = false;
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

    function loadMedia() {
        // var files = ['https://transcriptionstaff.com/audio1.mp3', 'https://transcriptionstaff.com/audio2.mp3', 'https://transcriptionstaff.com/audio3.mp3', 'https://transcriptionstaff.com/audio4.mp3', 'https://transcriptionstaff.com/audio5.mp3'];
        var files = [<?php foreach ($result as $val){ print "'".$val['audio_link']."',"; }?>];
        var audioNum = randomIntFromInterval(0, <?php print $audio->num_rows;?>);

        var file = files[audioNum];


        // Setting cookies for the audio file for a specific user (Start)
        var lifeTime = new Date();
        lifeTime.setTime(lifeTime.getTime() + (90*24*60*60*1000));
        var aUrl = getCookie('audioURL');
        if (aUrl) {
            file = aUrl;
        }else {
            document.cookie = "audioURL="+file+";expires="+lifeTime.toGMTString()+";path=/";
        }
        // Setting cookies for the audio file for a specific user (End)

        
        var opts = {
            source: file,
            container: $('#player-hook')[0],
            startpoint: 0,
            buttons: {
                playPause: '.play-pause'

            }
        }
        var filename = file.replace(/^.*[\\\/]/, '');

        if (window.player) {
            window.player.reset();
        }
        window.player = new oTplayer(opts);
        player.pause();

        if (isVideo(filename) == true) {
            var jqProgressBar = new Progressor({
                media: $('video')[0],
                bar: $('#player-hook')[0],
                text: filename,
                time: $('.player-time')[0]
            });
            $('video').addClass('video-player');
        } else {
            var jqProgressBar = new Progressor({
                media: $('audio')[0],
                bar: $('#player-hook')[0],
                text: filename,
                time: $('.player-time')[0]
            });
        }
    }

    function getCookie(cookieName) {
        let cookies = document.cookie;
        let cookieArray = cookies.split("; ");

        for (let i = 0; i < cookieArray.length; i++) {
            let cookie = cookieArray[i];
            let [name, value] = cookie.split("=");

            if (name === cookieName) {
                return decodeURIComponent(value);
            }
        }

        return null;
    }

    function randomIntFromInterval(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    var ts = {
        split: function (hms) {
            var a = hms.split(':');
            var seconds = (+a[0]) * 60 + (+a[1]);
            return seconds;
        },
        setFrom: function (clickts, element) {
            if (element.childNodes.length == 1) {
                player.setTime(ts.split(clickts));
            }
        },
        get: function () {
            // get timestap
            addMin = document.getElementById('minAdd').value;
            addSec = document.getElementById('secAdd').value;
            var time = player.getTime();
            var minutes = Math.floor(time / 60);
            var seconds = ("0" + Math.round((time - minutes * 60) + Number(addSec))).slice(-2);
            return (minutes + Number(addMin)) + ":" + seconds;
        },
        insert: function () {
            modal.style.display = "none";
            document.execCommand('insertHTML', false,
                // '<span class="timestamp" contenteditable="false" lang="'+ts.get()+'" >(' + ts.get() + ')</span>'
                '<span>[[' + ts.get() + ']]</span>'
            );
        }
    }
    $('.skip-backwards').click(function () {
        player.skip('backwards');
    });
    $(document).on('click', ".timestamp", function () {
        ts.setFrom($(this).attr('lang'), this);
    });
    $('.skip-forwards').click(function () {
        player.skip('forwards');
    });
    $('.reset').click(function () {
        player.reset();
        loadMedia();
    });
    $(".speed-slider").change(function () {
        player.speed(this.valueAsNumber);
    });
    $(".collapse.show").each(function () {
        $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
    });

    $(".collapse").on('show.bs.collapse', function () {
        $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
    }).on('hide.bs.collapse', function () {
        $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
    });
    document.addEventListener("keydown", function (event) {

        if (event.which == 27) {
            player.playPause();
        } else if (event.ctrlKey == true && event.keyCode == 74) {
            event.preventDefault();
            ts.insert();
        } else if (event.which == 112) {
            event.preventDefault();
            player.skip('backwards');
        } else if (event.which == 113) {
            player.skip('forwards');
        } else if (event.which == 114) {
            player.speed('down');
        } else if (event.which == 115) {
            player.speed('up');
        }
        $(".speed-slider").val(player.getSpeed());
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