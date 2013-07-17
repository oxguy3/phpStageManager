</head>
<body>
<div id="pageheader">
<div id="pageheadermargins">
<div id="sitetitle"><a href="<?php echo $siteaddr; ?>"><?php echo $sitetitle; ?></a></div>


<div id="minilogin">
<?php

if (!isset($_SESSION['user'])) {

?>
<form name="minilogin" method="POST" action="<?php echo $siteaddr; ?>/checklogin.php">
<input type="hidden" name="requesturi" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table id="minilogin-table"><tbody>
	<tr>
		<td id="minilogin-td-label-u"><label for="minilogin-in-u">Username: </label></td>
		<td class="minilogin-td-in"><input name="u" type="text" id="minilogin-in-u" required="required" tabindex="1"></td>
		<td><span id="minilogin-help"><a href="<?php echo $siteaddr; ?>/login.php">Help</a></span></td>
	</tr>
	<tr>
		<td id="minilogin-td-label-p"><label for="minilogin-in-p">Password: </label></td>
		<td class="minilogin-td-in"><input name="p" type="password" id="minilogin-in-p" required="required" tabindex="2"></td>
		<td><input type="submit" name="Submit" value="Login" id="minilogin-submit" tabindex="3"></td>
	</tr>
</tbody></table>
</form>
<?php

} else {

?>
<table id="minilogin-table-alt"><tbody>
	<tr>
		<?php /*<td rowspan="2"><img src="http://www.gravatar.com/avatar/<?php echo md5($_SESSION['email']); ?>?s=48&d=monsterid" alt="Gravatar user icon" /></td>*/?>
		<td colspan="4" id="minilogin-alt-yourname"><?php echo $_SESSION['user']; ?></td>
	</tr>
	<tr id="minilogin-alt-useroptions">
		<td id="minilogin-alt-useroptions-l2" class="minilogin-alt-td"></td>
		<td id="minilogin-alt-useroptions-l" class="minilogin-alt-td"><a href="<?php echo $siteaddr; ?>/settings.php" class="minilogin-alt-a">Settings</a></td>
		<td id="minilogin-alt-useroptions-r" class="minilogin-alt-td"><a href="<?php echo $siteaddr; ?>/checklogin.php" class="minilogin-alt-a">Logout</a></td>
		<td id="minilogin-alt-useroptions-r2" class="minilogin-alt-td"></td>
	</tr>
</tbody></table>
<?php

}

?>
</div>

<?php
/*switch($_SERVER['PHP_SELF']) {
	case "/index.php":
		$seltab = "home";
		break;
	case "/mastercal.php":
		$seltab = "calendar";
		break;
	case "/contactsheet.php":
		$seltab = "castlist";
		break;
	case "/scenebreakdown.php":
		$seltab = "sceneinfo";
		break;
	case "/downloads.php":
		$seltab = "downloads";
		break;
	default:
		$seltab = "";
		break;
}*/

function highlightSelTab($tabname) {
	global $sitesubdir;
	if ($sitesubdir . $tabname == $_SERVER['PHP_SELF']) {
		echo ' id="navbar-selected"';
	}
}
?>
<ul class="navbar">
	<li><a href="<?php echo $siteaddr; ?>"<?php highlightSelTab("/index.php")?>>Home</a></li>
	<li><a href="<?php echo $siteaddr; ?>/mastercal.php"<?php highlightSelTab("/mastercal.php")?>>Calendar</a></li>
	<li><a href="<?php echo $siteaddr; ?>/contactsheet.php"<?php highlightSelTab("/contactsheet.php")?>>Directory</a></li>
	<li><a href="<?php echo $siteaddr; ?>/scenebreakdown.php"<?php highlightSelTab("/scenebreakdown.php")?>>Scenes</a></li>
	<!--<li><a href="<?php echo $siteaddr; ?>/downloads.php"<?php highlightSelTab("/downloads.php")?>>Downloads</a></li>-->
</ul>
</div>
</div>
<div id="pagetitle"><?php echo $pagetitle; ?></div>
<div id="pagebody">
<?php
if (isset($_SESSION['username'])) {
?>
<div id="username">Hello <?php echo $_SESSION['username']; ?>!</div>
<?php } ?>