<?php

/**
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         ckeditor4
 *
 */

// Include the config file
require_once('../../../../../../config.php');

/**
 * cleanup some items that may cause problems
 */
function droplet_clean_str(&$aStr) {
	$vars = array(
		'"' => "\\\"",
		'\'' => "",
		"\n" => "<br />",
		"\r" => "",
	);
	$string = str_replace( array_keys($vars), array_values($vars), $aStr);
    return strip_tags($string);
}

$droplets = CAT_Helper_Droplet::getDroplets();

foreach ( $droplets as $item )
{
	$title	= droplet_clean_str( $item['name'] );
	$desc	= droplet_clean_str( $item['description'] );
	$comm	= droplet_clean_str( $item['comments'] );
    $data[] = array( 'title' => $title, 'description' => $desc, 'comment' => $comm );
}

header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
header( "Content-Type: text/xml; charset:utf-8;" );
echo '<?'.'xml version="1.0" encoding="utf-8"'.'?'.'><data>';
foreach( $data as $item ) {
    echo '<element';
    foreach( $item as $key => $value ) {
        echo ' '.$key.'=\''.$value.'\'';
    }
    echo ' />';
}
echo '</data>';