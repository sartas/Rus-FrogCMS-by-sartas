<div id="ai-form-container">
	<form id="<?=$part_id;?>-ai-upload-form" action="<?php echo get_url( 'plugin/part_images/upload/' . $page_id . '/' . $part_id ); ?>" method="post" enctype="multipart/form-data">

		<div id="ai-upload-container"><input id="<?=$part_id;?>-ai-upload-file" name="file_upload" type="file" /></div>

	</form>
</div>