<?php

/**
 *   @author          LEPTON v2.0 Black Cat Edition Development
 *   @copyright       2013, LEPTON v2.0 Black Cat Edition Development
 *   @link            http://www.lepton2.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        LEPTON2BCE_Modules
 *   @package         ckeditor4
 *
 */

// Include the config file
require_once('../../../../../../config.php');

/**
 * cleanup some items that may cause problems
 */
function droplep_clean_str(&$aStr) {
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
		$title	= droplep_clean_str( $droplet['name'] );
		$desc	= droplep_clean_str( $droplet['description'] );
		$comm	= droplep_clean_str( $droplet['comments'] );
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