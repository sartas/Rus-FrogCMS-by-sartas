<?php
if ( !defined( 'DEBUG' ) )
	die;
?>
<h1><?php echo __( 'Add page part' ); ?></h1>
<form id="newpart_form<?php if(isset($part->id)) echo '_' . $part->id;else echo '_layout_' . $part->layout_id; ?>">
	<p>
	<div>
		<label><?php echo __( 'Type' ); ?>:</label>
		<div>
			<select class="input-select" name="part[type]">
				<? foreach ( PagePart::getTypes() as $type ): ?>
					<option value="<?= $type; ?>" <? echo ($type == $part->type) ? 'selected' : ''; ?>><?= $type; ?></option>
				<? endforeach; ?>
			</select>
		</div>
	</div>
	<div>
		<label><?php echo __( 'Name' ); ?>:</label>
		<div><input class="input-text" style="width:200px;" type="text" name="part[name]" value="<?= $part->name; ?>"/></div>
	</div>
	<div>
		<label><?php echo __( 'Title' ); ?>:</label>
		<div><input class="input-text" style="width:200px;" type="text" name="part[title]" value="<?= $part->title; ?>"/></div>
	</div>
	
</p>

<p>
	<input id="newtab_ok" class="input-button" type="submit" value="<?php if(isset($part->id))echo __( 'Edit' );else echo __( 'Add' ); ?>" /> <?php echo __( 'or' ); ?> <a id="newtab_cancel" href="javascript:void(0);"><?php echo __( 'Cancel' ); ?></a>
</p>
</form>