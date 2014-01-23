<?php
require_once('config.php');

//$br = "\n          ";

/*$link = startmysql();
//$sql = "SELECT * FROM `" . $sql_pref . "events` WHERE `dtstamp` LIKE '" . date('Y') . "-" . date('m') . "-% %:%:%' LIMIT 0, 100 "; //LIMIT PREVENTS MORE THAN 100 EVENTS EXISTING IN ONE MONTH
$sql = "SELECT * FROM `" . $sql_pref . "events` LIMIT 0, 1000 "; //1000 event limit, so that nothing explodes
$result = mysql_query($sql) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");*/

$pagetitle="Calendar";
require_once('topheader.php');
?>
<link rel='stylesheet' type='text/css' href='<?php echo $siteaddr; ?>/includes/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='<?php echo $siteaddr; ?>/includes/fullcalendar.print.css' media='print'/>
<link rel="stylesheet" type="text/css" href="<?php echo $siteaddr; ?>/includes/mobiscroll-2.0.1.custom.min.css" />
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-ui-1.8.11.custom.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/fullcalendar.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/gcal.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery.qtip-1.0.0-rc3.min.js'></script>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/mobiscroll-2.0.1.custom.min.js'></script>
<script type='text/javascript'>
$(document).ready(function() {
    
    var usingios = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/i) ? true : false)<?php if(isset($_GET['nomobile'])) { echo "&& false"; } ?>;
    
    if (!usingios) {
    $('#icalsubscribe').qtip({
            content: "Works with iCal, iPad/iPhone/iTouch, Outlook, Windows Calendar, etc.",
            position: {
                corner: {
                    target: 'bottomLeft'/*,
                    tooltip: 'topLeft'*/
                }
            }
    });
    }
    
    $('#myrole-select').change( function(){
		if ($('#myrole-select option:selected').attr('username') !== undefined) {
			$('#myrole-username').attr('value', $('#myrole-select option:selected').attr('username'));
		}
        $('#myrole-form').submit();
    });
    
    /*$('#myrole-select').scroller({
        preset: 'select',
        theme: 'default',
        display: 'modal',
        mode: 'scroller',
        inputClass: 'i-txt'
    });*/
    
    $("#neweventbutton").click(function() {
        var now = new Date();
        now.setSeconds(0);
        createNewEvent(now);
    });
    
    $('#calendar').fullCalendar({
    header: {
	left: 'month,agendaWeek,agendaDay',
	center: 'title',
	right: 'prev,next today'
    },
    buttonText: {
        prev: '&lt;',
        next: '&gt;'
    },
    defaultView: 'month',
    eventSources: [
        {
            url: '<?php echo $siteaddr; ?>/eventsfeed.php',
            type: 'GET',
            ignoreTimezone: false,
            data: {<?php
            
            	if (isset($_REQUEST['myrole']) && $_REQUEST['myrole']!="0") {
            		if ($_REQUEST['myrole']=="@") {
            			echo $br . "                onlyrole: '" . $_SESSION['roles'] . "'" . $br . "            ";
            		} else {
            			echo $br . "                onlyrole: '" . $_REQUEST['myrole'] . "'" . $br . "            ";
            		}
            	}
            	
            ?>},
            error: function() {
                <?php
                if (isset($_REQUEST['myrole'])){
                	echo "                alert('No events were found for the role(s) specified. Showing all events...');";
                	echo "                window.location = '" . $siteaddr . "/mastercal.php';";
                } else {
                	echo "                alert('ERROR: The calendar events could not be fetched.');";
                }
				echo "\n";
                ?>
            },
            className: 'playfeedevents'
        },
        {
            url: 'http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic',
            color: '#dd9900',
            textColor: '#ffffff',
            className: 'usholidayfeedevents'
        }
    ],
    eventRender: function(event, element) {
    	if (event.source.className=='playfeedevents') {
	        if (event.status=="Tentative") {
	        	event.color = "#36c";
	        } else if (event.status=="Confirmed") {
	        	event.color = "#3c6";
	        } else if (event.status=="Cancelled") {
	        	event.color = "#c63";
	        } else {
	        	event.color = "#555";
	        }
	        
	        
	        var qtiptext = "";
	        
	        qtiptext += "<div class=\"event-qtip-title\">" + event.title + "</div>\n";
	        
	        if (event.showscenes) {
	        	var sceneslist = getRanges(event.scenes.split(","));
	        	qtiptext += "<div class=\"event-qtip-scenes\"><span class=\"event-qtip-label\">Scenes:</span> " + sceneslist.join(", ") + "</div>\n";
	        }
	        
	        var humanstart = event.start.toDateString();
	        var humanend = event.end.toDateString()
	        if (!event.allDay) {
	        	humanstart += " at " + prettyTime(event.start);
	        	humanend += " at " + prettyTime(event.end);
	        }
	        qtiptext += "<div class=\"event-qtip-start\"><span class=\"event-qtip-label\">Start:</span> " + humanstart + "</div>\n";
	        qtiptext += "<div class=\"event-qtip-end\"><span class=\"event-qtip-label\">End:</span> " + humanend + "</div>\n";
	        
	        /*qtiptext += "<div class=\"event-qtip-status\"><span class=\"event-qtip-label\">Status:</span> " + event.status + "</div>\n";
	        qtiptext += "<div class=\"event-qtip-loc\"><span class=\"event-qtip-label\">Location:</span> " + event.location + "</div>\n";*/
	        qtiptext += "<div class=\"event-qtip-status event-qtip-loc\"><span class=\"event-qtip-label\">Status:</span>&nbsp;" + event.status + "&nbsp;&nbsp;&#32;";
	        qtiptext += "<span class=\"event-qtip-label\">Location:</span>&nbsp;" + event.location + "</div>\n";
	        qtiptext += "<div class=\"event-qtip-comments\">" + event.comments + "</div>\n";
	        qtiptext += "<div class=\"event-qtip-username\">" + "Last edited by " + event.username + "</div>";
	        
	        if(!usingios){ element.qtip({
	            content: qtiptext,
	            position: {
	                corner: {
	                    target: 'bottomLeft'/*,
	                    tooltip: 'topLeft'*/
	                }
	            }
	        }); }
        }
    },
    dayClick: function(date, allDay, jsEvent, view) {

        if (allDay) {
            //alert('Clicked on the entire day: ' + date);
            $('#calendar').fullCalendar('changeView', 'agendaDay');
            $('#calendar').fullCalendar('gotoDate', date.getFullYear(), date.getMonth(), date.getDate());
            
        } else {
            //alert('Clicked on the slot: ' + date);
            
            createNewEvent(date);
        }

        //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

        //alert('Current view: ' + view.name);

        // change the day's background color just for fun
        //$(this).css('background-color', 'red');

    }
});

});

