<?php
require_once('config.php');

//die(print_r($_REQUEST));

//header('Content-type: text/plain'); ////NOTE: REMOVE WHEN DONE TESTING -- WE DON'T NEED NO STINKIN' HEADERS!!

function setErrcode($errcode, $scriptname, $dienow=false) {
	global $siteaddr;
	$_SESSION['errcode']=$errcode;
	header("Location: " . $siteaddr . "/" . $scriptname . ".php");
	if ($dienow==true) {
        if (isset($link)) {
            mysql_close($link);
        }
		die();
	}
}

mustBeLoggedIn();
if (intval($_SESSION['permission']) < 2) {
	die("You don't have permission to do that.");
}

$logtext = $_SESSION['user'] . " (#" . $_SESSION['id'] . ") ";

$link = startmysql();



if (!isset($_POST['u-id'])) {
	die("You did not specify an role ID; all parameters are required.");
}
$uidp = $_POST['u-id'];

if ($uidp!="new") {

	if (mysql_real_escape_string($uidp)!=$uidp) {
		die("Your role ID contains invalid characters.");
	}
	if (!is_numeric($uidp)) {
		die("Your role ID is not a number.");
	}
	if (strpos(".", $uidp)!=false||strpos("+", $uidp)!=false||strpos("-", $uidp)!=false||strpos("e", $uidp)!=false) {
		die("Your role ID contains an invalid character.");
	}
	$uidcl = mysql_real_escape_string($uidp);
}

if (!isset($_POST['u-delete'])) {
    
	if (!isset($_POST['u-title'])) {
        $_SESSION['errnote'] = "title";
        setErrcode("101", "admin", true);
	}
	$titlep = $_POST['u-title'];
    
	if (strip_tags($titlep)!=$titlep) {
        $_SESSION['errnote'] = "title";
        setErrcode("103", "admin", true);
	}
	$titlecl = mysql_real_escape_string(strip_tags($titlep));
    
    
    
    
    
	
	if (!isset($_POST['u-scenes'])) {
		die("You did not specify a scenes parameter; all parameters are required.");
	}
	$scenesp = $_POST['u-scenes'];
	
	if (mysql_real_escape_string($scenesp)!=$scenesp) {
		die("Your scenes parameter contains invalid characters.");
	}
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
	
	
	
	
	if (!isset($_POST['u-roletype'])) {
        $_SESSION['errnote'] = "role type";
        setErrcode("101", "admin", true);
	}
	$roletypep = $_POST['u-roletype'];
	if ($roletypep!="1" && $roletypep!="2") {
        $_SESSION['errnote'] = "role type";
        setErrcode("102", "admin", true);
	}
	$roletypecl = mysql_real_escape_string($roletypep);
	
	
	
	
	if (!isset($_POST['u-showinscenes'])) {
        $_SESSION['errnote'] = "showinscenes";
        setErrcode("101", "admin", true);
	}
	$showinscenesp = $_POST['u-showinscenes'];
	if ($showinscenesp!="0" && $showinscenesp!="1") {
        $_SESSION['errnote'] = "showinscenes";
        setErrcode("102", "admin", true);
	}
	$showinscenescl = mysql_real_escape_string($showinscenesp);
	
	
	
	
	if (!isset($_POST['u-showindirectory'])) {
        $_SESSION['errnote'] = "showindirectory";
        setErrcode("101", "admin", true);
	}
	$showindirectoryp = $_POST['u-showindirectory'];
	if ($showindirectoryp!="0" && $showindirectoryp!="1") {
        $_SESSION['errnote'] = "showindirectory";
        setErrcode("102", "admin", true);
	}
	$showindirectorycl = mysql_real_escape_string($showindirectoryp);
	
	
	
	
	if (!isset($_POST['u-showincaldropdown'])) {
        $_SESSION['errnote'] = "showincaldropdown";
        setErrcode("101", "admin", true);
	}
	$showincaldropdownp = $_POST['u-showincaldropdown'];
	if ($showincaldropdownp!="0" && $showincaldropdownp!="1") {
        $_SESSION['errnote'] = "showincaldropdown";
        setErrcode("102", "admin", true);
	}
	$showincaldropdowncl = mysql_real_escape_string($showincaldropdownp);
	
	
} else {
	
	
	if ($uidp == "new") {
		die("You can't create a user at the same time as you delete it!");
	}
}

if (isset($_POST['u-delete'])) {
	$sql = "DELETE FROM `" . $sql_pref . "roles` WHERE `id` = " . $uidcl  . ";";
	
} else if ($uidp!="new") {
	$sql = "UPDATE `" . $sql_pref . "roles` SET `title` = '" . $titlecl . "', `scenes` = '" . $scenescl . "', `roletype` = " . $roletypecl . ", `showInScenes` = " . $showinscenescl . ", `showInDirectory` = " . $showindirectorycl . ", `showInCalDropdown` = " . $showincaldropdowncl . " WHERE `id` = " . $uidcl  . ";";
	
} else {
	$sql = "INSERT INTO `" . $sql_pref . "roles` (`title`, `scenes`, `roletype`, `showInScenes`, `showInDirectory`, `showInCalDropdown`) VALUES ('" . $titlecl . "', '" . $scenescl . "', " . $roletypecl . ", " . $showinscenescl . ", " . $showindirectorycl . ", " . $showincaldropdowncl . ");";
	
}

mysql_query($sql) or die("Database query failed: " + mysql_error());
mysql_close($link);


//header("Location: " . $siteaddr . "/viewevent.php?id=" . $evidcl /*. "&errcode=201"*/);
header("Location: " . $siteaddr . "/admin.php");
die("test");



if (isset($_POST['u-delete'])) {
	$logtext .= "deleted user #" . $uidcl;
	
} else {
	if ($uidp=="new") {
		$logtext .= "created a new user";
	} else {
		$logtext .= "edited user #" . $uidcl;
	}
	$logtext .= ".  USERNAME:\"" . $usernamecl . "\"  PERMISSION:\"" . $permissioncl . "\"  FIRSTNAME:\"" . $firstnamecl . "\"  LASTENAME:\"" . $lastnamecl . "\"  MOBILEPHONE:\"" . $mobilephonecl . "\"  HOMEPHONE:\"" . $homephonecl . "\"  EMAILADDR:" . $emailaddrcl;
}

action_log($logtext);

//action_log($_SESSION['user'] . " (#" . $_SESSION['id'] . ") edited event #" . $evidcl . ".  TITLE:\"" . $titlecl . "\"  LOC:\"" . $loccl . "\"  DTSTART:\"" . $dtstartcl . "\"  DTEND:\"" . $dtendcl . "\"  COMMENTS:\"" . $commentscl . "\"  SCENES:\"" . $scenescl . "\"  ALLDAY:" . $alldaycl . "  SHOWSCENES:" . $showscenescl . "  STATUS:" . $statuscl . "");


?>