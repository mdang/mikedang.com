<?php

if (!defined('APP_INIT'))
{
    require_once '../../init.php';
}

require_once 'DateDifference.php';

$tab = 'tab1';

$featured = get_featured_apps(15);
$debug[] = Zend_Debug::dump($featured, 'Featured Projects', 0);

// 500px image sizes: https://github.com/500px/api-documentation/blob/master/basics/formats_and_terms.md#image-urls-and-image-sizes
$photo_options = array(
  'consumer_key' => _500PX_CONSUMER_KEY,
  'rpp' => 20,
  'sort' => '_score',
  'image_size[0]' => 3,
  'image_size[1]' => 600
  );

$featured_photos = get_featured_photos($photo_options);
$debug[] = Zend_Debug::dump($featured_photos, 'Featured Photos', 0);

// $third_party_posts = get_third_party_posts(null, 15);
// $debug[]    = Zend_Debug::dump($third_party_posts, 'All posts', 0);

?>

<div id="title">
    <h2>Hi, come see what's been keeping me busy</h2>
</div>

<div id="all">
<?php /*
<h3 class="headline">Wish your site was more social? I got you covered</h3>

<div id="soc-intro" class="clearfix">
	<?php

	foreach ($third_party_posts as $post)
	{
		$soc_logo = '';

		if (strtotime($post['third_party_create_tmsp']) > strtotime('3 days ago'))
		{
			$soc_logo = 'label_new_red.png';
		}

		switch ( $post['post_type'] )
		{
			case 'photo':
				?>
				<div class="soc-item soc-photo soc-<?php echo $post['third_party_id'] ?>">
					<img src="<?php echo $post['img_normal'] ?>" alt="<?php echo $post['text'] ?>" width="315" />
					<?php echo $post['text'] ?>
					<span>Posted <?php echo DateDifference::getString(new DateTime( $post['third_party_create_tmsp'] )) ?> on <a href="<?php echo $_social['url'][$post['third_party_id']] ?>" target="_new"><?php echo $post['third_party_nm'] ?></a></span>
					<?php if ( $soc_logo ): ?>
					<div class="soc-logo"><img src="<?php echo STATIC_ROOT ?>/i/<?php echo $soc_logo ?>" alt="" /></div>
					<?php endif; ?>
				</div>

				<?php

				break;
			case 'status':
			default:
				?>
				<div class="soc-item soc-<?php echo $post['third_party_id'] ?>">
					<?php echo $post['text'] ?>
					<span>Posted <?php echo DateDifference::getString(new DateTime( $post['third_party_create_tmsp'] )) ?> on <a href="<?php echo $_social['url'][$post['third_party_id']] ?>" target="_new"><?php echo $post['third_party_nm'] ?></a></span>
					<?php if ( $soc_logo ): ?>
					<div class="soc-logo"><img src="<?php echo STATIC_ROOT ?>/i/<?php echo $soc_logo ?>" alt="" /></div>
					<?php endif; ?>
				</div>

				<?php

				break;
		}
	}

	?>
</div>

<p class="link-prompt"><a class="ajax" href="/posts">see all posts</a></p>
*/
?>
<h3 class="headline">I help some of the world's most recognizable brands market on the web</h3>

<div id="dev-preview">
	<div id="feature" class="clearfix">
        <?php

        $i = 0;

        echo '<div class="feature-set clearfix">';

        foreach ($featured as $app)
        {
            if ($i !== 0 and ($i % 5 == 0))
            {
                //echo PHP_EOL .'</div>'. PHP_EOL .'<div class="feature-set clearfix">'. PHP_EOL;
            }

            $preview_file_nm = $app['preview_file_nm'];
            $app_id          = $app['app_id'];
            $app_nm          = $app['app_nm'];
            $client_id       = $app['client_id'];
            $client_nm       = $app['client_nm'];
            $app_desc        = $app['app_desc'];
            $url             = $app['url'];

            if ($preview_file_nm)
            {
                $img_tag = '<img src="'. IMG_APP_MEDIA_FILE_PATH . $preview_file_nm .'" width="175" height="150" alt="'. $app_nm .'" />';
            }
            else
            {
                $img_tag = '<img src="' . STATIC_ROOT . '/i/blank.gif" class="feature-divider" width="175" height="150" alt="'. $app_nm .'" />';
            }

            if ($client_nm)
            {
                $client_str = '<p><span>Client:</span> <a class="ajax" href="/work/?client='. $client_id .'">'. $client_nm .'</a></p>';
            }

            echo PHP_EOL;
            echo <<<FEATURE
                <div class="feature-item" style="display: none">

                    <a class="ajax" href="/work/detail?id=$app_id">$img_tag</a>

                    <h4><a class="ajax truncate" href="/work/detail?id=$app_id">$app_nm</a></h4>
                    $client_str
                </div>
FEATURE;
            $i++;
        }

        echo PHP_EOL .'</div>';

        ?>

    </div>

    <p class="link-prompt clearfix"><a class="ajax" href="/work/">see all projects</a></p>
</div>
</div>

</div>
<!-- </div> -->

<div class="container-fluid bg-3 text-center">
  <h3 class="headline">I love photography</h3>
  <div class="row">
    <?php

    $i = 0;
    foreach ($featured_photos as $photo) {
      if ($i % 4 === 0) {
        echo '</div>';
        echo '<div class="row">';
      }
      echo '<div class="col-sm-3 col-md-3"><img class="img-responsive" src="' . $photo->image_url[0] . '" srcset="' . $photo->image_url[0] .' 1x, ' . $photo->image_url[1] .' 2x"></div>';
      $i++;
    }

    ?>
  </div>
</div>

<p class="link-prompt clearfix"><a class="ajax" href="/photos/">see more photos</a></p>



<!-- testing -->
<!-- <div style="clear: both;">
<ul>
  <?php

  foreach ($featured_photos as $photo) {
    echo '<li style="display:inline-block"><img src="' . $photo->image_url[0] . '" srcset="' . $photo->image_url[0] .' 1x, ' . $photo->image_url[1] .' 2x"></li>';
  }

  ?>
</ul>
</div> -->


<script type="text/javascript">

$(function() {
	//select_tab('<?php echo $tab; ?>');
	set_page_title('<?php echo PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR . 'Home' ?>');
	add_ajax_request_handlers();

	var $container = $('.feature-set');

	$container.imagesLoaded(function() {
		// $container.masonry({
		// 	itemSelector: '.soc-item'
		// });

		fade_in_projects();
	});

	<?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/index']);
	<?php endif; ?>
});
</script>
