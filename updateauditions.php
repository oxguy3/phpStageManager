<?php

require_once('config.php');

function setErrcode($errcode, $errnote="", $dienow=true) {
	global $siteaddr;
	$_SESSION['errcode']=$errcode;
	$_SESSION['errnote']=$errnote;
	if ($errcode=="106") { echo mysql_error();} else{
	header("Location: " . $siteaddr . "/audition/index.php"); }
	if ($dienow) {
		die();
	}
}

//header('Content-type: text/plain'); ////NOTE: REMOVE WHEN DONE TESTING -- WE DON'T NEED NO STINKIN' HEADERS!!


//mustBeLoggedIn();


$link = startmysql();


if (!isset($_POST['mobilephone'])) {
	setErrcode("101","a mobile phone");
}
$mobilephonep = $_POST['mobilephone'];

if (mysql_real_escape_string($mobilephonep)!=$mobilephonep) {
	setErrcode("102","mobile phone");
}
if (strip_tags($mobilephonep)!=$mobilephonep) {
	setErrcode("103","mobile phone");
}
$mobilephonecl = mysql_real_escape_string(strip_tags($mobilephonep));



if (!isset($_POST['homephone'])) {
	setErrcode("101","a home phone");
}
$homephonep = $_POST['homephone'];

if (mysql_real_escape_string($homephonep)!=$homephonep) {
	setErrcode("102","home phone");
}
if (strip_tags($homephonep)!=$homephonep) {
	setErrcode("103","home phone");
}
$homephonecl = mysql_real_escape_string(strip_tags($homephonep));



if (!isset($_POST['emailaddr'])) {
	setErrcode("101","an email address");
}
$emailaddrp = $_POST['emailaddr'];

if (mysql_real_escape_string($emailaddrp)!=$emailaddrp) {
	setErrcode("102","email address");
}
if (strip_tags($emailaddrp)!=$emailaddrp) {
	setErrcode("103","email address");
}
$emailaddrcl = mysql_real_escape_string(strip_tags($emailaddrp));



if (!isset($_POST['firstname'])) {
	setErrcode("101","a first name");
}
$firstnamep = $_POST['firstname'];

if (mysql_real_escape_string($firstnamep)!=$firstnamep) {
	setErrcode("102","first name");
}
if (strip_tags($firstnamep)!=$firstnamep) {
	setErrcode("103","first name");
}
$firstnamecl = mysql_real_escape_string(strip_tags($firstnamep));



if (!isset($_POST['lastname'])) {
	setErrcode("101","a last name");
}
$lastnamep = $_POST['lastname'];

if (mysql_real_escape_string($lastnamep)!=$lastnamep) {
	setErrcode("102","last name");
}
if (strip_tags($firstnamep)!=$firstnamep) {
	setErrcode("103","last name");
}
$lastnamecl = mysql_real_escape_string(strip_tags($lastnamep));



if (!isset($_POST['username'])) {
	setErrcode("101","a username");
}
$usernamep = $_POST['username'];

if (mysql_real_escape_string($usernamep)!=$usernamep) {
	setErrcode("102","username");
}
if (strip_tags($usernamep)!=$usernamep) {
	setErrcode("103","username");
}
$usernamecl = mysql_real_escape_string(strip_tags($usernamep));



if (!isset($_POST['password'])) {
	setErrcode("101","a password");
}
$passwordp = $_POST['password'];

if (mysql_real_escape_string($passwordp)!=$passwordp) {
	setErrcode("102","password");
}
if (strip_tags($passwordp)!=$passwordp) {
	setErrcode("103","password");
}
$passwordcl = mysql_real_escape_string(strip_tags($passwordp));


imap_timeout(IMAP_READTIMEOUT, 3);
$my_imap = @imap_open("{middle.7hills.org}/imap/ssl", $usernamep, $passwordp, OP_HALFOPEN);
if ($my_imap != false) {
    imap_close($my_imap);
    $my_imap = true;
} else {
    $my_imap = false;
    setErrcode("104");
}



$sqlcu = "SELECT *  FROM `" . $sql_pref . "users` WHERE `username` LIKE '" . $usernamep . "'";
$resultcu = mysql_query($sqlcu) or setErrcode("106");

if (mysql_num_rows($resultcu)>0) {
	$rowcu = mysql_fetch_row($resultcu);
	
	$sqldu = "DELETE FROM `" . $sql_pref . "users` WHERE `id`=" . $rowcu[0];
	/*$resultdu = */mysql_query($sqldu) or setErrcode("106");
	
	///////////////////$sqldu = "DELETE FROM `" . $sql_pref . "users_extra` WHERE `id`=" . $rowcu[0];
	////////////////////*$resultdu = */mysql_query($sqldu) or setErrcode("106");
	
}







if (!isset($_POST['pastexperience'])) {
	setErrcode("101","a pastexperience");
}
$pastexperiencep = $_POST['pastexperience'];

if (mysql_real_escape_string($pastexperiencep)!=$pastexperiencep) {
	setErrcode("102","pastexperience");
}
if (strip_tags($pastexperiencep)!=$pastexperiencep) {
	setErrcode("103","pastexperience");
}
$pastexperiencecl = mysql_real_escape_string(strip_tags($pastexperiencep));



if (!isset($_POST['prefrole'])) {
	setErrcode("101","a prefrole");
}
$prefrolep = $_POST['prefrole'];

if (mysql_real_escape_string($prefrolep)!=$prefrolep) {
	setErrcode("102","prefrole");
}
if (strip_tags($prefrolep)!=$prefrolep) {
	setErrcode("103","prefrole");
}
$prefrolecl = mysql_real_escape_string(strip_tags($prefrolep));



