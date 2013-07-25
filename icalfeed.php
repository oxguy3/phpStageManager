<?php
require_once('config.php');

//$brt = "\n    ";

$link = startmysql();
//$sql = "SELECT * FROM `" . $sql_pref . "events` WHERE `dtstamp` LIKE '" . date('Y') . "-" . date('m') . "-% %:%:%' LIMIT 0, 100 "; //LIMIT PREVENTS MORE THAN 100 EVENTS EXISTING IN ONE MONTH
$sql = "SELECT * FROM `" . $sql_pref . "events`";//" LIMIT 0, 1000 "; //1000 event limit, so that nothing explodes
$result = mysql_query($sql) or die("Query failed:\n" . mysql_error());

header('Content-type: text/calendar');

//action_log("iCalendar accessed, user agent: " . $_SERVER['HTTP_USER_AGENT']);

echo "BEGIN:VCALENDAR" . $br;
echo "VERSION:2.0" . $br;
//echo "PRODID:-//Microsoft Corporation//Windows Calendar 1.0//EN" . $br;
echo "PRODID:-//Hayden Schiff//phpStageManager//EN" . $br;
echo "METHOD:PUBLISH" . $br;
//echo "X-WR-TIMEZONE:America/New_York";

//PRODID:-//Apple Inc.//iCal 3.0//EN
//METHOD:PUBLISH

$titleappend = "";
$descriptionappend = "";

if (isset($_GET['onlyrole'])) {
	$titleappend = " (custom roles)";
	$descriptionappend = " (roles: ".$_GET['onlyrole'].")";
}

echo "X-WR-CALNAME:" . prepareTextIcal($sitetitle . $titleappend) . $br; 
echo "X-WR-CALDESC:" . prepareTextIcal($sitedescription . $descriptionappend) . $br;


if (isset($_GET['onlyrole'])) {
	
	$onlyrolep = $_GET['onlyrole'];
	
	if (mysql_real_escape_string($onlyrolep)!=$onlyrolep) {
		die("Your onlyrole parameter contains invalid characters.");
	}
	
	
	
	$onlyrolepex = explode(",", $onlyrolep);
	
	for ($j = 0; $j < count($onlyrolepex); $j++) {
		if (preg_replace('#([^0-9])#imx', '', $onlyrolepex[$j])!=$onlyrolepex[$j]) { ////from http://stackoverflow.com/a/2788781/992504
			die("Invalid role: " . $onlyrolepex[$j]);
		}
		
		$sqlr = "SELECT * FROM `" . $sql_pref . "roles` WHERE `id` = " . $onlyrolepex[$j] . " LIMIT 0, 1 ";
		$resultr = mysql_query($sqlr) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");
		$rowr = mysql_fetch_row($resultr);
		$usersctext = "";
		if ($j!=0){
			$usersctext .= ",";
		}
		$usersctext .= $rowr[2];
	}
	
	$userscarr = array_unique(explode(",", $usersctext));
}




