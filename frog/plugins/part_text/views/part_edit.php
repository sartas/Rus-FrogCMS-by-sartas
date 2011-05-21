<?php
if ( !defined( 'DEBUG' ) )
	die;
?>
<!-- part -->
<div id="page_edit_twrapper">
	<div id="page_edit_tabs">
		<div id="" class="page-edit-tab page-edit-tactive">
			<span><?php echo $part->title; ?></span>
		</div>
	</div>
</div>
<div id="page_edit_items">
	<div class="page-edit-item page-edit-pactive" id="page_edit_<?php echo $index; ?>" title="<?php echo $part->title; ?>">
		<div class="page-edit-part content-area" id="part_<?php echo $index; ?>">
			<input id="part_<?php echo ($index - 1); ?>_name" name="part[<?php echo ($index - 1); ?>][type]" type="hidden" value="<?php echo $part->type; ?>" />
			<input id="part_<?php echo ($index - 1); ?>_part_id" name="part[<?php echo ($index - 1); ?>][part_id]" type="hidden" value="<?php echo $part->part_id; ?>" />
			<? if ( isset( $part->id ) && $part->id != '' ): ?>
				<input id="part_<?php echo ($index - 1); ?>_id" name="part[<?php echo ($index - 1); ?>][id]" type="hidden" value="<?php echo $part->id; ?>" />
			<? endif; ?>
			<p class="page-edit-filter">
				<label for="part_<?php echo ($index - 1); ?>_filter_id"><?php echo __( 'Filter' ); ?></label>
				<select id="part_<?php echo ($index - 1); ?>_filter_id" name="part[<?php echo ($index - 1); ?>][filter_id]" class="input-select page-part-filter">
					<option value="" <?php if ( $part->filter_id == '' )
				echo('selected="selected"'); ?> >&ndash; <?php echo __( 'none' ); ?> &ndash;</option>
							<?php foreach ( Filter::findAll() as $filter ): ?> 
						<option value="<?php echo $filter; ?>" <?php if ( $part->filter_id == $filter )
								echo(' selected="selected"'); ?> ><?php echo Inflector::humanize( $filter ); ?></option>
							<?php endforeach; ?> 
				</select>
			</p>

			<div class="page-edit-content">
				<textarea class="input-textarea-code page-part-textarea" id="part_<?php echo ($index - 1); ?>_content" name="part[<?php echo ($index - 1); ?>][content]" rows="20" cols="40"><?php echo htmlentities( $part->content, ENT_COMPAT, 'UTF-8' ); ?></textarea>
			</div>
		</div>
	</div>


	<script type="text/javascript">
			jQuery(function(){
				frogFilters.switchOn( 'part_<?php echo ($index - 1); ?>_content', '<?php echo $part->filter_id; ?>' );
			});
	</script>
</div>
<!-- /part -->
