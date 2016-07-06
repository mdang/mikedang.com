
</div> <!--//container -->

<footer class="container-fluid text-center">
	<div id="copyright">
		&copy;2002-<?php echo date('Y') ?> Mike Dang
	</div>

	<ul id="footernav">
		<li><a href="/" class="ajax" rel="tab1">Home</a></li>
		<li><a href="/work/" class="ajax" rel="tab2">Development</a></li>
		<li><a href="/photos" class="ajax" rel="tab3">Photos</a></li>
		<li><a href="/about/" class="ajax" rel="tab4">About</a></li>
		<li><a href="/contact/" class="ajax" rel="tab5">Contact</a></li>
		<li><a href="/sitemap" class="ajax" rel="">Sitemap</a></li>
	</ul>
	<ul id="footersubnav">
		<li><div id="fb-root"></div><fb:like href="http://www.mikedang.com" send="true" layout="button_count" show_faces="true" font=""></fb:like></li>
		<!-- <li id="li-plusone"><div id="g-plusone"></div></li> -->
	</ul>
</footer>

<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/<?php echo BOOTSTRAP_VERSION ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_ROOT ?>/js/common<?php echo ASSET_VERSION ?>.js"></script>
<script type="text/javascript" src="<?php echo STATIC_ROOT ?>/js/jquery.plugins.20160702.min.js"></script>
<script type="text/javascript">
$(function() {
	// load('http://apis.google.com/js/plusone.js', function() {
	// 	gapi.plusone.render("g-plusone", {"size": "medium", "count": "true"});
	// });
	load('http://connect.facebook.net/en_US/all.js#xfbml=1', function() {});
});
</script>
<?php if (GOOGLE_ANALYTICS_ACCT): ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo GOOGLE_ANALYTICS_ACCT ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php endif; ?>
<?php

if (DEBUG and (IS_DEV) and !empty($debug))
{
	echo '<div id="dbg">';
  print_r($debug);
  echo '</div>';
}

?>
</body>
</html>
