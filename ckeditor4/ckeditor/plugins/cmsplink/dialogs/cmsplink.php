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

global $database;

// Include the config file
require_once('../../../../../../config.php');

// get pages
require dirname(__FILE__).'/../../../../../../framework/class.pages.php';
$pg = new pages();
$pages = $pg->make_list();

// List helper
require dirname(__FILE__).'/../../../../../../framework/CAT/Helper/ListBuilder.php';
$list = new CAT_Helper_ListBuilder(array('__id_key'=>'page_id'));
$items = $list->sort( $pages, 0 );

header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
header( "Content-Type: text/xml; charset:utf-8;" );
echo '<?'.'xml version="1.0" encoding="utf-8"'.'?'.'><data>';
echo '<pageslist>';
foreach( $items as $i => $item ) {
    echo '<item id="'.$item['page_id'].'" value="'.$item['menu_title'].'" />';
}
echo '</pageslist></data>';