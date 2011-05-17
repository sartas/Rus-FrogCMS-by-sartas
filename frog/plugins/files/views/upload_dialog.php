<h1><?php echo __('Upload files to: :dir', array(':dir' => $dir)); ?></h1>

<form id="files_upload" action="<?php echo get_url('plugin/files/upload' . $dir); ?>" method="post" class="dform files-upload" enctype="multipart/form-data">
	<div class="dform-area">
	
		<div class="files-uploader">
			
			<p id="files_swf_container" class="files-container"><input id="file_upload" name="file_upload" type="file" /></p>
			
			<div id="files_simple_container" class="files-container">
				<p><input id="file_simple_add" class="input-button" type="button" value="<?php echo __('Add new field'); ?>" /></p>
				<p class="files-item"><input name="file_upload[]" type="file" /></p>
			</div>
			
			<p id="files_switcher"><a id="files_switcher_simple" href="javascript:void(0);"><?php echo __('Switch uploader type'); ?></a></p>
			
		</div>
	
	</div>
	
	<p>
		<input id="newtab_ok" class="input-button" type="submit" value="<?php echo __('Upload'); ?>" /> <?php echo __('or'); ?> <a id="newtab_cancel" href="javascript:void(0);"><?php echo __('Cancel'); ?></a>
	</p>
</form>