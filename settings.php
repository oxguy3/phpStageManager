<?php
require_once('config.php');

mustBeLoggedIn();


$link = startmysql();
$sql = "SELECT * FROM `" . $sql_pref . "users` WHERE `id` = " . $_SESSION['id'] . " LIMIT 0, 1";
$result = mysql_query($sql) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");
$row = mysql_fetch_row($result);



//NOTE: errcode is a misnomer, its actually being used as a general status code (like HTTP status codes)
//the 100s are for errors
//the 200s are for successes
$errcode=0;
if (isset($_SESSION['errcode'])) {
	$errcode = intval($_SESSION['errcode']);
}

/*if ($errcode==0&&isset($_SESSION['user'])){
	header("Location: " . $siteaddr);
	die();
}*/



$pagetitle="Settings"; // . $evtitle
require_once('topheader.php');
?>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-ui-1.8.11.custom.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jscolor/jscolor.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/settingspage.js.php'></script>
<script type='text/javascript'>
$(document).ready(function() {
	
	$("#settings-theme-defaults").click(function() {
		$("#settings-theme-backcolor").val('<?php echo $def_backcolor; ?>');
		$("#settings-theme-backcolor").css('background-color', '<?php echo $def_backcolor; ?>');
		$("#settings-theme-backcolor").css('color', 'white'); <?php /*//// TO-DO: dynamically determine white or black */ ?>
		
		$("#settings-theme-forecolor").val('<?php echo $def_forecolor; ?>');
		$("#settings-theme-forecolor").css('background-color', '<?php echo $def_forecolor; ?>');
		$("#settings-theme-forecolor").css('color', 'black');
		
		$("#settings-theme-forehcolor").val('<?php echo $def_forehcolor; ?>');
		$("#settings-theme-forehcolor").css('background-color', '<?php echo $def_forehcolor; ?>');
		$("#settings-theme-forehcolor").css('color', 'black');
        });
	
});
</script>
<link rel='stylesheet' type='text/css' href='<?php echo $siteaddr; ?>/includes/settingspage.css.php' />
<style type="text/css">

#leftbar-a-profile
{
    background-image:url(<?php echo $siteaddr; ?>/images/fatcow/vcard.png);
}
#leftbar-a-theme
{
    background-image:url(<?php echo $siteaddr; ?>/images/fatcow/skins.png);
}
#leftbar-a-password
{
    background-image:url(<?php echo $siteaddr; ?>/images/fatcow/change_password.png);
}
</style>
<?php
require_once('header.php');

/*$selectedmode = 0;
if (isset($_GET['mode'])) {
	if ($_GET['mode'] == "profile") {
		$selectedmode = 0;
	} else if ($_GET['mode'] == "theme") {
		$selectedmode = 1;
	} else if ($_GET['mode'] == "password") {
		$selectedmode = 2;
	} 
}*/


if ($errcode!=0) {
	
	echo "<div id=\"loginerror\">";
	
	if ($errcode==101) {
		echo "<span class=\"loginerror-red\">Missing parameter. You must specify " . $_SESSION['errnote'] . ".</span>";
	} else if ($errcode==102) {
		echo "<span class=\"loginerror-red\">The " . $_SESSION['errnote'] . " you specified contains invalid characters.</span>";
	} else if ($errcode==103) {
		echo "<span class=\"loginerror-red\">The " . $_SESSION['errnote'] . " you specified contains formatting tags.</span>";
	} else if ($errcode==104) {
		$_GET['mode'] = "password";
		echo "<span class=\"loginerror-red\">The old password you entered was incorrect.</span>";
	} else if ($errcode==105) {
		$_GET['mode'] = "password";
		echo "<span class=\"loginerror-red\">The new passwords you entered did not match.</span>";
	} else if ($errcode==106) {
		echo "<span class=\"loginerror-red\">The website's database is unavailable at the moment.</span>";
	} else if ($errcode==107) {
		echo "<span class=\"loginerror-red\">You specified an invalid mode. Nice try, wannabe hacker.</span>";
	} else if ($errcode==200) {
		echo "<span class=\"loginerror-green\">Success!</span>"; //generic "good" message, shouldn't actually be used
	} else if ($errcode==201) {
		$_GET['mode'] = "profile";
		echo "<span class=\"loginerror-green\">Your contact information has been updated.</span>";
	} else if ($errcode==202) {
		$_GET['mode'] = "theme";
		echo "<span class=\"loginerror-green\">Your theme has been modified successfully.</span>";
	} else if ($errcode==203) {
		$_GET['mode'] = "password";
		echo "<span class=\"loginerror-green\">Your password has been changed.</span>";
	} else {
		echo "<span class=\"loginerror-red\">An unknown error occurred (#" . $errcode . ")</span>";
	}
	
	echo "</div>";
	
}
unset($_SESSION['errcode'], $_SESSION['errnote']);

