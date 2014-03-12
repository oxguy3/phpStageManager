<?php
require_once('config.php');


$halfassadmincheck = true;
mustBeLoggedIn();


/*$link = startmysql();
$sql = "SELECT * FROM `cal_siteinfo`";
$result = mysql_query($sql) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");
$row = mysql_fetch_row($result);*/



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



$pagetitle="Administrative Control Panel";
require_once('topheader.php');
?>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-1.5.2.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-ui-1.8.11.custom.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jscolor/jscolor.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/settingspage.js.php'></script>
<link rel='stylesheet' type='text/css' href='<?php echo $siteaddr; ?>/includes/settingspage.css.php' />
<style type="text/css">

#leftbar-a-general
{
    background-image:url(<?php echo $siteaddr; ?>/images/fatcow/star.png);
}
#leftbar-a-users
{
    background-image:url(<?php echo $siteaddr; ?>/images/fatcow/user.png);
}
#leftbar-a-roles
{
    background-image:url(<?php echo $siteaddr; ?>/images/fatcow/user_sailor.png);
}
#leftbar-a-security
{
    background-image:url(<?php echo $siteaddr; ?>/images/fatcow/shield.png);
}
</style>
<?php
require_once('header.php');


if ($errcode!=0) {
	
	echo "<div id=\"loginerror\">";
	
	if ($errcode==101) {
		echo "<span class=\"loginerror-red\">Missing parameter. You must specify " . $_SESSION['errnote'] . ".</span>";
	} else if ($errcode==102) {
		echo "<span class=\"loginerror-red\">The " . $_SESSION['errnote'] . " you specified contains invalid characters.</span>";
	} else if ($errcode==103) {
		echo "<span class=\"loginerror-red\">The " . $_SESSION['errnote'] . " you specified contains formatting tags.</span>";
	} else if ($errcode==104) {
		$selectedmode = 1;
		echo "<span class=\"loginerror-red\">Username not found in the database.</span>";
	} else if ($errcode==106) {
		echo "<span class=\"loginerror-red\">The website's database is unavailable at the moment.</span>";
	} else if ($errcode==107) {
		echo "<span class=\"loginerror-red\">You specified an invalid mode. Nice try, wannabe hacker.</span>";
	} else if ($errcode==200) {
		echo "<span class=\"loginerror-green\">Success!</span>"; //generic "good" message, shouldn't actually be used
	} else if ($errcode==201) {
		$selectedmode = 0;
		echo "<span class=\"loginerror-green\">Your information has been updated.</span>";
	} else if ($errcode==202) {
		$selectedmode = 1;
		echo "<span class=\"loginerror-green\">Your users have been modified successfully.</span>";
	} else if ($errcode==203) {
		$selectedmode = 2;
		echo "<span class=\"loginerror-green\">Your roles have been modified successfully.</span>";
	} else {
		echo "<span class=\"loginerror-red\">An unknown error occurred (#" . $errcode . ")</span>";
	}
	
	echo "</div>";
	
}
unset($_SESSION['errcode'], $_SESSION['errnote']);

?>
<div id="leftbar">
<ul id="leftbar-list">
	<li id="leftbar-li-general"><span id="leftbar-a-general"<?php if($_GET['mode']=="general"||!isset($_GET['mode'])){ echo ' class="leftbarselected"';} ?> showdiv="settings-general">General</span></li>
	<li id="leftbar-li-users"><span id="leftbar-a-users"<?php if($_GET['mode']=="users"){ echo ' class="leftbarselected"';} ?> showdiv="settings-users">Users</span></li>
	<li id="leftbar-li-roles"><span id="leftbar-a-roles"<?php if($_GET['mode']=="roles"){ echo ' class="leftbarselected"';} ?> showdiv="settings-roles">Roles</span></li>
	<li id="leftbar-li-security"><span id="leftbar-a-security"<?php if($_GET['mode']=="security"){ echo ' class="leftbarselected"';} ?> showdiv="settings-security">Security</span></li>
