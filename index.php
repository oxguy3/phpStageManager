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
<iframe id="googledocnews" frameborder="0" src="<?php echo $psm_homepage_url; ?>">Your browser doesn't support frames. Click <a href="<?php echo $psm_homepage_url; ?>">here</a> to see the home page.</iframe>
<div><?php echo $psm_homepage_subtext; ?></div>
<?php
require_once('footer.php');
?>