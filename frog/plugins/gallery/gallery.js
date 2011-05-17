$(function(){

	if( frogTinymce != 'undefined' )
	{
		frogTinymce.addButton( 'gallery', function(editor)
		{
			editor.addButton('gallery', {
				title: frog.__('Insert simple gallery'),
				'class': 'mce_gallery',
				onclick: function()
				{
					try
					{
						//editor.selection.getNode();
						var last_pos = editor.selection.getBookmark();
					} 
					catch(e) {}
					
					var dialogClose_handler;
					
					// Loaded handler
					var dialogLoaded_handler = function( content )
					{								
						var form_action = content.find('#gallery-upload-form').attr('action');
						
						var onError_handler = function( event, ID, fileObj, errorObj )
						{
							frog.error( 'Gallery plugin: File not uploaded by SWF uploader.', errorObj );
						};
						
						var onAllComplete_handler = function( event, data )
						{
							var requestSuccess_handler = function( data )
							{
								if( dialogClose_handler )
									dialogClose_handler();
							
								var html_content = '<ul class="gallery">';
								
								for( var i=0; i<data.files.length; i++ )
								{
									html_content += '<li><a href="/public/gallery/'+ data.files[i] +'" rel="group"><img src="/public/gallery/0x120-'+ data.files[i] +'" border="0" alt="'+ data.files[i] +'" /></a></li>';
								}
								
								html_content += '</ul>';
							
								editor.focus();
							
								if( last_pos )
									editor.selection.moveToBookmark( last_pos );
								
								editor.execCommand( 'mceInsertContent', false, html_content );
							};
							
							var requestError_handler = function()
							{
								forg.error('Gallery: Ajax can\'t loaded uploaded files names.');
							};
							
							jQuery.ajax({
								// options
								url: '?/plugin/gallery/uploaded_files_names',
								type: 'get',
								dataType: 'json',
								
								// events
								success: requestSuccess_handler,
								error: requestError_handler
							});
						};
						
						// SWF uploader
						content.find('#gallery-upload-file').uploadify({
							// options
							uploader  : PLUGINS_URL + 'files/uploadify/uploadify.swf',
							script    : form_action,
							expressInstall : PLUGINS_URL + 'files/uploadify/expressInstall.swf',
							cancelImg : PLUGINS_URL + 'files/uploadify/cancel.png',
							wmode     : 'transparent',
							multi     : true,
							buttonText: 'Add files',
							fileExt   : '*.jpg;*.gif;*.png',
							fileDesc  : 'Images',
							scriptData: {
								'PHPSESSID': frogFileUpload.getPhpsessid()
							},
							method    : 'post',
							auto      : false,
							
							// events
							onError   : onError_handler,
							onAllComplete: onAllComplete_handler
						});
						
						content.find('#gallery-upload-button').click(function(){
							$('#gallery-upload-container .uploadifyQueueItem').each(function()
							{
								var file_id = jQuery(this).attr('id').replace('gallery-upload-file','');
								$('#gallery-upload-file').uploadifyUpload( file_id );
							});
							
							$(this).attr('disabled', true);
						});
						
						content.find('#gallery-upload-cancel').click(dialogClose_handler);
					};
					
					// Hack for TinyMCE fullscreen future
					//jQuery('#overlay').css('z-index', 200050);
					
					// Open dialog box
					dialogClose_handler = frog.dialog({
						// options
						url: '?/plugin/gallery/gallery_upload',
						modal: true,
						width: 500,
						height:400,
						className: 'gallerys-dialog',
						alwaysNew: true,
						
						//events
						loaded: dialogLoaded_handler
					});
				}
			});
		});
	}

});