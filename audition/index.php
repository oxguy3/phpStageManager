<?php
require_once('../config.php');

$pagetitle="Audition Sign-up";


//NOTE: errcode is a misnomer, its actually being used as a general status code (like HTTP status codes)
//the 100s are for errors
//the 200s are for successes
$errcode=0;
if (isset($_SESSION['errcode'])) {
	$errcode = intval($_SESSION['errcode']);
}


require_once('../topheader.php');
?>
<script type='text/javascript' src='<?php echo $siteaddr; ?>/includes/jquery-1.5.2.min.js'></script>
<script type='text/javascript'>
$(document).ready(function() {
	
	var info_pastexperience = "What previous theatrical roles have you been in?";
	var info_prefrole = "What role(s) would you prefer to play?";
	
	$("#settings-play-pastexperience").html(info_pastexperience);
	$("#settings-play-prefrole").html(info_prefrole);
	
	
	$("#settings-play-pastexperience").focusin(function() {
		if ($("#settings-play-pastexperience").html() == info_pastexperience) {
			$("#settings-play-pastexperience").html("");
		}
    });
	$("#settings-play-pastexperience").focusout(function() {
		if ($("#settings-play-pastexperience").html() == "") {
			$("#settings-play-pastexperience").html(info_pastexperience);
		}
    });
	
	$("#settings-play-prefrole").focusin(function() {
		if ($("#settings-play-prefrole").html() == info_prefrole) {
			$("#settings-play-prefrole").html("");
		}
    });
	$("#settings-play-prefrole").focusout(function() {
		if ($("#settings-play-prefrole").html() == "") {
			$("#settings-play-prefrole").html(info_prefrole);
		}
    });
	
	
        
    $('#loginerror').delay(5000).slideUp();
});
</script>
<style type="text/css">
h3 {
	margin-top: 25px;
	margin-bottom: 2px;
	text-decoration: underline;
}
#pagebody label {
	font-weight: bold;
}
</style>
<?php
require_once('../header.php');

if ($errcode!=0) {
	
	echo "<div id=\"loginerror\">";
	
	if ($errcode==101) {
		echo "<span class=\"loginerror-red\">Missing parameter. You must specify " . $_SESSION['errnote'] . ".</span>";
	} else if ($errcode==102) {
		echo "<span class=\"loginerror-red\">The " . $_SESSION['errnote'] . " you specified contains invalid characters.</span>";
	} else if ($errcode==103) {
		echo "<span class=\"loginerror-red\">The " . $_SESSION['errnote'] . " you specified contains formatting tags.</span>";
	} else if ($errcode==104) {//WAS SOMETHING ELSE FOR UPDATESETTINGS.PHP
		echo "<span class=\"loginerror-red\">Your login info couldn't be verified with the school's databases. Is your username and password correct?</span>";
	} else if ($errcode==105) {
		echo "<span class=\"loginerror-red\">The new passwords you entered did not match.</span>";
	} else if ($errcode==106) {
		echo "<span class=\"loginerror-red\">The website's database is unavailable at the moment.</span>";
	}/* else if ($errcode==107) {
		//NOT CURRENTLY USED FOR THIS PAGE
	}*/ else if ($errcode==200) {
		echo "<span class=\"loginerror-green\">Success!</span>"; //generic "good" message, shouldn't actually be used
	} else if ($errcode==201) {
		echo "<span class=\"loginerror-green\">You have successfully been registered for auditions!</span>";
	} /*else if ($errcode==202) {
		$_GET['mode'] = "theme";
		echo "<span class=\"loginerror-green\">Your theme has been modified successfully.</span>";
	} else if ($errcode==203) {
		$_GET['mode'] = "password";
		echo "<span class=\"loginerror-green\">Your password has been changed.</span>";
	}*/ else {
		echo "<span class=\"loginerror-red\">An unknown error occurred (#" . $errcode . ")</span>";
	}
	
	echo "</div>";
	
}
unset($_SESSION['errcode'], $_SESSION['errnote']);


?>
<div id="audition-welcome">
Welcome to the audition sign-up page. In lieu of paper forms, we're using this form so we can keep everything more organized (and save trees!). The shows will be on November 30, November 31, and December 1. If you have any questions, email Kate at <a href="mailto:kate.riley@7hills.org">kate.riley@7hills.org</a>.
<br><br>
If you want to change something after you've already submitted this form, you can fill it out a second time, and your first submission will be replaced with the new one. If you have any problems with this form, email Hayden Schiff at <a href="mailto:oxguy3@gmail.com">oxguy3@gmail.com</a>.
<br><br>
</div>
<form action="<?php echo $siteaddr; ?>/updateauditions.php" method="post" id="settings-form">
<h3>Basic information</h3>
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-basic-firstname">First name</label></td>
	<td class="settings-table-edit"><input type="text" name="firstname" id="settings-basic-firstname" value="" size="24"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-basic-lastname">Last name</label></td>
	<td class="settings-table-edit"><input type="text" name="lastname" id="settings-basic-lastname" value="" size="24"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-basic-emailaddr">Email address</label></td>
	<td class="settings-table-edit"><input type="text" name="emailaddr" id="settings-basic-emailaddr" value="" size="36"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-basic-mobilephone">Mobile phone</label></td>
	<td class="settings-table-edit"><input type="text" name="mobilephone" id="settings-basic-mobilephone" value="" size="16"></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-basic-homephone">Home phone</label></td>
	<td class="settings-table-edit"><input type="text" name="homephone" id="settings-basic-homephone" value="" size="16"></input></td>
