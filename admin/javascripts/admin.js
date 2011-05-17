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
	frog
	Main object (global functions)
 */
var frog = {};

// Translations array
frog.locale = [];

// Settings array
frog.settingsContainer = [];

// For dialog
frog.dialogs = {};

// Init forg
frog.init = function()
{
	/*
		Init localizations
	 */
	frog.localeInit();
		
	/*
		Overlay
	 */
	jQuery('body:first').append('<div id="overlay"></div>');
	
	
	/*
		Loader
	 */
	jQuery('body:first').append('<div id="loader"><span>'+ frog.__('Loading') +'</span></div>');
	
	
	/*
		Animate content message
	 */
	this.animateMessage();
};


// Settings
frog.settings = function(key)
{
	return frog.settings[key];
};


// Settings
frog.settingsAdd = function(key, val)
{
	frog.settings[key] = val;
};

// Translate string (not completed)
frog.__ = function( str )
{
	if( frog.locale[str] != undefined )
		return frog.locale[str];
	else
		return str;
};

// Init locale
frog.localeInit = function()
{
	if( window.__locale !== undefined )
	{
		for( var i=0; i<window.__locale.length; i++ )
		{
			frog.localeAdd( window.__locale[i] );
		}
	}
};

// Add language localization object
// frog.localeAdd( { 'English language' : 'Перевод на другом языке' } )
frog.localeAdd = function( obj )
{
	for( var k in obj )
	{
		this.locale[k] = obj[k];
	}
};

// Show Frog error message
frog.error = function( msg )
{
	alert( msg + (console !== undefined ? ' (more information in console)' : '') );
	
	if( console !== undefined )
		console.log( arguments );
		
// TODO: Send error to server logger
};

// Convert string to more pretty URI fragments
frog.toSlug = function( str )
{
	// Translation equivalents
	var translit = {
		// Russian
		'Ё':'YO',
		'Й':'I',
		'Ц':'TS',
		'У':'U',
		'К':'K',
		'Е':'E',
		'Н':'N',
		'Г':'G',
		'Ш':'SH',
		'Щ':'SCH',
		'З':'Z',
		'Х':'H',
		'Ъ':'',
		'ё':'yo',
		'й':'i',
		'ц':'ts',
		'у':'u',
		'к':'k',
		'е':'e',
		'н':'n',
		'г':'g',
		'ш':'sh',
		'щ':'sch',
		'з':'z',
		'х':'h',
		'ъ':'',
		'Ф':'F',
		'Ы':'I',
		'В':'V',
		'А':'A',
		'П':'P',
		'Р':'R',
		'О':'O',
		'Л':'L',
		'Д':'D',
		'Ж':'ZH',
		'Э':'E',
		'ф':'f',
		'ы':'i',
		'в':'v',
		'а':'a',
		'п':'p',
		'р':'r',
		'о':'o',
		'л':'l',
		'д':'d',
		'ж':'zh',
		'э':'e',
		'Я':'YA',
		'Ч':'CH',
		'С':'S',
		'М':'M',
		'И':'I',
		'Т':'T',
		'Ь':'',
		'Б':'B',
		'Ю':'YU',
		'я':'ya',
		'ч':'ch',
		'с':'s',
		'м':'m',
		'и':'i',
		'т':'t',
		'ь':'',
		'б':'b',
		'ю':'yu',
		// Lithuanian
		'Ą':'A',
		'Č':'C',
		'Ę':'E',
		'Ė':'E',
		'Į':'I',
		'Š':'S',
		'Ū':'U',
		'Ų':'U',
		'Ž':'Z',
		'ą':'a',
		'č':'c',
		'ę':'e',
		'ė':'e',
		'i':'i',
		'į':'i',
		'š':'s',
		'ū':'u',
		'ų':'u',
		'ž':'z'
	};
	
	// Replace chars and return valid string
	return jQuery.trim( str.toLowerCase() )
	.replace(/[àâ]/g,"a").replace(/[éèêë]/g,"e").replace(/[îï]/g,"i")
	.replace(/[ô]/g,"o").replace(/[ùû]/g,"u").replace(/[ñ]/g,"n")
	.replace(/[äæ]/g,"ae").replace(/[öø]/g,"oe").replace(/[ü]/g,"ue")
	.replace(/[ß]/g,"ss").replace(/[å]/g,"aa")
	.replace(/([\u0410-\u0451])/g, function(c){
		return translit[c] != undefined ? translit[c] : c;
	})
	.replace(/[^-a-z0-9~\s\.:;+=_]/g, '').replace(/[\s\.:;=+]+/g, '-');
};

// Show overlay
frog.overlayShow = function( with_animation )
{
	jQuery('body')
	.css({
		overflow: 'hidden',
		width: '100%',
		height: '100%'
	});
		
	$overlay = jQuery('#overlay');
	
	$overlay
	.css('opacity', 0)
	.show();
	
	if( with_animation == true )
		$overlay.animate({
			opacity: 0.3
		});
};

