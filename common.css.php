<?php
require_once('config.php');

header('Content-type: text/css');

getThemeColors();


function getFileExtCss($ext) {
	global $br,$siteaddr;
	$filecss = "";
	$filecss .= "    background:transparent url(" . $siteaddr . "/images/fatcow/file_extension_" . $ext . ".png) center left no-repeat;".$br;
	$filecss .= "    display:inline-block;".$br;
	$filecss .= "    padding-left:20px;".$br;
	$filecss .= "    line-height:18px;".$br;
	return $filecss;
}

?>
html
{
    font-family: sans-serif;
}
body
{
    display: block;
    margin: 0px;
    background-color: <?php echo $backcolor; ?>;
}

a:link
{
    color:#0000ee;
    /*text-decoration: none;*/
}
a:visited
{
    color:#550088;
    /*text-decoration: none;*/
}
a:hover
{
    color:#8888ee;
    /*text-decoration: underline;*/
}
a:active
{
    color:#ee0000;
    /*text-decoration: underline;*/
}
a[href$='.doc'], a[href$='.docx'] {
<?php echo getFileExtCss("doc"); ?>
}
a[href$='.dmg'] {
<?php echo getFileExtCss("dmg"); ?>
}
a[href$='.exe'] {
<?php echo getFileExtCss("exe"); ?>
}
a[href$='.gz'] {
<?php echo getFileExtCss("gz"); ?>
}
a[href$='.m4a'] {
<?php echo getFileExtCss("m4a"); ?>
}
a[href$='.m4b'] {
<?php echo getFileExtCss("m4b"); ?>
}
a[href$='.m4p'] {
<?php echo getFileExtCss("m4p"); ?>
}
a[href$='.m4v'] {
<?php echo getFileExtCss("m4v"); ?>
}
a[href$='.mcd'] {
<?php echo getFileExtCss("mcd"); ?>
}
a[href$='.mdb'] {
<?php echo getFileExtCss("mdb"); ?>
}
a[href$='.mid'] {
<?php echo getFileExtCss("mid"); ?>
}
a[href$='.mov'] {
<?php echo getFileExtCss("mov"); ?>
}
a[href$='.mp2'] {
<?php echo getFileExtCss("mp2"); ?>
}
a[href$='.mp4'] {
<?php echo getFileExtCss("mp4"); ?>
}
a[href$='.mpeg'] {
<?php echo getFileExtCss("mpeg"); ?>
}
a[href$='.mpg'] {
<?php echo getFileExtCss("mpg"); ?>
}
a[href$='.msi'] {
<?php echo getFileExtCss("msi"); ?>
}
a[href$='.mswmm'] {
<?php echo getFileExtCss("mswmm"); ?>
}
a[href$='.ogg'] {
<?php echo getFileExtCss("ogg"); ?>
}
a[href$='.pdf'] {
<?php echo getFileExtCss("pdf"); ?>
}
a[href$='.pps'], a[href$='.ppt'], a[href$='.pptx'] {
<?php echo getFileExtCss("pps"); ?>
}
a[href$='.psd'] {
<?php echo getFileExtCss("psd"); ?>
}
a[href$='.pub'] {
<?php echo getFileExtCss("pub"); ?>
}
a[href$='.rar'] {
<?php echo getFileExtCss("rar"); ?>
}
a[href$='.rtf'] {
<?php echo getFileExtCss("rtf"); ?>
}
a[href$='.torrent'] {
<?php echo getFileExtCss("torrent"); ?>
}
a[href$='.ttf'] {
<?php echo getFileExtCss("ttf"); ?>
}
a[href$='.txt'] {
<?php echo getFileExtCss("txt"); ?>
}
a[href$='.xls'], a[href$='.xlsx'] {
<?php echo getFileExtCss("xls"); ?>
}
a[href$='.zip'] {
<?php echo getFileExtCss("zip"); ?>
}


#pageheader
{
    position: relative;
    /*width: 100%;*/
    background-color: <?php echo $backcolor; ?>;
    background-image: url(<?php echo $siteaddr; ?>/images/gradient-banner-up.png);
    background-repeat: repeat-x;
    padding: 8px 0px 0px 8px;
    border-bottom: 5px solid <?php echo $forecolor; ?>;
}
#pageheadermargins
{
    width:1000px;
    margin-left:auto;
    margin-right:auto;
}

