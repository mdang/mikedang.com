<?php 

require_once '../init.php';

$tab = 'tab2';

$page_title = PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR .'Work';

?>
<?php include_once '../includes/header.php'; ?>
	
<div id="content" class="clearfix">
    <?php include_once '../rpc/content/work/index.php'; ?>
</div>

<?php include_once '../includes/footer.php'; ?>