// Hide overlay
frog.overlayHide = function()
{
	jQuery('body')
	.css({
		overflow: 'auto',
		width: 'auto',
		height: 'auto'
	});
		
	jQuery('#overlay').hide();
};

// Show loading screen
frog.loaderShow = function()
{
	this.overlayShow();
		
	jQuery('#loader').show();
};

// Hise loading screen
frog.loaderHide = function()
{
	this.overlayHide();
		
	jQuery('#loader').hide();
};

// Line-message
frog.messageShow = function( id, text )
{
	if( document.getElementById( id ) == undefined )
	{
		jQuery('#content').prepend('<div id="'+ id +'" class="frog-message"></div>');
	}

	$message = jQuery('#content #' + id).html( text );
	
	this.animateMessage();
};

/*
	Animate messages
 */
frog.adimateMessage_height = null;
frog.animateMessage = function()
{
	var messageTimer = null;
	var $message = null;
	
	var messageHide = function(){
		$message.animate({
			height: 0
		}, 500);
	};
	
	$message = jQuery('.frog-message');
	
	if( frog.adimateMessage_height == null )
		frog.adimateMessage_height = $message.height();
	
	$message
	.css({
		height: 0
	})
	.animate({
		height: frog.adimateMessage_height
	}, 500, function(){
		messageTimer = setTimeout(messageHide, 3000);
	})
	.mouseover(function(){
		//clearTimeout(messageTimer);
		messageHide();
	})
/*		.mouseout(function(){
			messageTimer = setTimeout(messageHide, 1000);
		});
	 */
};

// Very simple dialog window
frog.dialog = function( options )
{
	// options.url is required
	if( options.url == undefined )
	{
		frog.error('frog.dialog <url> option is required!');		
		return;
	}
	
	// Defaults
	options.width = (options.width == undefined ? 300 : options.width);
	options.height = (options.height == undefined ? 200 : options.height);
	options.alwaysNew = (options.alwaysNew == undefined ? true : options.alwaysNew);
	options.modal = (options.modal == undefined ? false : true);
	
	// Presets
	var win = null;
	var dialog_close_handler = null;
	
	// If dialog div not init
	if( this.dialogs[options.url] == undefined )
	{
		// Create win DOM elements
		win = jQuery('<div class="frog-dialog frog-d-loader"><div class="frog-d-content"></div><a href="javascript:void(0);" class="frog-d-close"><!--x--></a></div>');
		
		// append win to body
		jQuery('body:first').append(win);
		
		// Set close button event
		win
		.find('.frog-d-close')
		.click(function(){
			dialog_close_handler();
		});
		
		// Add win to windows stack
		this.dialogs[options.url] = win;
	}
	else
	{
		win = this.dialogs[options.url];
	}
	
	// Win close handler
	dialog_close_handler = function()
	{
		win.hide();
		frog.overlayHide();
	};
	
	// Show overlay
	if( options.modal != undefined && options.modal == true )
		this.overlayShow(true);
	
	// Refrash win position
	win.css({
		top: jQuery(window).height()/2.5 - options.height/2, 
		left: (jQuery(window).width() / 2)-25
	});
	
	// find content div
	var content = win.find('.frog-d-content:first');
	
	// load content
	if( content.html() == '' || options.alwaysNew == true )
	{
		// Success handler
		var onSuccess_handler = function( data )
		{
			// Remove loader bg
			win.removeClass('frog-d-loader');
			
			if( options.className != undefined )
				win.addClass( options.className );
			
			// Resize window
			win.animate({
				top: (jQuery(window).height()/2.5 - options.height/2),
				left: (jQuery(window).width()/2 - options.width/2),
				width: options.width,
				height: options.height
			}, 500, function(){
				// Show win close button
				win
				.find('.frog-d-close')
				.show();
				
				// Set window content
				content
				.height( options.height )
				.html( data )
				.find('input[type="text"]:first')
				.focus();
				
				// Run loaded enevt
				if( typeof(options.loaded) == 'function' )
					options.loaded( content );
			});
		};
		
		// Error handler
		var onError_handler = function( data )
		{
			frog.error('Dialog content not loaded by ajax!', data);
		};
		
		// Request
		jQuery.ajax({
			// options
			url: options.url,
			type: 'get',
			dataType: 'html',
			
			// events
			success: onSuccess_handler,
			error: onError_handler
		});
		
		// Show window
		win.show();
	}
	else
	{	
		/*
		// If win already exists and we should't update content - we only refrash win position
		win.animate({
			top: (jQuery(window).height()/2.5 - win.height()/2),
			left: (jQuery(window).width()/2 - win.width()/2)
		}, 500, function(){
			// And focus first input element
			win.find('input:first').focus();
		});
		 */
		//win.show();
		
		win
		.css({
			top: (jQuery(window).height()/2.5 - options.height/2),
			left: (jQuery(window).width()/2 - options.width/2)
		});
			
		// Show window
		win.show();
			
		win
		.find('input[type="text"]:first')
		.focus();
	}
	
	// Return close handler
	return dialog_close_handler;
};



