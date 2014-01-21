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
 *   @package         ckeditor
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('CAT_PATH')) {	
	include(CAT_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

$filemanager_name = 'FCKEditor Filemanager';
$filemanager_dirname = 'fck';
$filemanager_version = '-';
$filemanager_sourceurl = '-';
$filemanager_registerfiles = array(
    '/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/connectors/php/connector.php',
    '/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/connectors/php/upload.php'
);
$filemanager_include = "
    ,filebrowserBrowseUrl : '{\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/browser.html?Connector={\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/connectors/php/connector.php'
    ,filebrowserImageBrowseUrl : '{\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/browser.html?Type=Image&amp;Connector={\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/connectors/php/connector.php'
    ,filebrowserFlashBrowseUrl : '{\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/browser.html?Type=Flash&amp;Connector={\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/connectors/php/connector.php'
    ,filebrowserUploadUrl  : '{\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/connectors/php/upload.php?Type=File'
	,filebrowserImageUploadUrl : '{\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/connectors/php/upload.php?Type=Image'
    ,filebrowserFlashUploadUrl : '{\$CAT_URL}/modules/ckeditor4/ckeditor/filemanager/fck/browser/default/connectors/php/upload.php?Type=Flash'
";