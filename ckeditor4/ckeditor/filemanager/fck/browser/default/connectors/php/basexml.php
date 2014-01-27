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
 * These functions define the base of the XML response sent by the PHP
 * connector.
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

function SetXmlHeaders()
{
	ob_end_clean() ;

	// Prevent the browser from caching the result.
	// Date in the past
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
	// always modified
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
	// HTTP/1.1
	header('Cache-Control: no-store, no-cache, must-revalidate') ;
	header('Cache-Control: post-check=0, pre-check=0', false) ;
	// HTTP/1.0
	header('Pragma: no-cache') ;

	// Set the response format.
	header( 'Content-Type: text/xml; charset=utf-8' ) ;
}

function CreateXmlHeader( $command, $resourceType, $currentFolder )
{
	SetXmlHeaders() ;

	// Create the XML document header.
	echo '<?xml version="1.0" encoding="utf-8" ?>' ;

	// Create the main "Connector" node.
	echo '<Connector command="' . $command . '" resourceType="' . $resourceType . '">' ;

	// Add the current folder node.
	echo '<CurrentFolder path="' . ConvertToXmlAttribute( $currentFolder ) . '" url="' . ConvertToXmlAttribute( GetUrlFromPath( $resourceType, $currentFolder, $command ) ) . '" />' ;

	$GLOBALS['HeaderSent'] = true ;
}

function CreateXmlFooter()
{
	echo '</Connector>' ;
}

function SendError( $number, $text )
{
	if ( $_GET['Command'] == 'FileUpload' )
		SendUploadResults( $number, "", "", $text ) ;
	if ( isset( $GLOBALS['HeaderSent'] ) && $GLOBALS['HeaderSent'] )
	{
		SendErrorNode( $number, $text ) ;
		CreateXmlFooter() ;
	}
	else
	{
	SetXmlHeaders() ;

	// Create the XML document header
	echo '<?xml version="1.0" encoding="utf-8" ?>' ;

	echo '<Connector>' ;
	
	SendErrorNode(  $number, $text ) ;
	
	echo '</Connector>' ;
	}
	exit ;
}

function SendErrorNode(  $number, $text )
{
	if ($text)
	echo '<Error number="' . $number . '" text="' . htmlspecialchars( $text ) . '" />' ;
	else
		echo '<Error number="' . $number . '" />' ;
}
?>