/*
	frogFilters
 */
var frogFilters = {};

// Filters array
frogFilters.filters = [];
frogFilters.switchedOn = {};

// Add new filter
frogFilters.add = function( name, to_editor_callback, to_textarea_callback )
{	
	if( to_editor_callback == undefined || to_textarea_callback == undefined )
	{
		frog.error('System try to add filter without required callbacks.', name, to_editor_callback, to_textarea_callback);
		return;
	}
	
	this.filters.push([ name, to_editor_callback, to_textarea_callback ]);
};

// Switch On filter
frogFilters.switchOn = function( textarea_id, filter )
{
	// Hack for rich text editors like TinyMCE
	jQuery( '#' + textarea_id ).css( 'display', 'block' );
	
	if( this.filters.length > 0 )
	{
		// Switch off previouse editor with textarea_id
		frogFilters.switchOff( textarea_id );
		
		for( var i=0; i<this.filters.length; i++ )
		{
			if( this.filters[i][0] == filter )
			{
				try
				{
					// Call handler that will switch on editor
					this.filters[i][1]( textarea_id );
					
					// Add editor to switchedOn stack
					frogFilters.switchedOn[textarea_id] = this.filters[i];
				}
				catch(e)
				{
				//frog.error('Errors with filter switch on!', e);
				}
				
				break;
			}
		}
	}
};

// Switch Off filter
frogFilters.switchOff = function( textarea_id )
{
	for( var key in frogFilters.switchedOn )
	{
		// if textarea_id param is set we search only one editor and switch off it
		if( textarea_id != undefined && key != textarea_id )
			continue;
		else
			textarea_id = key;
		
		try
		{
			if( frogFilters.switchedOn[key] != undefined && frogFilters.switchedOn[key] != null && typeof(frogFilters.switchedOn[key][2]) == 'function' )
			{
				// Call handler that will switch off editor and showed up simple textarea
				frogFilters.switchedOn[key][2]( textarea_id );
			}
		}
		catch(e)
		{
		//frog.error('Errors with filter switch off!', e);
		}
		
		// Remove editor from switchedOn editors stack
		if( frogFilters.switchedOn[key] != undefined || frogFilters.switchedOn[key] != null )
		{
			frogFilters.switchedOn[key] = null;
		}
	}
};



/* 
	frogPages
	JavaScript object for managing pages tree
 */
var frogPages = {};

frogPages.expandedRows = [];

// Initialize Pages tree
frogPages.init = function()
{	
	// Attach event for expander
	jQuery('.page-expander').click(this.expanderClick);
	jQuery('#page_reorder').click(this.reorderClick);
	jQuery('#page_copy').click(this.copyClick);
	
	// Read coockies
	frogPages.readExpandedCookie();
};

// Save expanded pages ID's when collapse
frogPages.pageCollapse = function( page_id )
{
	this.expandedRows.push( page_id );
	
	//this.expandedRows = jQuery.unique(this.expandedRows);
	
	this.saveExpandedCookie();
}

// Save expanded pages ID's when expand
frogPages.pageExpand = function( page_id )
{
	this.expandedRows = jQuery.grep(this.expandedRows, function(value, i){
		return value != page_id;
	});
	
	//this.expandedRows = jQuery.unique(this.expandedRows);
	
	this.saveExpandedCookie();
}

// Read coockie expanded_rows
frogPages.readExpandedCookie = function()
{
	var matches = document.cookie.match(/expanded_rows=(.+?);/);
	this.expandedRows = matches ? matches[1].split(',') : [];
	
	var arr = [];
	
	for( var i=0; i<this.expandedRows.length; i++ )
	{
		if( this.expandedRows[i] != '' )
			arr[i] = parseInt(this.expandedRows[i]);
	}
	
	this.expandedRows = arr;
};

// Save coockie expanded_rows
frogPages.saveExpandedCookie = function()
{
	document.cookie = "expanded_rows=" + jQuery.unique(this.expandedRows).join(',');
};

// Get page list and return level depth of this list
frogPages.extractPageLevel = function( row )
{
	if( /page-level-(\d+)/i.test( row.attr('class') ) )
		return parseInt( RegExp.$1 );
};

// Get page element ID attribute and parse page_id from it
frogPages.extractPageId = function( row )
{
	if( /page_(\d+)/i.test( row.attr('id') ) )
		return parseInt( RegExp.$1 );
};

