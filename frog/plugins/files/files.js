/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Frog CMS.
 *
 * Frog CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Frog CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Frog CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Frog CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 *	@author Maslakov Alexandr <jmas.ukraine@gmail.com>
*/

/*
	frogFiles
	Files managment
*/
var frogFiles = {};

// Init
frogFiles.init = function()
{	
	/*
		Global init
	*/
	jQuery('body:first').addClass('files-index');
	
	
	
	/*
		events
	*/
	jQuery('#files_tree .file-node-folder .file-expander').click(this.expanderClick);
	jQuery('#files_tree .file-perm-link').click(this.filePermClick);
	jQuery('#files_tree .file-remove').click(this.fileRemoveClick);
};

// When we want expand folder
frogFiles.expanderClick = function()
{
	var $item = jQuery(this).parent().parent().parent();
	
	if( $item.hasClass('file-folder-loaded') === false )
	{
		var path = $item.attr('rel');	
		var level = path.split('/').length;
		
		// handlers
		var requestSuccess_handler = function( html )
		{
			$item
				.addClass('file-folder-loaded')
				.append( html )
				.find('ul .file-expander')
					.click(frogFiles.expanderClick)
				
			$item
				.find('ul .file-perm-link')
					.click(frogFiles.filePermClick);
					
			$item
				.find('.file-expander:first')
					.addClass('file-expander-collapse');
			
			$item
				.find('ul .file-remove')
					.click(frogFiles.fileRemoveClick);
					
			//frog.loaderHide();
		};
		
		var requestError_handler = function( answer )
		{
			frog.error('Filemanager: Ajax data not loaded!', answer);
			
			//frog.loaderHide();
		};
		
		// Show loader screen
		//frog.loaderShow();
		
		// Get subfoldres by Ajax
		jQuery.ajax({
			// options
			url: '?/plugin/files/browse',
			data: {
				level: level,
				path: path
			},
			type: 'post',
			dataType: 'html',
			
			// events
			success: requestSuccess_handler,
			error: requestError_handler
		});
	}
	else // If subfolders already loaded
	{
		if( $item.hasClass('file-folder-expand') )
		{
			$item
				.removeClass('file-folder-expand')
				.find('.file-expander:first')
					.addClass('file-expander-collapse');
		}
		else
		{
			$item
				.addClass('file-folder-expand')
				.find('.file-expander:first')
					.removeClass('file-expander-collapse');
		}
	}
};

// File permissions click event
frogFiles.filePermClick = function()
{
	var dialog_url = jQuery(this).attr('href');

	var permsClose_handler = frog.dialog({
		// options
		url: dialog_url,
		modal: true,
		alwaysNew: false,
		width: 280,
		height: 150,
		
		// events
		loaded: function( content ){
			var inp = content.find('.perms-num:first');
		
			content.find('.perms-form:first').submit(function(){
				var perms = inp.val().replace(/[^0-9]/ig, '');
				
				if( perms == '' )
				{
					alert( frog.__('Permissions number can\'t be empty!') );
				}
				else
				{
					// Success handler
					var permsSuccess_handler = function( data )
					{
						if( data == 'true' )
						{
							frog.messageShow('success', frog.__('Permissions chenged successfully! Update this page.'));
						}
						else
						{
							frog.messageShow('error', frog.__('Permissions not changed!'));
						}
						
						frog.loaderHide();
					};
					
					// Error handler
					var permsError_handler = function( data )
					{
						frog.error('Filemanager: Permission not changed by ajax!', data);
					};
					
					var target_path = content.find('.perms-target:first').val();
					
					// Close win
					permsClose_handler();
					
					// Hide loader
					frog.loaderShow();
					
					// Request
					jQuery.ajax({
						// options
						type: 'post',
						url: '?/plugin/files/perms_change/',
						data: {
							target: target_path,
							perms: perms
						},
						dataType: 'html',
						
						// events 
						success: permsSuccess_handler,
						error: permsError_handler
					});
				}
				
				return false;
			});
			
			content.find('.perms-cancel:first').click(permsClose_handler);
		}
	});
	
	return false;
};

