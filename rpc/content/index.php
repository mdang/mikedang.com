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
  'api_version' => _500PX_API_VERSION,
  'user_id' => _500PX_USER_ID,
  'gallery' => _500PX_GALLERY_NAME,
  'rpp' => _500PX_RECORDS_PER_PAGE,
  'rpp' => 20,
  'sort' => 'rating',
  'image_size[0]' => 3,
  'image_size[1]' => 600
  );

$featured_photos = get_500px_photos($photo_options)->photos;
$debug[] = Zend_Debug::dump($featured_photos, 'Featured Photos', 0);

// $third_party_posts = get_third_party_posts(null, 15);
// $debug[]    = Zend_Debug::dump($third_party_posts, 'All posts', 0);

?>
<div id="title">
    <h2>Hello, passion</h2>
</div>

<div id="all">
<h3 class="headline">I bring ideas to life with code <i class="fa fa-code" aria-hidden="true"></i></h3>

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
              $img_tag = '<img src="'. IMG_APP_MEDIA_FILE_PATH . $preview_file_nm .'" alt="'. $app_nm .'" />';
          }
          else
          {
              $img_tag = '<img src="' . STATIC_ROOT . '/i/blank.gif" class="feature-divider" alt="'. $app_nm .'" />';
          }

          if ($client_nm)
          {
              $client_str = '<p><!--<i class="fa fa-user" aria-hidden="true"></i> --><a class="ajax" href="/work/?client='. $client_id .'">'. $client_nm .'</a></p>';
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

<h3 class="headline">I dabble in photography <i class="fa fa-camera-retro" aria-hidden="true"></i></h3>

<div class="container-fluid bg-3 featured-photos-container">
  <div class="featured-photos" style="display: none">
    <?php
    // '' = regular size
    // 'w2' = double the width
    // 'h2' = double the height
    $random_sizes = ['featured-photo w2 h2', 'featured-photo w1 h1'];

    foreach ($featured_photos as $photo)
    {
      $random_index = array_rand($random_sizes);
      echo '<div class="' . $random_sizes[$random_index] . '"><a href="https://500px.com' . $photo->url . '"><img class="img-responsive" src="' . $photo->image_url[0] . '" srcset="' . $photo->image_url[0] .' 1x, ' . $photo->image_url[1] .' 2x"></a></div>';
    }

    ?>
  </div>
</div>

<?php /* <div class="container-fluid bg-3 text-center">
  <div class="row">
    <?php

    $i = 0;
    foreach ($featured_photos as $photo)
    {
      if ($i % 4 === 0)
      {
        echo '</div>';
        echo '<div class="row">';
      }
      echo '<div class="col-sm-3 col-md-3"><img class="img-responsive" src="' . $photo->image_url[0] . '" srcset="' . $photo->image_url[0] .' 1x, ' . $photo->image_url[1] .' 2x"></div>';
      $i++;
    }

    ?>
  </div>
</div>
*/ ?>

<p class="link-prompt clearfix"><a class="ajax" href="/photos/">see more photos</a></p>

<script type="text/javascript">

$(function() {
	selectTab('<?php echo $tab; ?>');
	setPageTitle('<?php echo PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR . 'Home' ?>');
	addAjaxRequestHandlers();

	$('.feature-set').imagesLoaded(function() {
		fadeInProjects();
	});

  $('.featured-photos').imagesLoaded(function() {
    $('.featured-photos').show();
		$('.featured-photos').masonry({
      itemSelector: '.featured-photo',
      gutter: 8
    });
	});

	<?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/index']);
	<?php endif; ?>
});
</script>