// Expander button click event
frogPages.expanderClick = function(){
	var expander = jQuery(this);
	var row = expander.parent().parent().parent();
	
	var page_id = frogPages.extractPageId( row );
	
	// If childrens of row not loaded
	if( row.hasClass('page-children-loaded') == false )
	{
		var page_level = frogPages.extractPageLevel( row.parent() );
		
		var page_loader = row.find('.page-busy').show();
		
		// When information of page reordering updated
		var eventSuccess = function( html )
		{
			row.append( html );
			
			row.find('ul .page-expander').click(frogPages.expanderClick);
			
			expander.addClass('page-expander-collapse');
			row.addClass('page-children-loaded');
			
			frogPages.expandedRows.push( page_id );
			frogPages.saveExpandedCookie();
			
			page_loader.hide();
		};
		
		// When ajax error of updating information about page position
		var eventError = function( html )
		{
			frog.error( 'Ajax: Sub pages not loaded!', html );
			
			page_loader.hide();
		}
		
		// Sending information about page position to frog
		jQuery.ajax({
			// options
			url: '?/page/children/' + page_id + '/' + page_level,
			dataType: 'html',
			
			// events
			success: eventSuccess,
			error: eventError
		});
	}
	else // When childrens of row loaded
	{
		if( row.hasClass('page-children-minimazed') == false )
		{
			expander.removeClass('page-expander-collapse');
			row.addClass('page-children-minimazed');
			frogPages.pageExpand( page_id );
		}
		else
		{
			expander.addClass('page-expander-collapse');
			row.removeClass('page-children-minimazed');
			frogPages.pageCollapse( page_id );
		}
	}
	
	return false;
};

// Reorder button click event
frogPages.reorderClick = function()
{
	if( jQuery('#site_map').hasClass('pages-drag-copy') == true )
	{
		jQuery('#site_map')
		.removeClass('pages-drag-copy')
		.sortable('destroy')
		.draggable('destroy');
			
		jQuery('.page-link-active').removeClass('page-link-active');
	}
	
	if( jQuery('#site_map').hasClass('pages-drag-reorder') == false )
	{
		jQuery(this).addClass('page-link-active');
		
		// When we start draggin
		var dragStart_handler = function( event, ui )
		{
			var ul = ui.helper.parent();
			var parent_li = ul.parent();
			
			if( ul.find('li').length-2 <= 0 )
			{
				parent_li.find('.page-expander:first').hide();
			}
		};
		
		// When draged element appended to container
		var dragOver_handler = function( event, ui )
		{
			var level = frogPages.extractPageLevel( ui.placeholder.parent() );
			ui.helper.find('.page-name:first').css('padding-left', (24 * level) );
			ui.placeholder.css('margin-left', (24 * level));
		};
		
		// When element dropped
		var dragStopped_handler = function( event, ui )
		{
			// For solving Opera position bug (http://bugs.jqueryui.com/ticket/4435)
			ui.item.css({
				'top':'0', 
				'left':'0'
			});
			
			var page = ui.item;
			var page_id = frogPages.extractPageId(ui.item);
			var parent_page = page.parent().parent();
			
			var parent_page_id = (parent_page.attr('id') == false ? 1 : frogPages.extractPageId(parent_page));
			
			var childrens = page.parent().children('li');
			
			var pages = [];
			
			for( var i=0; i<childrens.length; i++ )
			{
				pages.push( frogPages.extractPageId(jQuery(childrens[i])) );
			}
			
			// Show loading screen
			frog.loaderShow();
			
			// Save reordered positons
			jQuery.ajax({
				// options
				type: 'post',
				url: '?/page/reorder/' + parent_page_id,
				data: {
					pages: pages
				},
				
				// events
				success: function() {
					frog.loaderHide();
				},
				error: function() {
					frog.loaderHide();
					frog.error('Position not updated by ajax!');
				}
			});
		};
		
		// Begin sorting
		jQuery('#site_map')
		.addClass('pages-drag-reorder')
		.sortable({
			// options
			axis: 'y',
			items: 'li',
			connectWith: 'ul',
			handle: '.page-handle-reorder',
			placeholder: 'page-placeholder',
			opacity: 0.7,
			forceHelperSize: true,
			//revert: true,
			grid: [5, 8],
				
			// events
			start: dragStart_handler,
			over: dragOver_handler,				
			stop: dragStopped_handler
		});
	}
	else // Toggle if already switched on
	{
		jQuery('#site_map')
		.removeClass('pages-drag-reorder')
		.sortable('destroy');
			
		jQuery(this).removeClass('page-link-active');
	}
	
	return false;
};

