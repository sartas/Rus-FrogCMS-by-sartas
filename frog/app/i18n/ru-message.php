<?php if(!defined('DEBUG')) die;

/*
 *	@author Konstantin Baev <kipruss@mail.ru>, Maslakov Alexander <jmas.ukraine@gmail.com>
*/
 
return array(

// general
'Other'           => 'Другое',
'Feedback'        => 'Обратная связь',
'Administration'  => 'Администрирование',
'Pages'           => 'Страницы',
'Snippets'        => 'Вставки',
'Layouts'         => 'Шаблоны',
'Files'           => 'Файлы',
'Users'           => 'Пользователи',
'View'			  => 'Просмотр',
'Modify'          => 'Изменить',
'Action'          => 'Действие',
'Close'           => 'Закрыть',
'Save'            => 'Сохранить',
'Save Changes'    => 'Сохранить изменения',
'Save and Close'  => 'Сохранить и закрыть',
'Save and Continue Editing' => 'Сохранить и продолжить редактирование',
'or'              => 'или',
'Cancel'          => 'Отменить',
'Name'            => 'Имя',
'Body'            => 'Содержимое',
'Last updated by' => 'Последнее обновление',
'on'              => 'на',
'Last updated by <a href=":link">:name</a> on :date'
                  => 'Последнеее обновление :date сделал <a href=":link">:name</a>',
'Upload'          => 'Загрузить',
'Are you sure you wish to delete' => 'Вы уверены, что хотите удалить',
'Published'       => 'Опубликована',
'Draft'           => 'Черновик',
'Reviewed'        => 'Просмотрена',
'Hidden'          => 'Скрыта',
'Wait'            => 'Ожидает',
'More'            => 'Больше',
'Less'            => 'Меньше',
'Add'             => 'Добавить',
'Required.'       => 'Обязательно.',
'Optional.'       => 'Не обязательно',
'yes'             => 'да',
'no'              => 'нет',
'Remove'		  => 'Удалить',
'In a new window' => 'В новом окне',
'Add page part'   => 'Добавить часть страницы',

// layouts
'Design'			=> 'Дизайн',
'Layout'            => 'Шаблон',
'New Layout'        => 'Новый шаблон',
'What is a Layout?' => 'Что такое шаблон?',
'Use layouts to apply a visual look to a Web page. Layouts can contain special tags to include
  page content and other elements such as the header or footer. Click on a layout name below to
  edit it or click <strong>Remove</strong> to delete it.' => 'Используйте шаблоны для построения внешнего вида веб-страницы.
  Шаблоны могут содержать специальные тэги для включения контента и других элементов, таких как &laquo;шапка&raquo;
  и &laquo;подвал&raquo; страницы. Щёлкните на название шаблона для его редактирования или нажмите <strong>Удалить</strong>
  для его удаления.',
'Add layout'        => 'Добавить шаблон',
'Edit layout'       => 'Редактировать шаблон',
'Remove layout'     => 'Удалить шаблон',
'inherit'           => 'наследуется',

// pages
'Content'                 => 'Содержимое',
'Page'                    => 'Страница',
'reorder'                 => 'изменить порядок',
'copy'                 => 'копировать',
'Add Page'                => 'Добавить страницу',
'Edit Page'               => 'Редактировать страницу',
'Status'                  => 'Статус',
'Order'                   => 'Порядок',
'Add child'               => 'Добавить потомка',
'Add Tab'                 => 'Добавить вкладку',
'Add Part'                => 'Добавить вкладку',
'Remove Tab'              => 'Удалить вкладку',
'Delete the current tab?' => 'Удалить текущую вкладку',
'Remove page'             => 'Удалить страницу',
'Remove page disable'     => 'Удаление страницы заблокировано',
'Drag and Drop'           => 'Перетаскивание',
'Drag and Drop disable'   => 'Перетаскивание заблокировано',
'Page Title'              => 'Заголовок страницы',
'Metadata'                => 'Метаданные',
'Filter'                  => 'Фильтр',
'none'                    => 'отсутствует',
'Page Type'               => 'Тип страницы',
'Comments'                => 'Комментарии',
'Slug'                    => 'Компонент адреса',
'Breadcrumb'              => 'Хлебные крошки',
'Keywords'                => 'Ключевые слова',
'Description'             => 'Описание',
'Tags'                    => 'Тэги',
'View this page'          => 'Просмотреть страницу',
'Use Login'                  => 'Вход с паролем',
'When enabled, users have to login before they can view the page.' => 'Если установлено, то только зарегистрированные пользователи могут просматривать страницу.',
'not required'            => 'не требуется',
'required'                => 'требуется',
'Protected'               => 'Защищена',
'When enabled, only users who are an administor can edit the page.' => 'Если установлено, то только пользователи с правами администраторов могут редактировать страницу.',
'More options'			  => 'Дополнительные параметры',
'Published date'		  => 'Дата публикации',

// plugins
'n/a'		=> 'н/д',
'Plugin'    => 'Плагин',
'Plugins'   => 'Плагины',
'Website'   => 'Веб-сайт',
'Version'   => 'Версия',
'Latest'    => 'Последний',
'Unknown'	=> 'Неизвестно',
'Enabled'   => 'Включен',

// settings
'Interface'			    => 'Интерфейс',
'Settings'              => 'Настройки',
'General'               => 'Общие',
'Setting'				=> 'Настройка',
'Admin Site title'      => 'Заголовок сайта',
'Language'              => 'Язык',
'Administration Theme'  => 'Тема раздела администрирования',
'Page options'          => 'Настройки страницы',
'Default Status'        => 'Статус по умолчанию',
'Default Filter'        => 'Фильтр по умолчанию',
'Default tab'           => 'Вкладка по умолчанию',
'Optional component'    => 'Необязательные компоненты',
'Display stats'         => 'Показать статистику',
'Display file manager'  => 'Отобразить файловый менеджер',
'By using <strong>&lt;img src="img_path" /&gt;</strong> you can set your company logo instead of a title.' => 'Используя <strong>&lt;img src="путь_к_изображению" /&gt;</strong>, вы можете установить изображение логотипа вашей компании вместо заголовка.',
'This will set your language for the backend.'  => 'Это позволит установить язык для бэкенда.',
'This will change your Administration theme.'   => 'Это позволит сменить тему раздела администрирования',
'Only for filter in pages, NOT in snippets'     => 'Только для фильтра на страницах, НЕ во фрагментах.',
'Allow HTML in Title' => 'Разрешить HTML в заголовке',
'This allows you to specify which tab (controller) you will see by default after login.' =>
'Это позволит выбрать вкладку (контроллер), которую вы будете видеть по умолчанию после входа.',
'Determines whether or not HTML code is allowed in a page\'s title.' => 'Определяет, доступен или нет HTML код в заголовке страницы.',
'This plugin cannot be enabled! It requires Frog version :v.'
                        => 'Этот плагин не может быть активирован! Требуется Frog CMS версии :v.',
'by'                    => 'от',
'General site language' => 'Основной язык сайта',
'Site options'          => 'Настройки сайта',

// snippets
'New Snippet'           => 'Новая вставка',
'What is a Snippet?'    => 'Что такое фрагмент?',
'Snippets are generally small pieces of content which are included in other pages or layouts.' =>
                        'Фрагменты - это небольшие части контента, которые включены в другие страницы или шаблоны',
'Snippet'               => 'Вставка',
'Add Snippet'           => 'Добавить вставку',
'Add snippet'           => 'Добавить вставку',
'Edit snippet'          => 'Редактировать вставку',
'Remove Snippet'        => 'Удалить вставку',
'Tag to use this snippet'
                        => 'Тэг для использования этого фрагмента',
'Just replace <b>snippet</b> by the snippet name you want to include.'
                        => 'Замените <b>snippet</b> на имя фрагмента, который вы хотите подключить',

// users
'User'						=> 'Пользователь',
'Add user'                  => 'Добавить пользователя',
'Edit user'                 => 'Редактировать пользователя',
'Username'                  => 'Имя пользователя',
'E-mail'                    => 'Электронная почта',
'Password'                  => 'Пароль',
'Forgot password?'          => 'Забыли пароль?',
'Forgot password'           => 'Забыли пароль',
'Email address'             => 'Адрес e-mail',
'Confirm Password'          => 'Подтверждение пароля',
'Send password'             => 'Отправить пароль',
'No user found!'            => 'Пользователь не найден!',
'Login'                     => 'Вход',
'Remember me for 14 days'   => 'Запомнить меня на 14 дней',
'Roles'                     => 'Роли',
'Administrator'             => 'Администратор',
'Developer'                 => 'Разработчик',
'Editor'                    => 'Редактор',
'Optional. Please use a valid e-mail address.'  => 'Не обязательно. Пожалуйста, используйте действующий адрес электронной почты.',
'At least 3 characters. Must be unique.'        => 'По крайней мере 3 символа. Должно быть уникальным.',
'At least 5 characters.'    => 'По крайней мере 5 символов.',
'Leave password blank for it to remain unchanged.' => 'Оставьте пароль пустым, чтобы он остался без изменений',
'Roles restrict user privileges and turn parts of the administrative interface on or off.' =>
'Роли ограничивают пользовательские привилегии и включают или отключают части административного интерфейса.',
'New User'                  => 'Новый пользователь',
'Where do the avatars come from?' => 'Как разместить аватары',
'The avatars are automatically linked for those with a <a href="http://www.gravatar.com/" target="_blank">Gravatar</a> (a free service) account.' =>
'Аватары добавляются автоматически для пользователей бесплатного сервиса <a href="http://www.gravatar.com/" target="_blank">Gravatar</a>',
'Change Avatar'             => 'Изменить аватар',
'Interface language'        => 'Язык интерфейса',
'Individual interface language.'
                            => 'Индивидуальный язык интерфейса.',

// errors and success
'Layout has been added!'                            => 'Шаблон добавлен!',
'Layout has not been added. Name must be unique!'   => 'Шаблон не добавлен. Имя должно быть уникальным!',
'Layout has been saved!'                            => 'Шаблон сохранён!',
'Layout has not been saved. Name must be unique!'   => 'Шаблон не сохранён. Имя должно быть уникальным!',
'Layout :name has been deleted!'                    => 'Шаблон :name удалён!',
'Layout :name has not been deleted!'                => 'Шаблон :name не удалён!',
'Layout not found!'                                 => 'Шаблон не найден!',

'Login failed. Please check your login data and try again.' => 'Вы не вошли. Проверьте ваши данные и попробуйте еще раз.',

'Page has been saved!'              => 'Страница сохранена!',
'Page has not been saved!'          => 'Страница не сохранена!',
'Page not found!'                   => 'Страница не найдена!',
'Page :title has been deleted!'     => 'Страница :title удалена!',
'Page :title has not been deleted!' => 'Страница :title не удалена!',
'Action disabled!'                  => 'Действие заблокировано!',
'You have to specify a title!'      => 'Вы должны указать заголовок!',

'Snippet has been added!'                                => 'Фрагмент добавлен!',
'Snippet has not been added. Name must be unique!'       => 'Фрагмент не добавлен. Имя должно быть уникальным!',
'Snippet :name has been saved!'                          => 'Фрагмент :name сохранён!',
'Snippet :name has not been saved. Name must be unique!' => 'Фрагмент :name не сохранён. Имя должно быть уникальным!',
'Snippet :name has been deleted!'                        => 'Фрагмент :name удалён!',
'Snippet :name has not been deleted!'                    => 'Фрагмент :name не удалён',
'Snippet not found!'                                     => 'Фрагмент не найден!',

'You do not have permission to access the requested page!' => 'Вы не имеете права доступа на запрашиваемую страницу!',
'Password and Confirm are not the same or too small!'      => 'Пароль не совпадает с его подтверждением либо он слишком короткий!',
'Username must contain a minimum of 3 characters!'         => 'Имя пользователя должно содержить как минимум 3 символа!',
'User has been added!'                                     => 'Пользователь добавлен!',
'User has not been added!'                                 => 'Пользователь не добавлен!',
'User not found!'                                          => 'Пользователь не найден!',
'User has been saved!'                                     => 'Пользователь сохранён!',
'User has not been saved!'                                 => 'Пользователь не сохранён!',
'User <strong>:name</strong> has been deleted!'            => 'Пользователь <strong>:name</strong> удалён!',
'User <strong>:name</strong> has not been deleted!'        => 'Пользователь <strong>:name</strong> не удалён!',

'Settings has been saved!'        => 'Настройки сохранены!',
'Settings do not saved!'          => 'Настройки не были сохранены!',
'General settings'                => 'Общие настройки',
'Or press'                        => 'Или нажми',

// layout
'Logged in as'    					=> 'Вошли как',
'Log Out'                           => 'Выйти',
'View Site'                         => 'Просмотреть сайт',
'Thank you for using'               => 'Спасибо за использование',
'version'                           => 'версия',
'Page rendered in'                  => 'Страница сгенерирована за',
'seconds'                           => 'секунды',
'Memory usage'                      => 'Использовано памяти',

// TO BE REMOVED IN LATER VERSIONS

// File manager
'Rename' => 'Переименовать',
'Create' => 'Создать',
'overwrite it?' => 'перезаписать?',


// Comments
'Enable comments'       => 'Разрешить комментарии',
'Auto approve comments' => 'Автоматическое одобрение комментариев',
'Delete'                => 'Удалить',
'Reject'                => 'Отклонить',
'Please insert the result of the arithmetical operation from the following image:' => 'Пожалуйста, введите результат арифметической операции:',
'A comment was added' => 'Комментарий добавлен',
'Incorrect result value. Please try again:' => 'Неправильное значение. Повторите, пожалуйста:',
'Please insert the result of the arithmetical operation from this image' => 'Пожалуйста, введите результат арифметической операции:',
'Thank you for your comment. It has been added.' => 'Спасибо! Ваш комментарий добавлен.',
'Thank you for your comment. It is waiting for approval.' => 'Спасибо! Ваша сообщение отправлено на модерацию.',

'JavaScript is switched off or not supported in your Internet Browser. Please switch on JavaScript or change your Browser. Thanks.'
                        => 'В вашем интернет-браузере отключена поддержка JavaScript. Пожалуйста, включите JavaScript или смените ваш браузер. Спасибо.',
						
'Yes' => 'Да',
'No' => 'Нет'
);