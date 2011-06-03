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
 * @subpackage models
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

/**
 * class Plugin 
 *
 * Provide a Plugin API to make frog more flexible
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @since Frog version 0.9
 */
class Plugin
{
	static $plugins = array();
	static $plugins_infos = array();
    static $updatefile_cache = array();

	static $controllers = array();
    static $javascripts = array();
	
	static $tabs = array();

	/**
	 * Initialize all activated plugin by including is index.php file
	 */
	static function init()
	{
		Plugin::addTab('Content', __('Pages'), 'page', 'administrator,developer,editor');
		Plugin::addTab('Design', __('Layouts'), 'layout', 'administrator,developer');
		Plugin::addTab('Design', __('Snippets'), 'snippet', 'administrator,developer');
		Plugin::addTab('Settings', __('General'), 'setting', 'administrator');
		Plugin::addTab('Settings', __('Plugins'), 'setting/plugin', 'administrator');
		Plugin::addTab('Settings', __('Users'), 'user', 'administrator');
	
	
		self::$plugins = unserialize(Setting::get('plugins'));
		
		foreach (self::$plugins as $plugin_id => $tmp)
		{
			$manifest_file = CORE_ROOT . '/plugins/' . $plugin_id . '/manifest.ini';
			
			if( file_exists($manifest_file) )
			{
				$manifest = parse_ini_file($manifest_file, false);
				Plugin::setInfos( $manifest );
			}
			
			// Lang file
			$file = CORE_ROOT . '/plugins/' . $plugin_id . '/i18n/' . I18n::getLocale() . '-message.php';
			
			if (file_exists($file))
			{
				$array = include($file);
				I18n::add($array);
			}
			
			// Index file
			$file = CORE_ROOT . '/plugins/' . $plugin_id . '/index.php';
			
			if( file_exists($file) )
				include($file);
		}
	}

	/**
	 * Set plugin informations (id, title, description, version and website)
	 *
	 * @param infos array Assoc array with plugin informations
	 */
	static function setInfos($infos)
	{
		self::$plugins_infos[$infos['id']] = (object) $infos;
	}

	/**
	 * Activate a plugin. This will execute the enable.php file of the plugin
     * when found.
	 *
	 * @param plugin_id string	The plugin name to activate
	 */
	static function activate($plugin_id)
	{
		self::$plugins[$plugin_id] = 1;
		self::save();

		$file = CORE_ROOT.'/plugins/'.$plugin_id.'/enable.php';
		if (file_exists($file))
			include $file;
        
        //$class_name = Inflector::camelize($plugin_id).'Controller';        
        //AutoLoader::addFile($class_name, self::$controllers[$plugin_id]->file);
	}
	
	/**
	 * Deactivate a plugin
	 *
	 * @param plugin_id string	The plugin name to deactivate
	 */
	static function deactivate($plugin_id)
	{
		if (isset(self::$plugins[$plugin_id]))
		{
			unset(self::$plugins[$plugin_id]);
			self::save();

			$file = CORE_ROOT.'/plugins/'.$plugin_id.'/disable.php';
			if (file_exists($file))
				include $file;
		}
	}

	/**
	 * Save activated plugins to the setting 'plugins'
	 */
	static function save()
	{
		Setting::saveFromData(array('plugins' => serialize(self::$plugins)));
	}

	/**
	 * Find all plugins installed in the plugin folder
	 *
	 * @return array
	 */
	static function findAll()
	{
		$dir = CORE_ROOT.'/plugins/';

		if( $handle = opendir($dir) )
		{
			while( false !== ($plugin_id = readdir($handle)) )
			{
				if( !isset(self::$plugins[$plugin_id]) && is_dir($dir.$plugin_id) && strpos($plugin_id, '.') !== 0 )
				{
					$manifest_file = CORE_ROOT.'/plugins/'.$plugin_id.'/manifest.ini';
					
					if( file_exists($manifest_file) )
					{
						$manifest = parse_ini_file($manifest_file, false);
						
						Plugin::setInfos( $manifest );
					}
					
					/*
					$file = CORE_ROOT.'/plugins/'.$plugin_id.'/index.php';
					
					if( file_exists($file) )
						include($file);
					*/
				}
			}
			closedir($handle);
		}

		ksort(self::$plugins_infos);
		return self::$plugins_infos;
	}

