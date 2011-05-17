<h1><?php echo __('Insert gallery'); ?></h1>

<ul id="gallerys-dialog">
	<li><a id="gallery-create-button" href="#"><?php echo __('Create gallery'); ?></a></li>
	<?php foreach($gallerys as $gallery): ?>
	<li><a href="#" rel="<?php echo $gallery->id; ?>"><?php echo $gallery->name; ?></a></li>
	<?php endforeach; ?>
</ul>