<?php

/**
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         ckeditor4
 *
 */


if (defined('CAT_PATH')) {
	include(CAT_PATH.'/framework/class.secure.php');
} else {
	$root = "../";
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= "../";
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) {
		include($root.'/framework/class.secure.php');
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}

$debug = false;
if (true === $debug) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL|E_STRICT);
}

require CAT_Helper_Directory::sanitizePath(realpath(dirname(__FILE__).'/../wysiwyg_admin/c_editor_base.php'));

if(!class_exists('c_editor',false))
{
    final class c_editor extends c_editor_base
    {

        protected static $default_skin = 'moono';
        protected static $editor_package = 'standard';

        public function getFilemanagerPath()
        {
            return CAT_Helper_Directory::sanitizePath(realpath(dirname(__FILE__).'/ckeditor/filemanager'));
        }

        public function getSkinPath()
        {
            return CAT_Helper_Directory::sanitizePath(realpath(dirname(__FILE__).'/ckeditor/skins'));
        }

        public function getPluginsPath()
        {
            return CAT_Helper_Directory::sanitizePath(realpath(dirname(__FILE__).'/ckeditor/plugins'));
        }

        public function getToolbars()
        {
            return array( 'Full', 'Smart', 'Simple' );
        }

        /**
         * - scans the plugin directories for info.php
         * - retrieves the requirements from that file
         *
         * @access public
         * @return array
         **/
        public function getAdditionalSettings()
        {
            // defaults - always there
            $options = array(
                array(
                    'name'    => 'allowedContent',
                    'label'   => 'Activate Advanced Content Filter (ACF)',
                    'help'    => 'For details please visit <a href="http://docs.ckeditor.com/#!/guide/dev_advanced_content_filter" target="_blank">http://docs.ckeditor.com/#!/guide/dev_advanced_content_filter</a>',
                    'type'    => 'boolean',
                    'default' => 'false'
                ),
                array(
                    'name'    => 'contentsCss',
                    'label'   => 'Additional CSS files',
                    'help'    => 'editorCSS, please add at lease custom.css and font-awesome.min.css if you\'ve activated the fontawesome-Plugin',
                    'type'    => 'text',
                    'default' => 'editor.css'
                ),
            );

            // get configuration for optional plugins, located in <plugindir>/info.php
            $basedir = dirname(__FILE__).'/ckeditor/plugins';
            $plugins = CAT_Helper_Directory::getInstance(1)
                     ->setRecursion(true)
                     ->maxRecursionDepth(2)
                     ->findFiles('info.php',$basedir,$basedir.'/');

            if(is_array($plugins) && count($plugins))
            {
                foreach(array_values($plugins) as $file)
                {
                    $plugin_config = array(); // reset
                    @include($basedir.$file);
                    if(is_array($plugin_config))
                    {
                        if(isset($plugin_config['opt']))
                        {
                            foreach($plugin_config['opt'] as $opt)
                            {
                                array_push($options, $opt);
                            }
                        }
                    }
                    // there may also be a language file
                    $langfile = CAT_Helper_Directory::sanitizePath($basedir.pathinfo($file,PATHINFO_DIRNAME).'/languages/'.LANGUAGE.'.php');
                    if(file_exists($langfile))
                    {
                        CAT_Helper_Directory::getInstance(1)->lang()->addFile(
                            LANGUAGE.'.php', pathinfo($langfile,PATHINFO_DIRNAME)
                        );
                    }
                }
            }

            return $options;
        }

        public function getAdditionalPlugins()
        {
            // this is the list of plugins that are already included; this inhibits
            // that they are listed as optional plugins in the WYSIWYG Admin
            $defaults = array( 'a11yhelp', 'about', 'ajax', 'clipboard', 'cmsplink', 'colordialog',
                               'dialog', 'div', 'droplets', 'find', 'flash', 'forms', 'iframe', 'image',
                               'link', 'liststyle', 'magicline', 'pagebreak', 'pastefromword', 'preview',
                               'scayt', 'showblocks', 'smiley', 'specialchar',
                               'table', 'tabletools', 'templates', 'wsc', 'xml' );
            $path     = $this->getPluginsPath();
            $subs     = CAT_Helper_Directory::getInstance()->setRecursion(false)->getDirectories( $path, $path.'/' );
            // remove defaults from subs
            $plugins  = array_diff($subs,$defaults);
            if(count($plugins)) return $plugins;
            return array();
        }

        /**
         *
         * @access public
         * @return
         **/
        public function getFrontendCSS()
        {
            // get configuration for optional plugins, located in <plugindir>/info.php
            $basedir = dirname(__FILE__).'/ckeditor/plugins';
            $plugins = CAT_Helper_Directory::getInstance(1)
                     ->setRecursion(true)
                     ->maxRecursionDepth(2)
                     ->findFiles('info.php',$basedir,$basedir.'/');

            if(is_array($plugins) && count($plugins))
            {
                $css = array();
                foreach(array_values($plugins) as $file)
                {
                    $plugin_config = array(); // reset
                    @include($basedir.$file);
                    if(is_array($plugin_config))
                    {
                        if(isset($plugin_config['css']) && isset($plugin_config['css']['frontend']))
                        {
                            foreach($plugin_config['css']['frontend'] as $opt)
                            {
                                // fix relative paths
                                if(substr_compare(pathinfo($file,PATHINFO_DIRNAME), $opt, 0, strlen(pathinfo($file,PATHINFO_DIRNAME))+1))
                                {
                                    $opt = CAT_Helper_Directory::sanitizePath(pathinfo($file,PATHINFO_DIRNAME).'/'.$opt);
                                }
                                array_push($css, $opt);
                            }
                        }
                    }
                }
                return $css;
            }
        }   // end function getFrontendCSS()
    }   // ----- end class c_editor -----
}