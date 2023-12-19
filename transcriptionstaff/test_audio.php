
<?php

require 'email.php';
require 'config/database.php';
require 'controller/crud.php';

$email = new EmailSender();
$crud = new Crud();


$audio = mysqli_query($db, "SELECT * FROM ts_test ORDER BY RAND() LIMIT 0,5");
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


?>





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
    <meta property="og:image" content="img/iconx.png">
    <link rel="shortcut icon" href="img/iconx.png" type="image/x-icon">


    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <link href="css/style_audio.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet"/>


</head>
<body style="overflow-x: hidden">

<form id="saveStaffForm" method="post" action="save_staff.php">

    <div class="transcribe-panel">
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
                <div class="col-8 pt-5">
                    <!--question wrapper start-->
                    <div class="question-wrapper mb-5">
                        <div class="topbar inputting position-relative">
                            <div class="title">Transcribe</div>
                            <div class="controls">
                                <div class="button play-pause play-pause-0">
                                    <i class="fa fa-play"></i><i class="fa fa-pause"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="playPause">esc</div>
                                </div>
                                <div class="button skip-backwards-0">
                                    <i class="fa fa-backward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="backwards">f1</div>
                                </div>
                                <div class="button skip-forwards-0">
                                    <i class="fa fa-forward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="forwards">f2</div>
                                </div>
                                <div class="button speed">
                                    <i class="fa fa-dashboard"></i> <span data-l10n-id="speed">speed</span>
                                    <div class="speed-box">
                                        <span data-shortcut="speedDown">f3</span>
                                        <i class="slider-origin"></i>
                                        <input class="speed-slider-0" type="range" min="0.5" max="2.0" step="0.25" value="1"/>
                                        <span data-shortcut="speedUp">f4</span>
                                    </div>
                                </div>
                                <div id="player-hook-0"></div>
                                <div class="button player-time"></div>
                                <div class="time-selection">
                                    <label>
                                        <span data-l10n-id="jump-to-time">Jump to time:</span>
                                        <input type="text" value="0:00" class="mousetrap"/>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <textarea class="textbox-decoration" name="video_content_1" id="textbox-0" spellcheck="false"
                                  style="height: 340px;"></textarea>

                        <input type="hidden" name="video_id_1" id="video_id_0" >
                    </div>
                    <!--question wrapper end-->

                    <!--question wrapper start-->
                    <div class="question-wrapper mb-5">
                        <div class="topbar inputting position-relative">
                            <div class="title">Transcribe</div>
                            <div class="controls">
                                <div class="button play-pause play-pause-1">
                                    <i class="fa fa-play"></i><i class="fa fa-pause"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="playPause">esc</div>
                                </div>
                                <div class="button skip-backwards-1">
                                    <i class="fa fa-backward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="backwards">f1</div>
                                </div>
                                <div class="button skip-forwards-1">
                                    <i class="fa fa-forward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="forwards">f2</div>
                                </div>
                                <div class="button speed">
                                    <i class="fa fa-dashboard"></i> <span data-l10n-id="speed">speed</span>
                                    <div class="speed-box">
                                        <span data-shortcut="speedDown">f3</span>
                                        <i class="slider-origin"></i>
                                        <input class="speed-slider-1" type="range" min="0.5" max="2.0" step="0.25" value="1"/>
                                        <span data-shortcut="speedUp">f4</span>
                                    </div>
                                </div>
                                <div id="player-hook-1"></div>
                                <div class="button player-time"></div>
                                <div class="time-selection">
                                    <label>
                                        <span data-l10n-id="jump-to-time">Jump to time:</span>
                                        <input type="text" value="0:00" class="mousetrap"/>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <textarea class="textbox-decoration " name="video_content_2" id="textbox-1" spellcheck="false"
                                  style="height: 340px;"></textarea>
                        <input type="hidden" name="video_id_2" id="video_id_1" >
                    </div>
                    <!--question wrapper end-->

                    <!--question wrapper start-->
                    <div class="question-wrapper mb-5">
                        <div class="topbar inputting position-relative">
                            <div class="title">Transcribe</div>
                            <div class="controls">
                                <div class="button play-pause play-pause-2">
                                    <i class="fa fa-play"></i><i class="fa fa-pause"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="playPause">esc</div>
                                </div>
                                <div class="button skip-backwards-2">
                                    <i class="fa fa-backward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="backwards">f1</div>
                                </div>
                                <div class="button skip-forwards-2">
                                    <i class="fa fa-forward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="forwards">f2</div>
                                </div>
                                <div class="button speed">
                                    <i class="fa fa-dashboard"></i> <span data-l10n-id="speed">speed</span>
                                    <div class="speed-box">
                                        <span data-shortcut="speedDown">f3</span>
                                        <i class="slider-origin"></i>
                                        <input class="speed-slider-2" type="range" min="0.5" max="2.0" step="0.25" value="1"/>
                                        <span data-shortcut="speedUp">f4</span>
                                    </div>
                                </div>
                                <div id="player-hook-2"></div>
                                <div class="button player-time"></div>
                                <div class="time-selection">
                                    <label>
                                        <span data-l10n-id="jump-to-time">Jump to time:</span>
                                        <input type="text" value="0:00" class="mousetrap"/>
                                    </label>
                                </div>
                                <!--                <div class="button reset"><i class="fa fa-refresh"></i></div>-->
                            </div>
                        </div>
                        <!--                    <textarea name="content" id="textbox1" onkeyup="adjustHeight(this)" spellcheck="false"-->
                        <textarea class="textbox-decoration " name="video_content_3" id="textbox-2" spellcheck="false"
                                  style="height: 340px;"></textarea>
                        <input type="hidden" name="video_id_3" id="video_id_2" >
                    </div>
                    <!--question wrapper end-->

                    <!--question wrapper start-->
                    <div class="question-wrapper mb-5">
                        <div class="topbar inputting position-relative">
                            <div class="title">Transcribe</div>
                            <div class="controls">
                                <div class="button play-pause play-pause-3">
                                    <i class="fa fa-play"></i><i class="fa fa-pause"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="playPause">esc</div>
                                </div>
                                <div class="button skip-backwards-3">
                                    <i class="fa fa-backward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="backwards">f1</div>
                                </div>
                                <div class="button skip-forwards-3">
                                    <i class="fa fa-forward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="forwards">f2</div>
                                </div>
                                <div class="button speed">
                                    <i class="fa fa-dashboard"></i> <span data-l10n-id="speed">speed</span>
                                    <div class="speed-box">
                                        <span data-shortcut="speedDown">f3</span>
                                        <i class="slider-origin"></i>
                                        <input class="speed-slider-3" type="range" min="0.5" max="2.0" step="0.25" value="1"/>
                                        <span data-shortcut="speedUp">f4</span>
                                    </div>
                                </div>
                                <div id="player-hook-3"></div>
                                <div class="button player-time"></div>
                                <div class="time-selection">
                                    <label>
                                        <span data-l10n-id="jump-to-time">Jump to time:</span>
                                        <input type="text" value="0:00" class="mousetrap"/>
                                    </label>
                                </div>
                                <!--                <div class="button reset"><i class="fa fa-refresh"></i></div>-->
                            </div>
                        </div>
                        <!--                    <textarea name="content" id="textbox1" onkeyup="adjustHeight(this)" spellcheck="false"-->
                        <textarea class="textbox-decoration" name="video_content_4" id="textbox-3" spellcheck="false"
                                  style="height: 340px;"></textarea>
                        <input type="hidden" name="video_id_4" id="video_id_3" >
                    </div>
                    <!--question wrapper end-->

                    <!--question wrapper start-->
                    <div class="question-wrapper mb-5">
                        <div class="topbar inputting position-relative">
                            <div class="title">Transcribe</div>
                            <div class="controls">
                                <div class="button play-pause play-pause-4">
                                    <i class="fa fa-play"></i><i class="fa fa-pause"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="playPause">esc</div>
                                </div>
                                <div class="button skip-backwards-4">
                                    <i class="fa fa-backward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="backwards">f1</div>
                                </div>
                                <div class="button skip-forwards-4">
                                    <i class="fa fa-forward"></i>
                                    <div class="topbar-button-shortcut" data-shortcut="forwards">f2</div>
                                </div>
                                <div class="button speed">
                                    <i class="fa fa-dashboard"></i> <span data-l10n-id="speed">speed</span>
                                    <div class="speed-box">
                                        <span data-shortcut="speedDown">f3</span>
                                        <i class="slider-origin"></i>
                                        <input class="speed-slider-4" type="range" min="0.5" max="2.0" step="0.25" value="1"/>
                                        <span data-shortcut="speedUp">f4</span>
                                    </div>
                                </div>
                                <div id="player-hook-4"></div>
                                <div class="button player-time"></div>
                                <div class="time-selection">
                                    <label>
                                        <span data-l10n-id="jump-to-time">Jump to time:</span>
                                        <input type="text" value="0:00" class="mousetrap"/>
                                    </label>
                                </div>
                                <!--                <div class="button reset"><i class="fa fa-refresh"></i></div>-->
                            </div>
                        </div>
                        <!--                    <textarea name="content" id="textbox1" onkeyup="adjustHeight(this)" spellcheck="false"-->
                        <textarea class="textbox-decoration" name="video_content_5" id="textbox-4" spellcheck="false" style="height: 340px;"></textarea>

                        <input type="hidden" name="video_id_5" id="video_id_4" >
                    </div>
                    <!--question wrapper end-->

                    <div class="file-input-wrapperNew">
                        <div class="alert alert-danger mb-0 p-2" id="alertTextbox" role="alert">
                            Your application has been rejected, we do not accept partially complete application.
                        </div>
                        <button id="saveCallBtnSave" type="button" class="myButton saveCallBtnSave"><img
                                src="img/submit.png"/></button>
                    </div>
                    <input type="hidden" class="modal__input" name="audioId" id="audioId" >
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

