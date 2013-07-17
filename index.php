<?php
require_once('config.php');

$pagetitle="Home";

require_once('topheader.php');
?>
<style type="text/css">
#googledocnews
{
    width:100%;
    min-height:400px;
    border-width:0;
}
</style>
<?php
require_once('header.php');
?>
<iframe id="googledocnews" frameborder="0" src="https://docs.google.com/document/pub?id=1X8l3xhAP0xdGY1rtAKZrj-LtQ7o-vDInVKwb-A-q3xU&embedded=true&nocaching=<?php echo date('U'); ?>">Your browser doesn't support frames. Click <a href="https://docs.google.com/document/pub?id=1X8l3xhAP0xdGY1rtAKZrj-LtQ7o-vDInVKwb-A-q3xU">here</a> to see the home page.</iframe>
<div>You can edit the announcements via <a href="https://docs.google.com/document/d/1X8l3xhAP0xdGY1rtAKZrj-LtQ7o-vDInVKwb-A-q3xU/edit">this Google Doc</a>.</div>
<?php
require_once('footer.php');
?>