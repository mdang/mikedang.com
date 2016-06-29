<?php

if (!defined('APP_INIT')) 
{
    require_once '../init.php';
}

require_once 'DateDifference.php';

$third_party_id = null;

if (isset($_GET['tpid']) and is_numeric($_GET['tpid']))
{
	$third_party_id = $_GET['tpid'];
}

$third_party_posts = get_third_party_posts($third_party_id, 100);

if (empty( $third_party_posts ))
{
	$third_party_posts = get_third_party_posts(null, 100);
}

	
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
	