/**
 * Sends the user to the page to create a new event. Takes a Date object
 */
function createNewEvent(date) {
	goodpre = leadingZeros(date.getUTCFullYear(),4) + "-" + leadingZeros(date.getUTCMonth()+1,2) + "-" + leadingZeros(date.getUTCDate(),2) + " ";
	goodpost = ":" + leadingZeros(date.getUTCMinutes(),2) + ":" + leadingZeros(date.getUTCSeconds(),2);
	
	gooddtstart = goodpre + leadingZeros(date.getUTCHours(),2) + goodpost;
	gooddtend = goodpre + leadingZeros(date.getUTCHours()+1,2) + goodpost;
	
	
	window.location = "<?php echo $siteaddr; ?>/viewevent.php?id=new&dtstart=" + escape(gooddtstart) + "&dtend=" + escape(gooddtend);
}

/**
 * This code (lovingly) ripped off from http://www.webdevelopersnotes.com/tips/html/formatting_time_using_javascript.php3
 */
function prettyTime(d) {
	var a_p = "";
	var curr_hour = d.getHours();
	if (curr_hour < 12)
	   {
	   a_p = "AM";
	   }
	else
	   {
	   a_p = "PM";
	   }
	if (curr_hour == 0)
	   {
	   curr_hour = 12;
	   }
	if (curr_hour > 12)
	   {
	   curr_hour = curr_hour - 12;
	   }
	
	var curr_min = d.getMinutes();
	
	curr_min = curr_min + "";
	
	if (curr_min.length == 1)
	   {
	   curr_min = "0" + curr_min;
	   }
	
	return curr_hour + ":" + curr_min + " " + a_p;
}

/**
 * This function stolen from http://stackoverflow.com/a/2270987/992504
 */
function getRanges(array) {
  var ranges = [], rstart, rend;
  for (var i = 0; i < array.length; i++) {
    rstart = array[i];
    rend = rstart;
    while (array[i + 1] - array[i] == 1) {
      rend = array[i + 1]; // increment the index if the numbers sequential
      i++;
    }
    ranges.push(rstart == rend ? rstart+'' : rstart + '-' + rend);
  }
  return ranges;
}

/**
 * This function stolen from http://stackoverflow.com/a/2998822
 */
function leadingZeros(num, size) {
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}
</script>
<?php

require_once('header.php');

