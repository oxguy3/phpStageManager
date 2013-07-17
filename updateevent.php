<?php
require_once('config.php');

//header('Content-type: text/plain'); ////NOTE: REMOVE WHEN DONE TESTING -- WE DON'T NEED NO STINKIN' HEADERS!!


/*if (!isset($_SESSION['user'])) {
	die("You must be logged in to do that.");
}*/
mustBeLoggedIn();
if (intval($_SESSION['permission']) < 1) {
	die("You don't have permission to do that.");
}

$link = startmysql();


////////////////////////////////////////////////////////////////////////
//// IMPORTANT:
//// Should I deal with scenarios where not all variables are set?
//// a:NOPE, just kill them with fire
////////////////////////////////////////////////////////////////////////


if (!isset($_POST['ev-id'])) {
	die("You did not specify an event ID; all parameters are required.");
}
$evidp = $_POST['ev-id'];

if ($evidp!="new") {

	if (mysql_real_escape_string($evidp)!=$evidp) {
		die("Your event ID contains invalid characters.");
	}
	if (!is_numeric($evidp)) {
		die("Your event ID is not a number.");
	}
	if (strpos(".", $evidp)!=false||strpos("+", $evidp)!=false||strpos("-", $evidp)!=false||strpos("e", $evidp)!=false) { //i feel like SUCH a lazy programmer :P
		die("Your event ID contains an invalid character.");
	}
	$evidcl = mysql_real_escape_string($evidp);
}

if (!isset($_POST['ev-delete'])) {
	
	if (!isset($_POST['ev-scenes'])) {
		die("You did not specify a scenes parameter; all parameters are required.");
	}
	$scenesp = $_POST['ev-scenes'];
	
	if (mysql_real_escape_string($scenesp)!=$scenesp) {
		die("Your scenes parameter contains invalid characters.");
	}
	/*if (preg_replace('#([^0-9,])#imx', '', $scenesp)!=$scenesp) { ////from http://stackoverflow.com/a/2788781/992504
	//(preg_match_all("#[0-9]+[,]{1}#", $scenesp, $trash)!=count($scenesp)) {
		die("Your scenes were not formatted correctly. Correct format: \"4,5,6,10,13\"");
	}
	if (strpos(",,", $evidp)!=false) {
		die("You have two commas next to each other in your scenes parameter.");
	}
	if (implode(",", explode(",", $scenesp))!=$scenesp) { //lol doubt this ever returns false, but i feel safer when i densify my sphere of idiocy
		die("Your scenes parameter was changed after being exploded and imploded.");
	}*/
	$scenespex = explode(",", $scenesp);
	for ($sc = 0; $sc < count($scenespex); $sc++) {
		if (preg_replace('#([^0-9])#imx', '', $scenespex[$sc])!=$scenespex[$sc]) { ////from http://stackoverflow.com/a/2788781/992504
			die("Invalid scene: " . $scenespex[$sc]);
		}
		if (intval($scenespex[$sc]) > $scenecount || intval($scenespex[$sc]) < 0) {
			die("Scene out of range: " . $scenespex[$sc]);
		}
	}
	$scenescl = mysql_real_escape_string($scenesp);
	
	
	
	
	if (!isset($_POST['ev-dtstart'])) {
		die("You did not specify a start time; all parameters are required.");
	}
	$dtstartp = $_POST['ev-dtstart'];
	
	if (mysql_real_escape_string($dtstartp)!=$dtstartp) {
		die("Your start time contains invalid characters.");
	}
	if (date("Y-m-d H:i:s", strtotime($dtstartp))!=$dtstartp) {
		die("Your start time was not properly formatted. Correct format: \"1999-12-31 23:59:59\"");
	}
	$dtstartobj = date_create($dtstartp, $psm_deftimezone_obj);
	date_timezone_set($dtstartobj, timezone_open('UTC'));
	$dtstartcl = mysql_real_escape_string(date_format($dtstartobj, 'Y-m-d H:i:s'));
	
	
	
	
	if (!isset($_POST['ev-dtend'])) {
		die("You did not specify an end time; all parameters are required.");
	}
	$dtendp = $_POST['ev-dtend'];
	
	if (mysql_real_escape_string($dtendp)!=$dtendp) {
		die("Your end time contains invalid characters.");
	}
	if (date("Y-m-d H:i:s", strtotime($dtendp))!=$dtendp) {
		die("Your end time was not properly formatted. Correct format: \"1999-12-31 23:59:59\"");
	}
	$dtendobj = date_create($dtendp, $psm_deftimezone_obj);
	date_timezone_set($dtendobj, timezone_open('UTC'));
	$dtendcl = mysql_real_escape_string(date_format($dtendobj, 'Y-m-d H:i:s'));
	
	
	
	
	if (!isset($_POST['ev-comments'])) {
		die("You did not specify comments; all parameters are required.");
	}
	$commentsp = $_POST['ev-comments'];
	
	/*if (mysql_real_escape_string($commentsp)!=$commentsp) {
		die("Your comments contain invalid characters.");
	}*/
	if (strip_tags($commentsp)!=$commentsp) {
		die("Your comments contain markup tags, which are not allowed.");
	}
	$commentscl = mysql_real_escape_string(strip_tags($commentsp));
	
	
	
	
	if (!isset($_POST['ev-loc'])) {
		die("You did not specify a location; all parameters are required.");
	}
	$locp = $_POST['ev-loc'];
	
	/*if (mysql_real_escape_string($locp)!=$locp) {
		die("The location you specified contains invalid characters.");
	}*/
	if (strip_tags($locp)!=$locp) {
		die("The location you specified contains markup tags, which are not allowed.");
	}
	$loccl = mysql_real_escape_string(strip_tags($locp));
	
	
	
	
	if (!isset($_POST['ev-title'])) {
		die("You did not specify a title; all parameters are required.");
	}
	$titlep = $_POST['ev-title'];
	
	/*if (mysql_real_escape_string($titlep)!=$titlep) {
		die("The location you specified contains invalid characters.");
	}*/
	if (strip_tags($titlep)!=$titlep) {
		die("The title you specified contains markup tags, which are not allowed.");
	}
	$titlecl = mysql_real_escape_string(strip_tags($titlep));
	
	
	
	
	if (!isset($_POST['ev-status'])) {
		die("You did not specify a status; all parameters are required.");
	}
	$statusp = $_POST['ev-status'];
	if ($statusp!="1" && $statusp!="2" && $statusp!="3") {
		die("The status you specified is invalid.");
	}
	$statuscl = mysql_real_escape_string($statusp); //do i REALLY need to escape this string? i mean like srsly dawg
	
	
	
	
	if (!isset($_POST['ev-showscenes'])) {
		die("You did not specify showscenes; all parameters are required.");
	}
	$showscenesp = $_POST['ev-showscenes'];
	if ($showscenesp!="0" && $showscenesp!="1") {
		die("The showscenes parameter you specified is invalid.");
	}
	$showscenescl = mysql_real_escape_string($showscenesp); //do i REALLY need to escape this string? i mean like srsly dawg
	
	
	
	
	if (!isset($_POST['ev-allday'])) {
		die("You did not specify the allday parameter; all parameters are required.");
	}
	$alldayp = $_POST['ev-allday'];
	if ($alldayp!="0" && $alldayp!="1") {
		die("The allday parameter you specified is invalid.");
	}
	$alldaycl = mysql_real_escape_string($alldayp); //do i REALLY need to escape this string? i mean like srsly dawg
	
	
} else {
	
	
	if ($evidp=="new") {
		die("You can't create an event at the same time as you delete it!");
	}
	
	
	//die("not yet implemented");
}

