<?php
require_once('config.php');

$pagetitle="Login";



//NOTE: errcode is a misnomer, its actually being used as a general status code (like HTTP status codes)
//the 100s are for errors
//the 200s are for successes
$errcode=0;
if (isset($_SESSION['errcode'])) {
	$errcode = intval($_SESSION['errcode']);
}

if ($errcode==0&&isset($_SESSION['user'])){
	header("Location: " . $siteaddr);
	die();
}



require_once('topheader.php');
require_once('header.php');


if ($errcode!=0) {
	
	echo "<div id=\"loginerror\">";
	
	if ($errcode==101) {
		echo "<span class=\"loginerror-red\">Username and password must be alphanumeric (containing only letters and numbers)</span>";
	} else if ($errcode==102) {
		echo "<span class=\"loginerror-red\">Username not found in the database.</span>";
	} else if ($errcode==103) {
		echo "<span class=\"loginerror-red\">You appear to have a clone, as there are multiple instances of your username in the database. Bug Hayden to fix this so you can log in.</span>";
	} else if ($errcode==104) {
		echo "<span class=\"loginerror-red\">Wrong password!</span>";
	} else if ($errcode==105) {
		echo "<span class=\"loginerror-red\">The database query failed!</span>";
	} else if ($errcode==106) {
		echo "<span class=\"loginerror-red\">You must be logged in to do that.</span>";
	} else if ($errcode==200) {
		echo "<span class=\"loginerror-green\">An unknown good thing happened...</span>";
	} else if ($errcode==201) {
		echo "<span class=\"loginerror-green\">You are now logged in. Welcome " . $_SESSION['firstname'] . "!</span>";
	} else if ($errcode==202) {
		echo "<span class=\"loginerror-green\">Your account has been authenticated! Now log in.</span>";
	} else if ($errcode==203) {
		///////////////////////////////////////////////////////
		//// TODO: Currently, this message doesn't ever get seen because the session is destroyed when you log out, 
		//// and therefore the errcode is lost. I should probably come up with an easy fix for this at some point...
		///////////////////////////////////////////////////////
		echo "<span class=\"loginerror-green\">You have been logged out.</span>";
	} else {
		echo "<span class=\"loginerror-red\">An unknown error occurred (#" . $errcode . ")</span>";
	}
	
	echo "</div>";
	
}
unset($_SESSION['errcode'], $_SESSION['errnote']);



if (!isset($_SESSION['user'])) {

?>
<table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="float:left; margin-left: 20px;">
<tr>
<form name="form1" method="post" action="<?php echo $siteaddr; ?>/checklogin.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<!--<tr>
<td colspan="3"><strong>Login</strong></td>
</tr>-->
<tr>
<td width="78">Username:</td>
<td width="294"><input name="u" type="text" id="myusername"></td>
</tr>
<tr>
<td>Password:</td>
<td><input name="p" type="password" id="mypassword"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Login"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
<div style="margin-left:315px; padding:20px 7px 50px 20px;">Please enter your login information. If you forget your password, ask Hayden and he can reset it. If you have never set a password on this site, you can login using your school username and password.</div>
<?php //'

} else {
	$clickhereurl = $siteaddr;
	if (isset($_SESSION['requesturi'])) {
		$clickhereurl .= $_SESSION['requesturi'];
		unset($_SESSION['requesturi']);
	}
	echo "<div id=\"login-clicktocontinue\"><a href=\"" . $clickhereurl . "\">Click here to continue</a></div>";
}

require_once('footer.php');

?>