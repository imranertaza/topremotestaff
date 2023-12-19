<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require '../config/database.php';
require '../controller/crud.php';
require '../includes/calculateScore.php';

if (!isset($_COOKIE["staff_session_id"])) {
    if ($_COOKIE["staff_session_id"] != 1) {
        header('Location: login.php');
    }
}

$crud = new Crud();
$getScore = new CalculateScore();

if (!isset($_GET['tab'])) {
    $getData = mysqli_query($db, "SELECT * FROM ts_users WHERE status='0' ORDER BY date_created DESC");
    $result = mysqli_fetch_all($getData, MYSQLI_ASSOC);
    $getTestData = mysqli_query($db, "SELECT * FROM ts_test WHERE id='2'");
    $testDataResult = mysqli_fetch_all($getTestData, MYSQLI_ASSOC);
}


if (isset($_GET['tab'])) {
    if ($_GET['tab'] == "pending") {
        $getData = mysqli_query($db, "SELECT * FROM ts_users WHERE status='0' ORDER BY date_created DESC");
        $result = mysqli_fetch_all($getData, MYSQLI_ASSOC);
        $getTestData = mysqli_query($db, "SELECT * FROM ts_test WHERE id='2'");
        $testDataResult = mysqli_fetch_all($getTestData, MYSQLI_ASSOC);
    }
}
if (isset($_GET['tab'])) {
    if ($_GET['tab'] == "approved") {
        $getApproved = mysqli_query($db, "SELECT * FROM ts_users WHERE status='1' ORDER BY date_updated DESC");
        $approveResult = mysqli_fetch_all($getApproved, MYSQLI_ASSOC);
    }
}

if (isset($_GET['tab'])) {
    if ($_GET['tab'] == "test") {
        $getTest = mysqli_query($db, "SELECT * FROM ts_test ORDER BY id DESC");
        $testResult = mysqli_fetch_all($getTest, MYSQLI_ASSOC);
    }
}