////TODO: Add other_roles   //", `other_roles` = '0'" .
if (isset($_POST['ev-delete'])) {
	$sql = "DELETE FROM `" . $sql_pref . "events` WHERE `" . $sql_pref . "events`.`id` = " . $evidcl  . ";";
	
} else if ($evidp!="new") {
	$sql = "UPDATE `" . $sql_pref . "events` SET `title` = '" . $titlecl . "', `loc` = '" . $loccl . "', `dtstamp` = CURRENT_TIMESTAMP, `dtstart` = '" . $dtstartcl . "', `dtend` = '" . $dtendcl . "', `userid` = '" . $_SESSION['id'] . "', `comments` = '" . $commentscl . "', `scenes` = '" . $scenescl . "', `allday` = '" . $alldaycl . "', `showscenes` = '" . $showscenescl . "', `status` = '" . $statuscl . "' WHERE `" . $sql_pref . "events`.`id` = " . $evidcl  . ";";
	
} else {
	$sql = "INSERT INTO `" . $sql_pref . "events` (`title`, `id`, `loc`, `dtstamp`, `dtstart`, `dtend`, `userid`, `comments`, `scenes`, `allday`, `showscenes`, `status`, `other_roles`) VALUES ('" . $titlecl . "', NULL, '" . $loccl . "', CURRENT_TIMESTAMP, '" . $dtstartcl . "', '" . $dtendcl . "', '" . $_SESSION['id'] . "', '" . $commentscl . "', '" . $scenescl . "', '" . $alldaycl . "', '" . $showscenescl . "', '" . $statuscl . "', '0');";
	
}



mysql_query($sql) or die("Database query failed: " + mysql_error());
mysql_close($link);


//header("Location: " . $siteaddr . "/viewevent.php?id=" . $evidcl /*. "&errcode=201"*/);
header("Location: " . $siteaddr . "/mastercal.php");


$logtext = $_SESSION['user'] . " (#" . $_SESSION['id'] . ") ";
if (isset($_POST['ev-delete'])) {
	$logtext .= "deleted event #" . $evidcl;
	
} else {
	if ($evidp=="new") {
		$logtext .= "created a new event";
	} else {
		$logtext .= "edited event #" . $evidcl;
	}
	$logtext .=".  TITLE:\"" . $titlecl . "\"  LOC:\"" . $loccl . "\"  DTSTART:\"" . $dtstartcl . "\"  DTEND:\"" . $dtendcl . "\"  COMMENTS:\"" . $commentscl . "\"  SCENES:\"" . $scenescl . "\"  ALLDAY:" . $alldaycl . "  SHOWSCENES:" . $showscenescl . "  STATUS:" . $statuscl . "";
}

action_log($logtext);

//action_log($_SESSION['user'] . " (#" . $_SESSION['id'] . ") edited event #" . $evidcl . ".  TITLE:\"" . $titlecl . "\"  LOC:\"" . $loccl . "\"  DTSTART:\"" . $dtstartcl . "\"  DTEND:\"" . $dtendcl . "\"  COMMENTS:\"" . $commentscl . "\"  SCENES:\"" . $scenescl . "\"  ALLDAY:" . $alldaycl . "  SHOWSCENES:" . $showscenescl . "  STATUS:" . $statuscl . "");


?>