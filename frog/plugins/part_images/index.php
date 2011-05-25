<?php

AutoLoader::addFile( 'PartImages', PLUGINS_DIR . 'part_images/PartImages.php' );

Plugin::addController('part_images');

PagePart::addType( 'images' );
?>