<?php

if (!defined('APP_INIT')) 
{
    require_once '../../init.php';
}

$fb_active = '';
$twitter_active = '';
$flickr_active = '';
$all_active = '';

$third_party_id = '';

if (isset($_GET['tpid']) and 
	in_array($_GET['tpid'], array(1, 2, 3)))
{
	$third_party_id = $_GET['tpid'];
}

switch ( $third_party_id )
{
	case 1:
		$fb_active = 'active_link';
		break;
	case 2: 
		$twitter_active = 'active_link';
		break;
	case 3: 
		$flickr_active = 'active_link';
		break;
	default: 
		$all_active = 'active_link';
		break;
}

?>

<div id="title">
    <h2>Tap into the social pipeline</h2>
    
    <div id="details-ret">
    	<a class="soc_filter <?php echo $all_active ?>" data-tpid="" href="#">All Posts</a> | 
    	<a class="soc_filter <?php echo $fb_active ?>" data-tpid="1" href="#">Facebook</a> | 
    	<a class="soc_filter <?php echo $twitter_active ?>" data-tpid="2" href="#">Twitter</a> | 
    	<a class="soc_filter <?php echo $flickr_active ?>" data-tpid="3" href="#">Flickr</a>
    </div>
</div>

<div id="soc-intro" class="clearfix">Loading posts...</div>

<div class="top-link"><a href="#top-nav">back to top</a></div>

<script type="text/javascript">

$(function() {

	load_third_party_posts('<?php echo $third_party_id ?>');
	
	$('.soc_filter').click(function() {
		get_page('/posts?tpid=' + $(this).attr('data-tpid'), 'tab3', false);

		return false;
	});

	$.localScroll({
        duration:1200,
        onBefore:function( e, anchor, $target ){ 

            $(anchor).effect("highlight", { color: "" }, 1700);
        },
        onAfter:function( anchor ){
            
        }
    });

	<?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/posts']);
	<?php endif; ?>
});

</script>