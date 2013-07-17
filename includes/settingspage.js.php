<?php
require_once('../config.php');

header('Content-type: text/javascript');

?>
$(document).ready(function() {
	
	$("#leftbar-list li span").click(function() {
		$(".leftbarselected").removeClass("leftbarselected");
		$(this).addClass("leftbarselected");
		
		$(".settings-divpage").removeClass("settings-divpage-selected");
		var divtoshow = $(this).attr("showdiv");
		$("#" + divtoshow).addClass("settings-divpage-selected");
	});
        
    $("#leftbar-list li span").hover(
		function () {
			$(this).css('background-color','#cccccc');
			$(this).css('border-left-color','#cccccc');
		}, 
		function () {
			$(this).css('background-color','#dddddd');
			$(this).css('border-left-color','#dddddd');
		}
	);
        
    $('#loginerror').delay(5000).slideUp();
        
});