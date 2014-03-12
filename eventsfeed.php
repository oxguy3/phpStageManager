<?php
require_once('config.php');

$brt = "\n    ";

$link = startmysql();
//$sql = "SELECT * FROM `" . $sql_pref . "events` WHERE `dtstamp` LIKE '" . date('Y') . "-" . date('m') . "-% %:%:%' LIMIT 0, 100 "; //LIMIT PREVENTS MORE THAN 100 EVENTS EXISTING IN ONE MONTH


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
		if ($j!=0){
			$usersctext .= ",";
		}
		$usersctext .= $rowr[2];
	}
	
	$userscarr = array_unique(explode(",", $usersctext . ",0")); // ",0" added to allow scene 0 to function as a catch-all
}

$sql = "SELECT * FROM `" . $sql_pref . "events`";//" LIMIT 0, 1000 "; //1000 event limit, so that nothing explodes
$result = mysql_query($sql) or die("Query failed:\n" . mysql_error());

//header('Content-type: application/json');

echo "[";

$hassentfirstrow = false;

for ($i=0; $i < mysql_num_rows($result); $i++) {
	
	$echotext = "";
	
	//$line = mysql_fetch_array($result, MYSQL_ASSOC)
	$row = mysql_fetch_row($result);
	
	
	if (isset($_GET['onlyrole'])) {
		//if there are no scenes common to the user and this event, skip this event
		if (count(array_intersect($userscarr, explode(",", $row[8])))==0) {
			continue;
		}
	}
	
	
	if (/*$i!=0*/$hassentfirstrow){
		$echotext .= ",";
	}
	$echotext .= $brt . "{" . $brt;
	
	if ($row[0]!="@") { //for events with legit titles
		$echotext .= "    \"title\" : \"" . $row[0] . "\"," . $brt;
		
	} else { //for events with no real title
		$scarray = getRanges( explode(",", $row[8]) );
		$echotext .= "    \"title\" : \"Sc. ";
		for ($w=0; $w < count($scarray); $w++) {
			if ($w!=0) {
				$echotext .= ", ";
			}
			$echotext .= $scarray[$w];
		}
		$echotext .= "\"," . $brt;
	}
	
	$echotext .= "    \"start\" : \"" . date("c", strtotime($row[4])) . "\"," . $brt;
	$echotext .= "    \"end\" : \"" . date("c", strtotime($row[5])) . "\"," . $brt;
	$echotext .= "    \"allDay\" : " . $row[9] . "," . $brt;
	
	$echotext .= "    \"comments\" : \"" . $row[7] . "\"," . $brt;
	$echotext .= "    \"scenes\" : \"" . $row[8] . "\"," . $brt;
	$echotext .= "    \"id\" : \"" . $row[1] . "\"," . $brt;
	$echotext .= "    \"location\" : \"" . $row[2] . "\"," . $brt;
	$echotext .= "    \"showscenes\" : " . $row[10] . "," . $brt;
	$echotext .= "    \"url\" : \"" . $siteaddr . "/viewevent.php?" . /* htmlspecialchars(SID) . "&" .*/ "id=" . $row[1] . "\"," . $brt;
	
	$evstatus="";
	$evcolor="";
	if ($row[11]==1) {
		$evstatus = "Tentative";
		$evcolor = "#36c";
	} else if ($row[11]==2) {
		$evstatus = "Confirmed";
		$evcolor = "#3c6";
	} else if ($row[11]==3) {
		$evstatus = "Cancelled";
		$evcolor = "#c36";
	} else {
		$evstatus = "Unknown";
		$evcolor = "#555";
	}
	$echotext .= "    \"status\" : \"" . $evstatus . "\"," . $brt;
	$echotext .= "    \"color\" : \"" . $evcolor . "\"," . $brt;
	
	$sqlu = "SELECT * FROM `" . $sql_pref . "users` WHERE `id` = " . $row[6] . " LIMIT 0, 1 ";
	$resultu = mysql_query($sqlu) or die("Query failed:\n" . mysql_error());
	$rowu = mysql_fetch_row($resultu);
	$echotext .= "    \"username\" : \"" . $rowu[1] . "\"" . $brt;
	
	$echotext .= "}";
	
	echo $echotext;
	
	$hassentfirstrow = true;
	
}
echo $br . "]";

mysql_free_result($result);
mysql_free_result($resultu);
mysql_close($link);
?>