<?php
require_once('config.php');
$pagetitle="Edit user";


$halfassadmincheck = true;
mustBeLoggedIn();
if (intval($_SESSION['permission']) < 2) {
	die("You don't have permission to do that.");
}


$link = startmysql();


if (isset($_GET['id'])) {
	$eid = $_GET['id'];
} else {
	die("No ID specified.");
}

$row = array();

if ($eid == "new") {
    $row = array("new", "", "stinger", 0, "", "", "", "", "", "@");
    
} else if (is_numeric($eid)) {
    $sqlGetUser = "SELECT * FROM `" . $sql_pref . "users` WHERE `id`='" . $eid . "'";
    $resultGetUser = mysql_query($sqlGetUser) or die("Database connection failed.");
    $row = mysql_fetch_row($resultGetUser);
    
    if (mysql_num_rows($resultGetUser) <= 0) {
        mysql_close($link);
        die("Invalid ID specified.");
    }
    
} else {
    die("Invalid ID specified.");
}

require_once('topheader.php');
?>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-1.5.2.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-ui-1.8.11.custom.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/settingspage.js.php'></script>
<link rel='stylesheet' type='text/css' href='<?php echo $siteaddr; ?>/includes/settingspage.css.php' />
<?php
require_once('header.php');
?>
<form action="<?php echo $siteaddr; ?>/updateuser.php" method="post" id="settings-users-edit-form">
<input type="hidden" name="u-id" value="<?php if (isset($_GET['id'])) { echo $_GET['id']; } else { echo "new"; } ?>" />
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-username">Username</label></td>
	<td class="settings-table-edit"><input type="text" name="u-username" id="settings-users-create-username" value="<?php echo $row[1]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-permission">Permission level</label></td>
	<td class="settings-table-edit"><select name="u-permission" id="settings-users-create-permission">
		<option value="0"<?php if ($row[3]==0) { echo " selected=\"selected\""; } ?>>Default</option>
		<option value="1"<?php if ($row[3]==1) { echo " selected=\"selected\""; } ?>>Power user (can edit events)</option>
		<option value="2"<?php if ($row[3]==2) { echo " selected=\"selected\""; } ?>>Administrator</option>
	</select></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-firstname">First name</label></td>
	<td class="settings-table-edit"><input type="text" name="u-firstname" id="settings-users-create-firstname" value="<?php echo $row[4]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-lastname">Last name</label></td>
	<td class="settings-table-edit"><input type="text" name="u-lastname" id="settings-users-create-lastname" value="<?php echo $row[5]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-mobilephone">Mobile phone</label></td>
	<td class="settings-table-edit"><input type="text" name="u-mobilephone" id="settings-users-create-mobilephone" value="<?php echo $row[7]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-homephone">Home phone</label></td>
	<td class="settings-table-edit"><input type="text" name="u-homephone" id="settings-users-create-homephone" value="<?php echo $row[8]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-users-create-emailaddr">Email address</label></td>
	<td class="settings-table-edit"><input type="text" name="u-emailaddr" id="settings-users-create-emailaddr" value="<?php echo $row[9]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Submit"></input></td>
</tr>
</tbody></table></form>
<?php
require_once('footer.php');
?>