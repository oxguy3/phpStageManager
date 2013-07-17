<?php

include('psm_config.php');

//$psm_actionlogging = true; //if true, every user action (logging in/out, changing an event, etc) will be recorded in the file action.log

//$psm_deftimezone = 'America/New_York'; //name of timezone to be displayed to user. a list of valid values can be found at http://php.net/manual/en/timezones.php



/*$linksi = startmysql();
$sqlsi = "SELECT * FROM `" . $sql_pref . "siteinfo`";
$resultsi = mysql_query($sqlsi) or die("Query failed:\n" . mysql_error());

$rowsi = mysql_fetch_row($resultsi);
$sitetitle = $rowsi[0];

$rowsi = mysql_fetch_row($resultsi);
$sitedescription = $rowsi[0];

$rowsi = mysql_fetch_row($resultsi);
$companyname = $rowsi[0];

mysql_free_result($resultsi);
mysql_close($linksi);*/



///////////////////////////////////////////////
// ignore everything below here except mysql //
///////////////////////////////////////////////


date_default_timezone_set("UTC");
session_start();

$siteaddr = $siteprotocol . $sitedomain . $sitesubdir;
$br = "\n";
$date = getdate();
$psm_deftimezone_obj = timezone_open($psm_deftimezone);
//$usingmysql = false; //gets automatically set when a mysql query is made


$halfassadmincheck = false;




function startmysql() {
	global $sql_addr, $sql_user, $sql_pass, $sql_db;
	
	//$usingmysql=true;//commented because I decided not to attempt to dynamically close MySQL results
	
	$link = mysql_connect($sql_addr, $sql_user, $sql_pass) or die("ERROR: Could not connect to database: \n" . mysql_error());
	mysql_select_db($sql_db) or die("ERROR: Could not select database: \n" . mysql_error());
	
	return $link;
}


function action_log($logmsg) {
	global $psm_actionlogging;
	
	if ($psm_actionlogging) {
		error_log("\n" . date("Y-m-d H:i:s") . " [" . $_SERVER['REMOTE_ADDR'] . "] " . $logmsg, 3, $rootdir."action.log");
	}
}


function mustBeLoggedIn() {
	global $halfassadmincheck;
	
	if (!isset($_SESSION['user']) || ($halfassadmincheck && intval($_SESSION['permission'])<1)) {
		$_SESSION['errcode']="106";
		header("Location: " . $siteaddr . "/login.php");
		die("You must be logged in to do that.");
	}
}


function getThemeColors() {
	global $backcolor, $forecolor, $forehcolor;
	global $def_backcolor, $def_forecolor, $def_forehcolor;
	

	$backcolor = $def_backcolor;
	$forecolor = $def_forecolor;
	$forehcolor = $def_forehcolor;
	
	/*if (isset($_SESSION['theme'])) {
		$themearr = explode(",", $_SESSION['theme']);
		$backcolor = $themearr[0];
		$forecolor = $themearr[1];
		$forehcolor = $themearr[2];
	}*/
	
	if (isset($_SESSION['backcolor'])) {
		$backcolor = $_SESSION['backcolor'];
	}
	if (isset($_SESSION['forecolor'])) {
		$forecolor = $_SESSION['forecolor'];
	}
	if (isset($_SESSION['forehcolor'])) {
		$forehcolor = $_SESSION['forehcolor'];
	}
}


/**
 * From http://stackoverflow.com/a/2542531/992504
 */
function getRanges( $nums )
{
    $ranges = array();

    for ( $i = 0, $len = count($nums); $i < $len; $i++ )
    {
        $rStart = $nums[$i];
        $rEnd = $rStart;
        while ( isset($nums[$i+1]) && $nums[$i+1]-$nums[$i] == 1 )
            $rEnd = $nums[++$i];

        $ranges[] = $rStart == $rEnd ? $rStart : $rStart.'-'.$rEnd;
    }

    return $ranges;
}


/**
 * Modified from http://stackoverflow.com/q/6191503/992504
 */
function prepareTextIcal($text)
{
    $search = array('\\', ';', ',', "\r\n", "\n", "\r");
    $replace = array('\\\\', '\;', '\,', '\n', '\n', '\n');
    return strip_tags(str_replace($search, $replace, $text));
}
?>