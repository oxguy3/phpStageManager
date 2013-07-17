<?php
require_once('config.php');

$link = startmysql();
$sql = "SELECT * FROM `" . $sql_pref . "roles` WHERE `showInScenes`=1 ORDER BY `roletype`,`title` ASC";
$result = mysql_query($sql) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");


$pagetitle="Scene Breakdown";
require_once('topheader.php');


require_once('header.php');

?>
<table id="scenebreakdown" class="mydatatable">
<?php

$sctableheader = "<tr>\n" . '<th id="scenes-header-name" class="scenes-header">Name</th>';
for ($i=1; $i<=$scenecount; $i++) {
	$sctableheader .= "<th class=\"scenes-header\">" . $spacer . $i . $spacer . "</th>" . $br;
}
$sctableheader .= '</tr>';

//$prevroletype = 1;

for($i=0; $i < mysql_num_rows($result); $i++) {
	
	if ($i/*%20*/ == 0) {
		echo $sctableheader;
	}
	
	//$line = mysql_fetch_array($result, MYSQL_ASSOC)
	$row = mysql_fetch_row($result);
	
	
	echo "<tr class=\"scenes-row\">" . $br;
	echo "<td class=\"scenes-box scenes-namebox\">" . $row[1] . "</td>" . $br;
	
	$scarray = explode(",", ",".$row[2]); //the preceding comma prevents the first scene from getting omitted
	for ($j=1; $j<=$scenecount; $j++)
	{
		$asdf++;
		if ($j%2==1) {
			$colcolor = "#dddddd";
		} else {
			$colcolor = "#ffffff";
		}
		if (array_search($j,$scarray)) {
			echo "<td class=\"scenes-box scenes-marked\" style=\"background-color:$colcolor;\">X</td>";
		} else {
			echo "<td class=\"scenes-box scenes-blank\" style=\"background-color:$colcolor;\">&nbsp;</td>";
		}
	}
	
	echo "</tr>\n";
	
}
?>
</table>
<?php
//echo "<b>" . $asdf . "</b>";

require_once('footer.php');

mysql_free_result($result);
//mysql_free_result($resultr);
mysql_close($link);
?>