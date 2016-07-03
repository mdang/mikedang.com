<?php

// Redirect for IE6 users
if (isset($browser_info['msie']))
{
	if ($browser_info['msie'] < 7)
    {
		redirect('/ie6.php');
    }
}

if (!isset( $page_title ))
{
    $page_title = PAGE_TITLE_BASE;
}

if (!isset( $tab ))
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
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/global<?php echo ASSET_VERSION ?>.css" type="text/css" media="all" />
<!--[if IE]><![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/ie7.css" type="text/css" media="all" />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/ie8.css" type="text/css" media="all" />
<![endif]-->
<?php if (is_mobile_browser()): ?>
<link rel="stylesheet" href="<?php echo STATIC_ROOT ?>/css/mobile.css" type="text/css" media="all" />
<?php endif; ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript">
var reloader=document.location.hash.substr(1);if(reloader){if(reloader.charAt(0)=='/'){if(window.opener){window.opener.location.href=reloader;window.close();}else{location.href=reloader;}}}
</script>

</head>
<?php flush(); ?>
<body id="<?php echo $tab ?>" class="theme3">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#fullnav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="ajax navbar-brand" href="/">Mike Dang</a>
    </div>
    <div class="collapse navbar-collapse" id="fullnav">
      <ul class="nav navbar-nav navbar-right">
				<li class="active"><a class="ajax" href="/">Home</a></li>
				<li><a class="ajax" href="/work/">Development</a></li>
				<li><a class="ajax" href="/photos">Photos</a></li>
				<li><a class="ajax" href="/about/">About</a></li>
				<li><a class="ajax" href="/contact/">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<div id="container">
<a name="top"></a>

<!-- <div id="header">

  <div id="logo">
      <h1><a href="/"><img src="<?php echo STATIC_ROOT ?>/i/logo_min.gif" width="145" height="37" alt="Mike Dang" /></a></h1>
      <span>Code monkey for hire</span>
  </div>

	<?php if (!is_mobile_browser()): ?>
    <div id="twitter">
        <div id="twitter-ctrl">
            <a href="#" id="twitter-prev">previous</a>
            <a href="#" id="twitter-next">next</a>
        </div>
    	<div id="tweets" class="clearfix"></div>
    </div>
    <?php endif; ?>

    <div id="loader2">Working...</div>
</div> -->



<a name="top-nav"></a>

<!-- <ul id="tabnav">
	<li class="tab1"><a href="/">Home</a></li>
	<li class="tab2"><a href="/work/">Development</a></li>
	<li class="tab3"><a href="/posts">Posts</a></li>
	<li class="tab4"><a href="/about/">About</a></li>
	<li id="tab-cta" class="tab5"><a href="/contact/">Contact</a></li>
</ul>
<ul id="subnav"></ul> -->
