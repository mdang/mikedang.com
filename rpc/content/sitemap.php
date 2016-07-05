<?php

if (!defined('APP_INIT'))
{
    require_once '../../init.php';
}

$tab = '';

$tags    = get_app_tag_counts();
$debug[] = Zend_Debug::dump($tags, 'Tags', 0);

$projects = get_app_overview();
$debug[]  = Zend_Debug::dump($projects, 'Projects', 0);

?>

<div id="title">
    <h2>Can't find what you're looking for?</h2>
</div>

<div id="all">

<p>Use the links below to quickly navigate through key areas of this website.</p>

<div class="listview">

<ul>
    <li><a class="ajax" href="/">Home</a></li>
    <li><a class="ajax" href="/work/">Development</a></li>
    <li><a class="ajax" href="/posts">Posts</a></li>
    <li><a class="ajax" href="/about/">About</a></li>
    <li><a class="ajax" href="/contact/">Contact</a></li>
</ul>

</div>

<div class="listview">

<a class="ajax" href="/work">Development</a>

<ul>
    <?php

    foreach ($projects as $project)
    {
        echo '<li><a class="ajax tag" href="/work/detail?id='. $project['app_id'] .'">'. $project['app_nm'] .'</a> - <a class="ajax" href="/work/?client='. $project['client_id'] .'">'. $project['client_nm'] .'</a></li>';
    }

    ?>
</ul>

</div>

<div class="listview">

Tags

<ul>
    <?php

    foreach ($tags as $tag)
    {
        echo '<li><a class="ajax tag" href="/work/?tag='. $tag['tag_id'] .'">'. $tag['tag_nm'] .'</a> ('. $tag['cnt'] .')</li>';
    }

    ?>
</ul>

</div>
</div>

<script type="text/javascript">

$(function() {
	selectTab('<?php echo $tab; ?>');
  setPageTitle('<?php echo PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR .'Sitemap' ?>');
  addAjaxRequestHandlers();

  <?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/sitemap']);
	<?php endif; ?>
});

</script>