// Coppy button click event
frogPages.copyClick = function()
{
	if( jQuery('#site_map').hasClass('pages-drag-reorder') == true )
	{
		jQuery('#site_map')
		.removeClass('pages-drag-reorder')
		.sortable('destroy');
			
		jQuery('.page-link-active').removeClass('page-link-active');
	}

	if( jQuery('#site_map').hasClass('pages-drag-copy') == false )
	{
		jQuery(this).addClass('page-link-active');
	
		// When draged element appended to container
		var dragOver_handler = function( event, ui )
		{
			var level = frogPages.extractPageLevel( ui.placeholder.parent() );
			ui.helper.find('.page-name:first').css('padding-left', (24 * level) );
			ui.placeholder.css('margin-left', (24 * level));
		};
		
		// When element dropped
		var dragStopped_handler = function( event, ui )
		{
			// For solving Opera position bug (http://bugs.jqueryui.com/ticket/4435)
			ui.item.css({
				'top':'0', 
				'left':'0'
			});
			
			var page = ui.item;
			var page_id = frogPages.extractPageId(ui.item);
			var parent_page = page.parent().parent();
			
			var parent_page_id = (parent_page.attr('id') == false ? 1 : frogPages.extractPageId(parent_page));
			
			var childrens = page.parent().children('li');
			
			var pages = [];
			
			for( var i=0; i<childrens.length; i++ )
			{
				var children_id = frogPages.extractPageId(jQuery(childrens[i]));
				
				//strange bugfix. If children_id is wrong !maybe! this children is current copied page. Maybe...
				children_id = (children_id == undefined ? page_id : children_id);
				
				pages.push( children_id );
			}
			
			// Show loading screen
			frog.loaderShow();
			
			// Save copy
			jQuery.ajax({
				// options
				type: 'post',
				url: '?/page/copy/' + parent_page_id,
				data: {
					dragged_id: page_id,
					pages: pages
				},
				dataType: 'json',
				
				// events
				success: function( data ) {
					
					page.attr('id', 'page_' + data.new_root_id );
					page.find('.page-name:first a:first').append(' (copy)');
					page.find('.page-add:first').attr('href', '?/page/add/' + data.new_root_id);
					page.find('.page-remove:first').attr('href', '?/page/delete/' + data.new_root_id);
					
					frog.loaderHide();
				},
				error: function() {
					frog.loaderHide();
					frog.error('Position not updated by ajax!');
				}
			});
		};
		
		// Begin draggin
		jQuery('#site_map')
		.addClass('pages-drag-copy')
		.sortable({
			// options
			axis: 'y',
			items: 'li',
			connectWith: 'ul',
			handle: '.page-handle-copy',
			placeholder: 'page-placeholder',
			opacity: 0.7,
			forceHelperSize: true,
			//helper: 'clone',
			//revert: true,
			grid: [5, 8],
				
			// events
			over: dragOver_handler,
			beforeStop: dragStopped_handler
		})
		.find('li')
		.draggable({
			// options
			axis: 'y',
			items: 'li',
			connectToSortable: '#site_map',
			handle: '.page-handle-copy',
			placeholder: 'page-placeholder',
			opacity: 0.7,
			forceHelperSize: true,
			helper: 'clone',
			//revert: true,
			grid: [5, 8]
		});
	}
	else // Toggle if already switched on
	{
		jQuery('#site_map')
		.removeClass('pages-drag-copy')
		.sortable('destroy')
		.draggable('destroy');
			
		jQuery(this).removeClass('page-link-active');
	}
	
	return false;
};

// select page link dialog
frogPages.dialog = function()
{
	var pagesClose_handler = frog.dialog({
		// options
		url: '?/page/link_dialog/',
		modal: true,
		alwaysNew: false,
		width: 280,
		height: 200,
		
		// events
		loaded: function( content ){
			
		}
	});
};



/*
	frogPageEdit
 */
var frogPageEdit = {};

frogPageEdit.formChanged = false;
frogPageEdit.commitButton = false;

