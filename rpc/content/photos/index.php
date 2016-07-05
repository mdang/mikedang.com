<?php

if (!defined('APP_INIT'))
{
    require_once '../../../init.php';
}

$tab = 'tab3';

$current_page = (isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1);

// 500px image sizes: https://github.com/500px/api-documentation/blob/master/basics/formats_and_terms.md#image-urls-and-image-sizes
$photo_options = array(
  'consumer_key' => _500PX_CONSUMER_KEY,
  'api_version' => _500PX_API_VERSION,
  'user_id' => _500PX_USER_ID,
  'gallery' => _500PX_GALLERY_NAME,
  'rpp' => _500PX_RECORDS_PER_PAGE,
  'sort' => 'taken_at',
  'page' => $current_page,
  'image_size[0]' => 3,
  'image_size[1]' => 600
  );

$photo_results = get_500px_photos($photo_options);
$initial_photos = $photo_results->photos;
$total_pages = $photo_results->total_pages;
$debug[] = Zend_Debug::dump($photo_results, 'Initial Photos', 0);

?>
<div id="title">
    <h2>Photos, photos, photos!</h2>
</div>

<div id="all" class="container-fluid bg-3">
  <div class="photos">
    <?php
    // '' = regular size
    // 'w2' = double the width
    // 'h2' = double the height
    $random_sizes = ['item w2 h2', 'item w1 h1'];

    foreach ($initial_photos as $photo) {
      $random_index = array_rand($random_sizes);
      echo '<div class="' . $random_sizes[$random_index] . '"><img class="img-responsive" src="' . $photo->image_url[0] . '" srcset="' . $photo->image_url[0] .' 1x, ' . $photo->image_url[1] .' 2x"></div>';
    }
    ?>
  </div>

  <ul id="pagination">
    <?php

    $next_page = ($current_page == $total_pages) ? null : $current_page + 1;

    for ($i=1; $i<=$total_pages; $i++) {
      $next_class = ($i === $next_page) ? 'class="next"' : '';
      echo '<li ' . $next_class . '><a href="/photos/?page=' . $i . '">' . $i . '</a></li>';
    }

    ?>
  </ul>

</div>

<script type="text/javascript">

$(function() {
    select_tab('<?php echo $tab; ?>');
    set_page_title('<?php echo PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR . 'Photos' ?>');

    var container = document.querySelector('.photos');
    var msnry = new Masonry( container, {
      // options
      itemSelector: '.item',
      gutter: 8
    });

    var ias = $.ias({
      container: ".photos",
      item: ".item",
      pagination: "#pagination",
      next: ".next a",
      delay: 1200
    });

    ias.on('render', function(items) {
      $(items).css({ opacity: 0 });
    });

    ias.on('rendered', function(items) {
      console.log('got here', items);
      msnry.appended(items);
    });

    ias.extension(new IASSpinnerExtension({
        src: '<?php echo STATIC_ROOT ?>/i/loading-animation.svg',
    }));

    //ias.extension(new IASNoneLeftExtension({html: '<div class="ias-noneleft" style="text-align:center"><p><em>You reached the end!</em></p></div>'}));

    <?php if (GOOGLE_ANALYTICS_ACCT): ?>
  	_gaq.push(['_trackPageview', '/about/index']);
  	<?php endif; ?>
});

</script>
