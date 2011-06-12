<?php
if ( !defined( 'DEBUG' ) )
	die;
?>
<!-- part -->
<div style="clear:both;width:100%;">
	<h3><?=$part->title;?></h3>

	<div class="attach_images_list" id="<?php echo $part->part_id; ?>">
		<div class="attach_images_list_images">
			<input  name="part_images" type="hidden" value="1" />
			<?php if (isset($part->images)):?>
			<?php foreach ( $part->images as $item ): ?>
				<div class="item" rel="<?php echo $item->id; ?>" title="<?php echo $item->alternate; ?>">
					<img src="<?php echo $item->thumb( 80, 80 ); ?>" alt="<?php echo $item->alternate; ?>" />
					<a class="delete" href="<?php echo get_url( 'plugin/part_images/delete/' . $item->id ); ?>" title="<?php echo __( 'Remove' ); ?>">&times;</a>
					<a class="rename" href="<?php echo get_url( 'plugin/part_images/delete/' . $item->id ); ?>" title="<?php echo __( 'Rename' ); ?>">&times;</a>
				</div>
			<?php endforeach; ?>
			<?php endif; ?>
			
		</div>

		<div class="ail_add"><a href="<?php echo get_url( 'plugin/part_images/add' ); ?>" part_id="<?php echo $part->part_id; ?>" page_id="<?php echo $part->page_id; ?>" title="<?php echo __( 'Add images' ); ?>">+</a></div>
	</div>
</div>
<!-- /part -->