// Initializing frog page
frogPageEdit.init = function()
{
	/*
		Page options
	 */
	var $more = jQuery('#page_more');
	frogPageEdit.more_height = $more.height();
	$more.hide();
	
	jQuery('#page_more_button a').click( this.moreClick );
	
	jQuery('#page_edit_addtab').click( this.addTabClick );
	
	// When form will be submited we should switch off all filters
	jQuery('#page_edit_form').submit(function(){
		
		frogFilters.switchOff();
		var $breadcrumbs = jQuery('#page_breadcrumb');

		if( $breadcrumbs.val() == '' )
		{
			$breadcrumbs.val( jQuery('#page_edit_title_input').val() );
		}
	});
	
	if( jQuery('#page_edit_title_input').val() != '' )
		frogPageEdit.titleIsEmpty = false;
	
	jQuery('#page_edit_title_input')
	.keyup(this.titleKeyup)
	.focus();
	
	
	
	/*
		Page parts
	 */
/*	var tabs = [];
	
	jQuery('#page_edit_items .page-edit-item')
	//.hide()
	.each(function(){
		var $this = jQuery(this);
		var part_id = $this.attr('id').replace('page_edit_', '');
		var part_name = $this.attr('title').toString();
		
		tabs.push( [part_id, part_name] );
	})
	.attr('title', '')
	.first()
	.addClass('page-edit-pactive');
	
	var $tabs = jQuery('#page_edit_tabs');
	
	for( var i=0; i<tabs.length; i++ )
	{
		this.addTab( tabs[i][0], tabs[i][1] );
	}
	
	$tabs
	.find('.page-edit-tab:first')
	.addClass('page-edit-tactive');
	
	*/
	// Parts filter select
	jQuery('.page-part-filter').change(function(){
		var textarea_id = jQuery(this).attr('id').replace('_filter_id', '_content');
		
		frogFilters.switchOn( textarea_id, jQuery(this).val() );
	});
	
	
	
	/*
		published_on Calendar
	 */
	jQuery('#page_published_on').datepicker({
		// options
		dateFormat: 'yy-mm-dd',
		
		// events
		onSelect: function( dateText, inst )
		{
			inst.input.val( dateText +' 00:00:00' );
		}
	});
	
	
	
	jQuery('#page_edit_commit').click(function(){
		frogPageEdit.commitButton = true;
	});
	
	
	
	/*
		Page from submiting
	 */
	jQuery('#page_edit_form')
	.change(function(){
		frogPageEdit.formChanged = true;
	});
    
	/*
		.submit(function(){
			frogPageEdit.formChanged = false;
			
			// Success handler
			var formSuccess_handler = function( data )
			{
				if( data == 'error' )
				{
					alert(frog.__('Document not saved!'));
					
					frog.loaderHide();
				}
				else
				{
					//location.href = data;
				}
			};
			
			// Error handler
			var formError_handler = function( data )
			{
				alert(frog.__('Error with internet connection. Try again!'));
			};
			
			frog.loaderShow();
			
			var extraData = {};
			
			if( frogPageEdit.commitButton === true )
				extraData['commit'] = 'true';

			// Request
			jQuery(this).ajaxSubmit({
				data: extraData,
			
				// events
				success: formSuccess_handler,
				error: formError_handler
			});
			
			return false;
		});
	 */
	
	jQuery('#page_edit_cancel').click(function(){
		frogPageEdit.formChanged = false;
	});
	
	window.onbeforeunload = function( event )
	{
		if( frogPageEdit.formChanged == true )
		{
			event = event || window.event;
			
			if( jQuery.browser.ie )
				event.returnValue = frog.__('You have changed this form. Discard changes?');
			else
				return frog.__('You have changed this form. Discard changes?');
		}
	};
};

frogPageEdit.titleIsEmpty = true;

// When you input page title
frogPageEdit.titleKeyup = function()
{
	if( frogPageEdit.titleIsEmpty )
		jQuery('#page_slug').val( frog.toSlug( jQuery(this).val() ) );
};

// "More options" button click event
frogPageEdit.moreClick = function()
{
	$more = jQuery('#page_more');
	$more_button = jQuery('#page_more_button');

	if( $more.css('display') == 'none' )
	{		
		/*if( jQuery.browser.opera )
		{
			$more.show();
			
			$more.find('.input-text:first').focus();
		}
		else
		{*/
		$more
		.css({
			height:0, 
			display: 'block', 
			overflow: 'hidden'
		})
		.animate({
			height: frogPageEdit.more_height
		}, 500, function(){
			$more.find('.input-text:first').focus();
		});
		//}
			
		$more_button.addClass('page-mbutton-collapse');
	}
	else
	{
		/*if( jQuery.browser.opera )
		{
			$more.hide();
		}
		else
		{*/
		$more
		.animate({
			height: 0
		}, 500, function(){ 
			$more.css('display', 'none'); 
		});
		//}
			
		$more_button.removeClass('page-mbutton-collapse');
	}
	
	return false;
};

// Add new part tab
frogPageEdit.addTab = function( index, name )
{
	var $tabs = jQuery('#page_edit_tabs');
	
	$tabs
	.append( '<div class="page-edit-tab" id="page_edit_tab_'+ index +'"><span>'+ name +'</span> '+ (USER_IS_ADMINISTRATOR || USER_IS_DEVELOPER ? '<img src="images/icon-close.png" class="page-edit-tclose" alt="" title="'+ frog.__('Remove page part') +'" />' : '') +'</div>' )
	.find('#page_edit_tab_'+ index)
	.click(function(){
		var part_id = jQuery(this).attr('id').replace('page_edit_tab_', '');
			
		jQuery('#page_edit_items .page-edit-item').removeClass('page-edit-pactive');
		$tabs.find('.page-edit-tab').removeClass('page-edit-tactive');
			
		jQuery('#page_edit_' + part_id).addClass('page-edit-pactive');
		jQuery(this).addClass('page-edit-tactive');
			
		return false;
	})
	.find('.page-edit-tclose')
	.click(function(){
		if( confirm( frog.__('Are you sure?') ) )
		{
			var part_index = parseInt( jQuery(this).parent().attr('id').replace('page_edit_tab_', '') );
				
			jQuery('#page_edit_tab_'+ index).remove();
			jQuery('#page_edit_'+ index).remove();
				
			$tabs
			.find('.page-edit-tab:last')
			.addClass('page-edit-tactive');
				
			jQuery('#page_edit_items .page-edit-item:last')
			.addClass('page-edit-pactive');
		}
			
		return false;
	});
};

