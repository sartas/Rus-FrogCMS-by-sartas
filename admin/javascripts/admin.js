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
	$('body:first').append('<div id="overlay"></div>');
	
	
	/*
		Loader
	 */
	$('body:first').append('<div id="loader"><span>'+ frog.__('Loading') +'</span></div>');
	frog.messageInit();

	
/*
		Animate content message
	 */
//this.animateMessage();
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
	//alert( msg + (console !== undefined ? ' (more information in console)' : '') );
	frog.messageShow('error', msg);

	if( console !== undefined )
		console.log( arguments );
};

// Show Frog success message
frog.success = function( text )
{
	frog.messageShow('success',text);
};

// Detect success or error message received from server
frog.json_message = function( obj )
{
	if(obj.success !== undefined){
		frog.success(obj.success);
		return 'success';
	}
	
	if(obj.error !== undefined){
		frog.error(obj.error);		
		return 'error';
	}
};

frog.json_redirect = function( obj )
{
	if(obj.redirect !== undefined){
		window.location.href = obj.redirect;
	}
};


// Show overlay
frog.overlayShow = function( with_animation )
{
	$('body')
	.css({
		overflow: 'hidden',
		width: '100%',
		height: '100%'
	});
		
	$overlay = $('#overlay');
	
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
	$('body')
	.css({
		overflow: 'auto',
		width: 'auto',
		height: 'auto'
	});
		
	$('#overlay').hide();
};

// Show loading screen
frog.loaderShow = function()
{
	this.overlayShow();
	$('#loader').show();
};

// Hise loading screen
frog.loaderHide = function()
{
	this.overlayHide();
	$('#loader').hide();
};

frog.message_now = false;
frog.message = null;
frog.messageInit = function(){
	if( document.getElementById( 'frog-message' ) == undefined )
	{
		$('#content').prepend('<div id="frog-message"></div>');
		frog.message = $('#frog-message');
	}
	else
	{
		frog.message = $('#frog-message');
		frog.messageAnimate();
	}
}

frog.messageHide = function(){
	if(frog.message_now == true)
	{
		frog.message.animate({
			height: 0
		}, 500);
		
		clearTimeout(frog.messageTimer);
	}
	
	frog.message_now = false;
}

