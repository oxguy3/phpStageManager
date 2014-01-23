<?php
require_once('config.php');

$errorcode=0;

if (isset($_GET['id'])) {
	$eid = $_GET['id'];
} else {
	$errorcode=2; //no id specified
}

if ($eid=="new") {
	
	if (!isset($_SESSION['user']) || intval($_SESSION['permission'])<1) {
		die("You don't have permission to create new events.");
	}
	
	
	if (!isset($_GET['dtstart'])) {
		die("You did not specify a start time; all parameters are required.");
	}
	if (date("Y-m-d H:i:s", strtotime($_GET['dtstart']))!=$_GET['dtstart']) {
		die("Your start time was not properly formatted. Correct format: \"1999-12-31 23:59:59\"");
	}
	
	if (!isset($_GET['dtend'])) {
		die("You did not specify an end time; all parameters are required.");
	}
	if (date("Y-m-d H:i:s", strtotime($_GET['dtend']))!=$_GET['dtend']) {
		die("Your end time was not properly formatted. Correct format: \"1999-12-31 23:59:59\"");
	}
	
	
	$link = startmysql();
	
	//Structure of `cal_events`:
	//title, id, loc, dtstamp, dtstart, dtend, userid, comments, scenes, allday, showscenes, status, other_roles
	$row = array("@", "new", "DAC", "", $_GET['dtstart'], $_GET['dtend'], $_SESSION['id'], "", "0", 0, 0, 2, "0");
	$evtitle = "[title]";
	
	$pagetitle = "New Event";
	
} else {
	if ($errorcode==0&&!is_numeric($eid)) {
		$errorcode=3; //event id must be a number
	}
	
	
	if ($errorcode==0) {
		$link = startmysql();
		$sql = "SELECT * FROM `cal_events` WHERE `id` = " . mysql_real_escape_string(stripslashes($eid)) . " LIMIT 0, 1 ";
		$result = mysql_query($sql) or $errorcode=5;
		
		if ($errorcode!=5) {
			$row = mysql_fetch_row($result);
		}
		if (is_null($row[6])&&$errorcode==0){
			$errorcode=4; //die("ERROR: Event not found");
		}
	}
	
	
	if ($row[0]!="@") { //for events with legit titles
		$evtitle = $row[0];
		
	} else { //for events with no real title
		$scarray = getRanges( explode(",", $row[8]) );
		$evtitle = "Sc. ";
		for ($w=0; $w < count($scarray); $w++) {
			if ($w!=0) {
				$evtitle = $evtitle . ", ";
			}
			$evtitle = $evtitle . $scarray[$w];
		}
	}
	
	$pagetitle="View Event"; // . $evtitle
}
require_once('topheader.php');
?>
<style type="text/css">
.eventeditbox-td
{
<?php
if (!isset($_SESSION['user']) || intval($_SESSION['permission'])<1) {
	echo "    display:none;" . $br;
}
?>
}
.eventeditbox-td input, .eventeditbox-td textarea, .eventeditbox-td select
{
    width:180px;
}
.eventeditbox-td textarea
{
    max-width:470px;
}
.form-radio
{
    width:13px;
    max-width:15px;
}
/*#viewevent-table tr td
{
    vertical-align:top;
}*/

#viewevent-table
{
    font-size:16px;
    width:100%;
}
</style>
<!--<style type="text/css">
.ui-autocomplete {
	max-height: 100px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
	/* add padding to account for vertical scrollbar */
	padding-right: 20px;
}
/* IE 6 doesn't support max-height
 * we use height instead, but this forces the menu to always be this tall
 */
* html .ui-autocomplete {
	height: 100px;
}
</style>-->
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-ui-1.8.17.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery.qtip-1.0.0-rc3.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/mobiscroll-2.0.1.custom.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/play-viewevent.js.php'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $siteaddr; ?>/includes/smoothness/jquery-ui-1.8.18.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteaddr; ?>/includes/mobiscroll-2.0.1.custom.min.css" />
<?php

require_once('header.php');


if (isset($_GET['errcode'])) {
	
	echo '<div id="errcodeinfo" style="text-align:center; font-weight:bold;">';
	
	if ($_GET['errcode']==201) {
		if (isset($_SESSION['user']) && intval($_SESSION['permission'])>=1) {
			echo '<span style="color:green;">Event successfully edited</span>';
		}
	} else {
		echo '<span style="color:red;">Unknown error/status code: ' . $_GET['errcode'] . '</span>';
	}
	
	echo '</div>';
}


