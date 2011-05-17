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
	When DOM ready
*/
jQuery(function(){

	/*
		Add CodeMirror filter handlers to filters stack
	*/
	// CodeMirror switched on editors stack
	var codemirror_editors = {};
	
	// Handler for switch of CodeMirror editor
	var codemirror_switchOn_handler = function( textarea_id )
	{
		// Execute codemirror editor and remember CM object
		codemirror_editors[textarea_id] = CodeMirror.fromTextArea(textarea_id, {
			// options
			iframeClass: 'codemirror-editor-iframe',
			parserfile: ['parsexml.js', 'parsecss.js', 'tokenizejavascript.js', 'parsejavascript.js',
						 '../contrib/php/js/tokenizephp.js', '../contrib/php/js/parsephp.js',
						 '../contrib/php/js/parsephphtmlmixed.js'],
			stylesheet: [PLUGINS_URL + 'codemirror/codemirror/css/xmlcolors.css', PLUGINS_URL + 'codemirror/codemirror/css/jscolors.css', PLUGINS_URL + 'codemirror/codemirror/css/csscolors.css', PLUGINS_URL + 'codemirror/codemirror/contrib/php/css/phpcolors.css'],
			path: PLUGINS_URL + '/codemirror/codemirror/js/',
			indentUnit: 4,
			tabMode: 'spaces',
			//lineNumbers: true,
			textWrapping: false,
			
			// events
			onChange: function()
			{
				frogPageEdit.formChanged = true;
			}
		});
	};
	
	// Handler for switch off CodeMirror editor
	var codemirror_switchOff_handler = function( textarea_id )
	{
		var editor = codemirror_editors[textarea_id];
		
		if( editor != undefined && editor != null && editor.toTextArea != undefined )
		{
			editor.toTextArea();
			codemirror_editors[textarea_id] = null;
		}
	};
	
	// Add filter to filters stack
	frogFilters.add( '', codemirror_switchOn_handler, codemirror_switchOff_handler );
	
	
	
	/*
		Switch on CodeMirror editor on specific pages
		(Only for Core pages)
	*/
	// Switch on CodeMirror filter when we come to specific page
	switch( jQuery('body:first').attr('id') )
	{
		// Switch on Snippets filter on pages with <body> ID's:
		case 'body_snippet_add':
		case 'body_snippet_edit':
			frogFilters.switchOn( 'snippet_content', '' );
			break;
		
		// Switch on Layouts filter on pages with <body> ID's:
		case 'body_layout_add':
		case 'body_layout_edit':
			
			// Execute codemirror editor
			CodeMirror.fromTextArea('layout_content', {
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
			
			break;
	}
}); // end