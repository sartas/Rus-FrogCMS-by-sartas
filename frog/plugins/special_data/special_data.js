jQuery(function(){
	
	switch( $('body').attr('id') )
	{
		case 'body_plugin_special_data_edit':
		
			if( $('#special-data-value-wysiwyg').length == 1 )
			{
				frogFilters.switchOn( 'special-data-value-wysiwyg', 'tinymce' );
			}
			
			if( $('#special-data-value-text').length == 1 )
			{
				frogFilters.switchOn( 'special-data-value-wysiwyg', '' );
			}
			
			if( $('#special-data-value-file').length == 1 )
			{
				var value = $('#special-data-value-file').val();
				
				var $hidden = $('<input id="special-data-value-file" type="hidden" name="data[value]" />')
								.attr('value', value);
				
				$('#special-data-value-file')
						.replaceWith( $hidden )
				
				$('#special-data-value')
					.append('<span id="special-data-value-file-text"></span> <input id="special-data-value-file-button" class="input-button" type="button" value="'+ frog.__('&hellip;') +'" />');
					
				$('#special-data-value-file-text').text( value );
				
				var fileSelected_handler = function( file_url )
				{
					$('#special-data-value-file').val( file_url );
					$('#special-data-value-file-text').text( file_url );
				};
				
				$('#special-data-value-file-button').click(function(){
					frogFiles.dialog( fileSelected_handler, '' );
				});
			}
			
			break;
	}
	
});