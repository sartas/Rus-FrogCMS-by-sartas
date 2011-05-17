<?php if(!defined('DEBUG')) die;

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
 * @subpackage layout
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

$controller = Dispatcher::getController(Setting::get('default_tab'));
$action = Dispatcher::getAction();
$params = Dispatcher::getParams();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php use_helper('Kses'); echo kses(Setting::get('admin_title'), array()) . ' &ndash; ' . __(ucfirst($controller)) ?></title>

		<base href="<?php echo rtrim(BASE_URL, '?/').'/'; ?>" />
		
		<script type="text/javascript">
			var PUBLIC_URL = '<?php echo URL_PUBLIC; ?>';
			var PLUGINS_URL = '<?php echo PLUGINS_URL; ?>';
			var BASE_URL = '<?php echo rtrim(BASE_URL, '?/').'/'; ?>';
			var ADMIN_DIR = '<?php echo ADMIN_DIR; ?>';
			var FROG_LOCALE = '<?php echo I18n::getLocale(); ?>';
			var USER_IS_ADMINISTRATOR = <?php echo(AuthUser::hasPermission('administrator') ? 'true' : 'false'); ?>;
			var USER_IS_DEVELOPER = <?php echo(AuthUser::hasPermission('developer') ? 'true' : 'false'); ?>;
			var USER_IS_EDITOR = <?php echo(AuthUser::hasPermission('editor') ? 'true' : 'false'); ?>;
			
			window.__locale = [];
		</script>

		<link href="<?php echo URL_PUBLIC; ?>favicon.ico" rel="favourites icon" />
		
		<link href="stylesheets/admin.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="themes/<?php echo Setting::get('theme'); ?>/admin.css" id="css_theme" media="screen" rel="stylesheet" type="text/css" />

		<!-- IE6 PNG support fix -->
		<!--[if lt IE 7]>
			<script type="text/javascript" charset="utf-8" src="javascripts/unitpngfix.js"></script>
		<![endif]-->

		<script src="javascripts/jquery/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="javascripts/jquery/jquery-form.js" type="text/javascript" charset="utf-8"></script>
		
		<!-- jQuery UI -->
		<script src="javascripts/jquery/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
		<link href="javascripts/jquery/jquery-ui.css" media="screen" rel="stylesheet" type="text/css" />
		
		<?php if( file_exists( FROG_ROOT .'/'. ADMIN_DIR .'/javascripts/i18n/'. I18n::getLocale() .'-message.js' ) ): ?>
		<!-- JS regional settings -->
		<script src="javascripts/i18n/<?php echo I18n::getLocale(); ?>-message.js" type="text/javascript" charset="utf-8"></script>
		<?php endif; ?>
		
		<script src="javascripts/admin.js" type="text/javascript" charset="utf-8"></script>

		<!-- Plugins automatic requires -->
<?php foreach( Plugin::$plugins as $plugin_id => $plugin ): ?>
	<?php if( file_exists(CORE_ROOT . '/plugins/' . $plugin_id . '/i18n/'. I18n::getLocale() .'-message.js') ): ?>
		<script src="../frog/plugins/<?php echo $plugin_id; ?>/i18n/<?php echo I18n::getLocale(); ?>-message.js" type="text/javascript" charset="utf-8"></script>
	<?php endif; ?>
	
	<?php if (file_exists(CORE_ROOT . '/plugins/' . $plugin_id . '/' . $plugin_id . '.js')): ?>
		<script src="../frog/plugins/<?php echo $plugin_id.'/'.$plugin_id; ?>.js" type="text/javascript" charset="utf-8"></script>
	<?php endif; ?>

	<?php if( file_exists(CORE_ROOT . '/plugins/' . $plugin_id . '/' . $plugin_id . '.css') ): ?>
		<link href="../frog/plugins/<?php echo $plugin_id.'/'.$plugin_id; ?>.css" media="screen" rel="stylesheet" type="text/css" />
	<?php endif; ?>