if (!isset($_POST['conf_sun'])) {
	setErrcode("101","a conf_sun");
}
$conf_sunp = $_POST['conf_sun'];

if (mysql_real_escape_string($conf_sunp)!=$conf_sunp) {
	setErrcode("102","conf_sun");
}
if (strip_tags($conf_sunp)!=$conf_sunp) {
	setErrcode("103","conf_sun");
}
$conf_suncl = mysql_real_escape_string(strip_tags($conf_sunp));



if (!isset($_POST['conf_mon'])) {
	setErrcode("101","a conf_mon");
}
$conf_monp = $_POST['conf_mon'];

if (mysql_real_escape_string($conf_monp)!=$conf_monp) {
	setErrcode("102","conf_mon");
}
if (strip_tags($conf_monp)!=$conf_monp) {
	setErrcode("103","conf_mon");
}
$conf_moncl = mysql_real_escape_string(strip_tags($conf_monp));



if (!isset($_POST['conf_tue'])) {
	setErrcode("101","a conf_tue");
}
$conf_tuep = $_POST['conf_tue'];

if (mysql_real_escape_string($conf_tuep)!=$conf_tuep) {
	setErrcode("102","conf_tue");
}
if (strip_tags($conf_tuep)!=$conf_tuep) {
	setErrcode("103","conf_tue");
}
$conf_tuecl = mysql_real_escape_string(strip_tags($conf_tuep));



if (!isset($_POST['conf_wed'])) {
	setErrcode("101","a conf_wed");
}
$conf_wedp = $_POST['conf_wed'];

if (mysql_real_escape_string($conf_wedp)!=$conf_wedp) {
	setErrcode("102","conf_wed");
}
if (strip_tags($conf_wedp)!=$conf_wedp) {
	setErrcode("103","conf_wed");
}
$conf_wedcl = mysql_real_escape_string(strip_tags($conf_wedp));



if (!isset($_POST['conf_thu'])) {
	setErrcode("101","a conf_thu");
}
$conf_thup = $_POST['conf_thu'];

if (mysql_real_escape_string($conf_thup)!=$conf_thup) {
	setErrcode("102","conf_thu");
}
if (strip_tags($conf_thup)!=$conf_thup) {
	setErrcode("103","conf_thu");
}
$conf_thucl = mysql_real_escape_string(strip_tags($conf_thup));



if (!isset($_POST['conf_fri'])) {
	setErrcode("101","a conf_fri");
}
$conf_frip = $_POST['conf_fri'];

if (mysql_real_escape_string($conf_frip)!=$conf_frip) {
	setErrcode("102","conf_fri");
}
if (strip_tags($conf_frip)!=$conf_frip) {
	setErrcode("103","conf_fri");
}
$conf_fricl = mysql_real_escape_string(strip_tags($conf_frip));



if (!isset($_POST['conf_sat'])) {
	setErrcode("101","a conf_sat");
}
$conf_satp = $_POST['conf_sat'];

if (mysql_real_escape_string($conf_satp)!=$conf_satp) {
	setErrcode("102","conf_sat");
}
if (strip_tags($conf_satp)!=$conf_satp) {
	setErrcode("103","conf_sat");
}
$conf_satcl = mysql_real_escape_string(strip_tags($conf_satp));



if (!isset($_POST['conf_extra'])) {
	setErrcode("101","a conf_extra");
}
$conf_extrap = $_POST['conf_extra'];

if (mysql_real_escape_string($conf_extrap)!=$conf_extrap) {
	setErrcode("102","conf_extra");
}
if (strip_tags($conf_extrap)!=$conf_extrap) {
	setErrcode("103","conf_extra");
}
$conf_extracl = mysql_real_escape_string(strip_tags($conf_extrap));




$sql = "INSERT INTO `" . $sql_pref . "users` (`id`, `username`, `password`, `permission`, `firstname`, `lastname`, `roles`, `phone_mobile`, `phone_home`, `email`, `theme`) VALUES (NULL, '$usernamecl', '" . sha1($passwordcl) . "', '0', '$firstnamecl', '$lastnamecl', '0', '$mobilephonecl', '$homephonecl', '$emailaddrcl', '#0000AA,#FFDD00,#FFAA00');";
//die($sql);
/*$result = */mysql_query($sql) or setErrcode("106");




///////////////////$sql = "INSERT INTO `" . $sql_pref . "users_extra` (`id`, `pastexperience`, `prefrole`, `conf_sun`, `conf_mon`, `conf_tue`, `conf_wed`, `conf_thu`, `conf_fri`, `conf_sat`, `conf_extra`) VALUES (NULL, '$pastexperiencecl', '$prefrolecl', '$conf_suncl', '$conf_moncl', '$conf_tuecl', '$conf_wedcl', '$conf_thucl', '$conf_fricl', '$conf_satcl', '$conf_extracl');";
///////////////////mysql_query($sql) or setErrcode("106");

//mysql_free_result($result);
mysql_close($link);

setErrcode("201","",false);

action_log($usernamecl . " registered.");

//header("Location: " . $siteaddr . "/audition/index.php");

die("Success!");

/*
//$link = startmysql();
$sql = "SELECT * FROM `" . $sql_pref . "events` WHERE `id` = " . mysql_real_escape_string(stripslashes($eid)) . " LIMIT 0, 1 "; //i probably should do a better job of sanitizing $eid
$result = mysql_query($sql) or $errorcode=5;

$row = mysql_fetch_row($result);



$pagetitle="invisible"; // . $evtitle
require_once('topheader.php');

require_once('header.php');




require_once('footer.php');


mysql_free_result($result);
mysql_free_result($resultu);
mysql_close($link);
*/
?>