?>
<div id="leftbar">
<ul id="leftbar-list">
	<li id="leftbar-li-profile"><span id="leftbar-a-profile"<?php if($_GET['mode']=="profile"||!isset($_GET['mode'])){ echo ' class="leftbarselected"';} ?> showdiv="settings-profile">Profile</span></li>
	<li id="leftbar-li-theme"><span id="leftbar-a-theme"<?php if($_GET['mode']=="theme"){ echo ' class="leftbarselected"';} ?> showdiv="settings-theme">Theme</span></li>
	<li id="leftbar-li-password"><span id="leftbar-a-password"<?php if($_GET['mode']=="password"){ echo ' class="leftbarselected"';} ?> showdiv="settings-password">Password</span></li>
</ul>
</div>
<div id="settingsbox">


<div id="settings-profile" class="settings-divpage<?php if($_GET['mode']=="profile"||!isset($_GET['mode'])){ echo ' settings-divpage-selected';} ?>">
<form action="<?php echo $siteaddr; ?>/updatesettings.php" method="post" id="settings-profile-form">
<input type="hidden" name="mode" value="profile" />
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-profile-mobilephone">Mobile phone</label></td>
	<td class="settings-table-edit"><input type="text" name="mobilephone" id="settings-profile-mobilephone" value="<?php echo $row[7]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-profile-homephone">Home phone</label></td>
	<td class="settings-table-edit"><input type="text" name="homephone" id="settings-profile-homephone" value="<?php echo $row[8]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-profile-emailaddr">Email address</label></td>
	<td class="settings-table-edit"><input type="text" name="emailaddr" id="settings-profile-emailaddr" value="<?php echo $row[9]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Save"></input></td>
</tr>
</tbody></table>
</form>
</div>


<div id="settings-theme" class="settings-divpage<?php if($_GET['mode']=="theme"){ echo ' settings-divpage-selected';} ?>">
<form action="<?php echo $siteaddr; ?>/updatesettings.php" method="post" id="settings-theme-form">
<input type="hidden" name="mode" value="theme" />
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-theme-backcolor">Backcolor</label></td>
	<td class="settings-table-edit"><input type="text" name="backcolor"  id="settings-theme-backcolor" class="color {hash:true}" size="10" value="<?php echo $_SESSION['backcolor']; ?>"></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-theme-forecolor">Forecolor</label></td>
	<td class="settings-table-edit"><input type="text" name="forecolor" id="settings-theme-forecolor" class="color {hash:true}" size="10" value="<?php echo $_SESSION['forecolor']; ?>"></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-theme-forehcolor">Forecolor-hover</label></td>
	<td class="settings-table-edit"><input type="text" name="forehcolor" id="settings-theme-forehcolor" class="color {hash:true}" size="10" value="<?php echo $_SESSION['forehcolor']; ?>"></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Save">&nbsp;&nbsp;&nbsp;<input type="button" value="Restore defaults" id="settings-theme-defaults"></td>
</tr>
</tbody></table>
</form>
</div>


<div id="settings-password" class="settings-divpage<?php if($$_GET['mode']=="password"){ echo ' settings-divpage-selected';} ?>">
<form action="<?php echo $siteaddr; ?>/updatesettings.php" method="post" id="settings-password-form">
<input type="hidden" name="mode" value="password" />
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-profile-oldpassword">Old password</label></td>
	<td class="settings-table-edit"><input type="password" name="oldpassword" id="settings-profile-oldpassword" value=""></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-profile-newpassword">New password</label></td>
	<td class="settings-table-edit"><input type="password" name="newpassword" id="settings-profile-newpassword" value=""></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-profile-confirmpassword">Confirm new password</label></td>
	<td class="settings-table-edit"><input type="password" name="confirmpassword" id="settings-profile-confirmpassword" value=""></input></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Save"></input></td>
</tr>
</tbody></table>
</form>
</div>


</div>
<div id="bottomclear"></div>
<?php

require_once('footer.php');

?>