for($i=0; $i < mysql_num_rows($result); $i++) {
	
	//$line = mysql_fetch_array($result, MYSQL_ASSOC)
	$row = mysql_fetch_row($result);
	
	
	
	
	
	
	if (isset($_GET['onlyrole'])) {
		//if there are no scenes common to the user and this event, skip this event
		if (count(array_intersect($userscarr, explode(",", $row[8])))==0) {
			continue;
		}
	}
	
	
	
	
	if ($i!=0){
		echo $br;
	}
	echo "BEGIN:VEVENT" . $br;
	echo "UID:" . date("Ymd") . "T" . date("His") . "Z" . "-" . $row[1] . "@" . $sitedomain . $br;
	
	//from http://www.randomsnippets.com/2008/10/05/how-to-convert-mysql-timestamp-to-php-date-type/
	echo "DTSTAMP:" . date("Ymd", strtotime($row[3])) . "T" . date("His", strtotime($row[3])) . "Z" . $br; //the "Z" is because DTSTAMP is stored in UTC instead of EST
	
	echo "DTSTART:" . date("Ymd", strtotime($row[4])) . "T" . date("His", strtotime($row[4])) . "Z" . $br;
	echo "DTEND:" . date("Ymd", strtotime($row[5])) . "T" . date("His", strtotime($row[5])) . "Z" . $br;
		
	/*if ($row[9]==1) { //if all day event
		//echo "DTSTART;VALUE=DATE:TZID=America/New_York:" . date("Ymd", strtotime($row[4])) . $br;
		//echo "DTEND;VALUE=DATE:TZID=America/New_York:" . date("Ymd", strtotime($row[5])) . $br;
		echo "X-MICROSOFT-CDO-ALLDAYEVENT:TRUE" . $br;
		//echo "X-FUNAMBOL-ALLDAY:TRUE" . $br;
		
	} else { //if normal event
		//echo "DTSTART;TZID=America/New_York:" . date("Ymd", strtotime($row[4])) . "T" . date("His", strtotime($row[4])) . $br;
		//echo "DTEND;TZID=America/New_York:" . date("Ymd", strtotime($row[5])) . "T" . date("His", strtotime($row[5])) . $br;
		echo "X-MICROSOFT-CDO-ALLDAYEVENT:FALSE" . $br;
		//echo "X-FUNAMBOL-ALLDAY:FALSE" . $br;
	}*/
	
	
	$sqlu = "SELECT * FROM `" . $sql_pref . "users` WHERE `id` = " . $row[6] . " LIMIT 0, 1 ";
	$resultu = mysql_query($sqlu) or die("Query failed:\n" . mysql_error());
	$rowu = mysql_fetch_row($resultu);
	echo "ORGANIZER;CN=" . prepareTextIcal($rowu[4]) . " " . prepareTextIcal($rowu[5]); //ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com
	if ($rowu[9]!="0") {
		echo ":MAILTO:" . prepareTextIcal($rowu[9]);
	}
	echo $br;
	
	
	if ($row[0]!="@") { //for events with legit titles
		/*if ($row[11]==3) { //if the event is cancelled, make note of it in the title because iCal ignores STATUS
			echo "SUMMARY:CANCELLED - " . prepareTextIcal($row[0]) . $br;
		} else {*/
			echo "SUMMARY:" . prepareTextIcal($row[0]) . $br;
		//}
		
	} else { //for events with no real title
		$scarray = getRanges( explode(",", $row[8]) );
		/*if ($row[11]==3) { //if the event is cancelled, make note of it in the title because iCal ignores STATUS
			echo "SUMMARY:CANCELLED - Sc. ";
		} else {*/
			echo "SUMMARY:Sc. ";
		//}
		//echo "SUMMARY:Sc. ";
		for ($w=0; $w < count($scarray); $w++) {
			if ($w!=0) {
				echo ", ";
			}
			echo $scarray[$w];
		}
		echo $br;
	}
	
	if ($row[7]!="0"&&$row[7]!="") {
		echo "DESCRIPTION:" . prepareTextIcal($row[7]) . $br; //aka comments
	}
	
	if ($row[2]!="0"&&$row[2]!="") {
		echo "LOCATION:" . prepareTextIcal($row[2]) . $br;
	}
	
	if($row[11]==1) {
		echo "STATUS:TENTATIVE" . $br;
	} else if ($row[11]==2) {
		echo "STATUS:CONFIRMED" . $br;
	} else if ($row[11]==3) {
		echo "STATUS:CANCELLED" . $br;
	}
	
	echo "URL:".$siteaddr."/viewevent.php?id=" . $row[1] . $br;
	
	////////
	////TODO: Consider using the ATTENDEE attrib: http://tools.ietf.org/html/rfc5545#section-3.8.4.1
	////BIG TODO: Make the allDay variable get included!!!
	////////
	
	//echo "    \"allDay\" : " . $row[9] . "," . $br;
	
	
	//echo "    \"start\" : \"" . $row[4]/* . " EST"*/ . "\"," . $br;
	//echo "    \"end\" : \"" . $row[5]/* . " EST"*/ . "\"," . $br;
	//echo "    \"scenes\" : \"" . $row[8] . "\"," . $br;
	//echo "    \"showscenes\" : " . $row[10] . "," . $br;
	
	
	echo "END:VEVENT";
	
}
echo $br . "END:VCALENDAR";

mysql_free_result($result);
mysql_free_result($resultu);
mysql_close($link);
?>
