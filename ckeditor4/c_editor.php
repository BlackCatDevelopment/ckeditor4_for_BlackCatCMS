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

    public function getAdditionalSettings()
    {
        return array(
            array( 'name' => 'allowedContent'    , 'type' => 'boolean', 'default' => 'false'      ),
            array( 'name' => 'autoParagraph'     , 'type' => 'boolean', 'default' => 'false'      ),
            array( 'name' => 'contentsCss'       , 'type' => 'text'   , 'default' => 'editor.css' ),
            array( 'name' => 'insertpre_class'   , 'type' => 'text'   , 'default' => ''           ),
            array( 'name' => 'insertpre_style'   , 'type' => 'text'   , 'default' => ''           ),
            array( 'name' => 'autoGrow_minHeight', 'requires' => 'autogrow', 'type' => 'text'   , 'default' => 200          ),
            array( 'name' => 'autoGrow_maxHeight', 'requires' => 'autogrow', 'type' => 'text'   , 'default' => 400          ),
            array( 'name' => 'autoGrow_onStartup', 'requires' => 'autogrow', 'type' => 'boolean', 'default' => 'true'       ),
            array( 'name' => 'codemirror_theme'  , 'requires' => 'codemirror', 'type' => 'select' , 'default' => 'default',
                'options' => array('default','ambiance','blackboard','cobalt','eclipse','elegant','erlang-dark','lesser-dark','monokai','neat','night','rubyblue','twilight','vibrant-ink','xq-dark')
            ),
        );
    }

    public function getAdditionalPlugins()
    {
        $defaults = array( 'ajax', 'a11yhelp', 'about', 'clipboard', 'cmsplink', 'dialog', 'droplets',
                           'fakeobjects', 'floatpanel', 'image', 'insertpre', 'link', 'magicline', 'pastefromword',
                           'panel', 'panelbutton', 'richcombo', 'scayt', 'specialchar', 'table', 'tabletools', 'wsc', 'xml' );
        $path     = $this->getPluginsPath();
        $subs     = CAT_Helper_Directory::getInstance()->setRecursion(false)->getDirectories( $path, $path.'/' );
        // remove defaults from subs
        $plugins  = array_diff($subs,$defaults);
        if(count($plugins)) return $plugins;
        return array();
    }

}