?>
<div id="eventinfo">
<?php
if ($errorcode==0) {
	$evstatus="";
	$evcolor="";
	if ($row[11]==1) {
		$evstatus = "Tentative";
		$evcolor = "#36c";
	} else if ($row[11]==2) {
		$evstatus = "Confirmed";
		$evcolor = "#3c6";
	} else if ($row[11]==3) {
		$evstatus = "Cancelled";
		$evcolor = "#c36";
	} else {
		$evstatus = "Unknown";
		$evcolor = "#555";
	}
	
	$sqlu = "SELECT * FROM `" . $sql_pref . "users` WHERE `id` = " . $row[6] . " LIMIT 0, 1 ";
	$resultu = mysql_query($sqlu) or die("Query failed:\n" . mysql_error());
	$rowu = mysql_fetch_row($resultu);
	
	/////////////////////////////////////////////////////////////////////////
	//// HUGE NOTE TO SELF:
	//// THE WEB SERVER IS ASSUMING LOCAL TIMESTAMPS ARE IN CHICAGO TIME
	/////////////////////////////////////////////////////////////////////////
	
?>
<form action="<?php echo $siteaddr; ?>/updateevent.php" method="POST" autocomplete="off" id="event-edit-form">
<input type="hidden" name="ev-id" value="<?php echo $row[1]; ?>">
<table id="viewevent-table"><tbody>
<tr>
	<td width="50%"><div class="event-qtip-title"><?php echo $evtitle; ?></div></td>
	<td class="eventeditbox-td"><input type="text" name="ev-title" value="<?php echo $row[0]; 
		?>">&nbsp;<img id="helptip-edittitle" src="<?php echo $siteaddr; ?>/images/question_icon.gif" alt="(?)"></td>
</tr>
<?php	
	if ($row[10]==1 || (isset($_SESSION['user']) && intval($_SESSION['permission'])>=1)) {
		$scarray = getRanges( explode(",", $row[8]) );
		
		$scenestyle = ''; //this code used to italicize the scenes if they shouldn't technically be visible
		if ($row[10]!=1) { $scenestyle = ' style="font-style:italic;"'; }
		
		echo "<tr>" . $br;
		echo "\t<td><div class=\"event-qtip-scenes\"" . $scenestyle . "><span class=\"event-qtip-label\">Scenes:</span> ";
		
		for ($w=0; $w < count($scarray); $w++) {
			if ($w!=0) {
				echo ", ";
			}
			echo $scarray[$w];
		}
		echo "</div></td>" . $br;
		echo "\t" . '<td class="eventeditbox-td"><input type="text" name="ev-scenes" value="' .$row[8]. '">&nbsp;<img id="helptip-editscenes" src="';
			echo $siteaddr. '/images/question_icon.gif" alt="(?)"></td>' . $br;
		echo "</tr>" . $br;
		
	}
	
	
	
	
	
	echo "<!--"; ////TEMPORARY
	
	$orolestext = "";
	$orolesnums = "";
	echo "<tr>" . $br;
	echo "\t<td><div class=\"event-form-otherroles\"><span class=\"event-qtip-label\">Other roles:</span>";
	
	if ($row[12]!=0) {
		$orolesarr = explode(",", $row[12]);
		$orolesnums = $row[12] . ",";
		
		for ($w=0; $w < count($orolesarr); $w++) {
		
			$sqlor = "SELECT * FROM `" . $sql_pref . "roles` WHERE `id` = " . $orolesarr[$w] . " LIMIT 0, 1 ";
			$resultor = mysql_query($sqlor) or die("Query failed:\n" . mysql_error());
			$rowor = mysql_fetch_row($resultor);
			
			if ($w!=0) {
				$orolestext .= ", ";
			}
			$orolestext .= $rowor[1];
		}
		
		echo " " . $orolestext;
		$orolestext .= ", "; //I add this last comma wierdly now because I don't want the comma to show up the first time I echo $orolestext
	}
	
	echo "</div></td>" . $br;
	//echo '<input type="hidden" id="ev-input-otherroles-hidden" value="' . $orolesnums . '">' . $br;
	echo "\t" . '<td class="eventeditbox-td"><input type="text" id="ev-input-otherroles-text" name="ev-otherroles-names" value="' . $orolestext . '" />&nbsp;<img id="helptip-editotherroles" src="';
		echo $siteaddr. '/images/question_icon.gif" alt="(?)"></td>' . $br;
	echo "</tr>" . $br;
	
	echo "-->"; ////TEMPORARY
?>
<tr>
	<td><div class="event-qtip-start"><span class="event-qtip-label">Start:</span> <?php echo date('D M j, Y', strtotime($row[4])); 
		?> at <?php echo date('g:i A', strtotime($row[4])); ?></div></td>
	<td class="eventeditbox-td"><input type="text" id="input-ev-dtstart" name="ev-dtstart" value="<?php echo $row[4]; 
		?>">&nbsp;<img id="helptip-editdtstart" src="<?php echo $siteaddr; ?>/images/question_icon.gif" alt="(?)"></td>
</tr>
<tr>
	<td><div class="event-qtip-end"><span class="event-qtip-label">End:</span> <?php echo date('D M j, Y', strtotime($row[5])); 
		?> at <?php echo date('g:i A', strtotime($row[5])); ?></div></td>
	<td class="eventeditbox-td"><input type="text" id="input-ev-dtend" name="ev-dtend" value="<?php echo $row[5]; 
		?>">&nbsp;<img id="helptip-editdtend" src="<?php echo $siteaddr; ?>/images/question_icon.gif" alt="(?)"></td>
</tr>
<tr>
	<td><div class="event-qtip-status"><span class="event-qtip-label">Status:</span> <font color="<?php echo $evcolor; 
		?>"><?php echo $evstatus; ?></font></div></td>
	<td class="eventeditbox-td"><select name="ev-status">
		<option value="1"<?php if ($row[11]==1) { echo " selected=\"selected\""; } ?>>Tentative</option>
		<option value="2"<?php if ($row[11]==2) { echo " selected=\"selected\""; } ?>>Confirmed</option>
		<option value="3"<?php if ($row[11]==3) { echo " selected=\"selected\""; } ?>>Cancelled</option>
	</select>&nbsp;<img id="helptip-editstatus" src="<?php echo $siteaddr; ?>/images/question_icon.gif" alt="(?)"></td>
</tr>
<tr>
	<td><div class="event-qtip-loc"><span class="event-qtip-label">Location:</span> <?php echo $row[2]; ?></div></td>
	<td class="eventeditbox-td"><input type="text" name="ev-loc" value="<?php echo $row[2]; ?>"></input></td>
</tr>
<tr>
	<td><div class="event-qtip-comments"><?php echo $row[7]; ?></div></td>
	<td class="eventeditbox-td"><textarea name="ev-comments"><?php echo $row[7]; 
		?></textarea>&nbsp;<img id="helptip-editcomments" src="<?php echo $siteaddr; ?>/images/question_icon.gif" alt="(?)"></td>
</tr>
<?php
if (isset($_SESSION['user']) && intval($_SESSION['permission'])>=1) {

	$showscyes = '';
	$showscno = '';
	
	if ($row[10]==0) {
		$showscno = ' checked="checked"';
	}
	if ($row[10]==1) {
		$showscyes = ' checked="checked"';
	}
	
	
	echo '<tr>' . $br;
	echo "\t" . '<td><div class="event-form-radios"><span class="event-qtip-label">Show scenes?</span></div></td>' . $br;
	
	echo "\t" . '<td class="eventeditbox-td">';
	echo '<input id="radio-showscenes-yes" class="form-radio" type="radio" name="ev-showscenes" value="1"' .$showscyes. '><label for="radio-showscenes-yes">Yes</label>';
	echo '&nbsp;&nbsp;&nbsp;';
	echo '<input id="radio-showscenes-no" class="form-radio" type="radio" name="ev-showscenes" value="0"' .$showscno. '><label for="radio-showscenes-no">No</label>';
	echo '   (just leave this as "no")</td>' . $br;
	
	echo '</tr>' . $br;
	
	$alldayyes = '';
	$alldayno = '';
	
	if ($row[9]==0) {
		$alldayno = ' checked="checked"';
	}
	if ($row[9]==1) {
		$alldayyes = ' checked="checked"';
	}
	
	
	echo '<tr>' . $br;
	echo "\t" . '<td><div class="event-form-radios"><span class="event-qtip-label">All day event?</span></div></td>' . $br;
	
	echo "\t" . '<td class="eventeditbox-td">';
	echo '<input id="radio-allday-yes" class="form-radio" type="radio" name="ev-allday" value="1"' . $alldayyes;
		echo '><label for="radio-allday-yes">Yes</label>';
	echo '&nbsp;&nbsp;&nbsp;';
	echo '<input id="radio-allday-no" class="form-radio" type="radio" name="ev-allday" value="0"' . $alldayno;
		echo '><label for="radio-allday-no">No</label>';
	echo '   (just leave this as "no")</td>' . $br;
	
	echo '</tr>' . $br;
	
}
?>
<tr>
	<td><div class="event-qtip-username">Last edited by <?php echo $rowu[1];/*echo date('Y-m-d H:i:s T', strtotime($row[3]));*/ ?></div></td>
	<td class="eventeditbox-td"><input type="submit" value="Submit" /><?php
	if ($eid!="new") {
		echo '<br><input type="button" value="Delete" name="ev-delete" id="event-delete-button" onclick="verifyDelete()" />';
	}
	?></td>
</tr>
<?php
if (isset($_SESSION['user']) && intval($_SESSION['permission'])>=1) {
	echo "<tr><td colspan=\"2\"><br><b>Before you edit an event for the first time, please read all the <img src='";
		echo $siteaddr . "/images/question_icon.gif' alt='(?)'> info bubbles! Thanks!</b></td></tr>" . $br;
}
?>
</tbody></table>
</form>
<?php

} else {
	echo "ERROR: ";
	switch ($errorcode) {
	case 2:
		echo "No event ID specified.";
		break;
	case 3:
		echo "Event ID must be a number.";
		break;
	case 4:
		echo "Event not found.";
		break;
	case 5:
		echo "Event could not be retrieved from the database.";
		break;
	case 1:
	default:
		echo "An unknown error occurred.";
		break;
	}
}

echo "</div>";

require_once('footer.php');

if ($errorcode==0) {
	if ($eid!="new") {
		mysql_free_result($result);
	}
	mysql_free_result($resultu);
	mysql_close($link);
}
?>