// Add new content tab
frogPageEdit.addTabClick = function(layout_id)
{
	// Create dialog win and catch close handler
	var newtabClose_handler = frog.dialog({
		// options
		url: '?/page/newtab_dialog',
		modal: true,
		alwaysNew: false,
		width: 280,
		height: 150,
		
		// events
		loaded: function( content ){
			var nameInp = content.find('#newtab_name');
			
			// Add events for win content elements
			content.find('#newtab_form').submit(function(){
				var name = nameInp.val().replace(/[^a-z0-9а-я\-_ ]/ig, '');
				
				// Check name field value
				if( name == '' )
				{
					alert( frog.__('Part name can\'t be empty!') );
				}
				else
				{
					// Get last item ID
					var lastPartIndex = parseInt( jQuery('#page_edit_items .page-edit-item:last').attr('id').replace('page_edit_', '') );
					
					// Success handler
					var pagePartLoaded_handler = function( part_source )
					{
						frogPageEdit.addTab( (lastPartIndex + 1), name );
						
						// Append new tab and attach event to filters <select>
						jQuery('#page_edit_items')
						.append( part_source )
						.find('.page-part-filter').change(function(){ // Parts filter select
							var textarea_id = jQuery(this).attr('id').replace('_filter_id', '_content');
								
							frogFilters.switchOn( textarea_id, jQuery(this).val() );
						});
						
						// Clear win input value and hide loader
						nameInp.val('');
						frog.loaderHide();
					};
					
					// Error handler
					var pagePartError_handler = function()
					{
						frog.error('Part not loaded!');
						frog.loaderHide();
					};
					
					// Close dialog
					newtabClose_handler();
					
					// Show loading screen
					frog.loaderShow();	
					
					// Get part source code
					jQuery.ajax({
						// options
						type: 'post',
						url: '?/page/addPart',
						data: {
							name: name,
							index: (lastPartIndex + 1)
						},
						dataType: 'html',
						
						// events 
						success: pagePartLoaded_handler,
						error: pagePartError_handler
					});
				}
				
				return false;
			});
			
			// Add close link event
			content.find('#newtab_cancel').click(newtabClose_handler);
		}
	});
	
	return false;
};
var frogLayoutEdit = {};
frogLayoutEdit.addPartClick = function(layout_id)
{			

	// Create dialog win and catch close handler
	var newtabClose_handler = frog.dialog({
		// options
		url: '?/layout_part/add_dialog/'+layout_id,
		modal: true,
		alwaysNew: false,
		width: 280,
		height: 250,
		
		// events
		loaded: function( content ){
			
			// Add events for win content elements
			content.find('#newpart_form_layout_'+layout_id).submit(function(){
				
			
				// Success handler
				var pagePartLoaded_handler = function( content )
				{
					$('#layout_parts')
					.append('<tr id="part_'+ content.id +'"><td>'+ content.title +'</td><td>'+ content.name +'</td><td>'+ content.type +
						'</td><td><a href="#" onclick="frogLayoutEdit.editPartClick('+ content.id +');return false;">Edit</a></td>'+
						'<td><a href="#" onclick="frogLayoutEdit.deletePartClick('+ content.id +', \''+ content.title +'\');return false;">Delete</a></td></tr>')
					frog.loaderHide();
				};
					
				// Error handler
				var pagePartError_handler = function()
				{
					frog.error('Part not added!');
					frog.loaderHide();
				};
					
				// Close dialog
				newtabClose_handler();
					
				// Show loading screen
				frog.loaderShow();	

				// Get part source code
				$.ajax({
					// options
					type: 'post',
					url: '?/layout_part/add/'+layout_id,
					dataType: 'json',
					data: $('#newpart_form_layout_'+layout_id).serialize(),
					// events 
					success: pagePartLoaded_handler,
					error: pagePartError_handler
				});
				
				
				return false;
			});
			
			// Add close link event
			content.find('#newtab_cancel').click(newtabClose_handler);
		}
	});
	
	return false;
};

frogLayoutEdit.deletePartClick = function(id, title)
{
	if(confirm(frog.__('Вы уверены, что хотите удалить '+title+'?')))

	{
		$.ajax({
			url: '?/layout_part/delete/' + id,
			dataType: 'json',
					
			success: function( content )
			{
				if( content != 'false' )
				{
					$('#part_'+ id).remove();
				}
				else
				{
					frog.error('Part not deleted.');
				}
			},
					
			error: function()
			{
				frog.error('Error when trying to delete part.');
			}
		});
	}
};