frogFiles.fileRemoveClick = function()
{
	if( confirm(frog.__('Are you sure?')) )
	{
		var url = jQuery(this).attr('href');
		var $item = jQuery(this).parent().parent().parent();
		
		// Success handler
		var requestSuccess_handler = function( data )
		{
			if( data == 'true' )
			{
				frog.messageShow('success', frog.__('Deleted successfully!'));
				
				$item
					.animate({height: 0}, 500, function(){
						var parent = jQuery(this).parent();
						
						jQuery(this).remove();
						
						if( parent.find('li').length == 0 )
						{
							parent.parent().find('.file-expander:first').hide();
						}
					});
			}
			else
			{
				frog.messageShow('error', frog.__('Do not removed. Check permissions!'));
			}
			
			// Hide loader
			frog.loaderHide();
		};
		
		// Errror handler
		var requestError_handler = function( data )
		{
			frog.error('Filemanager: Ajax deleting error...', data);
		};
		
		// Show loader
		frog.loaderShow();
		
		// Request
		jQuery.ajax({
			// options
			type: 'get',
			url: url,
			dataType: 'html',
			
			// events
			success: requestSuccess_handler,
			error: requestError_handler
		});
	}
	
	return false;
};

frogFiles.dialogResult_handler = null;
frogFiles.dialogAllowedExt = '';
frogFiles.dialogClose_handler = '';

// Dialog for selecting files
frogFiles.dialog = function( result_callback, allowed_ext )
{
	var dialogClose_handler = null;
	
	frogFiles.dialogResult_handler = result_callback;
	frogFiles.dialogAllowedExt = allowed_ext;
	
	// Loaded handler
	var dialogLoaded_handler = function( content )
	{		
		content.find('.files-d-expander').click( frogFiles.dialogExpanderClick );
		content.find('.files-d-link').click( frogFiles.dialogLinkClick );
		
		content.find('.files-d-link:first').click();
	};
	
	// Hack for TinyMCE fullscreen future
	//jQuery('#overlay').css('z-index', 200050);
	
	// Open dialog box
	frogFiles.dialogClose_handler = frog.dialog({
		// options
		url: '?/plugin/files/files_dialog',
		modal: true,
		width: 800,
		height:460,
		className: 'files-dialog',
		alwaysNew: false,
		
		//events
		loaded: dialogLoaded_handler
	});
};

// Epander click handler
frogFiles.dialogExpanderClick = function()
{
	var $item = jQuery(this).parent().parent();
	
	if( $item.hasClass('files-d-loaded') == false )
	{
		var path = $item.attr('rel');
		var level = path.split('/').length;
		
		// Success handler
		var requestSuccess_handler = function( data )
		{
			var $children = jQuery(data);
			
			$item
				.addClass('files-d-loaded')
				.append($children)
				.find('ul .files-d-expander')
					.click(frogFiles.dialogExpanderClick);
			
			$item
				.find('.files-d-link')
					.click(frogFiles.dialogLinkClick);
			
			$item
				.find('.files-d-expander:first')
					.addClass('files-d-expanded');
			
			$item.find('.files-d-spinner:first').css('display', 'none');
		};
		
		//Error handler
		var requestError_handler = function( data )
		{
			frog.error( 'Filemanager: Can\'t load files by ajax!', data );
		};
		
		$item.find('.files-d-spinner:first').css('display', 'inline-block');
		
		// Request
		jQuery.ajax({
			// options
			type: 'post',
			url: '?/plugin/files/dialog_dirs',
			dataType: 'html',
			data: {
				level: level,
				path: path
			},
			
			// events
			success: requestSuccess_handler,
			error: requestError_handler
		});
	}
	else
	{
		$expander = $item.find('.files-d-expander:first');
		
		if( $expander.hasClass('files-d-expanded') )
		{
			$item
				.find('ul:first')
					.hide();
					
			$expander
				.removeClass('files-d-expanded');
		}
		else
		{
			$item
				.find('ul:first')
					.show();
					
			$expander
				.addClass('files-d-expanded');
		}
	}
};

