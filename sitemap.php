<?php 

require_once 'init.php';

$tab = '';

$page_title = PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR .'Sitemap';

?>
<?php include_once 'includes/header.php'; ?>	

<div id="content" class="clearfix">
    <?php include_once 'rpc/content/sitemap.php'; ?>
</div>

<?php include_once 'includes/footer.php'; ?>