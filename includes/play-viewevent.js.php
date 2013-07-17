<?php
require_once('../config.php');

header('Content-type: text/javascript');

$link = startmysql();

?>
$(document).ready(function() {
    ////OLD COMMA-SEPARATED FUNCTION: http://pastebin.com/Sy94FL6J
    
	$(function() {
		/*function log( message ) {
			$( "<div/>" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );
		}*/

		$( "#ev-input-otherroles-text" ).autocomplete({
			source: function( request, response ) {
				$.getJSON( "<?php echo $siteaddr; ?>/jsonroles.php", {
						q: request.term
					}, response );
				/*$.ajax({
					url: "<?php echo $siteaddr; ?>/jsonroles.php",
					type: get,
					dataType: "jsonp",
					data: {
						q: request.term
					},
					success: function( data ) {
						response( $.map( data.geonames, function( item ) {
							return {
								label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
								value: item.name
							}
						}));
					}
				});*/
			},
			minLength: 1/*,
			select: function( event, ui ) {
				log( ui.item ?
					"Selected: " + ui.item.label :
					"Nothing selected, input was " + this.value);
			}*//*,
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}*/
		});
	});
	
	
	<?php
	/*
	$orolesarr = explode(",", $row[12]);
	$orolesnums = $row[12] . ",";
	
	for ($w=0; $w < count($orolesarr); $w++) {
		
		$sqlor = "SELECT * FROM `" . $sql_pref . "roles` WHERE `id` = " . $orolesarr[$w] . " LIMIT 0, 1 ";
		$resultor = mysql_query($sqlor) or die("Query failed:\n" . mysql_error());
		$rowor = mysql_fetch_row($resultor);
		
		?>
	document.getElementById("otherroles-dump").appendChild(createOtherRolesSelect("<?php echo $orolesarr[$w]; ?>"));
		<?php
		
		/*if ($w!=0) {
			$orolestext .= ", ";
		}
		$orolestext .= $rowor[1];****
	}*/
	?>
	
	
	/**
	 * Creates a <select> object containing all the roles, with the given role ID selected
	 */
	function createOtherRolesSelect(selrole) {
		
		var uid = document.getElementsByName("otherroles_sel").length + 1;
		
		var orselect = document.createElement("select");
		orselect.setAttribute("name", "otherroles_sel");
		orselect.setAttribute("id", "otherroles-sel-"+uid.toString());
		
<?php
		
		$sqlroles = "SELECT * FROM `" . $sql_pref . "roles` ORDER BY `" . $sql_pref . "roles`.`title` ASC";
		$resultroles = mysql_query($sqlroles) or die("Query failed:\n" . mysql_error());
		
		for ($iroles=0; $iroles < mysql_num_rows($resultroles); $iroles++) {
		
			$rowroles = mysql_fetch_row($resultroles);
			?>
			option = document.createElement("option");
			option.setAttribute("value", "<?php echo $rowroles[0]; ?>");
			option.innerHTML = "<?php echo $rowroles[1]; ?>";
			if (selrole == "<?php echo $rowroles[0]; ?>") {
				option.setAttribute("selected","selected");
			}
			orselect.appendChild(option);
			
<?php
		}
		
		?>
		
		return orselect;
	}
	
	
	
	
	var now = new Date();

	$('#input-ev-dtstart').scroller({
		preset: 'datetime',
		theme: 'default',
		display: 'modal',
		mode: 'scroller',
		dateFormat: 'yy-mm-dd',
		separator: ' ',
		timeFormat: 'HH:ii:ss',
		dateOrder: 'D ddMyy'
	});

	$('#input-ev-dtend').scroller({
		preset: 'datetime',
		theme: 'default',
		display: 'modal',
		mode: 'scroller',
		dateFormat: 'yy-mm-dd',
		separator: ' ',
		timeFormat: 'HH:ii:ss',
		dateOrder: 'D ddMyy'
	});
	
	//$('#input-ev-dtstart').css("display","none");
	//$('#input-ev-dtend').css("display","none");
    
    
    
	
	
    
    $('#helptip-edittitle').qtip({
            content: '<small>This is the title for the rehearsal. For most normal rehearsals, this should be "@". Setting this to "@" will cause the calendar to automagically show the title as "Sc. ###"<br><br>\nOnly for rehearsals where the title should NOT be "Sc. ###" (i.e. "Chorus Call", "Full Run", etc.) should you change this.</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
    
    $('#helptip-editscenes').qtip({
            content: '<small>This should be a comma-separated list of all the scenes that are called for a rehearsal. Each scene must be listed individually rather than as a range (i.e. don\'t do "1-4", do "1,2,3,4"). If this rehearsal is an all call, just put "0" instead of listing all the scenes.</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
    
    $('#helptip-editotherroles').qtip({
            content: '<small>If there are any roles (i.e. characters, crew positions, etc.) who are not in the scenes you\'ve set for this event, but are nonetheless called, include them here. Start typing a name and a list of suggestions will appear.</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
	
    $('#helptip-editdtstart').qtip({
			content:'<small>The start time for this event. Naturally, this must come before the end time.</small>',
            //content: 'These dates <b>must</b> be in the format "YYYY-MM-DD HH:MM:SS".<small><br><br>\n(hopefully soon I\'ll have a date picker thingy to make this easier)<br><br>\n</small><b>N.B.</b> The hours need to be in 24 hour time.</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
    
    $('#helptip-editdtend').qtip({
			content:'<small>The end time for this event. Naturally, this must come after the start time.</small>',
            //content: 'These dates <b>must</b> be in the format "YYYY-MM-DD HH:MM:SS".<small><br><br>\n(hopefully soon I\'ll have a date picker thingy to make this easier)<br><br>\n</small><b>N.B.</b> The hours need to be in 24 hour time.</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
    
    $('#helptip-editstatus').qtip({
            content: '<small>Generally just use \'Confirmed\' or \'Cancelled\'.<br><br>\nMost iCal viewers show Cancelled events striked out, but don\'t differentiate between Confirmed and Tentative.<br><br>\nOn the web calendar, Confirmed=green, Cancelled=red, and Tentative=blue.</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
    
    $('#helptip-editcomments').qtip({
            content: '<small>Add any extra notes about the rehearsal here (optional).</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
    
    $('#helptip-editshowscenes').qtip({
            content: '<small>If set to "yes", then the scenes for this rehearsal will be shown in addition to the title (i.e. if you want to set a custom title, but you still want the scenes to be visible). In most cases, however, this should be set to "no".</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
    
    $('#helptip-editallday').qtip({
            content: '<small><strong>This feature is not compatible with iCalendar; it\'s best to leave this set as "no" for the time being.</strong><br />Denotes this event as an all day event such as a holiday, rather than an event that runs for a specific time span.</small>',
            position: {
                corner: {
                    target: 'bottomLeft'
                }
            }
    });
});

function verifyDelete() {
	var r = confirm("Are you absolutely sure you want to delete this event? (if you are cancelling this event, it might be better to not delete it, but instead change its status to Cancelled)");
	
	if (r == true) {
		var node = document.createElement('input');
		node.setAttribute('type', 'hidden');
		node.setAttribute('value', '1');
		node.setAttribute('name', 'ev-delete');
		
		document.getElementById("event-edit-form").appendChild(node);
		
		document.getElementById("event-edit-form").submit();
		
	} else {
		//alert("kay");
	}
}