// Link click
frogFiles.dialogLinkClick = function()
{
	var $item = jQuery(this).parent();
	
	jQuery('#files_list .file-d-current').removeClass('file-d-current');
	
	$item.addClass('file-d-current');
	
	$files_p = jQuery('#files_preview');
	
	$files_p
		.html('');
	
	// Success handler
	var requestSuccess_handler = function( data )
	{
		if( data != '' )
		{
			var source = jQuery( data );
			
			$files_p
				.html( source );
				
			$files_p	
				.find('.files-d-opened-file')
					.click(function(){
						var path = jQuery(this).attr('rel');
						
						// Execute callback
						if( frogFiles.dialogResult_handler != null && frogFiles.dialogResult_handler != undefined )
							frogFiles.dialogResult_handler( path );
						
						frogFiles.dialogClose_handler();
					});
			
			/*
			$files_p
				.find('.files-d-opened-dir')
					.click(function(){
						var path = jQuery(this).attr('rel');
						
						var parent_path = path.substring(0, path.lastIndexOf('/'));
						
						jQuery('#files_list li[rel="'+ parent_path +'"]').find('.files-d-expander').click();
					});
			*/
		}
		else
		{
			jQuery('#files_preview')
				.html( '<li class="files-d-empty">'+ frog.__('Empty') +'</li>' );
		}
		
		jQuery('#files_main').removeClass('files-d-loader');
	};
	
	// Error handler
	var requestError_handler = function( data )
	{
		frog.error( 'Filemanager: Do not loaded directory files by Ajax!', data );
	};
	
	var path = $item.parent().attr('rel');
	
	jQuery('#files_main').addClass('files-d-loader');
	
	// Request
	jQuery.ajax({
		// options
		type: 'get',
		url: '?/plugin/files/dialog_preview/' + path,
		dataType: 'html',
		
		// events
		success: requestSuccess_handler,
		error: requestError_handler
	});
	
	return false;
};



frogFiles.uploadDialog = function()
{
	var dialogClose_handler = null;
	
	// Loaded handler
	var dialogLoaded_handler = function( content )
	{		
		console.log(content);
	};
	
	// Hack for TinyMCE fullscreen future
	//jQuery('#overlay').css('z-index', 200050);
	
	// Open dialog box
	frogFiles.dialogClose_handler = frog.dialog({
		// options
		url: '?/plugin/files/upload_dialog',
		modal: true,
		width: 400,
		height:300,
		className: 'files-dialog',
		alwaysNew: false,
		
		//events
		loaded: dialogLoaded_handler
	});
};



/*
	frogFileEdit
*/
var frogFileEdit = {};

// Init
frogFileEdit.init = function()
{
	/*
		CodeMirror editor
	*/
	if( CodeMirror !== undefined )
	{
		CodeMirror.fromTextArea('file_content', {
			iframeClass: 'codemirror-editor-iframe',
			parserfile: ['parsexml.js', 'parsecss.js', 'tokenizejavascript.js', 'parsejavascript.js',
							 '../contrib/php/js/tokenizephp.js', '../contrib/php/js/parsephp.js',
							 '../contrib/php/js/parsephphtmlmixed.js'],
			stylesheet: [PLUGINS_URL + 'codemirror/codemirror/css/xmlcolors.css', PLUGINS_URL + 'codemirror/codemirror/css/jscolors.css', PLUGINS_URL + 'codemirror/codemirror/css/csscolors.css', PLUGINS_URL + 'codemirror/codemirror/contrib/php/css/phpcolors.css'],
			path: PLUGINS_URL + '/codemirror/codemirror/js/',
			indentUnit: 4,
			tabMode: 'spaces',
			textWrapping: false
		});
	}
};



/*
	frogFileUpload
*/
var frogFileUpload = {};

// Init
frogFileUpload.init = function()
{	
	/*
		SWF upload
	*/
	// Error handler
	var onError_handler = function( event, ID, fileObj, errorObj )
	{
		frog.error( 'Files plugin: File not uploaded by SWF uploader.', errorObj );
	};
	
	// Success handler
	var onAllComplete_handler = function( event, data )
	{
		location.href = PUBLIC_URL + ADMIN_DIR + '/?/plugin/files/';
	};
	
	// Get form action
	var form_action = jQuery('#files_upload').attr('action');
	
	// SWF uploader
	$('#file_upload').uploadify({
		// options
		uploader  : PLUGINS_URL + 'files/uploadify/uploadify.swf',
		script    : form_action,
		expressInstall : PLUGINS_URL + 'files/uploadify/expressInstall.swf',
		cancelImg : PLUGINS_URL + 'files/uploadify/cancel.png',
		wmode     : 'transparent',
		multi     : true,
		buttonText: frog.__('Select files'),
		scriptData: {
			'PHPSESSID': frogFileUpload.getPhpsessid()
		},
		method    : 'post',
		auto      : false,
		
		// events
		onError   : onError_handler,
		onAllComplete: onAllComplete_handler
	});
	
	
	
	/*
		Switcher event
	*/
	jQuery('#files_switcher').click(this.switcherClick);
	jQuery('#file_simple_add').click(this.simpleAddButtonClick);
	jQuery('#files_upload').submit(this.formSubmit);
};