</ul>
</div>
<div id="settingsbox">

<?php
$link = startmysql();
$sqlUsers = "SELECT * FROM `" . $sql_pref . "users` ORDER BY `username` ASC";// . " LIMIT 0, 100 "; //this commented code would limit to 100 people
$resultUsers = mysql_query($sqlUsers) or die("<span class=\"errortext\">User query failed:<br>\n" . mysql_error() . "</span>");

?>

<div id="settings-general" class="settings-divpage<?php if($_GET['mode']=="general"||!isset($_GET['mode'])){ echo ' settings-divpage-selected';} ?>">

<form action="<?php echo $siteaddr; ?>/crap/print_r.php" method="post" id="settings-general-general-form">
<input type="hidden" name="mode" value="general-general" />
<div class="settings-section-header">General info</div>
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-general-general-sitetitle">Site title</label></td>
	<td class="settings-table-edit"><input type="text" name="sitetitle" id="settings-general-general-sitetitle" value="<?php echo $sitetitle; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-general-general-sitedescription">Site description</label></td>
	<td class="settings-table-edit"><input type="text" name="sitedescription" id="settings-general-general-sitedescription" value="<?php echo $sitedescription; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-general-general-companyname">Company name</label></td>
	<td class="settings-table-edit"><input type="text" name="companyname" id="settings-general-general-companyname" value="<?php echo $companyname; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Save"></input></td>
</tr>
</tbody></table></form>

<form action="<?php echo $siteaddr; ?>/crap/print_r.php" method="post" id="settings-general-mastertheme-form">
<input type="hidden" name="mode" value="general-mastertheme" />
<div class="settings-section-header">Master theme</div>
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-general-mastertheme-backcolor">Backcolor</label></td>
	<td class="settings-table-edit"><input type="text" name="backcolor"  id="settings-general-mastertheme-backcolor" class="color {hash:true}" size="7" value="<?php echo $_SESSION['backcolor']; ?>"></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-general-mastertheme-forecolor">Forecolor</label></td>
	<td class="settings-table-edit"><input type="text" name="forecolor" id="settings-general-mastertheme-forecolor" class="color {hash:true}" size="7" value="<?php echo $_SESSION['forecolor']; ?>"></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-general-mastertheme-forehcolor">Forecolor-hover</label></td>
	<td class="settings-table-edit"><input type="text" name="forehcolor" id="settings-general-mastertheme-forehcolor" class="color {hash:true}" size="7" value="<?php echo $_SESSION['forehcolor']; ?>"></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Save">&nbsp;&nbsp;&nbsp;<input type="button" value="Restore defaults" id="settings-users-defaults"></td>
</tr>
</tbody></table></form>
</div>


<div id="settings-users" class="settings-divpage<?php if($_GET['mode']=="users"){ echo ' settings-divpage-selected';} ?>">
<form action="<?php echo $siteaddr; ?>/crap/print_r.php" method="post" id="settings-users-create-form">
<input type="hidden" name="u-id" value="new" />
<div class="settings-section-header">Create a new user</div>
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-username">Username</label></td>
	<td class="settings-table-edit"><input type="text" name="u-username" id="settings-users-create-username"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-permission">Permission level</label></td>
	<td class="settings-table-edit"><select name="u-permission" id="settings-users-create-permission">
		<option value="0">Default</option>
		<option value="1">Power user (can edit events)</option>
		<option value="2">Administrator</option>
	</select></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-firstname">First name</label></td>
	<td class="settings-table-edit"><input type="text" name="u-firstname" id="settings-users-create-firstname"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-lastname">Last name</label></td>
	<td class="settings-table-edit"><input type="text" name="u-lastname" id="settings-users-create-lastname"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-mobilephone">Mobile phone</label></td>
	<td class="settings-table-edit"><input type="text" name="u-mobilephone" id="settings-users-create-mobilephone"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-homephone">Home phone</label></td>
	<td class="settings-table-edit"><input type="text" name="u-homephone" id="settings-users-create-homephone"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-emailaddr">Email address</label></td>
	<td class="settings-table-edit"><input type="text" name="u-emailaddr" id="settings-users-create-emailaddr"></input></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Create"></input></td>
