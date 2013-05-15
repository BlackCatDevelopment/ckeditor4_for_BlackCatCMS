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
		"\r" => ""
	);
	return str_replace( array_keys($vars), array_values($vars), $aStr);
}

global $database;
$get_droplet = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_droplets` where `active`=1 ORDER BY `name`");

if($get_droplet->numRows() > 0) {
	/**
	 *	Loop through ...
	 */
	while(false != ($droplet = $get_droplet->fetchRow( MYSQL_ASSOC ) ) ) {
		$title	= droplet_clean_str( $droplet['name'] );
		$desc	= droplet_clean_str( $droplet['description'] );
		$comm	= droplet_clean_str( $droplet['comments'] );
        $data[] = array( 'title' => $title, 'description' => $desc, 'comment' => $comm );
    }
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