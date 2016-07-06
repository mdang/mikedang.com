<?php

if (!defined('APP_INIT'))
{
    require_once '../../../init.php';
}

$tab        = 'tab2';
$project_id = (isset($_GET['id']) and is_numeric($_GET['id'])) ? $_GET['id'] : '';
$page_num   = (isset($_GET['page']) and is_numeric($_GET['page'])) ? $_GET['page'] : 1;

if (!$project_id)
{
    redirect(WEB_ROOT .'work');
}

$project = get_app_details($project_id);

$debug[] = Zend_Debug::dump($project_id, 'Project Id', 0);
$debug[] = Zend_Debug::dump($project, 'Project', 0);

$tags    = get_app_tags($project_id);
$debug[] = Zend_Debug::dump($tags, 'Tags', 0);

if (empty($project))
{
    redirect(WEB_ROOT .'work');
}

$app_id          = $project['app_id'];
$client_id       = $project['client_id'];
$client_nm       = $project['client_nm'];
$logo_file_nm    = $project['logo_file_nm'];
$workplace_id    = $project['workplace_id'];
$workplace_nm    = $project['workplace_nm'];
$app_type_cd     = $project['app_type_cd'];
$app_type_nm     = $project['app_type_nm'];
$app_resp        = $project['app_resp'];
$app_nm          = $project['app_nm'];
$app_desc        = $project['app_desc'];
$url             = $project['url'];
$start_month     = $project['start_month'];
$start_year      = $project['start_year'];
$end_month       = $project['end_month'];
$end_year        = $project['end_year'];
$cmnt            = $project['cmnt'];
$preview_file_nm = $project['preview_file_nm'];
$featured_ind    = $project['featured_ind'];
$create_tmsp     = $project['create_tmsp'];

// Make sure http:// is present but not added again if it is
if ($url)
{
    if (!strstr($url, 'http'))
    {
        $full_url = 'http://'. $url;
    }
    else
    {
        $full_url = $url;
    }
}

$media_files  = get_app_media_files($project_id);
$related_work = get_client_apps($client_id, 3, $project_id);

$debug[] = Zend_Debug::dump($media_files, 'Media Files', 0);
$debug[] = Zend_Debug::dump($related_work, 'Related Work', 0);

$params = array();

if (isset($_GET['client']))
{
    $params = array('page' => $page_num,
    					'client' => $_GET['client']);
}
elseif (isset($_GET['tag']))
{
    $params = array('page' => $page_num,
    					'tag' => $_GET['tag']);
}
else
{
	$params = array('page' => $page_num);
}

$params_str = http_build_query($params);

?>
<div id="title">
    <h2><?php echo $app_nm ?></h2>

    <?php if ($logo_file_nm): ?>
    <!--
    <div id="client-logo">
        <img src="<?php echo IMG_CLIENT_LOGO_PATH ?><?php echo $logo_file_nm ?>" alt="<?php echo $client_nm; ?>" width="75" height="75" />
    </div>
    -->
    <?php endif; ?>

	<div id="details-ret">
    	<a class="ajax" href="/work/?<?php echo $params_str ?>">go back to project results</a>
    </div>
</div>

<div class="container-fluid bg-3">

<div id="main-2" class="col-xs-12 col-sm-12 col-md-9">
    <?php if (!empty($media_files)): ?>
    <div id="project-images">
        <?php

        foreach ($media_files as $file)
        {
            $file_id      = $file['media_file_id'];
            $file_nm      = $file['media_file_nm'];
            $file_type_cd = $file['media_file_type_cd'];
            $file_desc    = $file['media_file_desc'];

            $file_path_a  = IMG_APP_MEDIA_FILE_PATH . $file_nm;

            //  width="625" height="350"
            echo '<div class="project-image"><img width="300" src="'. $file_path_a .'" srcset="' . $file_path_a .' 1x, ' . $file_path_a .' 2x" alt="'. $file_desc .'" /></div>';
        }

        ?>
    </div>
    <?php else: ?>

    <img src="<?php echo STATIC_ROOT ?>/i/blank.gif" style="background: #ccc;" width="625" height="350" alt="" />

    <?php endif; ?>

    <div id="project-details">
        <?php if ($cmnt): ?>
          <p><?php echo nl2br($cmnt); ?></p>
        <?php elseif ($app_desc): ?>
          <p><?php echo nl2br($app_desc); ?></p>
        <?php endif; ?>

        <div class="project-details-ret"><a class="ajax" href="/work/?<?php echo $params_str ?>">go back to project results</a></div>
    </div>

</div>

<div id="sidebar-2" class="col-xs-12 col-sm-12 col-md-2">
    <?php if ($client_nm or $url): ?>
    <div class="submodule clearfix">
        <h3 class="headline">General Info</h3>

        <div class="subcontent">
            <?php if ($client_nm): ?>
              <a class="ajax" href="/work/?client=<?php echo $client_id ?>"><?php echo $client_nm ?></a><br />
            <?php endif; ?>
            <?php if ($url): ?>
              <a href="<?php echo $full_url ?>" target="_new"><?php echo $url ?></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($app_resp): ?>
    <div class="submodule clearfix">
        <h3 class="headline">Responsibilities</h3>

        <div class="subcontent">
            <?php echo nl2br($app_resp) ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($workplace_nm): ?>
    <div class="submodule clearfix">
        <h3 class="headline">Workplace</h3>

        <div class="subcontent">
            <?php echo $workplace_nm ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($tags)): ?>
    <div class="submodule clearfix">
        <h3 class="headline">Tags</h3>

        <div class="subcontent">
            <?php

            $tag_str = '';

            foreach ($tags as $tag)
            {
                $tag_str .= '<a class="ajax tag" href="/work/?tag='. $tag['tag_id'] .'">'. str_replace(' ', '&nbsp;', $tag['tag_nm']) .'</a> ';
            }

            $tag_str = rtrim($tag_str, ', ');

            echo $tag_str;

            ?>
        	<p><a class="ajax" href="/tags">see all</a></p>
        </div>

    </div>
    <?php endif; ?>

    <?php if (!empty($related_work)): ?>
    <div class="submodule clearfix">
        <h3 class="headline">More Client Work</h3>
        <div class="subcontent">
            <?php

            foreach ($related_work as $related)
            {
                echo '<div class="project-related">';

                if ($preview_file_nm)
                {
                    $img_path = IMG_APP_PREVIEW_PATH . $related['preview_file_nm'];
                    $img_tag  = '<img src="'. $img_path .'" alt="'. $related['app_nm'] .'" width="175" height="150" />';
                }
                else
                {
                    $img_tag  = '<img src="' . STATIC_ROOT .'/i/blank.gif" style="background: #ccc;" width="175" height="85" alt="" />';
                }

                echo '<a class="ajax" href="/work/detail?id='. $related['app_id'] .'&' . $params_str . '">'. $img_tag .'</a>';
                echo '<a class="ajax" href="/work/detail?id='. $related['app_id'] .'&' . $params_str . '">'. $related['app_nm'] .'</a>';
                echo '</div>';
            }

            ?>
        </div>
    </div>
    <?php endif; ?>
</div>

</div>

<script type="text/javascript">

$(function() {
	selectTab('<?php echo $tab; ?>');
	setPageTitle('<?php echo js_escape_string(PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR . 'Work' . PAGE_TITLE_SEPERATOR . $app_nm) ?>');
  addAjaxRequestHandlers();

  <?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/work/detail/<?php echo urlencode( $app_nm ) ?>']);
	<?php endif; ?>
});

</script>
