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
	
	// SwitchOn handler for Textile editor
	var markitup_textile_switchOn_handler = function( textarea_id )
	{
		var textile_settings = {
			nameSpace:          'textile', // Useful to prevent multi-instances CSS conflict
			//previewParserPath:	'', // path to your Textile parser
			onShiftEnter:		{keepDefault:false, replaceWith:'\n\n'},
			markupSet: [
				{name:'Heading 1', key:'1', openWith:'h1(!(([![Class]!]))!). ', placeHolder:'Your title here...' },
				{name:'Heading 2', key:'2', openWith:'h2(!(([![Class]!]))!). ', placeHolder:'Your title here...' },
				{name:'Heading 3', key:'3', openWith:'h3(!(([![Class]!]))!). ', placeHolder:'Your title here...' },
				{name:'Heading 4', key:'4', openWith:'h4(!(([![Class]!]))!). ', placeHolder:'Your title here...' },
				{name:'Heading 5', key:'5', openWith:'h5(!(([![Class]!]))!). ', placeHolder:'Your title here...' },
				{name:'Heading 6', key:'6', openWith:'h6(!(([![Class]!]))!). ', placeHolder:'Your title here...' },
				{name:'Paragraph', key:'P', openWith:'p(!(([![Class]!]))!). '},
				{separator:'---------------' },
				{name:'Bold', key:'B', closeWith:'*', openWith:'*'},
				{name:'Italic', key:'I', closeWith:'_', openWith:'_'},
				{name:'Stroke through', key:'S', closeWith:'-', openWith:'-'},
				{separator:'---------------' },
				{name:'Bulleted list', openWith:'(!(* |!|*)!)'},
				{name:'Numeric list', openWith:'(!(# |!|#)!)'}, 
				{separator:'---------------' },
				{name:'Picture', replaceWith:'![![Source:!:http://]!]([![Alternative text]!])!'}, 
				{name:'Link', openWith:'"', closeWith:'([![Title]!])":[![Link:!:http://]!]', placeHolder:'Your text to link here...' },
				{separator:'---------------' },
				{name:'Quotes', openWith:'bq(!(([![Class]!]))!). '},
				{name:'Code', openWith:'@', closeWith:'@'}
				//{separator:'---------------' },
				//{name:'Preview', call:'preview', className:'preview'}
			]
		};
	
		jQuery('#' + textarea_id).markItUp( textile_settings );
	};
	
	// SwitchOff handler for Textile editor
	var markitup_textile_switchOff_handler = function( textarea_id )
	{
		jQuery('#' + textarea_id).markItUpRemove();
	};
	
	// SwitchOn handler for Markdown editor
	var markitup_markdown_switchOn_handler = function( textarea_id )
	{
		// mIu nameSpace to avoid conflict.
		var miu = {
			markdownTitle: function(markItUp, char) {
				heading = '';
				n = $.trim(markItUp.selection||markItUp.placeHolder).length;
				for(i = 0; i < n; i++) {
					heading += char;
				}
				return '\n'+heading+'\n';
			}
		};
		
		var markdown_settings = {
		    nameSpace:          'markdown', // Useful to prevent multi-instances CSS conflict
		    //previewParserPath:  '~/sets/markdown/preview.php',
		    onShiftEnter:       {keepDefault:false, openWith:'\n\n'},
		    markupSet: [
		        {name:'First Level Heading', key:"1", placeHolder:'Your title here...', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, '=') } },
		        {name:'Second Level Heading', key:"2", placeHolder:'Your title here...', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, '-') } },
		        {name:'Heading 3', key:"3", openWith:'### ', placeHolder:'Your title here...' },
		        {name:'Heading 4', key:"4", openWith:'#### ', placeHolder:'Your title here...' },
		        {name:'Heading 5', key:"5", openWith:'##### ', placeHolder:'Your title here...' },
		        {name:'Heading 6', key:"6", openWith:'###### ', placeHolder:'Your title here...' },
		        {separator:'---------------' },        
		        {name:'Bold', key:"B", openWith:'**', closeWith:'**'},
		        {name:'Italic', key:"I", openWith:'_', closeWith:'_'},
		        {separator:'---------------' },
		        {name:'Bulleted List', openWith:'- ' },
		        {name:'Numeric List', openWith:function(markItUp) {
		            return markItUp.line+'. ';
		        }},
		        {separator:'---------------' },
		        {name:'Picture', key:"P", replaceWith:'![[![Alternative text]!]]([![Url:!:http://]!] "[![Title]!]")'},
		        {name:'Link', key:"L", openWith:'[', closeWith:']([![Url:!:http://]!] "[![Title]!]")', placeHolder:'Your text to link here...' },
		        {separator:'---------------'},    
		        {name:'Quotes', openWith:'> '},
		        {name:'Code Block / Code', openWith:'(!(\t|!|`)!)', closeWith:'(!(`)!)'}
		        //{separator:'---------------'},
		        //{name:'Preview', call:'preview', className:"preview"}
		    ]
		};
		
		jQuery('#' + textarea_id).markItUp( markdown_settings );
	};
	
	// SwitchOff handler for Markdown editor
	var markitup_markdown_switchOff_handler = function( textarea_id )
	{
		jQuery('#' + textarea_id).markItUpRemove();
	};
	
	// Add MarkItUp filter to filters stack
	frogFilters.add( 'textile', markitup_textile_switchOn_handler, markitup_textile_switchOff_handler );
	frogFilters.add( 'markdown', markitup_markdown_switchOn_handler, markitup_markdown_switchOff_handler );
});