<?php
/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2007 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Configuration file for the File Manager Connector for PHP.
 *
 *
 * Adapted for use with BlackCat CMS by Black Cat Development:
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

if(!defined('CAT_PATH'))
    require dirname(__FILE__).'/../../../../../../../../config.php';

$backend = CAT_Backend::getInstance('media','media',false,false);
$user    = CAT_Users::getInstance();
$dir     = CAT_Helper_Directory::getInstance();

global $Config ;

// SECURITY: You must explicitelly enable this "connector". (Set it to "true").
$Config['Enabled'] = false ;

/**
*	SECURITY PATCH
*   Only enable this connector if the user is authenticated (=logged in) and
*   has the appropriate permissions
*/

$base_path = CAT_PATH;

if(($user->get_permission('media_view') === true))
{
	// user allowed to view MEDIA folder -> enable PHP connector
	$Config['Enabled'] = true ;
	// add view actions to allowed commands
	$Config['ConfigAllowedCommands'] = array('GetFolders', 'GetFoldersAndFiles') ;
}
// check if user is allowed to upload files to the media directory
if(($user->get_permission('media_upload') === true)) {
	// add actions to upload files to the MEDIA folder
	array_push($Config['ConfigAllowedCommands'], 'FileUpload', 'QuickUpload');
}
// check if user is allowed to create new folders in the media directory
if(($user->get_permission('media_create') === true)) {
	// add action to create new folders in the MEDIA folder
	array_push($Config['ConfigAllowedCommands'], 'CreateFolder');
}

$val = CAT_Helper_Validate::getInstance();
if(method_exists($val,'getURI')) {
    $url = $val->getURI(CAT_URL); // for scheme relative URLs in BC >= v1.1
} else {
    $url = CAT_URL;
}

$Config['UserFilesPath']         = $url.MEDIA_DIRECTORY.'/';
$Config['UserFilesAbsolutePath'] = $dir->sanitizePath($base_path.MEDIA_DIRECTORY).'/';

// use home folder of current user as document root if available
if(isset($_SESSION['HOME_FOLDER']) && file_exists($base_path.MEDIA_DIRECTORY.$_SESSION['HOME_FOLDER']))
{
   $Config['UserFilesPath']         = $Config['UserFilesPath'].$_SESSION['HOME_FOLDER'].'/';
   $Config['UserFilesAbsolutePath'] = $dir->sanitizePath($Config['UserFilesAbsolutePath'].$_SESSION['HOME_FOLDER']).'/';
}

$Config['ForceSingleExtension']         = true;
$Config['SecureImageUploads']           = true;
$Config['ConfigAllowedTypes']           = array('File', 'Image', 'Flash', 'Media');
$Config['AllowedExtensions']['File']	= array('pdf','zip','gzip','gz');
$Config['DeniedExtensions']['File']		= array();
$Config['AllowedExtensions']['Image']	= array('jpg','gif','jpeg','png','tif');
$Config['DeniedExtensions']['Image']	= array();
$Config['AllowedExtensions']['Flash']	= array('swf','fla');
$Config['DeniedExtensions']['Flash']	= array();
$Config['AllowedExtensions']['Media']
    = array_merge(
        $Config['AllowedExtensions']['Image'],
        $Config['AllowedExtensions']['Flash'],
        array('avi','mpg','mpeg')
    );
$Config['DeniedExtensions']['Media']	= array() ;
$Config['HtmlExtensions']               = array("html", "htm", "xml", "xsd", "txt", "js");

// set all paths to the same value
$Config['FileTypesPath']['File']			= $Config['UserFilesPath'];
$Config['FileTypesAbsolutePath']['File']	= $Config['UserFilesAbsolutePath'];
$Config['QuickUploadPath']['File']			= $Config['UserFilesPath'];
$Config['QuickUploadAbsolutePath']['File']	= $Config['UserFilesAbsolutePath'];
$Config['FileTypesPath']['Image'] 			= $Config['UserFilesPath'];
$Config['FileTypesAbsolutePath']['Image'] 	= $Config['UserFilesAbsolutePath'];
$Config['QuickUploadPath']['Image'] 		= $Config['UserFilesPath'];
$Config['QuickUploadAbsolutePath']['Image']	= $Config['UserFilesAbsolutePath'];
$Config['FileTypesPath']['Flash']			= $Config['UserFilesPath'];
$Config['FileTypesAbsolutePath']['Flash'] 	= $Config['UserFilesAbsolutePath'];
$Config['QuickUploadPath']['Flash']			= $Config['UserFilesPath'];
$Config['QuickUploadAbsolutePath']['Flash']	= $Config['UserFilesAbsolutePath'];
$Config['FileTypesPath']['Media']			= $Config['UserFilesPath'] . '' ;
$Config['FileTypesAbsolutePath']['Media']	= $Config['UserFilesAbsolutePath'];
$Config['QuickUploadPath']['Media']			= $Config['UserFilesPath'];
$Config['QuickUploadAbsolutePath']['Media']	= $Config['UserFilesAbsolutePath'];

?>