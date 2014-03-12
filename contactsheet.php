<?php
require_once('config.php');

$link = startmysql();
$sql = "SELECT * FROM `" . $sql_pref . "users` ORDER BY `lastname` ASC";// . " LIMIT 0, 100 "; //this commented code would limit to 100 people
$result = mysql_query($sql) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");


$pagetitle="Directory";
require_once('topheader.php');

?>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-1.7.2.min.js'></script>
<script type='text/javascript'>

</script>
<?php

require_once('header.php');

?>
<table id="contactsheet" class="mydatatable">
<tr>
<!--<th id="contactsheet-callink" style="min-width:16px" title="Link to this person's calendar"></th>-->
<?php if (intval($_SESSION['permission'])>=2) { ?><th id="contactsheet-edit" style="min-width:16px;">&nbsp;</th><?php } ?>
<th id="contactsheet-name" style="width:20%;/*26%*/">Name</th>
<th id="contactsheet-roles" style="width:24%;/*18%*/">Roles</th>
<th id="contactsheet-mobilephone" style="width:15%;">Mobile Phone</th>
<th id="contactsheet-homephone" style="width:15%;">Home Phone</th>
<th id="contactsheet-email" style="width:26%;">Email</th>
</tr>
<?php
    
    	for($i=0; $i < mysql_num_rows($result); $i++) {
		
		//$line = mysql_fetch_array($result, MYSQL_ASSOC)
		$row = mysql_fetch_row($result);
		
		/*for($ct=0; $ct < count($row); $ct++) {
			if ($row[$ct]=="0") {
				$row[$ct]="0";
			}
		}*/
		
		
		
		$rowshading = "odd";
		if ($i % 2 == 0) {
			$rowshading = "even";
		}
		
		echo "<tr class=\"contactsheet-row-" . $rowshading . "\">" . $br;
        
		if (intval($_SESSION['permission'])>=2) {
            echo "<td class=\"contactsheet-edit\">";
			echo '<a href="edituser.php?id=' . $row[0] . '"><div class="contactsheet-edit-button" title="Edit this user">&nbsp;</div></a>';
            echo "</td>";
		}
        
		echo "<td class=\"contactsheet-name\">" . $row[4] . " " . $row[5] . "</td>" . $br;
		
		echo "<td class=\"contactsheet-roles\">";
		if ($row[6]!="") {
			$roleids = explode(",", $row[6]);
			for ($j=0; $j<count($roleids); $j++) {
				$sqlr = "SELECT * FROM `" . $sql_pref . "roles` WHERE `id` = " . $roleids[$j];
				$resultr = mysql_query($sqlr) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");
				$rowr = mysql_fetch_row($resultr);
				if ($rowr[5]!="0") {
					if ($j!=0){
						echo " / ";
					}
					echo $rowr[1];
				}
			}
		}
		echo "</td>" . $br;
		
		
		echo "<td class=\"contactsheet-mobilephone\">";
		if ($row[7]!="0") {
			echo $row[7];
		} else {
			echo "?";
		}
		echo "</td>" . $br;
		
		echo "<td class=\"contactsheet-homephone\">";
		if ($row[8]!="0") {
			echo $row[8];
		} else {
			echo "?";
		}
		echo "</td>" . $br;
		
		echo "<td class=\"contactsheet-email\">";
		if ($row[9]!="0") {
			echo "<a href=\"mailto:" . $row[9] . "\">" . $row[9] . "</a>";
		} else {
			echo "?";
		}
		echo "</td>" . $br;
		
		echo "</tr>\n";
		//print_r($row);
		
	}
?>
</table>
<?php
require_once('footer.php');

mysql_free_result($result);
mysql_free_result($resultr);
mysql_close($link);
?>