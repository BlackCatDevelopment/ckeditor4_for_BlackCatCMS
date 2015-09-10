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
 *   @copyright       2015, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Core
 *   @package         CAT_Core
 *
 */

if (defined('CAT_PATH')) {
	include(CAT_PATH.'/framework/class.secure.php');
} else {
	$root = "../";
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= "../";
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) {
		include($root.'/framework/class.secure.php');
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}

// additional requirements for this plugin
$plugin_config = array(
    'opt' => array(
        array( 'name' => 'autogrow'          , 'label' => 'autoGrow Plugin'   , 'type' => 'legend' ),
        array( 'name' => 'autoGrow_minHeight', 'label' => 'Editor min. height', 'type' => 'text'   , 'default' => 200    ),
        array( 'name' => 'autoGrow_maxHeight', 'label' => 'Editor max. height', 'type' => 'text'   , 'default' => 400    ),
        array( 'name' => 'autoGrow_onStartup', 'label' => 'Activate autoGrow on startup', 'type' => 'boolean', 'default' => 'true' ),
    ),
);
