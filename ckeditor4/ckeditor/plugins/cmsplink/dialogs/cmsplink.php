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

// include class.secure.php to protect this file and the whole CMS!
if (defined('LEPTON_PATH')) {
	include(LEPTON_PATH.'/framework/class.secure.php');
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
require dirname(__FILE__).'/../../../../../../framework/LEPTON/Helper/ListBuilder.php';
$list = new LEPTON_Helper_ListBuilder(array('__id_key'=>'page_id','__title_key'=>'page_title','__select_class'=>'cke_dialog_ui_input_select','space'=>'--'));

header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
header( "Content-Type: text/xml; charset:utf-8;" );
echo '<?'.'xml version="1.0" encoding="utf-8"'.'?'.'><data>';
echo '<pageslist>', html_entity_decode( $list->dropdown( 'pageslist', $pages, 0 ) ), '</pageslist>';
echo '</data>';