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
    if (defined('CAT_VERSION')) include(CAT_PATH.'/framework/class.secure.php');
} elseif (file_exists($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php')) {
    include($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php');
} else {
    $subs = explode('/', dirname($_SERVER['SCRIPT_NAME']));    $dir = $_SERVER['DOCUMENT_ROOT'];
    $inc = false;
    foreach ($subs as $sub) {
        if (empty($sub)) continue; $dir .= '/'.$sub;
        if (file_exists($dir.'/framework/class.secure.php')) {
            include($dir.'/framework/class.secure.php'); $inc = true;    break;
	}
	}
    if (!$inc) trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
}

// ----------------------------------------------
// --- TODO: Create API method in WYSIWYG_Admin
// ----------------------------------------------
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'autoGrow_maxHeight', '400');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'autoGrow_minHeight', '200');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'autoGrow_onStartup', 'true');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'plugins', 'autogrow,codemirror,colorbutton,div,font,stylescombo');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'autoParagraph', 'false');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'codemirror_theme', 'default');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'contentsCss', 'editor.css');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'filemanager', 'fck');");
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'height', '250px');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'skin', 'moono');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'width', '100%');" );

// add files to class_secure
$addons_helper = CAT_Helper_Addons::getInstance();
if ( false === $addons_helper->sec_register_file( 'ckeditor4', '/ckeditor/filemanager/fck/browser/default/connectors/php/connector.php' ) )
{
     error_log( "Unable to register file -connector.php-!" );
}
if ( false === $addons_helper->sec_register_file( 'ckeditor4', '/ckeditor/plugins/cmsplink/dialogs/cmsplink.php' ) )
{
     error_log( "Unable to register file -cmsplink.php-!" );
}
if ( false === $addons_helper->sec_register_file( 'ckeditor4', '/ckeditor/plugins/droplets/dialogs/droplets.php' ) )
{
     error_log( "Unable to register file -droplets.php-!" );
}

?>