    /**
     * Check the file mentioned as update_url for the latest plugin version available.
     * Messages that can be returned:
     * unknown - returned if the plugin doesn't provide an update url
     * latest  - returned if the plugin version matches the version number registerd at the url
     * error   - returned if the update url could not be reached or for any other reason
     *
     * @param plugin     object A plugin object.
     *
     * @return           string The latest version number or a localized message.
     */
    static function checkLatest($plugin)
    {
        $data = null;

        if (!defined('CHECK_UPDATES') || !CHECK_UPDATES)
            return __('unknown');

        // Check if plugin has update file url set
        if ( ! isset($plugin->update_url) )
            return __('unknown');

        // Check if update file was already cached and is no older than 30 minutes
        if (array_key_exists($plugin->update_url, Plugin::$updatefile_cache) && (Plugin::$updatefile_cache[$plugin->update_url]['time'] + 30 * 60) < time()) {
            unset(Plugin::$updatefile_cache[$plugin->update_url]);
        }

        if (!array_key_exists($plugin->update_url, Plugin::$updatefile_cache)) {
            // Read and cache the update file
            if (!defined('CHECK_TIMEOUT')) define('CHECK_TIMEOUT', 5);
            $ctx = stream_context_create(array('http' => array('timeout' => CHECK_TIMEOUT)));

            if ( ! $data = file_get_contents($plugin->update_url, 0, $ctx)) {
                return __('error');
            }
            Plugin::$updatefile_cache[$plugin->update_url] = array('time' => time(), 'data' => $data);
        }

        $xml = simplexml_load_string(Plugin::$updatefile_cache[$plugin->update_url]['data']);

        foreach($xml as $node) {
            if ($plugin->id == $node->id)
                if ($plugin->version == $node->version)
                    return __('latest');
                else
                    return (string) $node->version;
        }

        return __('error');
    }


	/**
	 * Add a controller (tab) to the administration
	 *
	 * @param plugin_id     string  The folder name of the plugin
	 * @param label         string/array  The tab label
	 * @param permissions   string  List of roles that will have the tab displayed
	 *                              separate by coma ie: 'administrator,developer'
     * @param show_tab      boolean Either 'true' or 'false'. Defaults to true.
	 *
	 * @return void
	 */
	static function addController($plugin_id)
	{
		$class_name = Inflector::camelize($plugin_id).'Controller';
		
		$class_file = CORE_ROOT.'/plugins/'.$plugin_id.'/'.$class_name.'.php';
		

		self::$controllers[$plugin_id] = (object) array(
			'class_name' => $class_name,
			'file'	=> CORE_ROOT.'/plugins/'.$plugin_id.'/'.$class_name.'.php'
		);
		
        AutoLoader::addFile($class_name, $class_file);
	}
    

    /**
     * Add a javascript file to be added to the html page for a plugin.
     * Backend only right now.
     *
     * @param $plugin_id    string  The folder name of the plugin
     * @param $file         string  The path to the javascript file relative to plugin root
     */
    static function addJavascript($plugin_id, $file)
    {
        if (file_exists(CORE_ROOT . '/plugins/' . $plugin_id . '/' . $file))
        {
            self::$javascripts[] = $plugin_id.'/'.$file;
        }
    }
    
    
    static function hasSettingsPage($plugin_id)
    {
        $class_name = Inflector::camelize($plugin_id).'Controller';
        
        return (array_key_exists($plugin_id, Plugin::$controllers) && method_exists($class_name, 'settings'));
    }
    
    
    static function hasDocumentationPage($plugin_id)
    {
        $class_name = Inflector::camelize($plugin_id).'Controller';
        
        return (array_key_exists($plugin_id, Plugin::$controllers) && method_exists($class_name, 'documentation'));
    }

    /**
     * Returns true if a plugin is enabled for use.
     *
     * @param string $plugin_id
     */
    static function isEnabled($plugin_id)
    {
        if (array_key_exists($plugin_id, Plugin::$plugins) && Plugin::$plugins[$plugin_id] == 1)
            return true;
        else
            return 0;
    }

