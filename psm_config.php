<?php

$sitetitle = "phpStageManager"; //name of website to appear everywhere
$sitedescription = "A web-based theatre management utility"; //a description of the site
$companyname = "Hayden Schiff"; //name of company to appear in misc places

$siteprotocol = "http://"; //URI scheme of the site (presumably this will always be "http://")
$sitedomain = "example.com"; //domain of the site (with port number if not 80), without URI scheme (i.e. http://) or subdirectories
$sitesubdir = ""; //subdirectory where the site is located. don't include trailing slash!

$rootdir = "/"; //internal server directory of this site

$scenecount = 30; //number of scenes in the show


$sql_addr = 'localhost'; //address of MySQL server
$sql_user = 'root'; //username for MySQL server
$sql_pass = 'pass'; //password for MySQL server
$sql_db = 'phpstagemanager'; //database to use on the MySQL server
$sql_pref = 'psm_'; //prefix to use for MySQL table names

$def_backcolor = '#0000AA'; //default background color
$def_forecolor = '#FFDD00'; //default foreground color
$def_forehcolor = '#FFAA00'; //default foreground-hover color

$psm_actionlogging = true; //if true, every user action (logging in/out, changing an event, etc) will be recorded in the file action.log

$psm_deftimezone = 'America/New_York'; //name of timezone to be displayed to user. a list of valid values can be found at http://php.net/manual/en/timezones.php

$psm_imap_enabled = false; //if true, IMAP authentication will be enabled
$psm_imap_address = "example.com"; //address of IMAP server
$psm_imap_usessl = true; //if true, IMAP authentication will use SSL (not yet implemented)
$psm_imap_timeout = 3; //time in seconds to wait for a response from the IMAP server

?>