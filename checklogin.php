<?php
require_once('config.php');

function setErrcode($errcode, $dienow=false) {
	global $siteaddr;
	$_SESSION['errcode']=$errcode;
	header("Location: " . $siteaddr . "/login.php");
	if ($dienow==true) {
		die();
	}
}



if (isset($_SESSION['user'])) {
	
	$sessuser = $_SESSION['user'];
	$sessid = $_SESSION['id'];
	
	
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}
	session_destroy();
	
	//session_start();
	setErrcode("203"); ////TODO: This doesn't actually work right (i.e. message won't be seen because the session is destroyed), ought to fix...
	
	action_log($sessuser . " (#" . $sessid . ") logged out");
	die();
	
} else {
	
	$link = startmysql();
	
	$puser = mysql_real_escape_string(strtolower(stripslashes($_POST['u']))); 
	$ppass = mysql_real_escape_string(stripslashes($_POST['p']));
	
	
	$sql = "SELECT * FROM `" . $sql_pref . "users` WHERE `username` = '" . $puser . "' LIMIT 0, 1 ";
	$result = mysql_query($sql) or setErrcode("105", true);
	
	if (mysql_errno()!=0) {
		die();
	}
	
	if (mysql_num_rows($result)!=1) {
		if (mysql_num_rows($result)<1) {
			setErrcode("102"); //username not found
			
			action_log("Username \"" . strtolower(stripslashes($_POST['u'])) . "\" tried to login, but username could not be found.");
			
			die();
		} else {
			setErrcode("103"); //multiple instances of username found
			
			action_log("Username \"" . strtolower(stripslashes($_POST['u'])) . "\" tried to login, but username was found multiple times.");
			error_log("DUPLICATE USERNAME IN DATABASE: " . $puser);
			
			die();
		}
	}
	
	$row = mysql_fetch_row($result);
	
	
	if (sha1($ppass)==$row[2]) { //if password is correct
		
		$_SESSION['user'] = strtolower(stripslashes($_POST['u']));//$_POST['u'];
		$_SESSION['id'] = $row[0];
		$_SESSION['permission'] = $row[3];
		$_SESSION['firstname'] = $row[4];
		$_SESSION['roles'] = $row[6];
		//$_SESSION['theme'] = $row[10];
		//$_SESSION['email'] = $row[9]; //from my experiment with gravatars
		
		$_SESSION['requesturi'] = $_POST['requesturi'];
		
		if ($row[10]!="@") {
			$themearr = explode(",", $row[10]);
			$_SESSION['backcolor'] = $themearr[0];
			$_SESSION['forecolor'] = $themearr[1];
			$_SESSION['forehcolor'] = $themearr[2];
			
		} else {
			$_SESSION['backcolor'] = $def_backcolor;
			$_SESSION['forecolor'] = $def_forecolor;
			$_SESSION['forehcolor'] = $def_forehcolor;
			
		}
		
		setErrcode("201");
		
		action_log(strtolower(stripslashes($_POST['u'])) . " (#" . $row[0] . ") logged in successfully");
		
	} else if ($row[2]=="stinger" && $psm_imap_enabled==true) { //if password isn't set
		
		imap_timeout(IMAP_READTIMEOUT, $psm_imap_timeout);
		$my_imap = @imap_open("{" . $psm_imap_address . "}/imap/ssl", stripslashes($_POST['u']), $_POST['p'], OP_HALFOPEN);
		if ($my_imap != false) {
			imap_close($my_imap);
			$my_imap = true;
			
			
			$sqlp = "UPDATE `" . $sql_pref . "users` SET `password` = '" . sha1($ppass) . "' WHERE `" . $sql_pref . "users`.`id` = " . $row[0] . ";";
			$resultp = mysql_query($sqlp) or setErrcode("105", true);
			setErrcode("202"); //202: password changed
			
			action_log(strtolower(stripslashes($_POST['u'])) . " (#" . $row[0] . ") was authenticated via IMAP");
			
			mysql_free_result($resultp);
			
			
		} else {
			$my_imap = false;
			setErrcode("104");
		
			action_log(strtolower(stripslashes($_POST['u'])) . " failed to authenticate via IMAP (wrong password)");
		}
		
		
	} else if ($row[2]=="stinger" && $psm_imap_enabled==false) {
        
        $sqlp = "UPDATE `" . $sql_pref . "users` SET `password` = '" . sha1($ppass) . "' WHERE `" . $sql_pref . "users`.`id` = " . $row[0] . ";";
        $resultp = mysql_query($sqlp) or setErrcode("105", true);
        setErrcode("202"); //202: password changed
        
        action_log(strtolower(stripslashes($_POST['u'])) . " (#" . $row[0] . ") initialized their password");
        
        mysql_free_result($resultp);
        
    } else { //if password is wrong or whatever
		setErrcode("104"); //104: wrong password
		
		action_log(strtolower(stripslashes($_POST['u'])) . " failed to login (wrong password)");
		
	}
	mysql_free_result($result);
	mysql_close($link);
	die();
}
?>