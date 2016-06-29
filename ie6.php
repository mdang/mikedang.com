<?php 

require_once 'init.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="I develop applications for the social web. My development skillset includes PHP, Oracle, MySQL, Facebook Apps, Twitter Apps and more." />
<meta name="keywords" content="Mike Dang, Dang, Interactive Marketing, Social Media, Developer, Application Developer, Web Developer, Facebook, Facebook apps, Twitter" />

<title>Mike Dang</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-touch-fullscreen" content="yes" />

<!–[if IE]><![endif]–>
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/global<?php echo ASSET_VERSION ?>.css" type="text/css" media="all" />

<!--[if lte IE 6]> 
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/ie6.css" type="text/css" media="all" /> 
<![endif]--> 
<!--[if gte IE 7]>
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/ie7.css" type="text/css" media="all" />
<![endif]-->
<!--[if gte IE 8]>
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/ie8.css" type="text/css" media="all" />
<![endif]-->

<?php if (IS_DEV): ?>
<script type="text/javascript" src="<?php echo STATIC_ROOT ?>/js/jquery-<?php echo JQUERY_VERSION ?>.min.js"></script>
<?php else: ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/<?php echo JQUERY_VERSION ?>/jquery.min.js"></script>
<?php endif; ?>
</head>
<body class="theme3">
<div id="container">

<div id="header">
    <div id="logo">
        <h1><a href="/"><img src="<?php echo STATIC_ROOT ?>/i/logo_min.gif" width="145" height="37" alt="Mike Dang" /></a></h1>
        <span>I'm a code monkey</span>
    </div>
</div>

<div id="all">
	<br /><br /><br />
	<div class="warning">
		<p>You're one of the last people on this world still using Internet Explorer 6. Microsoft doesn't even want to support it anymore. I realize you might be working at an outdated company that's forcing you to use it because the tech team is especially lazy and doesn't want to go through any trouble. In that case, I can only say I feel sorry for you. If that's not the case though, please do consider <a href="http://www.quirksmode.org/upgrade.html" target="_new">upgrading to a better browser</a>.</p> 
		<p>Not clicking the link to upgrade is like someone giving you a Ferrari for free, but you don't want it because you don't want to bother picking it up.</p>
	</div>
</div>

</div>
</body>
</html>