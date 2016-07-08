<?php

if (!isset($page_title))
{
    $page_title = PAGE_TITLE_BASE;
}

if (!isset($tab))
{
    $tab = 'tab1';
}

?><!DOCTYPE html>
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="description" content="I develop applications for the social web. My development skillset includes PHP, Oracle, MySQL, Facebook Apps, Twitter Apps and more." />
<meta name="keywords" content="Mike Dang, Dang, Interactive Marketing, Social Media, Developer, Application Developer, Web Developer, Facebook, Facebook apps, Twitter" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-touch-fullscreen" content="yes" />
<title><?php echo $page_title ?></title>
<link rel="canonical" href="http://www.mikedang.com/" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/<?php echo BOOTSTRAP_VERSION ?>/css/bootstrap.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/global<?php echo ASSET_VERSION ?>.css" type="text/css" media="all" />
<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/ie8.css" type="text/css" media="all" />
<![endif]-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/<?php echo JQUERY_VERSION ?>/jquery.min.js"></script>
<script type="text/javascript">
var reloader=document.location.hash.substr(1);if(reloader){if(reloader.charAt(0)=='/'){if(window.opener){window.opener.location.href=reloader;window.close();}else{location.href=reloader;}}}
</script>
</head>
<?php flush(); ?>
<body id="<?php echo $tab ?>" class="theme3">
<a name="top-nav"></a>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#fullnav">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<h1><a class="ajax navbar-brand" href="/">Mike Dang</a></h1>
    </div>
    <div class="collapse navbar-collapse" id="fullnav">
			<ul class="nav navbar-nav navbar-right">
				<li class="<?php echo ($tab == 'tab1') ? 'active' : '' ?>"><a class="ajax nav-link" href="/">Home</a></li>
				<li class="<?php echo ($tab == 'tab2') ? 'active' : '' ?>"><a class="ajax nav-link" href="/work/">Development</a></li>
				<li class="<?php echo ($tab == 'tab3') ? 'active' : '' ?>"><a class="ajax nav-link" href="/photos">Photos</a></li>
				<li class="<?php echo ($tab == 'tab4') ? 'active' : '' ?>"><a class="ajax nav-link" href="/about/">About</a></li>
				<li class="<?php echo ($tab == 'tab5') ? 'active' : '' ?>"><a class="ajax nav-link" href="/contact/">Contact</a></li>
			</ul>
    </div>
  </div>
</nav>
<a name="top"></a>

<div id="loader2">Loading...</div>
<div id="container">