<script type="text/javascript" src="js/progressor.min.js"></script>
<script type="text/javascript" src="js/otplayer.js"></script>
<script src="js/jquery.min.js" crossorigin="anonymous"></script>
<script src="js/popper.min.js" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" crossorigin="anonymous"></script>


<script type="text/javascript">

    var modal = document.getElementById("myModal");
    var chckModal = 0;
    var addMin = 0, addSec = 0;

    var files = [<?php foreach ($result as $val){ print "'".$val['audio_link'].'-'.$val['id']."',"; }?>];
    const lengthOfAdio = files.length;

    $(document).ready(function () {

        $(".transcribe-panel").show();

        loadMedia();
        //minimum length of audio text box
        const minLengthText= 100;
        // this function and event using for audio text box validation
        $("#saveCallBtnSave").click(function () {
            // var count = $("#textbox").val().length;

            let  validation;
            for (let i = 0; i < lengthOfAdio ; i++){
                if ($(`#textbox-${i}`).val().length < minLengthText) {
                    validation = false;
                    break;
                } else {
                    validation = true;
                }
            }
            if (!validation) {
                $("#alertTextbox").show();
            } else {
                $("#saveStaffForm").submit();
            }
        });
    });



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

        var audioNum = randomIntFromInterval(0, 4);

        var aFile = files[audioNum];
        let fiArray = aFile.split("|");

        var file = fiArray[0];

        var idAudio = fiArray[1];
        $('#audioId').val(idAudio);


        // Setting cookies for the audio file for a specific user (Start)
        var lifeTime = new Date();
        lifeTime.setTime(lifeTime.getTime() + (90*24*60*60*1000));
        var aUrl = getCookie('audioURL');
        var aID = getCookie('audioID');
        if (aUrl) {
            file = aUrl;
            $('#audioId').val(aID);
        }else {
            document.cookie = "audioURL="+file+";expires="+lifeTime.toGMTString()+";path=/";
            document.cookie = "audioID="+idAudio+";expires="+lifeTime.toGMTString()+";path=/";
        }
        // Setting cookies for the audio file for a specific user (End)




        var opts = [];

        for (let i = 0; i < lengthOfAdio ; i++){
            opts[i] = {
                source: files[i].replace(/-[\d]+$/, ''),
                container: $(`#player-hook-${i}`)[0],
                startpoint: 0,
                buttons: {
                    playPause: `.play-pause-${i}`
                }
            }
        };

        var filename = file.replace(/^.*[\\\/]/, '');
        var filenames = [];

        window.player={};
         for (let i = 0; i < lengthOfAdio ; i++){
             if (window.player[i]) {
                 window.player[i].reset();
             }
             filenames[i] = files[i].replace(/.*\/([^\/]+)-\d+$/, '$1');
             let videotrim =files[i].replace(/^.*[\\\/]/, '');
             let videoId = videotrim.split('-')

              $(`#video_id_${i}`).val(videoId[1]);
             window.player[i] = new oTplayer(opts[i]);
         }

         // player[0].pause();

        for (let i = 0; i < lengthOfAdio ; i++) {

            if (isVideo(filename) == true) {
                var jqProgressBar = new Progressor({
                    media: $('video')[i],
                    bar: opts[i].container,
                    text: filenames[i],
                    time: $('.player-time')[i]
                });
                $('video').addClass('video-player');
            } else {
                var jqProgressBar = new Progressor({
                    media: $('audio')[i],
                    bar: opts[i].container,
                    text: filenames[i],
                    time: $('.player-time')[i]
                });
            }
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

    for (let i = 0; i < lengthOfAdio ; i++){
        // console.log($('.skip-backwards')[i])
        $(`.skip-backwards-${i}`).click(function () {
            // console.log(player[i])
            player[i].skip('backwards');
        });

        $(`.skip-forwards-${i}`).click(function () {
            player[i].skip('forwards');
        });

        $(`.speed-slider-${i}`).change(function () {
            player[i].speed(this.valueAsNumber);
        });
    }

    $(document).on('click', ".timestamp", function () {
        ts.setFrom($(this).attr('lang'), this);
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
        for (let i = 0; i < lengthOfAdio ; i++){
            if (event.which == 27) {
                player[i].playPause();
            } else if (event.ctrlKey == true && event.keyCode == 74) {
                event.preventDefault();
                ts.insert();
            } else if (event.which == 112) {
                event.preventDefault();
                player[i].skip('backwards');
            } else if (event.which == 113) {
                player[i].skip('forwards');
            } else if (event.which == 114) {
                player[i].speed('down');
            } else if (event.which == 115) {
                player[i].speed('up');
            }
            $(`.speed-slider-${i}`).val(player[i].getSpeed());
        }
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