#sitetitle
{
    width: 50%;
    /*background-color: <?php echo $backcolor; ?>;*/
    text-decoration: none;
    color: <?php echo $forecolor; ?>;
    font-size: 250%;
    font-weight: bold;
    font-variant: small-caps;
    padding-bottom: 4px;
    float:left;
    font-family: Verdana, Geneva, sans-serif;
}
#sitetitle a:link, #sitetitle a:visited
{
    text-decoration: none;
    color: <?php echo $forecolor; ?>;
}


#minilogin
{
    width: 24%;
    font-size:10px;
    float:right;
    margin-right:9px; /*a bit messy but it does the job!*/
}
#minilogin-table, #minilogin-table-alt
{
    border: 2px solid <?php echo $forecolor; ?>;
    border-radius: 6px;
    width: 240px;
    height: 60px;
}
#minilogin-table
{
    padding: 0px 4px 0px;
}
#minilogin-table-alt
{
    padding: 2px 4px 4px;
}
#minilogin-help a:link, #minilogin-help a:visited, #minilogin-help a:active
{
    color: <?php echo $forecolor; ?>;
    font-weight: bold;
    font-size: 14px;
    text-decoration: none;
}
#minilogin-help a:hover, .minilogin-alt-td a:hover
{
    color: <?php echo $forehcolor; ?>;
    /*text-decoration: underline;*/
    border-bottom: 1px solid <?php echo $forehcolor; ?>;
}
#minilogin-help
{
    padding-left: 3px;
}
#minilogin-td-label-u, #minilogin-td-label-p
{
    text-align: right;
    font-size: 14px;
    color: <?php echo $forecolor; ?>;
}
td.minilogin-td-in
{
    padding:0;
    margin:0;
}
#minilogin-in-u, #minilogin-in-p
{
    width: 100px;
    display: block;
    font-size: 11px;
    height: 14px;
    padding: 1px 2px;
    line-height: 11px;
    margin: 0;
    border: 1px solid <?php echo $forecolor; ?>;
    -webkit-appearance: none;
    box-sizing:content-box;
}
#minilogin-submit
{
    padding: 0 3px;
    font-size: 11px;
}
#minilogin-alt-yourname
{
    font-weight: bold;
    color: <?php echo $forecolor; ?>;
    text-align: center;
	font-size: 16px;
}
#minilogin-alt-useroptions td
{
    /*width:25%;*//*to be uncommented if/when i use up the l2 and r2 boxes*/
}
#minilogin-alt-useroptions-l, #minilogin-alt-useroptions-r
{
    text-align: center;
    width: 33%;
}
#minilogin-alt-useroptions-l
{
    padding: 0 7px 0 0;
}
#minilogin-alt-useroptions-r
{
    padding: 0 0 0 7px;
}
#minilogin-alt-useroptions td a:link, #minilogin-alt-useroptions td a:visited, #minilogin-alt-useroptions td a:active
{
    color: <?php echo $forecolor; ?>;
    font-weight: none;
    font-size: 12px;
    text-decoration: none;
}


ul.navbar
{
    clear:left;
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    /*background-color: <?php echo $backcolor; ?>;*/
}
ul.navbar li
{
    float: left;
    margin-left: 8px;
}
ul.navbar a:link, ul.navbar a:visited
{
    display: block;
    min-height: 20px;
    min-width: 120px;
    vertical-align: middle;
    font-weight: bold;
    color: <?php echo $backcolor; ?>;
    background-color: <?php echo $forecolor; ?>;
    text-align: center;
    padding: 4px;
    text-decoration: none;
    text-transform: uppercase;
    -webkit-border-top-left-radius: 8px;
    -webkit-border-top-right-radius: 8px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    font-family: Verdana, Geneva, sans-serif;
}
ul.navbar a:hover, ul.navbar a:active, #navbar-selected
{
    background-color: <?php echo $forehcolor; ?>;
}

ul.navbar a.adminlink:link, ul.navbar a.adminlink:visited
{
    color: #ffffff ! important;
    background-color: #cc0000 ! important;
}
ul.navbar a.adminlink:hover, ul.navbar a.adminlink:active, .adminlink#navbar-selected
{
    background-color: #990000 ! important;
}


