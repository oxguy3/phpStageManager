<?php
require_once('config.php');
$pagetitle="Edit role";


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
    $row = array("new", "", "1,2,3", 1, 1, 1, 1);
    
} else if (is_numeric($eid)) {
    $sqlGetRole = "SELECT * FROM `" . $sql_pref . "roles` WHERE `id`='" . $eid . "'";
    $resultGetRole = mysql_query($sqlGetRole) or die("Database connection failed.");
    $row = mysql_fetch_row($resultGetRole);
    
    if (mysql_num_rows($resultGetRole) <= 0) {
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
<form action="<?php echo $siteaddr; ?>/updaterole.php" method="post" id="settings-roles-create-form">
<input type="hidden" name="u-id" value="<?php echo $row[0]; ?>" />
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-roles-create-title">Name</label></td>
	<td class="settings-table-edit"><input type="text" name="u-title" id="settings-roles-create-title" value="<?php echo $row[1]; ?>"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-roles-create-scenes">Scenes</label></td>
	<td class="settings-table-edit"><input type="text" name="u-scenes" id="settings-roles-create-scenes" value="<?php echo $row[2]; ?>"></input> (comma separated list, no spaces)</td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-roles-create-roletype">Role type</label></td>
	<td class="settings-table-edit"><select name="u-roletype" id="settings-roles-create-roletype">
		<option value="1"<?php if ($row[3]==1) { echo " selected=\"selected\""; } ?>>Cast</option>
		<option value="2"<?php if ($row[3]==2) { echo " selected=\"selected\""; } ?>>Crew</option>
	</select></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-roles-create-showinscenes">Show in scene breakdown?</label></td>
	<td class="settings-table-edit"><select name="u-showinscenes" id="settings-roles-create-showinscenes">
		<option value="1"<?php if ($row[4]==1) { echo " selected=\"selected\""; } ?>>Yes</option>
		<option value="0"<?php if ($row[4]==0) { echo " selected=\"selected\""; } ?>>No</option>
	</select></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-roles-create-showindirectory">Show in directory?</label></td>
	<td class="settings-table-edit"><select name="u-showindirectory" id="settings-roles-create-showindirectory">
		<option value="1"<?php if ($row[5]==1) { echo " selected=\"selected\""; } ?>>Yes</option>
		<option value="0"<?php if ($row[5]==0) { echo " selected=\"selected\""; } ?>>No</option>
	</select></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-roles-create-showincaldropdown">Show in calendar dropdown?</label></td>
	<td class="settings-table-edit"><select name="u-showincaldropdown" id="settings-roles-create-showincaldropdown">
		<option value="1"<?php if ($row[6]==1) { echo " selected=\"selected\""; } ?>>Yes</option>
		<option value="0"<?php if ($row[6]==0) { echo " selected=\"selected\""; } ?>>No</option>
	</select></td>
</tr>
<tr>
	<td class="settings-table-label"></td>
	<td class="settings-table-edit settings-table-submit"><input type="submit" value="Submit"></input></td>
</tr>
</tbody></table></form>
<?php
require_once('footer.php');
?>