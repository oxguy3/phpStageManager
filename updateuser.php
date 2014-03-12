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


if (isset($_POST['u-resetpass']) && $_POST['u-resetpass']=="true") {
    
	if (!isset($_POST['u-username'])) {
        $_SESSION['errnote'] = "username";
        setErrcode("101", "admin", true);
	}
	$usernamep = $_POST['u-username'];
    
	if (strip_tags($usernamep)!=$usernamep) {
        $_SESSION['errnote'] = "username";
        setErrcode("103", "admin", true);
	}
	$usernamecl = mysql_real_escape_string(strip_tags($usernamep));
    
    
    $sqlGetUser = "SELECT * FROM `" . $sql_pref . "users` WHERE `username`='" . $usernamecl . "'";
    $resultGetUser = mysql_query($sqlGetUser) or setErrcode("106", "admin", true);
    
    if (mysql_num_rows($resultGetUser) <= 0) {
        mysql_close($link);
        setErrcode("104", "admin", true);
    }
    
    $sqlResetPass = "UPDATE `" . $sql_pref . "users` SET `password`='stinger' WHERE `username`='" . $usernamecl . "'";
    $resultResetPass = mysql_query($sqlResetPass) or setErrcode("106", "admin", true);
    
    setErrcode("202", "admin");
    
    $logtext .= " reset " . $usernamecl . "'s password.";
    action_log($logtext);
    mysql_close($link);
    die("dead");
}


if (!isset($_POST['u-id'])) {
	die("You did not specify an user ID; all parameters are required.");
}
$uidp = $_POST['u-id'];

if ($uidp!="new") {

	if (mysql_real_escape_string($uidp)!=$uidp) {
		die("Your user ID contains invalid characters.");
	}
	if (!is_numeric($uidp)) {
		die("Your user ID is not a number.");
	}
	if (strpos(".", $uidp)!=false||strpos("+", $uidp)!=false||strpos("-", $uidp)!=false||strpos("e", $uidp)!=false) {
		die("Your user ID contains an invalid character.");
	}
	$uidcl = mysql_real_escape_string($uidp);
}

if (!isset($_POST['u-delete'])) {
    
	if (!isset($_POST['u-username'])) {
        $_SESSION['errnote'] = "username";
        setErrcode("101", "contactsheet", true);
	}
	$usernamep = $_POST['u-username'];
    
	if (strip_tags($usernamep)!=$usernamep) {
        $_SESSION['errnote'] = "username";
        setErrcode("103", "contactsheet", true);
	}
	$usernamecl = mysql_real_escape_string(strip_tags($usernamep));
	
	
	
	
	if (!isset($_POST['u-permission'])) {
        $_SESSION['errnote'] = "permission level";
        setErrcode("101", "contactsheet", true);
	}
	$permissionp = $_POST['u-permission'];
	if ($permissionp!="0" && $permissionp!="1" && $permissionp!="2") {
        $_SESSION['errnote'] = "permission level";
        setErrcode("102", "contactsheet", true);
	}
	$permissioncl = mysql_real_escape_string($permissionp);
    
    
    
    
	if (!isset($_POST['u-firstname'])) {
        $_SESSION['errnote'] = "first name";
        setErrcode("101", "contactsheet", true);
	}
	$firstnamep = $_POST['u-firstname'];
    
	if (strip_tags($firstnamep)!=$firstnamep) {
        $_SESSION['errnote'] = "first name";
        setErrcode("103", "contactsheet", true);
	}
	$firstnamecl = mysql_real_escape_string(strip_tags($firstnamep));
    
    
    
    
	if (!isset($_POST['u-lastname'])) {
        $_SESSION['errnote'] = "last name";
        setErrcode("101", "contactsheet", true);
	}
	$lastnamep = $_POST['u-lastname'];
    
	if (strip_tags($lastnamep)!=$lastnamep) {
        $_SESSION['errnote'] = "last name";
        setErrcode("103", "contactsheet", true);
	}
	$lastnamecl = mysql_real_escape_string(strip_tags($lastnamep));
    
    
    
    
	if (!isset($_POST['u-mobilephone'])) {
        $_SESSION['errnote'] = "mobile phone";
        setErrcode("101", "contactsheet", true);
	}
	$mobilephonep = $_POST['u-mobilephone'];
    
	if (strip_tags($mobilephonep)!=$mobilephonep) {
        $_SESSION['errnote'] = "mobile phone";
        setErrcode("103", "contactsheet", true);
	}
	$mobilephonecl = mysql_real_escape_string(strip_tags($mobilephonep));
    
    
    
    
	if (!isset($_POST['u-homephone'])) {
        $_SESSION['errnote'] = "home phone";
        setErrcode("101", "contactsheet", true);
	}
	$homephonep = $_POST['u-homephone'];
    
	if (strip_tags($homephonep)!=$homephonep) {
        $_SESSION['errnote'] = "home phone";
        setErrcode("103", "contactsheet", true);
	}
	$homephonecl = mysql_real_escape_string(strip_tags($homephonep));
    
    
    
    
	if (!isset($_POST['u-emailaddr'])) {
        $_SESSION['errnote'] = "emailaddr";
        setErrcode("101", "contactsheet", true);
	}
	$emailaddrp = $_POST['u-emailaddr'];
    
	if (strip_tags($emailaddrp)!=$emailaddrp) {
        $_SESSION['errnote'] = "emailaddr";
        setErrcode("103", "contactsheet", true);
	}
	$emailaddrcl = mysql_real_escape_string(strip_tags($emailaddrp));
	
	
} else {
	
	
	if ($uidp == "new") {
		die("You can't create a user at the same time as you delete it!");
	}
}

if (isset($_POST['u-delete'])) {
	$sql = "DELETE FROM `" . $sql_pref . "users` WHERE `id` = " . $uidcl  . ";";
	
} else if ($uidp!="new") {
	$sql = "UPDATE `" . $sql_pref . "users` SET `username` = '" . $usernamecl . "', `permission` = " . $permissioncl . ", `firstname` = '" . $firstnamecl . "', `lastname` = '" . $lastnamecl . "', `phone_mobile` = '" . $mobilephonecl . "', `phone_home` = '" . $homephonecl . "', `email` = '" . $emailaddrcl . "' WHERE `id` = " . $uidcl  . ";";
	
} else {
	$sql = "INSERT INTO `" . $sql_pref . "users` (`username`, `password`, `permission`, `firstname`, `lastname`, `roles`, `phone_mobile`, `phone_home`, `email`, `theme`) VALUES ('" . $usernamecl . "', 'stinger', " . $permissioncl . ", '" . $firstnamecl . "', '" . $lastnamecl . "', '0', '" . $mobilephonecl . "', '" . $homephonecl . "', '" . $emailaddrcl . "', '@');";
	
}

mysql_query($sql) or die("Database query failed: " + mysql_error());
mysql_close($link);


//header("Location: " . $siteaddr . "/viewevent.php?id=" . $evidcl /*. "&errcode=201"*/);
header("Location: " . $siteaddr . "/contactsheet.php");
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