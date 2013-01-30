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
 
// include class.secure.php to protect this file and the whole CMS!
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
// end include class.secure.php 

// ----------------------------------------------
// --- TODO: Create API method in WYSIWYG_Admin
// ----------------------------------------------
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'autoGrow_maxHeight', '400');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'autoGrow_minHeight', '200');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'autoParagraph', 'false');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'codemirror_theme', 'default');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'contentsCss', 'editor.css');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'height', '250px');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'skin', 'moono');" );
$database->query("REPLACE INTO `".CAT_TABLE_PREFIX."mod_wysiwyg_admin_v2` (`editor`, `set_name`, `set_value`) VALUES ('ckeditor4', 'width', '100%');" );

// add files to class_secure
$addons_helper = new CAT_Helper_Addons();
if ( false === $addons_helper->sec_register_file( 'ckeditor4', '/ckeditor/filemanager/browser/default/connectors/php/connector.php' ) )
{
     error_log( "Unable to register file -connector.php-!" );
}
 
?>
