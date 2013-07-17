<?php
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//// I DON'T BELIEVE THIS FILE IS ACTUALLY BEING USED....
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////

require_once('config.php');

mustBeLoggedIn(); //anons don't need access to this, so let's not give it

$link = startmysql();

$sqltitlein = "";
if (isset($_GET['q'])) {
	$titlein = $_GET['q'];
	$titlein = mysql_real_escape_string($titlein);
	$sqltitlein = " WHERE `title` LIKE '" . $titlein . "%'";
}

$sql = "SELECT * FROM `" . $sql_pref . "roles`" . $sqltitlein /*. " WHERE `roletype`=1" *//*. " ORDER BY `" . $sql_pref . "roles`.`title` ASC" */. " LIMIT 0, 500";
$result = mysql_query($sql) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");

$rolesarr = array();

for($i=0; $i < mysql_num_rows($result); $i++) {
	
	$row = mysql_fetch_row($result);
	
	$rolesarr[$i] = array(
		'label' => $row[1],
		'value' => $row[0]
	);
	
	
}

header('Content-type:application/json');
echo json_encode($rolesarr);

mysql_free_result($result);
mysql_close($link);
?>