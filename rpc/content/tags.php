<?php 

if (!defined('APP_INIT')) 
{
    require_once '../../init.php';
}

$tab = '';

$tags    = get_app_tag_counts();
$debug[] = Zend_Debug::dump($tags, 'Tags', 0);

?>

<div id="title">
    <h2>Development Tags</h2>
</div>

<div id="all">
<!--  
<p>Use the links below to search all tags.</p>
-->
<div class="listview">

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
    setPageTitle('<?php echo PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR .'Tags' ?>');

    addAjaxRequestHandlers();

    <?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/tags']);
	<?php endif; ?>
});

</script>