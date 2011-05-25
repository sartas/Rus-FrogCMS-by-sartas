<?php
if ( !defined( 'DEBUG' ) )
	die;
?>
<!-- part -->
<div  class="page-edit-part content-area">
	<div style="font-size:120%;float:left;width:20%;font-weight: bold;line-height:25px"><?php echo $part->title; ?></div>
	<div style="float:left;width:80%">
		<input id="part_<?php echo ($index - 1); ?>_name" name="part[<?php echo ($index - 1); ?>][type]" type="hidden" value="<?php echo $part->type; ?>" />
		<input id="part_<?php echo ($index - 1); ?>_part_id" name="part[<?php echo ($index - 1); ?>][part_id]" type="hidden" value="<?php echo $part->part_id; ?>" />
		<? if ( isset( $part->id ) && $part->id != '' ): ?>
			<input id="part_<?php echo ($index - 1); ?>_id" name="part[<?php echo ($index - 1); ?>][id]" type="hidden" value="<?php echo $part->id; ?>" />
		<? endif; ?>


		<input class="input-text" style="width:100%"  id="part_<?php echo ($index - 1); ?>_string" name="part[<?php echo ($index - 1); ?>][content]" type="text" value="<?php echo $part->content; ?>" />

	</div>
	<div class="clear">	</div>
</div>
<!-- /part -->
