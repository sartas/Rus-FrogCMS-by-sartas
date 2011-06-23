<?php
if ( !defined( 'DEBUG' ) )
	die;
?>

<h1><?php echo __( 'Select Page type' ); ?></h1>



<?php foreach ( $layouts as $layout ): ?>
	<ul><br /><br /><br /><br /><br /><br /><br /><br />
		<li><a href="<?= get_url( 'page/add/' . $parent_id . '/' . $layout->id ); ?>"><?= $layout->name; ?></a></li>
	</ul>
<? endforeach; ?>