<?php endforeach; ?>

<?php foreach( Plugin::$javascripts as $jscript_plugin_id => $javascript ): ?>
		<script src="../frog/plugins/<?php echo $javascript; ?>" type="text/javascript" charset="utf-8"></script>
<?php endforeach; ?>

<?php Observer::notify('admin_layout_backend_head'); ?>

	</head>
	<body id="body_<?php echo $controller .'_'. $action . ($controller == 'plugin' ? '_'. (empty($params) ? 'index' : $params[0]) : ''); ?>">
		
		<div id="header">
			<ul id="navigation">				
				<?php foreach( Plugin::getTabs() as $tab_name => $tab ): ?>
				<li <?php if($tab->is_current) echo('class="current"'); ?> >
					<a href="<?php echo $tab->items[0]->uri; ?>"><?php echo __($tab_name); ?></a>
					
					<ul class="navigation-sub">
						<?php foreach( $tab->items as $item ): ?>
						<li <?php if($item->is_current) echo('class="current"'); ?>><a href="<?php echo get_url($item->uri); ?>"><?php echo $item->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endforeach; ?>
			</ul>
			
			<div id="site_links">
				<span class="site-links-logged"><?php echo __('Logged in as'); ?> <a href="<?php echo get_url('user/edit/'.AuthUser::getId()); ?>"><?php echo AuthUser::getRecord()->name; ?></a></span>
				<span class="site-links-logout">(<a href="<?php echo get_url('login/logout'); ?>"><?php echo __('Log Out'); ?></a>)</span>
				<a href="<?php echo URL_PUBLIC . (USE_MOD_REWRITE ? '': '?/'); ?>" target="_blank" class="site-links-view"><?php echo __('View Site'); ?></a>
			</div>
		</div>
		
	    <div id="main">
		<!-- main -->
			<div id="content">
			<!-- content -->
				
				<?php if( ($info = Flash::get('info')) !== null ): ?>
				<div id="info" class="frog-message"><?php echo $info; ?></div>
				<?php endif; ?>
				
				<?php if( ($error = Flash::get('error')) !== null ): ?>
		        <div id="error" class="frog-message"><?php echo $error; ?></div>
				<?php endif; ?>
				
				<?php if( ($success = Flash::get('success')) !== null ): ?>
				<div id="success" class="frog-message"><?php echo $success; ?></div>
				<?php endif; ?>
				
				<?php echo $content_for_layout; ?>
				
			<!-- /content -->
			</div>
			
			<?php if(!empty($actions)): ?>
			<div id="actions">
			<!-- actions -->
				
				<?php echo $actions; ?>
				
			<!-- /actions -->
			</div>
			<?php endif; ?>
			
			<div class="clear"><!--x--></div>
			
		<!-- /main -->
	    </div>
		
	    <div id="footer">
		<?php /*
			<p>
				<?php echo __('Thank you for using'); ?> <a href="http://www.madebyfrog.com/" target="_blank">Frog CMS</a> <?php echo FROG_VERSION; ?> | <a href="http://forum.madebyfrog.com/" target="_blank"><?php echo __('Feedback'); ?></a>
			</p>
			
			<?php if( DEBUG ): ?>
			<p id="footer_stats">
				<?php echo __('Page rendered in'); ?> <?php echo execution_time(); ?> <?php echo __('seconds'); ?> <span class="separator"> | </span> <?php echo __('Memory usage'); ?>: <?php echo memory_usage(); ?>
			</p>
			<?php endif; ?>
			*/ ?>
	    </div>
		
		<noscript id="noscript">
			<p><?php echo __('JavaScript is switched off or not supported in your Internet Browser. Please switch on JavaScript or change your Browser. Thanks.'); ?></p>
		</noscript>
		<script type="text/javascript">
			/*
				Hide noscript for IE
			*/
			jQuery('#noscript').hide();
		</script>
		
	</body>
</html>