</tr>
</tbody></table></form>


<div class="settings-section-header">Edit an existing user</div>
<table class="settings-table"><tbody>
<tr>
    <td>To modify or delete an existing user, click the pencil next to their name in <a href="<?php echo $siteaddr; ?>/contactsheet.php">the directory</a>.</td>
</tr>
</tbody></table>

<form action="<?php echo $siteaddr; ?>/updateuser.php" method="post" id="settings-users-resetpass-form">
<div class="settings-section-header">Reset a user password</div>
<input type="hidden" name="u-resetpass" value="true" />
<table class="settings-table"><tbody>
<tr>
    <td colspan="2"><label for="settings-users-resetpass-username">Select the user whose password you would like to reset:</label></td>
</tr>
<tr>
    <td class="settings-table-label"><select name="u-username" id="settings-users-resetpass-username">
        <option>Select a username</option><?php
for($i=0; $i < mysql_num_rows($resultUsers); $i++) {
    
    $row = mysql_fetch_row($resultUsers);
    echo "\n        <option>" . $row[1] . "</option>";
}
?>
    </select></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Reset password"></input></td>
</tr>
</tbody></table></form>
</div>


<div id="settings-roles" class="settings-divpage<?php if($_GET['mode']=="roles"){ echo ' settings-divpage-selected';} ?>">
<form action="<?php echo $siteaddr; ?>/crap/print_r.php" method="post" id="settings-roles-form">
<input type="hidden" name="mode" value="roles" />
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-roles-oldpassword">Old password</label></td>
	<td class="settings-table-edit"><input type="password" name="oldpassword" id="settings-roles-oldpassword" value=""></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-roles-newpassword">New password</label></td>
	<td class="settings-table-edit"><input type="password" name="newpassword" id="settings-roles-newpassword" value=""></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-roles-confirmpassword">Confirm new password</label></td>
	<td class="settings-table-edit"><input type="password" name="confirmpassword" id="settings-roles-confirmpassword" value=""></input></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Save"></input></td>
</tr>
</tbody></table>
</form>
</div>


<div id="settings-security" class="settings-divpage<?php if($_GET['mode']=="security"){ echo ' settings-divpage-selected';} ?>">
<form action="<?php echo $siteaddr; ?>/crap/print_r.php" method="post" id="settings-security-loginauth-form">
<input type="hidden" name="mode" value="security-loginauth" />
<div class="settings-section-header">Login authentication</div>
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-security-loginauth-imapenabled">Enable IMAP?</label></td>
	<td class="settings-table-edit"><input type="checkbox" name="imapenabled" id="settings-security-loginauth-imapenabled"<?php if($psm_imap_enabled){echo " checked";} ?>></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-security-loginauth-imapaddress">IMAP server address</label></td>
	<td class="settings-table-edit"><input type="text" name="imapaddress" id="settings-security-loginauth-imapaddress" value="<?php echo $psm_imap_address; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-security-loginauth-imapusessl">Use SSL with IMAP? (toggle not yet functional)</label></td>
	<td class="settings-table-edit"><input type="checkbox" name="imapusessl" id="settings-security-loginauth-imapusessl"<?php if($psm_imap_usessl){echo " checked";} ?>></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-security-loginauth-imaptimeout">IMAP timeout (in seconds)</label></td>
	<td class="settings-table-edit"><input type="text" name="imaptimeout" id="settings-security-loginauth-imaptimeout" value="<?php echo $psm_imap_timeout; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Save"></td>
</tr>
</tbody></table></form>
</div>


</div>
<div id="bottomclear"></div>
<?php

require_once('footer.php');

?>