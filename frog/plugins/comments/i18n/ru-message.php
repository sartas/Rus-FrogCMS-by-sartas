<?php if(!defined('DEBUG')) die;

/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2010 Maslakov Alexandr <jmas.ukraine@gmail.com>
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
 * The Comment plugin provides an interface to enable adding and moderating page comments.
 *
 * @package frog
 * @subpackage plugin.comments
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Bebliuc George <bebliuc.george@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 1.2.0
 * @since Frog version 0.9.3
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, Bebliuc George & Martijn van der Kleijn, 2008
 */


return array(
	'Comment summary'
	           => 'Описание комментария',
			   
	'Approve'  => 'Утвердить',
	'Approved' => 'Утвержден',
	
	'Not approved'
	           => 'Не утвержден',
			   
	'no link'  => 'нет ссылки',
	'no email' => 'нет эл. почты',
			   
	'Actions'  => 'Действия',
	'Comment'  => 'Комментарий',
	'Date'     => 'Дата',
	
	'Submit comment'
	           => 'Отправить комментарий',
			   
	'Opened'   => 'Открыты',
	'Closed'   => 'Закрыты',
	
	'Required fields do not filled properly!'
		       => 'Обязательные поля не заполнены!',
			   
	'Captcha image have different text. Please retype captcha!'
				=> 'Текст на рисунке отличается от того, что вы ввели. Пожалуйста, повторите ввод!',
				
	'Comment posted successfully!'
	            => 'Комментарий успещно добавлен!',
				
	'Please, enter valid e-mail address!'
	            => 'Пожалуйста, введите правильный адрес электронной почты!',
				
	'Allowed tags'
	            => 'Доступны тэги',
				
	'Comments settings'
                => 'Настройки комментариев',
				
	'Auto approve'
	            => 'Автодобавление',
	
	'Use captcha'
	            => 'Использовать каптчу',
				
	'Choose yes if you want your comments to be auto approved. Otherwise, they will have status "Not approved".'
	            => 'Выберите да, если хотите чтобы ваши комментарии сразу же отображались на сайте. В противном случае у кмментариев будет статус "Не утвержден".',
				
	'Choose yes if you want to use a captcha to protect yourself against spammers.'
	            => 'Выберите да, если вы хотите защитить форму добавления комментариев от спаммеров.',
				
	'Comment sent to moderation...'
	            => 'Комментарий отправлен на модерацию...',
);

?>