<?php

if (!defined('APP_INIT'))
{
    require_once '../../../init.php';
}

$tab = 'tab2';

?>

<div id="title">
    <h2>Clients</h2>
</div>

<div id="all">

<p>Below are some clients I've had the pleasure of working with in my career so far.</p>

<div id="client-list">
    <img src="<?php echo STATIC_ROOT ?>/i/clients_2.jpg" width="800" height="563" alt="Clients" />
</div>

</div>

<script type="text/javascript">

$(function() {
  selectTab('<?php echo $tab; ?>');
  setPageTitle('<?php echo PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR . 'Clients' ?>');

  <?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/work/clients']);
	<?php endif; ?>
});

</script>
