<?php
require_once('../config.php');

header('Content-type: text/css');

getThemeColors();

?>
#leftbar-list
{
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    width:150px;
    float:left;
}
#leftbar-list li span/*a:link, #leftbar-list li a:visited*/
{
    color: #000000; 
    display: block;
    height: 18px;
    width: 100%;
    padding: 4px;
    text-decoration: none;
    /*font-family: Verdana, Geneva, sans-serif;*/
    background-position: center left;
    background-repeat: no-repeat;
    background-color: #dddddd;
    background-origin: padding-box;
    padding-left: 20px;
    border-left: 4px solid #dddddd;
}
/*#leftbar-list li a:hover, #leftbar-list li a:active
{
    background-color:#cccccc;
    border-left-color:#cccccc;
}*/
.leftbarselected
{
    background-color:#bbbbbb ! important;
    border-left-color:#bbbbbb ! important;
}


#settingsbox
{
    float:left;
    /*width:850px;*/
    clear:right;
    margin:0;
    padding:0 6px;
}
.settings-divpage
{
    display:none;
}
.settings-divpage-selected
{
    display:block;
}

.settings-section-header
{
    font-weight:bold;
    text-decoration:underline;
}

.settings-table
{
    margin-bottom: 14px;
}

.settings-table-label
{
    width: 225px;
}
/*.settings-table-label label:after
{
    content: ":";
}*/
.settings-table-edit
{
    /*width: 100%;*/
}


input.color
{
    appearance:none;
    -moz-appearance:none;
    -webkit-appearance:none;
}


#bottomclear/*this is too simple, it feels like cheating*/
{
    clear:both;
}