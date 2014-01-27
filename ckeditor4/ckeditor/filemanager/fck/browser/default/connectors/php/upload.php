<?php
/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2010 Frederico Caldeira Knabben
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
 * This is the "File Uploader" for PHP.
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

require('./config.php') ;
require('./util.php') ;
require('./io.php') ;
require('./commands.php') ;
require('./phpcompat.php') ;

function SendError( $number, $text )
{
	SendUploadResults( $number, '', '', $text ) ;
}

// Check if this uploader has been enabled.
if ( !$Config['Enabled'] )
	SendUploadResults( '1', '', '', 'This file uploader is disabled. Please check the "editor/filemanager/connectors/php/config.php" file' ) ;

$sCommand = 'QuickUpload' ;

// The file type (from the QueryString, by default 'File').
$sType = isset( $_GET['Type'] ) ? $_GET['Type'] : 'File' ;

$sCurrentFolder	= "/" ;

// Is enabled the upload?
if ( ! IsAllowedCommand( $sCommand ) )
	SendUploadResults( '1', '', '', 'The ""' . $sCommand . '"" command isn\'t allowed' ) ;

// Check if it is an allowed type.
if ( !IsAllowedType( $sType ) )
    SendUploadResults( 1, '', '', 'Invalid type specified' ) ;

// Get the CKEditor Callback
$CKEcallback = $_GET['CKEditorFuncNum'];

//pass it on to file upload function
FileUpload( $sType, $sCurrentFolder, $sCommand, $CKEcallback );

?>