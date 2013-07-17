</div>
<div id="footer">
Powered by phpStageManager &#8212; Copyright 2013 Hayden Schiff
<?php
if (isset($_SESSION['permission'])&&$_SESSION['permission']>1) {
?>
<div id="footer-adminlink"><a href="<?php echo $siteaddr; ?>/admin.php">Administrative Control Panel</a> (not yet functional!)</div>
<?php
}
?>
</div>
</body>
</html>