<?php

if (!defined('APP_INIT'))
{
    require_once '../../../init.php';
}

$tab = 'tab2';

require_once 'Zend/Db.php';
require_once 'db/pager/Helper.php';

$dbh       = App_Db::getInstance(DB_CONN_CORE);

$main_title = 'The best of all teachers, experience';

$base_link = '#/work/';
$page_num  = (isset($_GET['page']) and is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$limit     = 15;

//$highlight_color = '#ff9900';
$highlight_color = '#F17022';

$page_nav_bar = '';
$clients      = array();
$projects     = array();
$tags         = array();
$filters      = array();
$add_params   = array();
$show_reset   = false;

$select = $dbh->select()
              ->from(array('a' => 'app'),
                      array('a.app_id',
                            'a.client_id',
                            'c.client_nm',
                            'a.workplace_id',
                            'a.app_type_cd',
                            'a.app_nm',
                            'a.app_desc',
                            'a.app_resp',
                            'a.url',
                            'a.start_month',
                            'a.start_year',
                            'a.end_month',
                            'a.end_year',
                            'a.create_tmsp',
                            'a.preview_file_nm',
                      		'a.disp_seq',
                            'at.app_type_nm'))
                     ->joinLeft(array('at' => 'app_type'),
                                'a.app_type_cd = at.app_type_cd',
                                array())
                     ->joinLeft(array('c' => 'client'),
                                'a.client_id = c.client_id',
                                array())
              ->where("a.disp_ind = 'Y'");

if (isset($_GET['client']) and is_numeric($_GET['client']))
{
    $select->where("a.client_id = ". $_GET['client']);

    $filters[] = 'client';
    $add_params['client'] =  $_GET['client'];

    $show_reset = true;
}

if (isset($_GET['tag']) and is_numeric($_GET['tag']))
{
    $tag_id = $_GET['tag'];
    $select->where("a.app_id in (select app_id from app_tag where tag_id = $tag_id)");

    $filters[] = 'tag';
    $add_params['tag'] =  $_GET['tag'];

    $show_reset = true;
}

$select->order("a.disp_seq desc")
    ->order("a.create_tmsp desc");

try
{
    $pager = new App_Db_Pager_Helper($select, $base_link, $page_num, $limit);
}
catch (Exception $e)
{
    notify($e, __FILE__, __LINE__);

    throw $e;
}

foreach ($add_params as $key=>$val)
{
    $pager->addParam($key, $val);
}

if ($page_nav = $pager->getBasePager(5, '', 'current'))
{
    if (count($page_nav) > 1)
    {
        $page_nav_bar  = '<div id="pager-nav">';

        foreach ($page_nav as $page)
        {
          $page_nav_bar .= $page .' ';
        }

        $page_nav_bar .= '</div>';

        $page_nav_bar .= '<div id="pager-ctrl">';

        $page_nav_bar .= $pager->getPreviousPageLink('Previous');
        $page_nav_bar .= ' ';
        $page_nav_bar .= $pager->getNextPageLink('Next');
        $page_nav_bar .= '</div>';
    }
}

$results = $pager->getResults();
$offset  = $pager->getOffSet();
$total   = $pager->getTotalRecordCount();

$offset2 = $offset + $limit;

if ($offset2 > $total)
{
    $offset2 = $total;
}

$debug[] = Zend_Debug::dump($results, 'Results', 0);
$debug[] = Zend_Debug::dump($offset, 'Offset', 0);
$debug[] = Zend_Debug::dump($offset2, 'Offset2', 0);
$debug[] = Zend_Debug::dump($total, 'Total', 0);

// Get application tags
if (!empty($results))
{
    $app_ids = array();

    foreach ($results as $val)
    {
        $app_id = $val['app_id'];

        if (!in_array($app_id, $app_ids))
        {
            $app_ids[] = $app_id;
        }
    }

    $app_ids_str = implode(',', $app_ids);

    $debug[] = Zend_Debug::dump($app_ids_str, 'App ids comma delimited', 0);

    $app_tags          = get_app_tags_by_in($app_ids_str);
    $distinct_app_tags = get_distinct_app_tags($app_tags);

    $debug[] = Zend_Debug::dump($app_tags, 'App tags', 0);
    $debug[] = Zend_Debug::dump($distinct_app_tags, 'Distinct app tags', 0);
}

// Get featured clients
$featured_clients = get_featured_clients();

$params = array();

// Set page title
if (isset($_GET['client']) and is_numeric($_GET['client']))
{
    if (isset($results[0]['client_nm']))
    {
        $main_title = '<span>client / </span>'. $results[0]['client_nm'];
    }
    if ($total > $limit)
    {
        //$main_title .= '<span> / '. $page_num .'</span>';
    }

    $params = array('page' => $page_num,
    					'client' => $_GET['client']);
}
elseif (isset($_GET['tag']) and is_numeric($_GET['tag']))
{
    $requested_tag_id = $_GET['tag'];

    if (isset($distinct_app_tags[$requested_tag_id]))
    {
        $main_title = '<span>tag / </span>'. $distinct_app_tags[$requested_tag_id];
    }
    if ($total > $limit)
    {
        //$main_title .= '<span> / '. $page_num .'</span>';
    }

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
    <h2><?php echo $main_title ?></h2>
</div>

<div>
<div id="main" class="col-xs-12 col-sm-12 col-md-9">

<div id="project-list">

    <?php if (!empty($results)): ?>

    <div id="pager-summary">
        <div>Showing <span><?php echo $offset + 1 ?>-<?php echo $offset2 ?></span> of <span><?php echo $total ?></span>
        <?php

        if (!empty($filters))
        {
            $filter_str = implode(', ', $filters);

            echo 'filtered by '. $filter_str;
        }
        else
        {
            echo 'for all projects';
        }

        if ( $show_reset )
        {
        	echo '&nbsp; | &nbsp;<a class="ajax" href="/work/">show all</a>';
        }

        ?>

        </div>
    </div>

    <?php $position = $offset + 1; ?>
    <?php foreach ($results as $result): ?>

    <div id="p<?php echo $position; ?>" class="row project-row clearfix">
        <?php

        if ($result['preview_file_nm'])
        {
            $img_tag = '<img src="'. IMG_APP_MEDIA_FILE_PATH . $result['preview_file_nm'] .'" width="175" height="150" alt="'. $result['app_nm'] .'" />';
        }
        else
        {
            $img_tag = '<img src="' . STATIC_ROOT .'/i/blank.gif" style="background: #ccc;" width="175" height="150" alt="" />';
        }

        ?>

        <div class="project-col col-xs-12 col-sm-3 col-md-3">
            <div class="marker"><?php echo $position; ?></div>
            <a class="ajax" href="/work/detail?id=<?php echo $result['app_id'] ?>&amp;<?php echo $params_str ?>"><?php echo $img_tag ?></a>
        </div>

        <div class="project-col project-col-dtl col-xs-12 col-sm-9 col-md-9">
        	 <h3><a class="ajax" href="/work/detail?id=<?php echo $result['app_id'] ?>&amp;<?php echo $params_str ?>"><?php echo $result['app_nm'] ?></a></h3>

            <div>
            <?php

            if ($result['client_id'])
            {
                echo '<i class="fa fa-user" aria-hidden="true"></i> <a class="ajax" href="/work/?client='. $result['client_id'] .'">'. $result['client_nm'] .'</a>';
            }

            ?>

            <?php

            $app_id = $result['app_id'];

            echo '<div class="tags-list"><i class="fa fa-tags" aria-hidden="true"></i> ' ;
            if (isset($app_tags[$app_id]))
            {
                $tag_str = '';

                foreach ($app_tags[$app_id] as $tag_id=>$tag_nm)
                {
                    $tag_str .= '<a class="ajax tag" href="/work/?tag='. $tag_id .'">'. str_replace(' ', '&nbsp;', $tag_nm) .'</a> ';
                }

                $tag_str = rtrim($tag_str, ', ');

                echo $tag_str;
            }
            echo '</div>';

            ?>
            </div>
            <p><?php echo nl2br($result['app_desc']) ?></p>
            <p><a class="ajax" href="/work/detail?id=<?php echo $result['app_id'] ?>&<?php echo $params_str ?>">see more</a></p>
        </div>
    </div>

    <?php

    // Build quick nav list
    $projects[$position] = $result['app_nm'];

    // Build client list
    $client_id = $result['client_id'];
    $client_nm = $result['client_nm'];

    if (!isset($clients[$client_id]))
    {
        $clients[$client_id] = $client_nm;
    }

    ?>

    <?php $position++; ?>
    <?php endforeach; ?>

    <?php if ($page_nav_bar): ?>

    <div id="pager" class="clearfix">
        <?php echo $page_nav_bar ?>
    </div>

    <?php endif; ?>

    <div class="top-link"><a href="#top-nav">back to top</a></div>

    <?php else: ?>

    <div>Sorry, there are no projects that match your search.</div>

    <?php endif; ?>

</div>
</div>

<div id="sidebar" class="col-xs-12 col-sm-12 col-md-2">
    <?php /*
    <div class="submodule clearfix">
        <h4>At a Glance</h4>
        <div class="subcontent">
            <ul id="project-list-nav">
                <?php

                foreach ($projects as $position => $project_nm)
                {
                    echo '<li><div class="marker">'. $position .'</div> <a href="#p'. $position .'">'. $project_nm .'</a></li>';
                }

                ?>
            </ul>

        </div>

    </div>
    */ ?>

    <div class="submodule clearfix">
        <h3 class="headline">Client Overview</h3>
        <div class="subcontent">
            <ul id="client-list-nav">
                <?php

                foreach ($featured_clients as $client)
                {
                	echo '<li><a class="ajax" href="/work/?client='. $client['client_id'] .'">'. $client['client_nm'] .'</a></li>';
                }

                ?>
            </ul>

        </div>

    </div>
    <?php /*
    <div class="submodule clearfix">
        <h4>Related Tags</h4>

        <div class="subcontent">
            <ul id="tag-list-nav">
                <?php

                foreach ($distinct_app_tags as $tag_id=>$tag_nm)
                {
                    echo '<li><a class="ajax tag" href="/work/?tag='. $tag_id .'">'. $tag_nm .'</a></li>';
                }

                ?>
            </ul>
        </div>
    </div>
    */ ?>

</div>

</div>

<script type="text/javascript">

$(function() {
	selectTab('<?php echo $tab; ?>');
	setPageTitle('<?php echo PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR . 'Work' ?>');
  addAjaxRequestHandlers();

	$.localScroll({
    duration:1200,
    onBefore:function( e, anchor, $target ){

        $(anchor).effect("highlight", { color: "<?php echo $highlight_color ?>" }, 1700);
    },
    onAfter:function( anchor ){

    }
  });

	<?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/work/index']);
	<?php endif; ?>
});
</script>