$link = startmysql();
$sql = "SELECT * FROM `" . $sql_pref . "roles` WHERE `showInCalDropdown`=1 ORDER BY `" . $sql_pref . "roles`.`title` ASC";
$result = mysql_query($sql) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");

$roledropdown = '';
//$roledropdown = '<span class="pad"><div style="background:url(' . $siteaddr . '/images/fatcow/32/new.png) center center no-repeat; /*height:16px;*/ padding-right:38px; /*margin-right:4px;*/ display:inline;"></div>';
//$roledropdown .= '' . $br;
$roledropdown .= '<span id="myrole" class="pad"><label for="myrole-select">Only show rehearsals for </label><select style="display:inline;" name="myrole" id="myrole-select">' . $br;
$roledropdown .= '<option value="0">all roles</option>' . $br;

if (isset($_SESSION['user'])) {
	if ($_REQUEST['myrole']=="@") {
		$roledropdown .= '<option value="@" selected="selected">your roles</option>' . $br;
	} else {
		$roledropdown .= '<option value="@">your roles</option>' . $br;
	}
}
/*if (isset($_REQUEST['myrole']) && $_REQUEST['myrole']!="@") {
	$roledropdown .= '<option value="' . $_REQUEST['myrole'] . '" selected="selected">Custom role(s)</option>' . $br;
}*/



$roledropdown .= '<optgroup label="People">';

$sqlu = "SELECT * FROM `" . $sql_pref . "users` ORDER BY `lastname` ASC";// . " LIMIT 0, 100 "; //this commented code would limit to 100 people
$resultu = mysql_query($sqlu) or die("<span class=\"errortext\">Query failed:<br>\n" . mysql_error() . "</span>");

for($i=0; $i < mysql_num_rows($resultu); $i++) {
	$rowu = mysql_fetch_row($resultu);
	
	$isselected = "";
    if (isset($_REQUEST['myrole']) && isset($_REQUEST['myroleusername'])) {
        if ($rowu[6]==$_REQUEST['myrole'] && $_REQUEST['myroleusername']==$rowu[1]) {
            $isselected = ' selected="selected"';
        }
    }
	
	$roledropdown .= '<option value="' . $rowu[6] . '" username="' . $rowu[1] . '"' . $isselected . '>' . $rowu[5] . ', ' . $rowu[4] . '</option>' . $br;
}
$roledropdown .= '</optgroup>';





$roledropdown .= '<optgroup label="Roles">';
for($i=0; $i < mysql_num_rows($result); $i++) {
	
	$row = mysql_fetch_row($result);
	
	
	$isselected = "";
	if ($row[0]==$_REQUEST['myrole'] && (!isset($_REQUEST['myroleusername']) || $_REQUEST['myroleusername']=="")) {
		$isselected = ' selected="selected"';
	}
	
	///////////////////////////////////////
	////TODO: Create a better, DYNAMIC solution to the "Chorus" problem
	///////////////////////////////////////
	
	//if ($row[1] != "Chorus") {
		$roledropdown .= '<option value="' . $row[0] . '"' . $isselected . '>' . $row[1] . '</option>' . $br;
	//}
}
$roledropdown .= '</optgroup>';

$roledropdown .= '</select>' . $br;
$roledropdown .= '<!--<input type="submit" value="Go" style="display:inline;" />&nbsp;-->';
//$roledropdown .= '<span class="betatag">(don\'t use this if your <a href="' . $siteaddr . '/scenebreakdown.php">scene breakdown</a> is incorrect!!)</span>';
$roledropdown .= '</span>';



$suburlappend = "";

if (isset($_REQUEST['myrole']) && $_REQUEST['myrole']!="0") {
	if ($_REQUEST['myrole']=="@") {
		$suburlappend .= "?onlyrole=" . $_SESSION['roles'];
	} else {
		$suburlappend .= "?onlyrole=" . $_REQUEST['myrole'];
	}
}

?>
<form action="<?php echo $siteaddr; ?>/mastercal.php" method="post" id="myrole-form"><input type="hidden" name="myroleusername" value="" id="myrole-username"></input>
<div id="abovecal"><span id="icalsubscribe" class="pad"><a href="webcal://<?php echo $sitedomain.$sitesubdir; ?>/icalfeed.php<?php echo $suburlappend; ?>">Subscribe</a><!--&nbsp;<span class="betatag">(beta)</span>--></span><?php echo $roledropdown; ?><span><input id="neweventbutton" type="button" value="Create a new event"></span></div>
<div id="calendar"></div>
</form>
<?php
require_once('footer.php');

mysql_free_result($result);
mysql_close($link);

?>