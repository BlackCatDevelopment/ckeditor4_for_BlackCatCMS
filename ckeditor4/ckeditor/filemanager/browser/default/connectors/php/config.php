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
 */

global $Config ;

// SECURITY: You must explicitelly enable this "connector". (Set it to "true").
$Config['Enabled'] = false ;


/**
*	SECURITY PATCH FOR WEBSITEBAKER (doc)
*	only enable PHP connector if user is authenticated to WB
*	and has at least permissions to view the WB MEDIA folder
*   Adapted for use with LEPTON2BCE
*/
// include WB config.php file and admin class
require_once('../../../../../../../config.php');
require_once(WB_PATH .'/framework/class.admin.php');

$wb_path = str_replace('\\','/', WB_PATH);
$wb_path = str_replace('//','/', WB_PATH);

// check if user is authenticated if WB and has permission to view MEDIA folder
$admin = new admin('Media', 'media_view', false, false);
if(($admin->get_permission('media_view') === true))
{
	// user allowed to view MEDIA folder -> enable PHP connector
	$Config['Enabled'] = true ;
	// allow actions to list folders and files
	$Config['ConfigAllowedCommands'] = array('GetFolders', 'GetFoldersAndFiles') ;
}

// Path to user files relative to the document root.
// $Config['UserFilesPath'] = '/userfiles/' ;
$Config['UserFilesPath'] = WB_URL.MEDIA_DIRECTORY.'/' ;
// use home folder of current user as document root if available
if(isset($_SESSION['HOME_FOLDER']) && file_exists($wb_path .MEDIA_DIRECTORY .$_SESSION['HOME_FOLDER'])){
   $Config['UserFilesPath'] = $Config['UserFilesPath'].$_SESSION['HOME_FOLDER'];
}

// Fill the following value it you prefer to specify the absolute path for the
// user files directory. Useful if you are using a virtual directory, symbolic
// link or alias. Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
// Attention: The above 'UserFilesPath' must point to the same directory.
// $Config['UserFilesAbsolutePath'] = '' ;

$Config['UserFilesAbsolutePath'] = $wb_path .MEDIA_DIRECTORY.'/' ;
// use home folder of current user as document root if available
if(isset($_SESSION['HOME_FOLDER']) && file_exists($wb_path .MEDIA_DIRECTORY .$_SESSION['HOME_FOLDER'])){
   $Config['UserFilesAbsolutePath'] = $Config['UserFilesAbsolutePath'].$_SESSION['HOME_FOLDER'].'/';
}

// Due to security issues with Apache modules, it is reccomended to leave the
// following setting enabled.
$Config['ForceSingleExtension'] = true ;

$Config['AllowedExtensions']['File']	= array() ;
$Config['DeniedExtensions']['File']		= array('html','htm','php','php2','php3','php4','php5','phtml','pwml','inc','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','com','dll','vbs','js','reg','cgi','htaccess','asis','sh','shtml','shtm','phtm') ;

$Config['AllowedExtensions']['Image']	= array('jpg','gif','jpeg','png') ;
$Config['DeniedExtensions']['Image']	= array() ;

$Config['AllowedExtensions']['Flash']	= array('swf','fla') ;
$Config['DeniedExtensions']['Flash']	= array() ;

$Config['AllowedExtensions']['Media']	= array('swf','fla','jpg','gif','jpeg','png','avi','mpg','mpeg') ;
$Config['DeniedExtensions']['Media']	= array() ;

?>