</tr>
</tbody></table>


<h3><label for="settings-play-pastexperience">Past experience</label></h3>
<textarea name="pastexperience" id="settings-play-pastexperience" rows="4" cols="80"></textarea>

<h3><label for="settings-play-prefrole">Preferred role(s)</label></h3>
<textarea name="prefrole" id="settings-play-prefrole" rows="4" cols="80"></textarea>


<!--<h3>Play stuff</h3>
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-play-pastexperience">Past experience</label></td>
	<td class="settings-table-edit"><textarea name="pastexperience" id="settings-play-pastexperience" rows="4" cols="80"></textarea></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-play-prefrole">Preferred role(s)</label></td>
	<td class="settings-table-edit"><textarea name="prefrole" id="settings-play-prefrole" rows="4" cols="80"></textarea></td>
</tr>
</tbody></table>-->


<h3>Scheduling</h3>
<div>What foreseeable scheduling conflicts will you have this semester that might interfere with rehearsals?</div>
<table class="settings-table"><tbody>
<tr>
	<td></td>
	<td class="settings-table-label"><label for="settings-conflicts-sunday">Sunday</label></td>
	<td class="settings-table-label"><label for="settings-conflicts-monday">Monday</label></td>
	<td class="settings-table-label"><label for="settings-conflicts-tuesday">Tuesday</label></td>
	<td class="settings-table-label"><label for="settings-conflicts-wednesday">Wednesday</label></td>
	<td class="settings-table-label"><label for="settings-conflicts-thursday">Thursday</label></td>
	<td class="settings-table-label"><label for="settings-conflicts-friday">Friday</label></td>
	<td class="settings-table-label"><label for="settings-conflicts-saturday">Saturday</label></td>
</tr>
<tr>
	<td><b>Example:</b></td>
	<td class="settings-table-label"></td>
	<td class="settings-table-label">Soccer, 4-5<br>until 10/15</td>
	<td class="settings-table-label"></td>
	<td class="settings-table-label">Piano, 5-6<br>starting 9/12</td>
	<td class="settings-table-label"></td>
	<td class="settings-table-label">Doctor appt,<br>3-4 on 9/21</td>
	<td class="settings-table-label"></td>
</tr>
<tr>
	<td></td>
	<td class="settings-table-edit"><textarea rows="4" cols="12" name="conf_sun" id="settings-conflicts-sunday"></textarea></td>
	<td class="settings-table-edit"><textarea rows="4" cols="12" name="conf_mon" id="settings-conflicts-monday"></textarea></td>
	<td class="settings-table-edit"><textarea rows="4" cols="12" name="conf_tue" id="settings-conflicts-tuesday"></textarea></td>
	<td class="settings-table-edit"><textarea rows="4" cols="12" name="conf_wed" id="settings-conflicts-wednesday"></textarea></td>
	<td class="settings-table-edit"><textarea rows="4" cols="12" name="conf_thu" id="settings-conflicts-thursday"></textarea></td>
	<td class="settings-table-edit"><textarea rows="4" cols="12" name="conf_fri" id="settings-conflicts-friday"></textarea></td>
	<td class="settings-table-edit"><textarea rows="4" cols="12" name="conf_sat" id="settings-conflicts-saturday"></textarea></td>
</tr>
<tr>
	<td class="settings-table-label" colspan="2"><label for="settings-conflicts-extra">Anything else?</label></td>
	<td class="settings-table-edit" colspan="6"><textarea name="conf_extra" id="settings-conflicts-extra" rows="4" cols="72"></textarea></td>
</table>

<h3>Login information</h3>
<div>This will be your login information for this website (you probably will never need to login to this website, but this stuff just needs to be set). You must use your school username and password; that way, your identity can be verified by testing the login information against the school's IMAP server.</div>
<table class="settings-table"><tbody>
<tr>
	<td class="settings-table-label"><label for="settings-login-username">Username</label></td>
	<td class="settings-table-edit"><input type="text" name="username" id="settings-login-username" value=""></input></td>
</tr>
<tr>
	<td class="settings-table-label"><label for="settings-login-password">Password</label></td>
	<td class="settings-table-edit"><input type="password" name="password" id="settings-login-password" value=""></input></td>
</tr>
<!--<tr>
	<td class="settings-table-label"><label for="settings-login-confirmpassword">Confirm password</label></td>
	<td class="settings-table-edit"><input type="password" name="confirmpassword" id="settings-login-confirmpassword" value=""></input></td>
</tr>-->
</tbody></table>
<br>
<div><strong>By clicking "Submit!", you are agreeing to commit yourself to the play completely. You must also get your parent(s) to agree to this before submitting.</strong></div>
<p><input type="submit" value="Submit!"></input></p>
</form>
<?php
require_once('../footer.php');
?>