    /**
     * Stores all settings from a name<->value pair array in the database.
     *
     * @param array $settings Array of name-value pairs
     * @param string $plugin_id     The folder name of the plugin
     */
    static function setAllSettings($array=null, $plugin_id=null)
    {
        if ($array == null || $plugin_id == null) return false;

        $conn = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';
        $plugin_id = $conn->quote($plugin_id);

        $existingSettings = array();

        $sql = "SELECT name FROM $tablename WHERE plugin_id=$plugin_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        while ($settingname = $stmt->fetchColumn())
            $existingSettings[$settingname] = $settingname;

        $ret = false;

        foreach ($array as $name => $value)
        {
            if (array_key_exists($name, $existingSettings))
            {
                $name = $conn->quote($name);
                $value = $conn->quote($value);
                $sql = "UPDATE $tablename SET value=$value WHERE name=$name AND plugin_id=$plugin_id";
            }
            else
            {
                $name = $conn->quote($name);
                $value = $conn->quote($value);
                $sql = "INSERT INTO $tablename (value, name, plugin_id) VALUES ($value, $name, $plugin_id)";
            }

            $stmt = $conn->prepare($sql);
            $ret = $stmt->execute();
        }

        return $ret;
    }

    /**
     * Allows you to store a single setting in the database.
     *
     * @param string $name          Setting name
     * @param string $value         Setting value
     * @param string $plugin_id     Plugin folder name
     */
    static function setSetting($name=null, $value=null, $plugin_id=null)
    {
        if ($name == null || $value == null || $plugin_id == null) return false;

        $conn = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';
        $plugin_id = $conn->quote($plugin_id);

        $existingSettings = array();

        $sql = "SELECT name FROM $tablename WHERE plugin_id=$plugin_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($plugin_id));

        while ($settingname = $stmt->fetchColumn())
            $existingSettings[$settingname] = $settingname;

        if (in_array($name, $existingSettings))
        {
            $name = $conn->quote($name);
            $value = $conn->quote($value);
            $sql = "UPDATE $tablename SET value=$value WHERE name=$name AND plugin_id=$plugin_id";
        }
        else
        {
            $name = $conn->quote($name);
            $value = $conn->quote($value);
            $sql = "INSERT INTO $tablename (value, name, plugin_id) VALUES ($value, $name, $plugin_id)";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * Retrieves all settings for a plugin and returns an array of name-value pairs.
     * Returns empty array when unsuccessful in retrieving the settings.
     *
     * @param <type> $plugin_id
     */
    static function getAllSettings($plugin_id=null)
    {
        if ($plugin_id == null) return false;

        $conn = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';
        $plugin_id = $conn->quote($plugin_id);

        $settings = array();

        $sql = "SELECT name,value FROM $tablename WHERE plugin_id=$plugin_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        while ($obj = $stmt->fetchObject()) {
            $settings[$obj->name] = $obj->value;
        }

        return $settings;
    }

    /**
     * Returns the value for a specified setting.
     * Returns false when unsuccessful in retrieving the setting.
     *
     * @param <type> $name
     * @param <type> $plugin_id
     */
    static function getSetting($name=null, $plugin_id=null)
    {
        if ($name == null || $plugin_id == null) return false;

        $conn = Record::getConnection();
        $tablename = TABLE_PREFIX.'plugin_settings';
        $plugin_id = $conn->quote($plugin_id);
        $name = $conn->quote($name);

        $existingSettings = array();

        $sql = "SELECT value FROM $tablename WHERE plugin_id=$plugin_id AND name=$name LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($value = $stmt->fetchColumn()) return $value;
        else return false;

    }
	
	
	static function addTab($tab = 'Other', $name, $uri, $permissions = 'administrator' )
	{
		if( AuthUser::hasPermission( $permissions ) )
		{
			if( !isset(self::$tabs[$tab]) )
			{
				self::$tabs[$tab] = (object) array(
					'is_current' => false,
					'items' => array()
				);
			}
			
			self::$tabs[$tab]->items[] = (object) array(
				'name' => $name,
				'uri' => $uri,
				'is_current' => false
			);
		}
	}
	
	static function getTabs()
	{
		$controller = Dispatcher::getController();
		$action = Dispatcher::getAction();
		$params = join('/', Dispatcher::getParams());
		
		$break = false;
		foreach( self::$tabs as $tab_key => $tab )
		{
			foreach( $tab->items as $item_key => $item )
			{
				$item_expl = explode('/', $item->uri);
				$item_controller = $item_expl[0];
				$item_action = isset($item_expl[1]) ? $item_expl[1] : DEFAULT_ACTION;
			
				if( ($item_controller != 'plugin' && $item_controller == $controller) || ($item_controller == 'plugin' && $item_action == $action) )
				{
					self::$tabs[$tab_key]->is_current = true;
					self::$tabs[$tab_key]->items[$item_key]->is_current = true;
					$break = true;
					break;
				}
			}
			
			if($break) break;
		}
		
		return self::$tabs;
	}
	
} // end Plugin class