if (isset($_GET['tab'])) {
    if ($_GET['tab'] == "email") {
        $getApproveEmailTemplate = mysqli_query($db, "SELECT * FROM ts_approve_email_template");
        $approveEmailTemplate = mysqli_fetch_all($getApproveEmailTemplate, MYSQLI_ASSOC);

        $getFollowupEmailTemplate = mysqli_query($db, "SELECT * FROM ts_followup_email_template");
        $followupEmailTemplate = mysqli_fetch_all($getFollowupEmailTemplate, MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Show Staff</title>
    <link rel="shortcut icon" href="#"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1"/>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/stylesheet.css">

</head>
<body>
<a href="signout.php" class="btn-danger" style="float:right;text-decoration:none;font-size:15px">Sign Out</a>
<h2>All Staff</h2>


            <div class="tab">
                <?php if (!empty($_GET)) { ?>
                    <?php if ($_GET['tab'] == "approved") { ?>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="pending" class="tablinks"
                                    onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="approved" class="tablinks active"
                                    onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="test" class="tablinks"
                                    onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="email" class="tablinks"
                                    onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5>
                            </button>
                        </form>
                    <?php } else if ($_GET['tab'] == "test") { ?>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="pending" class="tablinks"
                                    onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="approved" class="tablinks"
                                    onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="test" class="tablinks active"
                                    onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="email" class="tablinks"
                                    onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5>
                            </button>
                        </form>
                    <?php } else if ($_GET['tab'] == "email") { ?>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="pending" class="tablinks"
                                    onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="approved" class="tablinks"
                                    onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="test" class="tablinks"
                                    onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="email" class="tablinks active"
                                    onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5>
                            </button>
                        </form>
                    <?php } else { ?>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="pending" class="tablinks active"
                                    onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="approved" class="tablinks"
                                    onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="test" class="tablinks"
                                    onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
                        </form>
                        <form action="" method="get">
                            <button type="submit" name="tab" value="email" class="tablinks"
                                    onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5>
                            </button>
                        </form>
                    <?php } ?>
                <?php } else { ?>
                    <form action="" method="get">
                        <button type="submit" name="tab" value="pending" class="tablinks active"
                                onclick="openTab(event, 'pending')"><h5 class="m-0">PENDING STAFF</h5></button>
                    </form>
                    <form action="" method="get">
                        <button type="submit" name="tab" value="approved" class="tablinks"
                                onclick="openTab(event, 'approved')"><h5 class="m-0">APPROVED STAFF</h5></button>
                    </form>
                    <form action="" method="get">
                        <button type="submit" name="tab" value="test" class="tablinks"
                                onclick="openTab(event, 'audio_test')"><h5 class="m-0">AUDIO TEST</h5></button>
                    </form>
                    <form action="" method="get">
                        <button type="submit" name="tab" value="email" class="tablinks"
                                onclick="openTab(event, 'email_template')"><h5 class="m-0">EMAIL TEMPLATE</h5></button>
                    </form>


                <?php } ?>

            </div>

            <?php if (!empty($_GET)){ ?>
            <?php if ($_GET['tab'] == "approved"){ ?>
                <div id="pending" class="tabcontent p-1 ">
                <?php }else if ($_GET['tab'] == "test"){ ?>
                <div id="pending" class="tabcontent p-1">
                    <?php }else if ($_GET['tab'] == "email"){ ?>
                    <div id="pending" class="tabcontent p-1">
                        <?php }else{ ?>
                        <div id="pending" class="tabcontent show p-1 ">
                            <?php } ?>
                            <?php }else{ ?>
                            <div id="pending" class="tabcontent show p-1 ">
                                <?php } ?>
                                <table cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th style="width:20%">Full Name</th>
                                        <th style="width:20%">Email</th>
                                        <th style="width:10%">Phone</th>
                                        <th style="width:15%">IP Address<br/>
                                            <button onclick="tagduplicateip()" type="button">Tag Duplicate</button>
                                        </th>
                                        <th style="width:11%">Code<br/>
                                            <button onclick="tagnocode()" type="button">Tag No Code</button>
                                        </th>
                                        <th style="width:12%">Content<br/>
                                            <button onclick="tagnegativekeyword()" type="button">Tag Negative</button>
                                        </th>
                                        <th style="width:12px">Score</th>

                                        <th style="width:6%">Action</th>
                                        <th style="width:6%">Delete</th>
                                        <th>
                                            <center>
                                                <select onchange="minTagRating(this)">
                                                    <option value="10">Minimum 10</option>
                                                    <option value="9">Minimum 9</option>
                                                    <option value="8">Minimum 8</option>
                                                    <option value="7">Minimum 7</option>
                                                    <option value="6">Minimum 6</option>
                                                    <option value="5">Minimum 5</option>
                                                    <option value="4">Minimum 4</option>
                                                    <option value="3">Minimum 3</option>
                                                    <option value="2">Minimum 2</option>
                                                    <option value="1">Minimum 1</option>
                                                </select>
                                                <button class="btn-danger" onclick="showDeleteAllPendingModal()">REMOVE
                                                    ALL
                                                </button>
                                            </center>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!isset($_GET['tab']) || $_GET['tab'] == "pending") { ?>
                                        <?php if (mysqli_num_rows($getData) > 0) { ?>
                                            <?php

                                            $ip_list = array();

                                            for ($x = 0; $x < count($result); $x++) {
                                                array_push($ip_list, $result[$x]['ip_address']);
                                            }

                                            $ip_list = array_unique(array_diff_assoc($ip_list, array_unique($ip_list)));

                                            for ($x = 0; $x < count($result); $x++) {

                                                $search_ip = array_search($result[$x]['ip_address'], $ip_list);
                                                $duplicated_ip = 0;
                                                if (!empty($search_ip) || $search_ip != "") {
                                                    $duplicated_ip = 1;
                                                }

                                                ?>
                                                <tr>
                                                    <td><?php echo urldecode($result[$x]['fullname']); ?></td>
                                                    <td><?php echo $result[$x]['email']; ?></td>
                                                    <td><?php echo urldecode($result[$x]['phone']); ?></td>
                                                    <td><?php echo urldecode($result[$x]['ip_address']); ?></td>
                                                    <td>
                                                        <?php echo $result[$x]['code']; ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn-default"
                                                                onclick="showModal(<?php echo "contentmodal" . (string)$result[$x]['id']; ?>)">
                                                            VIEW CONTENT
                                                        </button>
                                                    </td>
                                                    <td class="score-total">
                                                        <?php

                                                        $getDataTest = mysqli_query($db, "SELECT * FROM ts_user_test WHERE user_id=".$result[$x]['id']);
                                                        $resultTest = mysqli_fetch_all($getDataTest, MYSQLI_ASSOC);

                                                        if (!empty($resultTest)) {

                                                        $test_1_result = $getScore->user_single_test_result($resultTest[0]['test_1_id'],$resultTest[0]['test_1_content']);
                                                        $test_2_result = $getScore->user_single_test_result($resultTest[0]['test_2_id'],$resultTest[0]['test_2_content']);
                                                        $test_3_result = $getScore->user_single_test_result($resultTest[0]['test_3_id'],$resultTest[0]['test_3_content']);
                                                        $test_4_result = $getScore->user_single_test_result($resultTest[0]['test_4_id'],$resultTest[0]['test_4_content']);
                                                        $test_5_result = $getScore->user_single_test_result($resultTest[0]['test_5_id'],$resultTest[0]['test_5_content']);

                                                        $score_1 = $test_1_result['score']/$test_1_result['total_keyword'];
                                                        $score_2 = $test_2_result['score']/$test_2_result['total_keyword'];
                                                        $score_3 = $test_3_result['score']/$test_3_result['total_keyword'];
                                                        $score_4 = $test_4_result['score']/$test_4_result['total_keyword'];
                                                        $score_5 = $test_5_result['score']/$test_5_result['total_keyword'];



                                                        $score =  (($score_1 + $score_2 + $score_3 + $score_4 + $score_5)/5)*100;
                                                        $total = $test_1_result['total_keyword'];

                                                        $t_not_included_words = $test_1_result['not_included_words'].$test_2_result['not_included_words'].$test_3_result['not_included_words'].$test_4_result['not_included_words'].$test_5_result['not_included_words'];
                                                        $t_negative_included_words = $test_1_result['negative_included_words'].$test_2_result['negative_included_words'].$test_3_result['negative_included_words'].$test_4_result['negative_included_words'].$test_5_result['negative_included_words'];

//
                                                        ?>

                                                        <?php if ($total != $score) { ?>
                                                            <div class="tooltip">
                                                                <?php echo round($score,2); ?>
                                                                <span class="tooltiptext">
                                                                    <p style="color:#000;margin:0;font-size:14px;padding-left:4px;"><strong>Score: </strong><?php echo round($score,2); ?></p>
                                                                    <?php echo $t_not_included_words; ?>
                                                                    <p style="color:#000;margin:0;font-size:14px;padding-left:4px;padding-top:10px;"><b>Negative Keywords:</b></p>
                                                                    <?php echo $t_negative_included_words; ?>
														        </span>
                                                            </div>

                                                        <?php } else { ?>
                                                            <p><?php echo round($score,2); ?></p>
                                                        <?php } } ?>

                                                    </td>

                                                    <td>
                                                        <button class="btn-success"
                                                                onclick="showModal(<?php echo "approvemodal" . (string)$result[$x]['id']; ?>)">
                                                            APPROVE
                                                        </button>
                                                        <button class="btn-danger"
                                                                onclick="showModal(<?php echo "declinemodal" . (string)$result[$x]['id']; ?>)">
                                                            DECLINE
                                                        </button>
                                                        <div id="approvemodal<?php echo $result[$x]['id']; ?>"
                                                             class="modal">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <span class="close"
                                                                          onclick="closeModal(<?php echo "approvemodal" . (string)$result[$x]['id']; ?>)">&#x2716;</span>
                                                                    <h3 style="margin:0">Are you sure you want to
                                                                        approve?</h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <center>
                                                                        <form method="post" action="approve_staff.php"
                                                                              style="display:inline">
                                                                            <input type="hidden" name="id"
                                                                                   value="<?php echo $result[$x]['id']; ?>">
                                                                            <input type="hidden" name="email"
                                                                                   value="<?php echo $result[$x]['email']; ?>">
                                                                            <input type="hidden" name="fullname"
                                                                                   value="<?php echo $result[$x]['fullname']; ?>">
                                                                            <input type="hidden" name="account_type"
                                                                                   value="1">
                                                                            <input type="hidden" name="status"
                                                                                   value="1">
                                                                            <button type="submit" class="btn-success"
                                                                                    style="font-size:12px;">Yes, as
                                                                                TRANSCRIBER
                                                                            </button>
                                                                        </form>
<!--                                                                        <form method="post" action="approve_staff.php"-->
<!--                                                                              style="display:inline">-->
<!--                                                                            <input type="hidden" name="id"-->
<!--                                                                                   value="--><?php //echo $result[$x]['id']; ?><!--">-->
<!--                                                                            <input type="hidden" name="email"-->
<!--                                                                                   value="--><?php //echo $result[$x]['email']; ?><!--">-->
<!--                                                                            <input type="hidden" name="fullname"-->
<!--                                                                                   value="--><?php //echo $result[$x]['fullname']; ?><!--">-->
<!--                                                                            <input type="hidden" name="account_type"-->
<!--                                                                                   value="2">-->
<!--                                                                            <input type="hidden" name="status"-->
<!--                                                                                   value="1">-->
<!--                                                                            <button type="submit" class="btn-success"-->
<!--                                                                                    style="font-size:12px;">Yes, as-->
<!--                                                                                TRANSCRIBER-->
<!--                                                                            </button>-->
<!--                                                                        </form>-->
                                                                    </center>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="contentmodal<?php echo $result[$x]['id']; ?>"
                                                             class="modal">
                                                            <div class="modal-content"
                                                                 style="width:50%;max-height: 500px;overflow-y: auto;">
                                                                <div class="modal-body">
                                                                    <span class="close"
                                                                          onclick="closeModal(<?php echo "contentmodal" . (string)$result[$x]['id']; ?>)">&#x2716;</span>

                                                                    <form method="post" action="approve_staff.php"
                                                                          style="display:inline">
                                                                        <input type="hidden" name="id"
                                                                               value="<?php echo $result[$x]['id']; ?>">
                                                                        <input type="hidden" name="email"
                                                                               value="<?php echo $result[$x]['email']; ?>">
                                                                        <input type="hidden" name="fullname"
                                                                               value="<?php echo $result[$x]['fullname']; ?>">
                                                                        <input type="hidden" name="account_type"
                                                                               value="1">
                                                                        <input type="hidden" name="status" value="1">
                                                                        <button type="submit" class="btn-success"
                                                                                style="font-size:12px;">APPROVE
                                                                            TRANSCRIBER
                                                                        </button>
                                                                    </form>
<!--                                                                    <form method="post" action="approve_staff.php"-->
<!--                                                                          style="display:inline">-->
<!--                                                                        <input type="hidden" name="id"-->
<!--                                                                               value="--><?php //echo $result[$x]['id']; ?><!--">-->
<!--                                                                        <input type="hidden" name="email"-->
<!--                                                                               value="--><?php //echo $result[$x]['email']; ?><!--">-->
<!--                                                                        <input type="hidden" name="fullname"-->
<!--                                                                               value="--><?php //echo $result[$x]['fullname']; ?><!--">-->
<!--                                                                        <input type="hidden" name="account_type"-->
<!--                                                                               value="2">-->
<!--                                                                        <input type="hidden" name="status" value="1">-->
<!--                                                                        <button type="submit" class="btn-success"-->
<!--                                                                                style="font-size:12px;">APPROVE-->
<!--                                                                            TRANSCRIBER-->
<!--                                                                        </button>-->
<!--                                                                    </form>-->
                                                                    <button class="btn-danger"
                                                                            onclick="showModal(<?php echo "declinemodal" . (string)$result[$x]['id']; ?>,<?php echo "contentmodal" . (string)$result[$x]['id']; ?>)">
                                                                        DECLINE
                                                                    </button>
                                                                    <button class="btn-danger"
                                                                            onclick="showModal(<?php echo "deletePendingModal" . (string)$result[$x]['id']; ?>,<?php echo "contentmodal" . (string)$result[$x]['id']; ?>)">
                                                                        REMOVE
                                                                    </button>
                                                                    <br/>
                                                                    <br/>
                                                                    <?php if (!empty($resultTest)) { ?>
                                                                    <div class="tooltip">
                                                                        <span><strong>Test One Score: </strong><?php echo $test_1_result['score'] . "/" . $test_1_result['total_keyword']; ?></span>
                                                                        <span class="tooltiptext" style="left:105%">
																            <?php echo $test_1_result['not_included_words']; ?>
                                                                            <p style="color:#000;margin:0;font-size:14px;padding-left:4px;padding-top:10px;"><b>Negative Keywords:</b></p>
															                <?php echo $test_1_result['negative_included_words']; ?>
															            </span>
                                                                    </div>
                                                                    <p style='white-space: pre-line;margin:0'>
                                                                        <?php echo $test_1_result['content']; ?>
                                                                    </p>

                                                                    <br>
                                                                    <div class="tooltip">
                                                                        <span><strong>Test Two Score: </strong><?php echo $test_2_result['score'] . "/" . $test_2_result['total_keyword']; ?></span>
                                                                        <span class="tooltiptext" style="left:105%">
																        <?php echo $test_2_result['not_included_words']; ?>
                                                                            <p style="color:#000;margin:0;font-size:14px;padding-left:4px;padding-top:10px;"><b>Negative Keywords:</b></p>
															                <?php echo $test_2_result['negative_included_words']; ?>
															            </span>
                                                                    </div>
                                                                    <p style='white-space: pre-line;margin:0'>
                                                                        <?php echo $test_2_result['content']; ?>
                                                                    </p>

                                                                    <br>
                                                                    <div class="tooltip">
                                                                        <span><strong>Test Three Score: </strong><?php echo $test_3_result['score']. "/" . $test_3_result['total_keyword']; ?></span>
                                                                        <span class="tooltiptext" style="left:105%">
																        <?php echo $test_3_result['not_included_words']; ?>
                                                                            <p style="color:#000;margin:0;font-size:14px;padding-left:4px;padding-top:10px;"><b>Negative Keywords:</b></p>
															                <?php echo $test_3_result['negative_included_words']; ?>
															            </span>
                                                                    </div>
                                                                    <p style='white-space: pre-line;margin:0'>
                                                                        <?php echo $test_3_result['content']; ?>
                                                                    </p>

                                                                    <br>
                                                                    <div class="tooltip">
                                                                        <span><strong>Test Four Score: </strong><?php echo $test_4_result['score']. "/" . $test_4_result['total_keyword']; ?></span>
                                                                        <span class="tooltiptext" style="left:105%">
																        <?php echo $test_4_result['not_included_words']; ?>
                                                                            <p style="color:#000;margin:0;font-size:14px;padding-left:4px;padding-top:10px;"><b>Negative Keywords:</b></p>
															                <?php echo $test_4_result['negative_included_words']; ?>
															            </span>
                                                                    </div>
                                                                    <p style='white-space: pre-line;margin:0'>
                                                                        <?php echo $test_4_result['content']; ?>
                                                                    </p>

                                                                    <br>
                                                                    <div class="tooltip">
                                                                        <span><strong>Test Five Score: </strong><?php echo $test_5_result['score']. "/" . $test_5_result['total_keyword']; ?></span>
                                                                        <span class="tooltiptext" style="left:105%">
																        <?php echo $test_5_result['not_included_words']; ?>
                                                                            <p style="color:#000;margin:0;font-size:14px;padding-left:4px;padding-top:10px;"><b>Negative Keywords:</b></p>
															                <?php echo $test_5_result['negative_included_words']; ?>
															            </span>
                                                                    </div>
                                                                    <p style='white-space: pre-line;margin:0'>
                                                                        <?php echo $test_5_result['content']; ?>
                                                                    </p>
                                                                    <?php }else{
                                                                        print '<p><b>Data Not Found</b></p>';
                                                                    } ?>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="declinemodal<?php echo $result[$x]['id']; ?>"
                                                             class="modal">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <span class="close"
                                                                          onclick="closeModal(<?php echo "declinemodal" . (string)$result[$x]['id']; ?>)">&#x2716;</span>
                                                                    <h3 style="margin:0">Are you sure you want to
                                                                        decline?</h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" action="approve_staff.php">
                                                                        <input type="hidden" name="id"
                                                                               value="<?php echo $result[$x]['id']; ?>">
                                                                        <input type="hidden" name="skype"
                                                                               value="<?php echo $result[$x]['skype']; ?>">
                                                                        <input type="hidden" name="email"
                                                                               value="<?php echo $result[$x]['email']; ?>">
                                                                        <input type="hidden" name="paypal"
                                                                               value="<?php echo $result[$x]['paypal']; ?>">
                                                                        <input type="hidden" name="fullname"
                                                                               value="<?php echo $result[$x]['fullname']; ?>">
                                                                        <input type="hidden" name="status" value="0">
                                                                        <button type="submit" class="btn-danger"
                                                                                style="font-size:1rem;">Reject
                                                                        </button>
                                                                        <button type="button" class="btn-default"
                                                                                style="font-size:1rem;"
                                                                                onclick="closeModal(<?php echo "declinemodal" . (string)$result[$x]['id']; ?>)">
                                                                            No
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn-danger"
                                                                onclick="showModal(<?php echo "deletePendingModal" . (string)$result[$x]['id']; ?>)">
                                                            REMOVE
                                                        </button>
                                                        <div id="deletePendingModal<?php echo $result[$x]['id']; ?>"
                                                             class="modal">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <span class="close"
                                                                          onclick="closeModal(<?php echo "deletePendingModal" . (string)$result[$x]['id']; ?>)">&#x2716;</span>
                                                                    <h3 style="margin:0">Are you sure you want to
                                                                        remove?</h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" action="remove_staff.php">
                                                                        <input type="hidden" name="id"
                                                                               value="<?php echo $result[$x]['id']; ?>">
                                                                        <input type="hidden" name="check" value="1">
                                                                        <button type="submit" class="btn-danger"
                                                                                style="font-size:1rem;">Yes
                                                                        </button>
                                                                        <button type="button" class="btn-default"
                                                                                style="font-size:1rem;"
                                                                                onclick="closeModal(<?php echo "deletePendingModal" . (string)$result[$x]['id']; ?>)">
                                                                            No
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="rating<?php echo round($score,0); ?> <?php echo ($duplicated_ip > 0) ? "duplicateip" : ""; ?> <?php echo ($result[$x]['code'] == "" || $result[$x]['code'] == null) ? "nocode" : ""; ?>
                                                    <?php
                                                    if (!empty($resultTest)) {
                                                        for ($c = 1; $c <= 5; $c++){
                                                            $neg = $getScore->negative_keyword_not_included($resultTest[0]['test_'.$c.'_id'], $resultTest[0]['test_'.$c.'_content']);
                                                            if ($neg == 0){
                                                                echo "negative-keyword-content";
                                                                break;
                                                            }
                                                        }

                                                    }

                                                    ?>">

                                                        <center><input type="checkbox" class="remove_all"
                                                                       name="remove_all[]"
                                                                       value="<?php echo $result[$x]['id']; ?>">
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="10">No pending staff.</td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>

                            <?php if (!empty($_GET)){ ?>
                            <?php if ($_GET['tab'] == "approved"){ ?>
                            <div id="approved" class="tabcontent p-1 show">
                                <?php }else if ($_GET['tab'] == "test"){ ?>
                                <div id="approved" class="tabcontent p-1">
                                    <?php }else if ($_GET['tab'] == "email"){ ?>
                                    <div id="approved" class="tabcontent p-1">
                                        <?php }else{ ?>
                                        <div id="approved" class="tabcontent p-1">
                                            <?php } ?>
                                            <?php }else{ ?>
                                            <div id="approved" class="tabcontent p-1">
                                                <?php } ?>
                                                <table cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th style="width:20%">Full Name</th>
                                                        <th style="width:20%">Email</th>
                                                        <th style="width:8%">Phone</th>
                                                        <th style="width:12%">Skype</th>
                                                        <th style="width:12%">Paypal</th>
                                                        <th style="width:8%">Jobtitle</th>
                                                        <th style="width:8%">Timestamp</th>
                                                        <th style="width:8%">Content</th>
                                                        <th style="width:6%">Delete</th>
                                                        <th>
                                                            <button class="btn-danger"
                                                                    onclick="showDeleteAllApprovedModal()">REMOVE ALL
                                                            </button>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if (isset($_GET['tab'])) {
                                                        if ($_GET['tab'] == "approved") { ?>
                                                            <?php if (mysqli_num_rows($getApproved) > 0) { ?>
                                                                <?php for ($x = 0; $x < count($approveResult); $x++) { ?>
                                                                    <tr>
                                                                        <td style="word-break: break-word;"><?php echo urldecode($approveResult[$x]['fullname']); ?></td>
                                                                        <td style="word-break: break-word;"><?php echo $approveResult[$x]['email']; ?></td>
                                                                        <td><?php echo urldecode($approveResult[$x]['phone']); ?></td>
                                                                        <td style="word-break: break-word;"><?php echo urldecode($approveResult[$x]['skype']); ?></td>
                                                                        <td><?php echo $approveResult[$x]['paypal']; ?></td>
                                                                        <td>
                                                                            TRANSCRIBER
                                                                        </td>
                                                                        <td>
                                                                            <?php

                                                                            echo date('Y-m-d H:i:s', $approveResult[$x]['date_updated']);

                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn-default"
                                                                                    onclick="showModal(<?php echo "approvedcontentmodal" . (string)$approveResult[$x]['id']; ?>)">
                                                                                VIEW CONTENT
                                                                            </button>
                                                                            <div id="approvedcontentmodal<?php echo $approveResult[$x]['id']; ?>"
                                                                                 class="modal">
                                                                                <div class="modal-content"
                                                                                     style="width:50%;max-height: 500px;overflow-y: auto;">
                                                                                    <div class="modal-body">
                                                                                        <span class="close"
                                                                                              onclick="closeModal(<?php echo "approvedcontentmodal" . (string)$approveResult[$x]['id']; ?>)">&#x2716;</span>

                                                                                        <?php

                                                                    $getDataTestAprov = mysqli_query($db, "SELECT * FROM ts_user_test WHERE user_id=".$approveResult[$x]['id']);
                                                                    $resultTestAprov = mysqli_fetch_all($getDataTestAprov, MYSQLI_ASSOC);
                                                                    if (!empty($resultTestAprov)) {

                                                                        $test_1_resultAp = $getScore->user_single_test_result($resultTestAprov[0]['test_1_id'],$resultTestAprov[0]['test_1_content']);
                                                                        $test_2_resultAp = $getScore->user_single_test_result($resultTestAprov[0]['test_2_id'],$resultTestAprov[0]['test_2_content']);
                                                                        $test_3_resultAp = $getScore->user_single_test_result($resultTestAprov[0]['test_3_id'],$resultTestAprov[0]['test_3_content']);
                                                                        $test_4_resultAp = $getScore->user_single_test_result($resultTestAprov[0]['test_4_id'],$resultTestAprov[0]['test_4_content']);
                                                                        $test_5_resultAp = $getScore->user_single_test_result($resultTestAprov[0]['test_5_id'],$resultTestAprov[0]['test_5_content']);

                     print '<p><b>Test One Score:</b></p><p style="white-space: pre-line">'.$test_1_resultAp['content'].'</p>';
                     print '<p><b>Test Two Score:</b></p><p style="white-space: pre-line">'.$test_1_resultAp['content'].'</p>';
                     print '<p><b>Test Three Score:</b></p><p style="white-space: pre-line">'.$test_1_resultAp['content'].'</p>';
                     print '<p><b>Test Four Score:</b></p><p style="white-space: pre-line">'.$test_1_resultAp['content'].'</p>';
                     print '<p><b>Test Five Score:</b></p><p style="white-space: pre-line">'.$test_1_resultAp['content'].'</p>';

                                                                    }else{
                                                                        print '<p><b>Data Not Found</b></p>';
                                                                    }

                                                                                        ?>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn-danger"
                                                                                    onclick="showModal(<?php echo "deleteModal" . (string)$approveResult[$x]['id']; ?>)">
                                                                                REMOVE
                                                                            </button>
                                                                            <div id="deleteModal<?php echo $approveResult[$x]['id']; ?>"
                                                                                 class="modal">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <span class="close"
                                                                                              onclick="closeModal(<?php echo "deleteModal" . (string)$approveResult[$x]['id']; ?>)">&#x2716;</span>
                                                                                        <h3 style="margin:0">Are you
                                                                                            sure you want to
                                                                                            remove?</h3>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form method="post"
                                                                                              action="remove_staff.php">
                                                                                            <input type="hidden"
                                                                                                   name="id"
                                                                                                   value="<?php echo $approveResult[$x]['id']; ?>">
                                                                                            <input type="hidden"
                                                                                                   name="check"
                                                                                                   value="2">
                                                                                            <button type="submit"
                                                                                                    class="btn-danger"
                                                                                                    style="font-size:1rem;">
                                                                                                Yes
                                                                                            </button>
                                                                                            <button type="button"
                                                                                                    class="btn-default"
                                                                                                    style="font-size:1rem;"
                                                                                                    onclick="closeModal(<?php echo "deleteModal" . (string)$approveResult[$x]['id']; ?>)">
                                                                                                No
                                                                                            </button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            $num_days = 30;
                                                                            $per_day = 24 * 60 * 60;
                                                                            $checkDate = new DateTime();
                                                                            $today_timestamp = $checkDate->getTimestamp();
                                                                            $approvedDate = ($num_days * $per_day) + $approveResult[$x]['date_updated'];
                                                                            $approvedPlusDays = $approvedDate - $today_timestamp;

                                                                            if ($approvedPlusDays <= 0) {
                                                                                ?>
                                                                                <center><input type="checkbox"
                                                                                               class="remove_all_approved"
                                                                                               name="remove_all_approved[]"
                                                                                               value="<?php echo $approveResult[$x]['id']; ?>"
                                                                                               checked></center>
                                                                            <?php } else { ?>
                                                                                <center><input type="checkbox"
                                                                                               class="remove_all_approved"
                                                                                               name="remove_all_approved[]"
                                                                                               value="<?php echo $approveResult[$x]['id']; ?>">
                                                                                </center>
                                                                            <?php } ?>

                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <td colspan="10">No approved staff.</td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php if (!empty($_GET)){ ?>
        <?php if ($_GET['tab'] == "test"){ ?>
        <div id="audio_test" class="tabcontent show p-1">
            <?php echo (isset($_SESSION["err_message"]))?$_SESSION["err_message"]:'' ?>
            <?php }else if ($_GET['tab'] == "approved"){ ?>
            <div id="audio_test" class="tabcontent p-1">
                <?php }else if ($_GET['tab'] == "email"){ ?>
                <div id="audio_test" class="tabcontent p-1">
                    <?php }else{ ?>
                    <div id="audio_test" class="tabcontent p-1">
                        <?php } ?>
                        <?php }else{ ?>
                        <div id="audio_test" class="tabcontent p-1">
                            <?php } ?>
                            <table>
                                <tbody>
                                <tr>
                                    <?php if (isset($_GET['tab'])) {
                                        if ($_GET['tab'] == "test") { ?>
                                            <td style="width:40%;vertical-align: top;">
                                                <?php if (mysqli_num_rows($getTest) > 0){ ?>
                                                <?php for ($z = 0;
                                                $z < count($testResult);
                                                $z++){ ?>
                                                <?php if ($z < 1){ ?>
                                                <div class="test-container"
                                                     style="padding:10px;background-color:#d4ebf1;">
                                                    <?php }else{ ?>
                                                    <div class="test-container"
                                                         style="padding:10px;background-color:#d4ebf1;margin-top:8px">
                                                        <?php } ?>

                                                        <h4 style="margin:0"><?php echo $testResult[$z]['name']; ?></h4>
                                                        <p style="margin:8px 0 0 0;">
                                                            <strong><small>Audio
                                                                    Link:</small></strong>
                                                            <?php echo $testResult[$z]['audio_link']; ?>
                                                        <form action="update_audio_link.php"
                                                              method="post">
                                                            <input type="text"
                                                                   id="audioField<?php echo $testResult[$z]['id']; ?>"
                                                                   name="new_link"
                                                                   value="<?php echo $testResult[$z]['audio_link']; ?> "
                                                                   style="display:none;width: 98%;"/>
                                                            <input type="hidden"
                                                                   name="id"
                                                                   value="<?php echo $testResult[$z]['id']; ?>">
                                                            <button type="submit"
                                                                    id="audioBtn<?php echo $testResult[$z]['id']; ?>"
                                                                    style="display:none;">
                                                                SAVE
                                                            </button>
                                                            <button type="button"
                                                                    id="<?php echo "editBtn" . (string)$testResult[$z]['id']; ?>"
                                                                    onclick="showInputField(<?php echo "audioField" . (string)$testResult[$z]['id']; ?>,<?php echo "audioBtn" . (string)$testResult[$z]['id']; ?>,<?php echo "editBtn" . (string)$testResult[$z]['id']; ?>)">
                                                                EDIT
                                                            </button>
                                                        </form>
                                                        </p>
                                                        <p style="margin:8px 0 0 0;word-break:break-word">
                                                            <strong><small>Keywords:</small></strong>
                                                            <?php
                                                            $words = json_decode($testResult[$z]['keywords']);
                                                            $all_words = "";
                                                            for ($i = 0; $i < count($words); $i++) {
                                                                if ($i < 1) {
                                                                    echo '"' . $words[$i] . '"';
                                                                    $all_words = $all_words . '"' . $words[$i] . '"';
                                                                } else {
                                                                    echo ',"' . $words[$i] . '"';
                                                                    $all_words = $all_words . ',"' . $words[$i] . '"';
                                                                }

                                                            }
                                                            ?>
                                                        <form action="update_new_keywords.php"
                                                              method="post">
                                                            <textarea rows="5"
                                                                      id="wordsField<?php echo $testResult[$z]['id']; ?>"
                                                                      name="new_words"
                                                                      style="display:none;width: 98%;"/><?php print($testResult[$z]['keywords']); ?></textarea>
                                                            <input type="hidden"
                                                                   name="id"
                                                                   value="<?php echo $testResult[$z]['id']; ?>">
                                                            <input type="hidden"
                                                                   name="keyword_type"
                                                                   value="1">
                                                            <button type="submit"
                                                                    id="wordsBtn<?php echo $testResult[$z]['id']; ?>"
                                                                    style="display:none;">
                                                                SAVE
                                                            </button>
                                                            <button type="button"
                                                                    id="<?php echo "editWordsBtn" . (string)$testResult[$z]['id']; ?>"
                                                                    onclick="showInputField(<?php echo "wordsField" . (string)$testResult[$z]['id']; ?>,<?php echo "wordsBtn" . (string)$testResult[$z]['id']; ?>,<?php echo "editWordsBtn" . (string)$testResult[$z]['id']; ?>)">
                                                                EDIT
                                                            </button>
                                                        </form>
                                                        </p>
                                                        <p style="margin:8px 0 0 0;word-break:break-word">
                                                            <strong><small>Negative
                                                                    Keywords:</small></strong>
                                                            <?php
                                                            $words = json_decode($testResult[$z]['negative_keywords']);
                                                            $all_words = "";

                                                            if ($words != NULL) {
                                                                for ($i = 0; $i < count($words); $i++) {
                                                                    if ($i < 1) {
                                                                        echo '"' . $words[$i] . '"';
                                                                        $all_words = $all_words . '"' . $words[$i] . '"';
                                                                    } else {
                                                                        echo ',"' . $words[$i] . '"';
                                                                        $all_words = $all_words . ',"' . $words[$i] . '"';
                                                                    }

                                                                }
                                                            }
                                                            ?>
                                                        <form action="update_new_keywords.php"
                                                              method="post">
                                                            <textarea rows="5"
                                                                      id="negativewordsField<?php echo $testResult[$z]['id']; ?>"
                                                                      name="new_words"
                                                                      style="display:none;width: 98%;"/><?php print($testResult[$z]['negative_keywords']); ?></textarea>
                                                            <input type="hidden"
                                                                   name="id"
                                                                   value="<?php echo $testResult[$z]['id']; ?>">
                                                            <input type="hidden"
                                                                   name="keyword_type"
                                                                   value="2">
                                                            <button type="submit"
                                                                    id="negativewordsBtn<?php echo $testResult[$z]['id']; ?>"
                                                                    style="display:none;">
                                                                SAVE
                                                            </button>
                                                            <button type="button"
                                                                    id="<?php echo "editNegativeWordsBtn" . (string)$testResult[$z]['id']; ?>"
                                                                    onclick="showInputField(<?php echo "negativewordsField" . (string)$testResult[$z]['id']; ?>,<?php echo "negativewordsBtn" . (string)$testResult[$z]['id']; ?>,<?php echo "editNegativeWordsBtn" . (string)$testResult[$z]['id']; ?>)">
                                                                EDIT
                                                            </button>
                                                        </form>
                                                        </p>
                                                        <center>
                                                            <button type="submit"
                                                                    class="btn-danger"
                                                                    onclick="showModal(<?php echo "deleteTestModal" . (string)$testResult[$z]['id']; ?>)"
                                                                    style="margin-top:10px;">
                                                                DELETE
                                                            </button>
                                                        </center>
                                                        <div id="deleteTestModal<?php echo $testResult[$z]['id']; ?>"
                                                             class="modal">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <span class="close"
                                                                          onclick="closeModal(<?php echo "deleteTestModal" . (string)$testResult[$z]['id']; ?>)">&#x2716;</span>
                                                                    <h3 style="margin:0">
                                                                        Are you sure
                                                                        you want to
                                                                        remove?</h3>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                          action="delete_test.php">
                                                                        <input type="hidden"
                                                                               name="id"
                                                                               value="<?php echo $testResult[$z]['id']; ?>">
                                                                        <button type="submit"
                                                                                class="btn-danger"
                                                                                style="font-size:1rem;">
                                                                            Yes
                                                                        </button>
                                                                        <button type="button"
                                                                                class="btn-default"
                                                                                style="font-size:1rem;"
                                                                                onclick="closeModal(<?php echo "deleteTestModal" . (string)$testResult[$z]['id']; ?>)">
                                                                            No
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } else { ?>
                                                        <h4>No available test.</h4>
                                                    <?php } ?>
                                            </td>
                                            <td style="width:40%; padding:1.5rem 2rem;">
                                                <h4 style="margin-top:0">ADD NEW
                                                    TEST</h4>
                                                <form method="post"
                                                      action="add_test.php">
                                                    <div>
                                                        <label><small><strong>Test
                                                                    Name</strong></small></label>
                                                        <input type="text"
                                                               name="name"
                                                               style="width:97%"
                                                               required/>
                                                    </div>
                                                    <br/>
                                                    <div>
                                                        <label><small><strong>Audio
                                                                    Link</strong></small></label>
                                                        <input type="text"
                                                               name="link"
                                                               style="width:97%"
                                                               required/>
                                                    </div>
                                                    <br/>
                                                    <div>
                                                        <label><small><strong>Keywords
                                                                    Match</strong></small></label>
                                                        <div class="keywords-container">
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="primary_keywords_1"
                                                                       placeholder="Primary Keyword 1"
                                                                       required/>
                                                                <input type="text"
                                                                       name="alternative_keywords_1[]"
                                                                       placeholder="Alternative Keyword 1"/>
                                                                <button type="button"
                                                                        class="btn-1"
                                                                        onclick="addMoreAlternative(1)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="primary_keywords_2"
                                                                       placeholder="Primary Keyword 2"
                                                                       required/>
                                                                <input type="text"
                                                                       name="alternative_keywords_2[]"
                                                                       placeholder="Alternative Keyword 2"/>
                                                                <button type="button"
                                                                        class="btn-2"
                                                                        onclick="addMoreAlternative(2)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="primary_keywords_3"
                                                                       placeholder="Primary Keyword 3"
                                                                       required/>
                                                                <input type="text"
                                                                       name="alternative_keywords_3[]"
                                                                       placeholder="Alternative Keyword 3"/>
                                                                <button type="button"
                                                                        class="btn-3"
                                                                        onclick="addMoreAlternative(3)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="primary_keywords_4"
                                                                       placeholder="Primary Keyword 4"
                                                                       required/>
                                                                <input type="text"
                                                                       name="alternative_keywords_4[]"
                                                                       placeholder="Alternative Keyword 4"/>
                                                                <button type="button"
                                                                        class="btn-4"
                                                                        onclick="addMoreAlternative(4)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="primary_keywords_5"
                                                                       placeholder="Primary Keyword 5"
                                                                       required/>
                                                                <input type="text"
                                                                       name="alternative_keywords_5[]"
                                                                       placeholder="Alternative Keyword 5"/>
                                                                <button type="button"
                                                                        class="btn-5"
                                                                        onclick="addMoreAlternative(5)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="primary_keywords_6"
                                                                       placeholder="Primary Keyword 6"
                                                                       required/>
                                                                <input type="text"
                                                                       name="alternative_keywords_6[]"
                                                                       placeholder="Alternative Keyword 6"/>
                                                                <button type="button"
                                                                        class="btn-6"
                                                                        onclick="addMoreAlternative(6)">
                                                                    +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                                onclick="addKeyword()"
                                                                class="btn-default"
                                                                style="margin-top:12px">
                                                            + KEYWORD
                                                        </button>
                                                        <input type="hidden"
                                                               name="count_all_set"
                                                               id="count_all_set"
                                                               value="6"/>
                                                        <center>
                                                            <button type="submit"
                                                                    class="btn-success"
                                                                    style="font-size:15px;padding: 10px 2rem;">
                                                                SUBMIT
                                                            </button>
                                                        </center>
                                                    </div>
                                                    <br/>
                                                    <div>
                                                        <label><small><strong>Negative
                                                                    Keywords
                                                                    Match</strong></small></label>
                                                        <div class="negativekeywords-container">
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="negativeprimary_keywords_1"
                                                                       placeholder="Primary Keyword 1"
                                                                       required/>
                                                                <input type="text"
                                                                       name="negativealternative_keywords_1[]"
                                                                       placeholder="Alternative Keyword 1"/>
                                                                <button type="button"
                                                                        class="negativebtn-1"
                                                                        onclick="addMoreNegativeAlternative(1)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="negativeprimary_keywords_2"
                                                                       placeholder="Primary Keyword 2"
                                                                       required/>
                                                                <input type="text"
                                                                       name="negativealternative_keywords_2[]"
                                                                       placeholder="Alternative Keyword 2"/>
                                                                <button type="button"
                                                                        class="negativebtn-2"
                                                                        onclick="addMoreNegativeAlternative(2)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="negativeprimary_keywords_3"
                                                                       placeholder="Primary Keyword 3"
                                                                       required/>
                                                                <input type="text"
                                                                       name="negativealternative_keywords_3[]"
                                                                       placeholder="Alternative Keyword 3"/>
                                                                <button type="button"
                                                                        class="negativebtn-3"
                                                                        onclick="addMoreNegativeAlternative(3)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="negativeprimary_keywords_4"
                                                                       placeholder="Primary Keyword 4"
                                                                       required/>
                                                                <input type="text"
                                                                       name="negativealternative_keywords_4[]"
                                                                       placeholder="Alternative Keyword 4"/>
                                                                <button type="button"
                                                                        class="negativebtn-4"
                                                                        onclick="addMoreNegativeAlternative(4)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="negativeprimary_keywords_5"
                                                                       placeholder="Primary Keyword 5"
                                                                       required/>
                                                                <input type="text"
                                                                       name="negativealternative_keywords_5[]"
                                                                       placeholder="Alternative Keyword 5"/>
                                                                <button type="button"
                                                                        class="negativebtn-5"
                                                                        onclick="addMoreNegativeAlternative(5)">
                                                                    +
                                                                </button>
                                                            </div>
                                                            <div class="keywords-holder">
                                                                <input type="text"
                                                                       name="negativeprimary_keywords_6"
                                                                       placeholder="Primary Keyword 6"
                                                                       required/>
                                                                <input type="text"
                                                                       name="negativealternative_keywords_6[]"
                                                                       placeholder="Alternative Keyword 6"/>
                                                                <button type="button"
                                                                        class="negativebtn-6"
                                                                        onclick="addMoreNegativeAlternative(6)">
                                                                    +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                                onclick="addNegativeKeyword()"
                                                                class="btn-default"
                                                                style="margin-top:12px">
                                                            + KEYWORD
                                                        </button>
                                                        <input type="hidden"
                                                               name="negativecount_all_set"
                                                               id="negativecount_all_set"
                                                               value="6"/>
                                                        <center>
                                                            <button type="submit"
                                                                    class="btn-success"
                                                                    style="font-size:15px;padding: 10px 2rem;">
                                                                SUBMIT
                                                            </button>
                                                        </center>
                                                    </div>
                                                </form>
                                            </td>
                                        <?php } ?>
                                    <?php } ?>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php if (!empty($_GET)){ ?>
                        <?php if ($_GET['tab'] == "email"){ ?>
                        <div id="email_template" class="tabcontent show p-1">
                            <?php }else if ($_GET['tab'] == "approved"){ ?>
                            <div id="email_template" class="tabcontent p-1">
                                <?php }else if ($_GET['tab'] == "email"){ ?>
                                <div id="email_template" class="tabcontent p-1">
                                    <?php }else{ ?>
                                    <div id="email_template" class="tabcontent p-1">
                                        <?php } ?>
                                        <?php }else{ ?>
                                        <div id="email_template"
                                             class="tabcontent p-1">
                                            <?php } ?>

                                            <p><strong>EMAILS</strong></p>
                                            <table style="border:0;">
                                                <tbody>
                                                <?php if (isset($_GET['tab'])) {
                                                    if ($_GET['tab'] == "email") { ?>
                                                        <tr>
                                                            <td style="width:40%;vertical-align: top;border:0;">
                                                                <small>APPROVE
                                                                    EMAIL</small>&ensp;<strong
                                                                        style="font-size: 12px;">JOB
                                                                    TYPE:
                                                                    TRANSCRIBER</strong>
                                                                <br/>
                                                                <form action="save_approve_email_template.php"
                                                                      method="post">
                                                                    <input type="hidden"
                                                                           name="id"
                                                                           value="1">
                                                                    <input type="hidden"
                                                                           name="type"
                                                                           value="1">
                                                                    <textarea
                                                                            name="content"
                                                                            rows="15"
                                                                            style="width:100%;"><?php echo htmlentities(urldecode($approveEmailTemplate[0]['content'])); ?></textarea>
                                                                    <button type="submit"
                                                                            class="btn-success"
                                                                            style="font-size:12px;">
                                                                        UPDATE
                                                                    </button>
                                                                </form>
                                                                <br/>
                                                                <small>APPROVE
                                                                    EMAIL</small>&ensp;<strong
                                                                        style="font-size: 12px;">JOB
                                                                    TYPE:
                                                                    TRANSCRIBER</strong>
                                                                <br/>
                                                                <form action="save_approve_email_template.php"
                                                                      method="post">
                                                                    <input type="hidden"
                                                                           name="id"
                                                                           value="2">
                                                                    <input type="hidden"
                                                                           name="type"
                                                                           value="2">
                                                                    <textarea
                                                                            name="content"
                                                                            rows="15"
                                                                            style="width:100%;"><?php echo htmlentities(urldecode($approveEmailTemplate[1]['content'])); ?></textarea>
                                                                    <button type="submit"
                                                                            class="btn-success"
                                                                            style="font-size:12px;">
                                                                        UPDATE
                                                                    </button>
                                                                </form>
                                                                <br/>
                                                                <small>AUTO CREATE
                                                                    ACCOUNT</small>&ensp;<strong
                                                                        style="font-size: 12px;">JOB
                                                                    TYPE:
                                                                    TRANSCRIBER</strong>
                                                                <br/>
                                                                <form action="save_approve_email_template.php"
                                                                      method="post">
                                                                    <input type="hidden"
                                                                           name="id"
                                                                           value="3">
                                                                    <input type="hidden"
                                                                           name="type"
                                                                           value="3">
                                                                    <textarea
                                                                            name="content"
                                                                            rows="15"
                                                                            style="width:100%;"><?php echo htmlentities(urldecode($approveEmailTemplate[2]['content'])); ?></textarea>
                                                                    <button type="submit"
                                                                            class="btn-success"
                                                                            style="font-size:12px;">
                                                                        UPDATE
                                                                    </button>
                                                                </form>
                                                                <br/>
                                                                <small>AUTO CREATE
                                                                    ACCOUNT</small>&ensp;<strong
                                                                        style="font-size: 12px;">JOB
                                                                    TYPE:
                                                                    TRANSCRIBER</strong>
                                                                <br/>
                                                                <form action="save_approve_email_template.php"
                                                                      method="post">
                                                                    <input type="hidden"
                                                                           name="id"
                                                                           value="4">
                                                                    <input type="hidden"
                                                                           name="type"
                                                                           value="4">
                                                                    <textarea
                                                                            name="content"
                                                                            rows="15"
                                                                            style="width:100%;"><?php echo htmlentities(urldecode($approveEmailTemplate[3]['content'])); ?></textarea>
                                                                    <button type="submit"
                                                                            class="btn-success"
                                                                            style="font-size:12px;">
                                                                        UPDATE
                                                                    </button>
                                                                </form>
                                                            </td>
                                                            <td style="width:40%;vertical-align: top;border:0"
                                                                class="follow-up-email-container">
                                                                <?php for ($d = 0; $d < count($followupEmailTemplate); $d++) { ?>
                                                                    <div class="follow-up-emails">
                                                                        <small>FOLLOW
                                                                            UP
                                                                            EMAILS</small>
                                                                        <br/>
                                                                        <form action="save_followup_email_template.php"
                                                                              method="post">
                                                                            <textarea
                                                                                    name="content"
                                                                                    rows="15"
                                                                                    style="width:100%;"><?php echo htmlentities(urldecode($followupEmailTemplate[$d]['content'])); ?></textarea>
                                                                            <br/>
                                                                            <small>Delayed
                                                                                Time </small><input
                                                                                    type="number"
                                                                                    value="<?php echo $followupEmailTemplate[$d]['delayed_time']; ?>"
                                                                                    min="1"
                                                                                    max="9999999"
                                                                                    name="delayed_time"
                                                                                    required>
                                                                            <small>hrs</small>
                                                                            &ensp;<select
                                                                                    name="type"
                                                                                    required>followupEmailTemplate
                                                                                <option value="1" <?php if ($followupEmailTemplate[$d]['type'] == 1) echo "selected"; ?>>
                                                                                    Transcriber
                                                                                </option>
                                                                            </select>
                                                                            <input type="hidden"
                                                                                   name="id"
                                                                                   value="<?php echo $followupEmailTemplate[$d]['id']; ?>">
                                                                            <div style="float:right">
                                                                                <button type="submit"
                                                                                        class="btn-success"
                                                                                        style="font-size:12px;">
                                                                                    UPDATE
                                                                                </button>
                                                                                <button class="btn-danger"
                                                                                        type="button"
                                                                                        style="font-size:12px;"
                                                                                        onclick="showModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">
                                                                                    DELETE
                                                                                </button>
                                                                            </div>
                                                                        </form>

                                                                        <div id="deleteFollowupModal<?php echo $followupEmailTemplate[$d]['id']; ?>"
                                                                             class="modal">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <span class="close"
                                                                                          onclick="closeModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">&#x2716;</span>
                                                                                    <h3 style="margin:0">
                                                                                        Are
                                                                                        you
                                                                                        sure
                                                                                        you
                                                                                        want
                                                                                        to
                                                                                        remove?</h3>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form method="post"
                                                                                          action="delete_followup_email.php">
                                                                                        <input type="hidden"
                                                                                               name="id"
                                                                                               value="<?php echo $followupEmailTemplate[$d]['id']; ?>">
                                                                                        <button type="submit"
                                                                                                class="btn-danger"
                                                                                                style="font-size:1rem;">
                                                                                            Yes
                                                                                        </button>
                                                                                        <button type="button"
                                                                                                class="btn-default"
                                                                                                style="font-size:1rem;"
                                                                                                onclick="closeModal(<?php echo "deleteFollowupModal" . (string)$followupEmailTemplate[$d]['id']; ?>)">
                                                                                            No
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                <?php } ?>
                                                                <button class="btn-default btn-add-follow-up-email"
                                                                        onclick="addNewFollowupEmail()"
                                                                        type="button">
                                                                    + ADD NEW FOLLOW
                                                                    UP EMAIL
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                            <div id="deleteAllModal" class="modal">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <span class="close"
                                                              onclick="closeDeleteAllModal()">&#x2716;</span>
                                                        <h3 style="margin:0">Are you
                                                            sure you want to remove
                                                            all?</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post"
                                                              action="remove_all_staff.php">
                                                            <input type="hidden"
                                                                   name="staff_ids">
                                                            <button type="submit"
                                                                    class="btn-danger"
                                                                    style="font-size:1rem;">
                                                                Yes
                                                            </button>
                                                            <button type="button"
                                                                    class="btn-default"
                                                                    style="font-size:1rem;"
                                                                    onclick="closeDeleteAllModal()">
                                                                No
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="deleteQuestionModal"
                                                 class="modal">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <span class="close"
                                                              onclick="closeDeleteQuestionModal()">&#x2716;</span>
                                                        <h3 style="margin:0">Are you
                                                            sure you want to
                                                            remove?</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post"
                                                              action="remove_question.php">
                                                            <input type="hidden"
                                                                   name="question_id">
                                                            <button type="submit"
                                                                    class="btn-danger"
                                                                    style="font-size:1rem;">
                                                                Yes
                                                            </button>
                                                            <button type="button"
                                                                    class="btn-default"
                                                                    style="font-size:1rem;"
                                                                    onclick="closeDeleteQuestionModal()">
                                                                No
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="addQuestionModal"
                                                 class="modal">
                                                <div class="modal-content"
                                                     style="width:40%">
                                                    <div class="modal-header">
                                                        <span class="close"
                                                              onclick="closeModal(addQuestionModal)">&#x2716;</span>
                                                        <h3 style="margin:0">Add
                                                            Question</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post"
                                                              action="add_question.php">
                                                            <div>
                                                                <label><strong>Question</strong></label>
                                                                <br/>
                                                                <textarea
                                                                        name="question"
                                                                        style="width:100%"></textarea>
                                                            </div>
                                                            <br/>
                                                            <div>
                                                                <label><strong>Add
                                                                        Choices</strong></label>
                                                                <button type="button"
                                                                        id="addMoreChoices">
                                                                    +
                                                                </button>
                                                                <br/>
                                                                <small><i>Click the
                                                                        radio for
                                                                        correct
                                                                        answer.</i></small>
                                                                <br/>
                                                                <br/>
                                                                <div id="choices">
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <button type="submit"
                                                                    class="btn-success"
                                                                    style="font-size:1rem;">
                                                                SAVE
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
        
        <script src="../js/jquery.min.js"
                crossorigin="anonymous"></script>
        <script>
            var cnt = 7;
            var count_choices = 0;
            $(document).ready(function () {
                $("#addMoreChoices").click(function () {
                    $('#choices').append('<div class="row"><input type="text" name="choices[]"><input type="radio" name="answer" value=' + count_choices + ' required></div>');
                    count_choices += 1;
                });
            });

            function minTagRating(n) {
                var rating = $(n).val();
                $('.remove_all').prop('checked', false);

                for (var x = 0; x < rating; x++) {
                    var cl = ".rating" + x + " .remove_all";
                    $(cl).prop('checked', true);
                }
            }

            function tagduplicateip() {

                $('.remove_all').prop('checked', false);
                $('.duplicateip .remove_all').prop('checked', true);

            }

            function tagnocode() {

                $('.remove_all').prop('checked', false);
                $('.nocode .remove_all').prop('checked', true);

            }

            function tagnegativekeyword() {

                $('.remove_all').prop('checked', false);
                $('.negative-keyword-content .remove_all').prop('checked', true);

            }

            function addNewFollowupEmail() {
                $(".btn-add-follow-up-email").before('<div class="follow-up-emails"> <small>FOLLOW UP EMAILS</small> <br/><form action="add_followup_email_template.php" method="post"><textarea name="content" rows="15" style="width:100%;"></textarea><br/> <small>Delayed Time </small><input type="number" min="1" max="9999999" name="delayed_time" required> <small>hrs</small> &ensp;<select name="type" required>followupEmailTemplate<option value="1">Transcriber</option> </select><div style="float:right"> <button type="submit" class="btn-success" style="font-size:12px;">SAVE</button></div></form></div> <br/>');
            }

            function addKeyword() {
                $(".keywords-container").append('<div class="keywords-holder"><input type="text" name="primary_keywords_' + cnt + '" placeholder="Primary Keyword ' + cnt + '" required /> <input type="text" name="alternative_keywords_' + cnt + '[]" placeholder="Alternative Keyword ' + cnt + '" /> <button type="button" class="btn-' + cnt + '" onclick="addMoreAlternative(' + cnt + ')">+</button></div>');
                $("#count_all_set").val(cnt);
                cnt += 1;
            }

            function addNegativeKeyword() {
                $(".negativekeywords-container").append('<div class="keywords-holder"><input type="text" name="negativeprimary_keywords_' + n_cnt + '" placeholder="Primary Keyword ' + n_cnt + '" required /> <input type="text" name="negativealternative_keywords_' + n_cnt + '[]" placeholder="Alternative Keyword ' + n_cnt + '" /> <button type="button" class="negativebtn-' + n_cnt + '" onclick="addMoreNegativeAlternative(' + n_cnt + ')">+</button></div>');
                $("#negativecount_all_set").val(n_cnt);
                n_cnt += 1;
            }

            function addMoreNegativeAlternative(n) {
                $(".negativebtn-" + n + "").before(' <input type="text" name=negativealternative_keywords_' + n + '[] placeholder="Alternative Keyword ' + n + '" /> ');
            }

            function addMoreAlternative(n) {
                $(".btn-" + n + "").before(' <input type="text" name=alternative_keywords_' + n + '[] placeholder="Alternative Keyword ' + n + '" /> ');
                //$(".alternative_keywords_"+n+"").append('<input type="text" name=alternative_keywords_'+n+'[] placeholder="Alternative Keyword" />');
            }

            function showModal(id) {
                id.style.display = "block";
            }

            function showDeleteAllApprovedModal() {

                var checkedVals = $('.remove_all_approved:checkbox:checked').map(function () {
                    return this.value;
                }).get();

                document.getElementById('deleteAllModal').style.display = "block";
                $('input[name=staff_ids]').val(checkedVals.join(","));

            }

            function showRemoveQuestion(id) {

                document.getElementById('deleteQuestionModal').style.display = "block";
                $('#deleteQuestionModal input[name=question_id]').val(id);

            }

            function closeDeleteQuestionModal() {

                document.getElementById('deleteQuestionModal').style.display = "none";

            }

            function showDeleteAllPendingModal() {

                var checkedVals = $('.remove_all:checkbox:checked').map(function () {
                    return this.value;
                }).get();

                document.getElementById('deleteAllModal').style.display = "block";
                $('input[name=staff_ids]').val(checkedVals.join(","));

            }

            function closeDeleteAllModal() {
                document.getElementById('deleteAllModal').style.display = "none";
            }

            function showInputField(field, button, editBtn) {
                field.style.display = "block";
                button.style.display = "block";
                editBtn.style.display = "none";
            }

            function closeModal(id) {
                id.style.display = "none";
            }

            function openTab(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                document.getElementById("transcription").style.display = "block";
                evt.currentTarget.className += " active";
            }

            function openT(evt, cityName) {

                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                if (cityName == "transcription") {
                    document.getElementById("pending").style.display = "block";
                }
                evt.currentTarget.className += " active";
            }
        </script>
</body>
</html>

<?php session_destroy(); ?>