frogLayoutEdit.editPartClick = function(id)
{			

	// Create dialog win and catch close handler
	var newtabClose_handler = frog.dialog({
		// options
		url: '?/layout_part/edit_dialog/'+id,
		modal: true,
		alwaysNew: false,
		width: 280,
		height: 250,
		
		// events
		loaded: function( content ){
			
			// Add events for win content elements
			content.find('#newpart_form_'+id).submit(function(){
				
				// Success handler
				var pagePartLoaded_handler = function( content )
				{
					$('#part_'+ id)
					.before('<tr id="part_'+ content.id +'"><td>'+ content.title +'</td><td>'+ content.name +'</td><td>'+ content.type +
						'</td><td><a href="#" onclick="frogLayoutEdit.editPartClick('+ content.id +');return false;">Edit</a></td>'+
						'<td><a href="#" onclick="frogLayoutEdit.deletePartClick('+ content.id +', \''+ content.title +'\');return false;">Delete</a></td></tr>')
					.remove()
					frog.loaderHide();
				};
					
				// Error handler
				var pagePartError_handler = function()
				{
					frog.error('Part not edited!');
					frog.loaderHide();
				};
					
				// Close dialog
				newtabClose_handler();
					
				// Show loading screen
				frog.loaderShow();	
				
				// Get part source code
				$.ajax({
					// options
					type: 'post',
					url: '?/layout_part/edit/'+id,
					dataType: 'json',
					data: $('#newpart_form_'+id).serialize(),
					// events 
					success: pagePartLoaded_handler,
					error: pagePartError_handler
				});
				 				
				
				return false;
			});
			
			// Add close link event
			content.find('#newtab_cancel').click(newtabClose_handler);
		}
	});
	
	return false;
};



/*
	frogPlugins
 */
frogPlugins = {};

// Init plugins
frogPlugins.init = function()
{
	jQuery('#plugins .plugin-enabled-checkbox').change(function(){

		var plugin_id = jQuery(this).val();
		var action = (jQuery(this).attr('checked') ? 'activate' : 'deactivate');
	
		// When plugin request is successful
		var pluginRequestSuccess_handler = function()
		{
			if( action == 'activate' )
			{
				jQuery('#plugin_' + plugin_id).addClass('plugin-active');
			}
			else
			{
				jQuery('#plugin_' + plugin_id).removeClass('plugin-active');
			}
			
			frog.loaderHide();
			
			frog.messageShow('success', frog.__('Plugin '+ (action == 'activate' ? 'activated' : 'deactivated') +' successfully, but you should refrash this page.'));
		};
		
		// When plugin request return error
		var pluginRequestError_handler = function()
		{
			frog.error('Error with plugin request...');
			frog.loaderHide();
		};
	
		var requestUrl = '?/setting/' + action + '_plugin/' + jQuery(this).val();
		
		// Show loading screen
		frog.loaderShow();
		
		// Plugin request
		jQuery.ajax({
			// options
			type: 'get',
			url: requestUrl,
			
			// events
			success: pluginRequestSuccess_handler,
			error: pluginRequestError_handler
		});
	});
};



/*
	When DOM ready
 */
jQuery(document).ready(function(){
	/*
		Global init
	 */
	frog.init();
	
	
	/*
		Global init for specific pages
	 */
	switch( jQuery('body').attr('id') )
	{
		// Page -> index
		case 'body_page_index':
			frogPages.init();
			break;
		
		
		// Page -> add, edit
		case 'body_page_add':
		case 'body_page_edit':
			frogPageEdit.init();
			break;
		
		
		// Snippet -> add, edit
		case 'body_snippet_add':
		case 'body_snippet_edit':
			// Parts filter select
			jQuery('#snippet_filter_id').change(function(){
				frogFilters.switchOn( 'snippet_content', jQuery(this).val() );
			});
			
			// When form will be submited we should switch off all filters
			jQuery('#snippet_edit_form').submit(function(){
				frogFilters.switchOff();
			});
			
			// Focus first form element
			jQuery('#snippet_name').focus();
			break;
			
		
		// Layout -> add, edit
		case 'body_layout_add':
		case 'body_layout_edit':
			// When form will be submited we should switch off all filters
			jQuery('#layout_edit_form').submit(function(){
				frogFilters.switchOff();
			});
		
			jQuery('#layout_name').focus();
			break;
			
			
		// User -> edit
		case 'body_user_edit':
			// Focus first form element
			jQuery('#user_name').focus();
			break;
			
		
		// Setting -> index
		case 'body_setting_index':
			// Focus first form element
			jQuery('#setting_admin_title').focus();
			break;
		
		
		// Setting -> plugin	
		case 'body_setting_plugin':
			frogPlugins.init();
			break;
	}
}); // end