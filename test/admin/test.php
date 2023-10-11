<?php
require 'config/database.php';
require 'controller/crud.php';

$crud = new Crud();
$getData = mysqli_query($db, "SELECT * FROM ts_test WHERE id='4'");
$result = mysqli_fetch_all($getData, MYSQLI_ASSOC);
$score = 0;
$content = "<p style='white-space:pre-wrap'>Interviewee: I worked there for nearly 6 years, in charge of anti-trafficking programing labor migrations. But before I am in Indonesia. I work for the UNHCR, the United Nations High Commissioner for Refugees, that's why after I returned back from Hong Kong for 3 year with the UNHCR and then back in Hong Kong, I was 8 years living in Hong Kong, from the year of 2000 to 2007, end of 2007. And then at the beginning of Jan 2008, I moved to Indonesia. And now back here.
 
Interviewer: Alright and you, you said you worked  for an ngo before?
 
Interviewee: I worked in Hong Kong for regional ngos called the Asian Migrant Center. That's exactly during the year of 2000 to 2007 when I'm here.
 
Interviewer: And what did that organization do?
 
Interviewee: Asian Migrant Center is basically a Regional ngos just somehow based in Hong Kong. We are doing a lot of advocacy policy. We are also doing, you know, you know conducting research, we publishing Asian migrant yearbook. And then we are doing a lot of capacity building programming for the ngos. But somehow, my responsibility at that time was actually in-charge of the domestic workers programming. So I’m Interviewee: I worked there for nearly 6 years, in charge of anti-trafficking programing labor migrations. But before I am in Indonesia. I work for the UNHCR, the United Nations High Commissioner for Refugees, that's why after I returned back from Hong Kong for 3 year with the UNHCR and then back in Hong Kong, I was 8 years living in Hong Kong, from the year of 2000 to 2007, end of 2007. And then at the beginning of Jan 2008, I moved to Indonesia. And now back here.
 
Interviewer: Alright and you, you said you worked  for an ngo before?
 
Interviewee: I worked in Hong Kong for regional ngos called the Asian Migrant Center. That's exactly during the year of 2000 to 2007 when I'm here.
 
Interviewer: And what did that organization do?
 
Interviewee: Asian Migrant Center is basically a Regional ngos just somehow based in Hong Kong. We are doing a lot of advocacy policy. We are also doing, you know, you know conducting research, we publishing Asian migrant yearbook. And then we are doing a lot of capacity building programming for the ngos. But somehow, my responsibility at that time was actually in-charge of the domestic workers programming.</p>";

echo "<strong>Content:</strong>";
echo $content;
echo "<br/>";

echo "<strong>Match Score:</strong>";
echo "<br/>";

echo "<br/>";
$kerywords = json_decode($result[0]['keywords']);

for($x=0;$x< count($kerywords); $x++){
	
	$words = explode("|", $kerywords[$x]);
	$primary = $words[0];
	$alertnative = explode(",", $words[1]);
	
	if(stripos($content,$primary) > 0 && stripos($content,$primary) !== FALSE ){
		$score += 1;
	}else{
		for($y=0;$y< count($alertnative); $y++){
			if(preg_match('/\b'.$alertnative[$y].'\b/', $content)){
				$score += 1;
			}
		}
	}
	
}
echo $score;

?>