/*
	Frog locale
*/
window.__locale.push({
	'Loading'            : 'Загрузка',
	'Remove page part'   : 'Удалить часть страницы',
	'Are you sure?'      : 'Вы уверены?',
	
	'Plugin activated successfully, but you should refrash this page.'
	                     : 'Плагин успешно активирован &mdash; обновите страницу.',
						 
	'Plugin deactivated successfully, but you should refrash this page.'
	                     : 'Плагин успешно деактивирован &mdash; обновите страницу.',
						 
	'You have changed this form. Discard changes?'
	                     : 'Вы изменили эту форму. Отменить изменения?'
});



/*
	When DOM is loaded
*/
jQuery(function($){
	/*
		Datapicker locale
		Russian (UTF-8) initialisation for the jQuery UI date picker plugin.
		Written by Andrew Stromnov (stromnov@gmail.com).
	*/
	$.datepicker.regional['ru'] = {
		closeText: 'Закрыть',
		prevText: '&#x3c;Пред',
		nextText: 'След&#x3e;',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
		'Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		weekHeader: 'Не',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});