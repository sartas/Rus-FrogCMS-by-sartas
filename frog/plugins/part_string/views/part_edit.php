<?php
if ( !defined( 'DEBUG' ) )
	die;
?>
<!-- part -->
<div>
			<span><?php echo $part->title; ?></span>
	
<input id="part_<?php echo ($index - 1); ?>_name" name="part[<?php echo ($index - 1); ?>][type]" type="hidden" value="<?php echo $part->type; ?>" />
			<input id="part_<?php echo ($index - 1); ?>_part_id" name="part[<?php echo ($index - 1); ?>][part_id]" type="hidden" value="<?php echo $part->part_id; ?>" />
			<? if ( isset( $part->id ) && $part->id != '' ): ?>
				<input id="part_<?php echo ($index - 1); ?>_id" name="part[<?php echo ($index - 1); ?>][id]" type="hidden" value="<?php echo $part->id; ?>" />
			<? endif; ?>
				

			<input id="part_<?php echo ($index - 1); ?>_string" name="part[<?php echo ($index - 1); ?>][content]" type="text" value="<?php echo $part->content; ?>" />

</div>
<!-- /part -->
