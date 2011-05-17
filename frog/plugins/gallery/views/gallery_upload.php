<h1><?php echo __('Upload gallery photos'); ?></h1>

<div id="gallery-form-container">
	<form id="gallery-upload-form" action="<?php echo get_url('plugin/gallery/upload_files'); ?>" method="post" enctype="multipart/form-data">

		<div id="gallery-upload-container"><input id="gallery-upload-file" name="file_upload" type="file" /></div>
		
		<p>
			<input id="gallery-upload-button" class="input-button" type="button" value="<?php echo __('Upload files and Insert Gallery'); ?>" />
			<?php echo __('or'); ?>
			<a id="gallery-upload-cancel" href="javascript:void(0);"><?php echo __('Cancel'); ?></a>
		</p>

	</form>
</div>