frog.messageAnimate = function(){
	var m_height = 40;
	frog.message
	.css({
		height: 0
	})
	.animate({
		height: m_height
	}, 500, function(){
		frog.messageTimer = setTimeout(frog.messageHide, 10000);
	})
	.mouseover(function(){
		frog.messageHide();
	});
	
	frog.message_now = true;
}
frog.messageShow = function(id, text){
	var timout = 0;
	if(frog.message_now == true){
		frog.messageHide();
		timout = 500;
	}
	
	setTimeout(function(){
		frog.message.html(text).removeClass().addClass( id );
		frog.messageAnimate();
	}, timout);
}




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
		win = $('<div class="frog-dialog frog-d-loader"><div class="frog-d-content"></div><a href="javascript:void(0);" class="frog-d-close"><!--x--></a></div>');
		
		// append win to body
		$('body:first').append(win);
		
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
	

	
	// find content div
	var content = win.find('.frog-d-content:first');
	

	
	// load content
	if( content.html() == '' || options.alwaysNew == true )
	{
		// Refrash win position
		win.css({
			top: $(window).height()/2 - (content.height())/2, 
			left: ($(window).width() / 2)-25
		});
		
		// Success handler
		var onSuccess_handler = function( data )
		{
			// Remove loader bg
			win.removeClass('frog-d-loader');
			
			if( options.className != undefined )
				win.addClass( options.className );
			
			// Set window content
			content
			//.height( options.height )
			.html( data )
			.find('input[type="text"]:first')
			.focus();
			// Refrash win position
			//	win.css({
			//		top: $(window).height()/2.5 - (content.height() + win.height())/2, 
			//		left: ($(window).width() / 2)-25
			//	});	
			// Resize window
			win.animate({
				top: ($(window).height()/2 - (content.height())/2),
				left: ($(window).width()/2 - options.width/2),
				width: options.width,
				height: content.height()
			}, 500, function(){
				// Show win close button
				win
				.find('.frog-d-close')
				.show();
				

				
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
		$.ajax({
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
			top: ($(window).height()/2.5 - win.height()/2),
			left: ($(window).width()/2 - win.width()/2)
		}, 500, function(){
			// And focus first input element
			win.find('input:first').focus();
		});
		 */
		//win.show();
		//		
		//		win
		//		.css({
		//			top: ($(window).height()/2 - (content.height())/2), 
		//			left: ($(window).width()/2 - options.width/2)
		//		});
			
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
	$( '#' + textarea_id ).css( 'display', 'block' );
	
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
	$('.page-expander').click(this.expanderClick);
	$('.page-remove').click(this.removeClick);
	$('.page-add').click(this.addClick);
	$('#page_reorder').click(this.reorderClick);
	$('#page_copy').click(this.copyClick);
	
	// Read coockies
	frogPages.readExpandedCookie();
};

frogPages.removeClick = function()
{
	if(confirm($(this).attr('rel')) == false)
		return false;
			
	var row =  $(this).parent().parent().parent();
	var page_id = frogPages.extractPageId( row );
	
	var eventSuccess = function( data )
	{
		if(frog.json_message(data) != 'success')
			return false;

		row.animate({
			height: 0
		}, 500, function(){
			var parent = row.parent();
						
			$(this).remove();
						
			if( parent.find('li').length == 0 )
			{
				parent.parent().find('.page-expander:first').hide();
			}
		});
	};

	var eventError = function( data )
	{
		frog.json_message(data);
	};
		
	// Sending information
	$.ajax({
		// options
		url: '?/page/delete/' + page_id,
		dataType: 'json',
			
		// events
		success: eventSuccess,
		error: eventError
	});

	
	return false;
}

frogPages.addClick = function()
{
	var row =  $(this).parent().parent().parent();
	var page_id = frogPages.extractPageId( row );
	
	frog.dialog({
		// options
		url: '?/page/select_type/' + page_id,
		modal: true,
		alwaysNew: false,
		width: 280,

		
		// events
		loaded: function( content ){
		//alert(content)
		}
	});
	
	return false;
}

// Save expanded pages ID's when collapse
frogPages.pageCollapse = function( page_id )
{
	this.expandedRows.push( page_id );
	
	//this.expandedRows = $.unique(this.expandedRows);
	
	this.saveExpandedCookie();
}

// Save expanded pages ID's when expand
frogPages.pageExpand = function( page_id )
{
	this.expandedRows = $.grep(this.expandedRows, function(value, i){
		return value != page_id;
	});
	
	//this.expandedRows = $.unique(this.expandedRows);
	
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
	document.cookie = "expanded_rows=" + $.unique(this.expandedRows).join(',');
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
	var expander = $(this);
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
			row.find('.page-add').click(frogPages.addClick);

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
		$.ajax({
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
	if( $('#site_map').hasClass('pages-drag-copy') == true )
	{
		$('#site_map')
		.removeClass('pages-drag-copy')
		.sortable('destroy')
		.draggable('destroy');
			
		$('.page-link-active').removeClass('page-link-active');
	}
	
	if( $('#site_map').hasClass('pages-drag-reorder') == false )
	{
		$(this).addClass('page-link-active');
		
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
			// For solving Opera position bug (http://bugs.$ui.com/ticket/4435)
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
				pages.push( frogPages.extractPageId($(childrens[i])) );
			}
			
			// Show loading screen
			frog.loaderShow();
			
			// Save reordered positons
			$.ajax({
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
		$('#site_map')
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
		$('#site_map')
		.removeClass('pages-drag-reorder')
		.sortable('destroy');
			
		$(this).removeClass('page-link-active');
	}
	
	return false;
};

// Coppy button click event
frogPages.copyClick = function()
{
	if( $('#site_map').hasClass('pages-drag-reorder') == true )
	{
		$('#site_map')
		.removeClass('pages-drag-reorder')
		.sortable('destroy');
			
		$('.page-link-active').removeClass('page-link-active');
	}

	if( $('#site_map').hasClass('pages-drag-copy') == false )
	{
		$(this).addClass('page-link-active');
	
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
			// For solving Opera position bug (http://bugs.$ui.com/ticket/4435)
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
				var children_id = frogPages.extractPageId($(childrens[i]));
				
				//strange bugfix. If children_id is wrong !maybe! this children is current copied page. Maybe...
				children_id = (children_id == undefined ? page_id : children_id);
				
				pages.push( children_id );
			}
			
			// Show loading screen
			frog.loaderShow();
			
			// Save copy
			$.ajax({
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
					if(frog.json_message(data)=='success'){
						page.attr('id', 'page_' + data.new_root_id );
						page.find('.page-name:first a:first').attr('href', '?/page/edit/' + data.new_root_id);
						page.find('.page-name:first a:first').append(' (copy)');
						page.find('.page-add:first').attr('href', '?/page/add/' + data.new_root_id);
						page.find('.page-remove:first').attr('href', '?/page/delete/' + data.new_root_id);
					}
					else{
						page.remove();						
					}

					frog.loaderHide();

				},
				error: function() {
					frog.loaderHide();
					frog.error('Position not updated by ajax!');
				}
			});
		};
		
		// Begin draggin
		$('#site_map')
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
		$('#site_map')
		.removeClass('pages-drag-copy')
		.sortable('destroy')
		.draggable('destroy');
			
		$(this).removeClass('page-link-active');
	}
	
	return false;
};
/*
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
*/


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
	var $more = $('#page_more');
	frogPageEdit.more_height = $more.height();
	$more.hide();
	
	$('#page_more_button a').click( this.moreClick );
	
	
	// When form will be submited we should switch off all filters
	$('#page_edit_form').submit(function(event){
		
		if(typeof(tinyMCE) != "undefined"){
			tinyMCE.triggerSave(true, true);
		}
		
		//	frogFilters.switchOff();
		var $breadcrumbs = $('#page_breadcrumb');

		if( $breadcrumbs.val() == '' )
		{
			$breadcrumbs.val( $('#page_edit_title_input').val() );
		}
		

	/* stop form from submitting normally */
	//event.preventDefault(); 
        
	//		/* get some values from elements on the page: */
	//		var $form = $( this ),
	//		url = $form.attr( 'action' );



		
	//		/* Send the data using post and put the results in a div */
	//		$.post( url, $form.serialize(),
	//			function( data ) {
	//				frog.json_message(data);
	//				frog.json_redirect(data);
	//			//		frogFilters.switchOn();
	//			}, 'json'
	//			);
	});
	$('#page_edit_form').ajaxForm({
		dataType:  'json',
		//		beforeSubmit: function(){
		//			return frogPageEdit.formChanged;
		//		},
		success: function(data) {
			frog.json_message(data);
			frog.json_redirect(data);
		}
	});
	
	$('#page_edit_title_input')
	.keyup(this.titleKeyup)
	.focus();
	
	
	
	/*
		Page parts
	 */
	/*	var tabs = [];
	
	$('#page_edit_items .page-edit-item')
	//.hide()
	.each(function(){
		var $this = $(this);
		var part_id = $this.attr('id').replace('page_edit_', '');
		var part_name = $this.attr('title').toString();
		
		tabs.push( [part_id, part_name] );
	})
	.attr('title', '')
	.first()
	.addClass('page-edit-pactive');
	
	var $tabs = $('#page_edit_tabs');
	
	for( var i=0; i<tabs.length; i++ )
	{
		this.addTab( tabs[i][0], tabs[i][1] );
	}
	
	$tabs
	.find('.page-edit-tab:first')
	.addClass('page-edit-tactive');
	
	*/
	// Parts filter select
	$('.page-part-filter').change(function(){
		var textarea_id = $(this).attr('id').replace('_filter_id', '_content');
		
		frogFilters.switchOn( textarea_id, $(this).val() );
	});
	
	
	
	/*
		published_on Calendar
	 */
	$('#page_published_on').datepicker({
		// options
		dateFormat: 'yy-mm-dd',
		
		// events
		onSelect: function( dateText, inst )
		{
			inst.input.val( dateText +' 00:00:00' );
		}
	});
	
	
	/*
	$('#page_edit_commit').click(function(){
		frogPageEdit.commitButton = true;
	});
	*/
	
	
	/*
		Page from submiting
	 */
	
	//	$("#page_edit_form").submit(function(event) {
	//
	//		/* stop form from submitting normally */
	//		event.preventDefault(); 
	//        
	//		/* get some values from elements on the page: */
	//		var $form = $( this ),
	//		url = $form.attr( 'action' );
	//
	//		/* Send the data using post and put the results in a div */
	//		$.post( url, $form.serialize(),
	//			function( data ) {
	//				frog.json_message(data);
	//				frog.json_redirect(data);
	//			}, 'json'
	//			);
	//	});
	//
	/*	$('#page_edit_continue').click(function(){
		$.post($("#page_edit_form").attr( 'action' ), $("#page_edit_form").serialize(),
	function(data) {
				frog.json_message(data);
				frog.json_redirect(data);
			});

		$('#page_edit_form').ajaxForm({
			dataType:  'json',
			//		beforeSubmit: function(){
			//			return frogPageEdit.formChanged;
			//		},
			success: function(data) {
				frog.json_message(data);
				frog.json_redirect(data);
			}
		});
	});

*/
	$('#page_edit_cancel').click(function(){
		frogPageEdit.formChanged = false;
	});
/*
	window.onbeforeunload = function( event )
	{
		if( frogPageEdit.formChanged == true )
		{
			event = event || window.event;
			
			if( $.browser.ie )
				event.returnValue = frog.__('You have changed this form. Discard changes?');
			else
				return frog.__('You have changed this form. Discard changes?');
		}
	};*/
};

// "More options" button click event
frogPageEdit.moreClick = function()
{
	$more = $('#page_more');
	$more_button = $('#page_more_button');

	if( $more.css('display') == 'none' )
	{		
		/*if( $.browser.opera )
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
		/*if( $.browser.opera )
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
/*
// Add new part tab
frogPageEdit.addTab = function( index, name )
{
	var $tabs = $('#page_edit_tabs');
	
	$tabs
	.append( '<div class="page-edit-tab" id="page_edit_tab_'+ index +'"><span>'+ name +'</span> '+ (USER_IS_ADMINISTRATOR || USER_IS_DEVELOPER ? '<img src="images/icon-close.png" class="page-edit-tclose" alt="" title="'+ frog.__('Remove page part') +'" />' : '') +'</div>' )
	.find('#page_edit_tab_'+ index)
	.click(function(){
		var part_id = $(this).attr('id').replace('page_edit_tab_', '');
			
		$('#page_edit_items .page-edit-item').removeClass('page-edit-pactive');
		$tabs.find('.page-edit-tab').removeClass('page-edit-tactive');
			
		$('#page_edit_' + part_id).addClass('page-edit-pactive');
		$(this).addClass('page-edit-tactive');
			
		return false;
	})
	.find('.page-edit-tclose')
	.click(function(){
		if( confirm( frog.__('Are you sure?') ) )
		{
			var part_index = parseInt( $(this).parent().attr('id').replace('page_edit_tab_', '') );
				
			$('#page_edit_tab_'+ index).remove();
			$('#page_edit_'+ index).remove();
				
			$tabs
			.find('.page-edit-tab:last')
			.addClass('page-edit-tactive');
				
			$('#page_edit_items .page-edit-item:last')
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
					var lastPartIndex = parseInt( $('#page_edit_items .page-edit-item:last').attr('id').replace('page_edit_', '') );
					
					// Success handler
					var pagePartLoaded_handler = function( part_source )
					{
						frogPageEdit.addTab( (lastPartIndex + 1), name );
						
						// Append new tab and attach event to filters <select>
						$('#page_edit_items')
						.append( part_source )
						.find('.page-part-filter').change(function(){ // Parts filter select
							var textarea_id = $(this).attr('id').replace('_filter_id', '_content');
								
							frogFilters.switchOn( textarea_id, $(this).val() );
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
					$.ajax({
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
};*/

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
	$('#plugins .plugin-enabled-checkbox').change(function(){

		var plugin_id = $(this).val();
		var action = ($(this).attr('checked') ? 'activate' : 'deactivate');
	
		// When plugin request is successful
		var pluginRequestSuccess_handler = function()
		{
			if( action == 'activate' )
			{
				$('#plugin_' + plugin_id).addClass('plugin-active');
			}
			else
			{
				$('#plugin_' + plugin_id).removeClass('plugin-active');
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
	
		var requestUrl = '?/setting/' + action + '_plugin/' + $(this).val();
		
		// Show loading screen
		frog.loaderShow();
		
		// Plugin request
		$.ajax({
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
$(document).ready(function(){
	/*
		Global init
	 */
	frog.init();

	/*
		Global init for specific pages
	 */
	switch( $('body').attr('id') )
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
			$('#snippet_filter_id').change(function(){
				frogFilters.switchOn( 'snippet_content', $(this).val() );
			});
			
			// When form will be submited we should switch off all filters
			$('#snippet_edit_form').submit(function(){
				frogFilters.switchOff();
			});
			
			// Focus first form element
			$('#snippet_name').focus();
			break;
			
		
		// Layout -> add, edit
		case 'body_layout_add':
		case 'body_layout_edit':
			// When form will be submited we should switch off all filters
			$('#layout_edit_form').submit(function(){
				frogFilters.switchOff();
			});
		
			$('#layout_name').focus();
			break;
			
			
		// User -> edit
		case 'body_user_edit':
			// Focus first form element
			$('#user_name').focus();
			break;
			
		
		// Setting -> index
		case 'body_setting_index':
			// Focus first form element
			$('#setting_admin_title').focus();
			break;
		
		
		// Setting -> plugin	
		case 'body_setting_plugin':
			frogPlugins.init();
			break;
	}
}); // end
