<?php
require '../vendor/autoload.php';

require '../config/database.php';

class CalculateScore{

    public function calculateTestScore($userContent,$testDataKeywords,$testDataNegativeKeywords){

        $content = htmlentities(urldecode($userContent));
        $kerywords = json_decode($testDataKeywords);
        $negative_keywords = json_decode($testDataNegativeKeywords);
        $score = 0;
        $total = count($kerywords);
        $totalNegative = count($negative_keywords);
        $not_included_words = "";
        $negative_included_words = "";
        $not_included = 0;
        for ($a = 0; $a < $total; $a++) {

            $words = explode("|", $kerywords[$a]);
            $not_included = 0;
            $chk = 0;

            for ($z = 0; $z < count($words); $z++) {
                if ($z < 1) {
                    if (stripos($content, $words[$z]) > 0 && stripos($content, $words[$z]) !== FALSE) {
                        $score += 1;
                    } else {
                        $not_included = 1;
                    }
                }
                if ($z > 0 && stripos($content, $words[0]) < 1) {
                    if (stripos($content, $words[$z]) > 0 && stripos($content, $words[$z]) !== FALSE) {
                        $score += 1;
                        $not_included = 0;
                        $chk = 1;
                    } else {
                        if ($chk != 1) {
                            $not_included = 1;
                        }
                    }
                }

            }
            if ($not_included == 1) {
                $not_included_words = $not_included_words . "<span>" . $words[0] . "</span>";
            }
        }

        for ($a = 0; $a < $totalNegative; $a++) {

            $words = explode("|", $negative_keywords[$a]);
            $not_included = 0;
            $chk = 0;

            for ($z = 0; $z < count($words); $z++) {
                if ($z < 1) {
                    if (stripos($content, $words[$z]) > 0 && stripos($content, $words[$z]) !== FALSE) {
                        $score += 1;

                    } else {
                        $not_included = 1;
                    }
                }
                if ($z > 0 && stripos($content, $words[0]) < 1) {
                    if (stripos($content, $words[$z]) > 0 && stripos($content, $words[$z]) !== FALSE) {
                        $score += 1;
                        $not_included = 0;
                        $chk = 1;
                    } else {

                        if ($chk != 1) {
                            $not_included = 1;
                        }

                    }
                }

            }
            if ($not_included == 0) {
                $negative_included_words = $negative_included_words . "<span style='background-color:#f19c00'>" . $words[0] . "</span>";
            }
        }

        $dataArray = array(
            'total_keyword' => $total,
            'score' => $score,
            'not_included_words' => $not_included_words,
            'negative_included_words' => $negative_included_words,
            'not_included' => $not_included,
            'content' => $content,
        );

        return $dataArray;
    }

    public function user_single_test_result($testID,$testCon){
        global $db;
        $getTestDataDB = mysqli_query($db, "SELECT * FROM ts_test WHERE id=".$testID);
        $testDataResultDB = mysqli_fetch_all($getTestDataDB, MYSQLI_ASSOC);

        $tFunScore = $this->calculateTestScore($testCon,$testDataResultDB[0]['keywords'],$testDataResultDB[0]['negative_keywords']);

        return $tFunScore;
    }

    public function negative_keyword_not_included($testID,$testCon){
        global $db;
        $getTestDataDB = mysqli_query($db, "SELECT * FROM ts_test WHERE id=".$testID);
        $testDataResultDB = mysqli_fetch_all($getTestDataDB, MYSQLI_ASSOC);

        $content = htmlentities(urldecode($testCon));
        $kerywords = json_decode($testDataResultDB[0]['keywords']);
        $negative_keywords = json_decode($testDataResultDB[0]['negative_keywords']);

        $totalNegative = count($negative_keywords);
        $negative_included_words = "";

        for ($a = 0; $a < $totalNegative; $a++) {

            $words = explode("|", $negative_keywords[$a]);
            $not_included = 0;
            $chk = 0;

            for ($z = 0; $z < count($words); $z++) {
                if ($z < 1) {
                    if (stripos($content, $words[$z]) > 0 && stripos($content, $words[$z]) !== FALSE) {
                        //$score += 1;

                    } else {
                        $not_included = 1;
                    }
                }
                if ($z > 0 && stripos($content, $words[0]) < 1) {
                    if (stripos($content, $words[$z]) > 0 && stripos($content, $words[$z]) !== FALSE) {
                        //$score += 1;
                        $not_included = 0;
                        $chk = 1;
                    } else {

                        if ($chk != 1) {
                            $not_included = 1;
                        }

                    }
                }

            }

            return $not_included;

        }

    }



}

?>