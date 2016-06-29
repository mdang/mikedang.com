<?php 

require_once 'init.php';

$tab = '';

$page_title = PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR .'Tags';

?>
<?php include_once 'includes/header.php'; ?>	

<div id="content" class="clearfix">
    <?php include_once 'rpc/content/tags.php'; ?>
</div>

<?php include_once 'includes/footer.php'; ?>