// switcher click event handler
frogFileUpload.switcherClick = function()
{
	if( jQuery('#files_swf_container').css('display') == 'block' )
	{
		jQuery('#files_swf_container').hide();
		jQuery('#files_simple_container').show();
	}
	else
	{
		jQuery('#files_swf_container').show();
		jQuery('#files_simple_container').hide();
	}
};

// New field button event handler
frogFileUpload.simpleAddButtonClick = function()
{
	jQuery('#files_simple_container').append('<p class="files-item"><input name="file_upload[]" type="file" /></p>');
};

// Form submit event handler
frogFileUpload.formSubmit = function()
{
	if( jQuery('#files_swf_container').css('display') == 'block' )
	{
		$('#files_swf_container .uploadifyQueueItem').each(function(){
			var file_id = jQuery(this).attr('id').replace('file_upload','');
			$('#file_upload').uploadifyUpload( file_id );
		});
		
		return false;
	}
};

// Get PHPSESSID from Cookies
frogFileUpload.getPhpsessid = function()
{
	var start = document.cookie.indexOf('PHPSESSID=');
	
	// First ; after start
	var end = document.cookie.indexOf(';', start);
	
	// failed indexOf = -1
	if( end == -1 )
		end = document.cookie.length;
		
	return document.cookie.substring( start+10, end );
};



/*
	When DOM ready
*/
jQuery(function(){
	/*
		TinyMCE File browser
	*/
	if( typeof(frogTinymce) != 'undefined' )
	{
		// file browser
		frogTinymce.settings['file_browser_callback'] = function(field_name, url, type, win)
		{
			var winInsert_handler = function( file_url )
			{
				 win.document.forms[0].elements[field_name].value = file_url;
			};
			
			var files_exts = '';
			
			switch( type )
			{
				case 'file':  files_exts = ''; break;
				case 'image': files_exts = 'jpg,jpeg,gif,png'; break;
				case 'media': files_exts = 'swf,fla,flv,avi,mpeg'; break;
			}
			
			frogFiles.dialog( winInsert_handler, files_exts );
		};
		
		frogTinymce.addButton( 'filemanager', function(editor)
		{
			editor.addButton('filemanager', {
				title: frog.__('Insert a file'),
				'class': 'mce_filemanager',
				onclick: function()
				{
					try
					{
						//editor.selection.getNode();
						var last_pos = editor.selection.getBookmark();
					} 
					catch(e) {}
					
					// Insert to content handler
					var editorInsert_handler = function( file_url )
					{
						var html_content = '';
						
						switch( file_url.replace(/^.+\./ig, '').toString().toLowerCase() )
						{
							case 'jpg':
							case 'jpeg':
							case 'gif':
							case 'png':
								html_content = '<img src="'+ file_url +'" alt="" />';
								break;
								
							default:
								html_content = '<a href="'+ file_url +'">'+ file_url +'</a>';
								break;
						}
						editor.focus();
						editor.selection.moveToBookmark( last_pos );
						editor.execCommand( 'mceInsertContent', false, html_content );
					};
					
					frogFiles.dialog( editorInsert_handler, 'jpg,jpeg,gif,png' );
				}
			});
		});
	}


	/*
		Detect specific pages
	*/
	switch( jQuery('body:first').attr('id') )
	{
		// Files -> index
		case 'body_plugin_files_index':
			frogFiles.init();
			break;
			
		// Files -> upload
		case 'body_plugin_files_upload':
			frogFileUpload.init();
			break;
			
		// Files -> edit
		case 'body_plugin_files_edit':
			frogFileEdit.init();
			break;
	}
});