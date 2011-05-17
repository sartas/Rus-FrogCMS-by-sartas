/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Maslakov Alexander <jmas.ukraine@gmail.com>
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
 * @package frog
 * @subpackage tinymce
 *
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Maslakov Alexander, 2010
 */

/*
	TinyMCE object
*/
var frogTinymce = {}; 

frogTinymce.setupInitArr = [];

frogTinymce.buttons = [];

// TinyMCE settings
// Part of settings were taked from Wordpress (http://wordpress.org/)
frogTinymce.settings = {
	// General options
	script_url: PLUGINS_URL + 'tinymce/tinymce/tiny_mce.js',
	mode: 'textareas',
	theme: 'advanced',
	plugins: 'directionality,fullscreen,inlinepopups,media,paste,safari,spellchecker',
	theme_advanced_buttons1: 'bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,filemanager,image,media,|,gallery,|,code,fullscreen',
	theme_advanced_buttons2: 'fontsizeselect,formatselect,|,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,charmap,|,outdent,indent,|,undo,redo',
	theme_advanced_buttons3: '',
	theme_advanced_toolbar_location: 'top',
	theme_advanced_toolbar_align: 'left',
	theme_advanced_statusbar_location: 'bottom',
	theme_advanced_resizing: false,
	theme_advanced_resize_horizontal: true,
	width: '100%',
	valid_elements: '@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,#p[align],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,-blockquote[cite],-table[border=0|cellspacing|cellpadding|width|frame|rules|height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],object[classid|width|height|codebase|*],param[name|value],embed[type|width|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value|tabindex|accesskey],kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],q[cite],samp,select[disabled|multiple|name|size],small,textarea[cols|rows|disabled|name|readonly],tt,var,big',
	directionality: 'ltr',
	forced_root_block: 'p',
	delta_width: 0,
	delta_height: 0,
	popup_css: '',
	add_form_submit_trigger: 1,
	submit_patch: 1,
	add_unload_trigger: 1,
	
	document_base_url: PUBLIC_URL,
	convert_urls: 1,
	relative_urls: 0,
	remove_script_host: 1,
	table_inline_editing: 0,
	object_resizing: 1,
	cleanup: 1,
	accessibility_focus: 1,
	custom_shortcuts: 1,
	custom_undo_redo_keyboard_shortcuts: 1,
	custom_undo_redo_restore_selection: 1,
	custom_undo_redo: 1,
	doctype: '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">',
	visual_table_class: 'mceItemTable',
	visual: 1,
	inline_styles: true,
	convert_fonts_to_spans: true,
	font_size_style_values: 'xx-small,x-small,small,medium,large,x-large,xx-large',
	apply_source_formatting: 1,
	hidden_input: 1,
	padd_empty_editor: 1,
	render_ui: 1,
	init_theme: 1,
	force_p_newlines: 1,
	indentation: '30px',
	keep_styles: 1,
	fix_table_elements: 1,
	removeformat_selector: 'span,b,strong,em,i,font,u,strike',
	height:400,
	
	// custom links
	external_link_list_url: BASE_URL + '?/plugin/tinymce/links_js/',
	
	// events
	
	// pre init event
	setup: function( editor )
	{		
		for( var i=0; i<frogTinymce.setupInitArr.length; i++ )
		{
			frogTinymce.setupInitArr[i]( editor );
		}
	},
	
	// onchange
	onchange_callback: function()
	{
		frogPageEdit.formChanged = true;
	},
	
	// when form before submit
	save_callback: function(element_id, html, body)
	{
		frogPageEdit.formChanged = false;
		
		return html;
	}
};

frogTinymce.addButton = function( identifier, callback )
{
	frogTinymce.buttons.push( identifier );
	frogTinymce.setupInitArr.push( callback );
};

// Switch on tinymce handler
frogTinymce.switchOn_handler = function( textarea_id )
{
	var ed = tinymce.get( textarea_id );
	
	if( ed == undefined )
	{
		ed = new tinyMCE.Editor( textarea_id, frogTinymce.settings );
		ed.render();
	}
	else
	{
		ed.show();
	}
};


// Switch off tinymce handler
frogTinymce.switchOff_handler = function( textarea_id )
{
	tinymce.get( textarea_id ).hide();
};



/*
	When DOM init
*/
jQuery(function(){

	frogTinymce.settings['language'] = TINYMCE_LOCALE;

	/*
		Add tinymce filter to Frog filters stack
	*/
	frogFilters.add( 'tinymce', frogTinymce.switchOn_handler, frogTinymce.switchOff_handler );
});