#pagetitle
{
    padding-top:0px;
    margin-top:12px;
    font-size:150%;
    width:1000px;
    margin-left:auto;
    margin-right:auto;
    color: <?php echo $forecolor; ?>/*<?php echo $backcolor; ?>*/;
    font-family: Verdana, Geneva, sans-serif;
    font-weight: bold;
    
    /*padding: 0px 12px 2px;
    background-color: <?php echo $forecolor; ?>;
    border:5px solid <?php echo $forecolor; ?>;
    border-top-left-radius:5px;
    border-top-right-radius:5px;
    border-bottom:0;*/
}

#pagebody
{
    padding:12px;
    width:1000px;
    margin-left:auto;
    margin-right:auto;
    margin-top:4px/*0*/;
    border:5px solid <?php echo $forecolor; ?>;
    border-radius:5px;
    /*border-bottom-left-radius:5px;
    border-bottom-right-radius:5px;*/
    background-color:white;
}

#footer
{
    margin-top:10px;
    margin-bottom:10px;
    text-align: center;
    color: <?php echo $forecolor; ?>;
    font-size:10px;
}
#footer a
{
    color: <?php echo $forecolor; ?>;
}
#footer-adminlink a
{
    border: 1px solid <?php echo $forehcolor; ?>;
    background-color: <?php echo $forecolor; ?>;
    color: <?php echo $backcolor; ?>;
    text-decoration: none;
    width:150px;
}



.mydatatable, .mydatatable tr td, .mydatatable tr th
{
    border: 1px solid black;
    border-collapse:collapse;
}

#contactsheet, #contactsheet tr td, #contactsheet tr th
{
    border: 2px solid black;
    border-collapse:collapse;
	min-height:16px;
}
#contactsheet tr th
{
    width: 200px;
    background-color: #cccccc;
}
.contactsheet-row-odd td
{
    background-color: #eeeeee;
}
.contactsheet-row-even td
{
    background-color: #ffffff;
}

.contactsheet-edit a
{
    text-decoration:none;
}
.contactsheet-edit-button
{
	background-image: url(<?php echo $siteaddr; ?>/images/fatcow/pencil.png);
    background-repeat: no-repeat;
	min-width: 16px;
	min-height: 16px;
    text-decoration: none;
}


.event-qtip-label
{
    font-weight: bold;
}
.event-qtip-title
{
    font-weight: bold;
    font-size: 110%;
    margin-bottom: 2px;
}
.event-qtip-start, .event-qtip-end, .event-qtip-status, .event-qtip-loc, .event-qtip-scenes, .event-qtip-comments, .event-form-radios,
.event-form-otherroles
{
    font-size: 80%;
    margin-bottom: 2px;
}
.event-qtip-comments
{
    margin-top: 5px;
}
.event-qtip-username
{
    font-size: 60%;
    color: #AAAAAA;
}


#abovecal
{
    padding-bottom: 10px;
    font-weight: bold;
}
#abovecal span.pad
{
    margin-right:35px;
}
span.betatag
{
    color: #AAAAAA;
    font-size: 60%;
    font-weight: normal;
}
#calendar
{
    font-family:"Lucida Grande",Helvetica,Arial,Verdana,sans-serif; /*needed to make the arrows not break in some browsers*/
}


#scenebreakdown
{
    border-collapse:collapse;
    border: 1px solid black;
}
/*#scenebreakdown, #scenebreakdown tr td, #scenebreakdown tr th
{
    border: 1px solid #AAAAAA;
}*/
.scenes-header 
{
    width: 2.2%;
    height: 30px;
    text-transform: uppercase;
}
#scenes-header-name, .scenes-namebox
{
    width: 14%;
}
.scenes-marked
{
    background-color:#404040;
    color:#404040;
    text-align:center;
	font-weight:bold;
}
.scenes-blank
{
    background-color:#ffffff;
    text-align:center;
}


#loginerror
{
    font-weight: bold;
    font-size: 16px;
    text-align: center;
    padding-bottom: 14px;
}
.loginerror-red
{
    color: #ff0000;
}
.loginerror-green
{
    color: #008800;
}
#login-clicktocontinue
{
    font-size: 14px;
    text-align: center;
    padding-bottom: 6px;
}