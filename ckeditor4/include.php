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
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         ckeditor4
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

/**
 *	Function called by parent, default by the wysiwyg-module
 *	
 * @access public
 * @param  string  $name    - textarea name
 * @param  string  $id      - textarea id
 * @param  string  $content - textarea content
 * @param  string  $width   - width - overloaded by settings
 * @param  string  $height  - height - overloaded by settings
 * @param  boolean $print   - direct print (default) or return string
 **/
function show_wysiwyg_editor($name, $id, $content, $width = '100%', $height = '250px', $print = true) {

    // get settings
    $query  = "SELECT * from `%smod_wysiwyg_admin_v2` where `editor`='%s'";
    $result = CAT_Helper_Array::getInstance()->db()->query(sprintf($query,CAT_TABLE_PREFIX,WYSIWYG_EDITOR));
    $config = array();
    $css    = array();
    $plugins = NULL;
    $filemanager_dirname = $filemanager_include = $filemanager_plugin = $toolbar = NULL;
    if($result->numRows())
    {
        while( false !== ( $row = $result->fetchRow(MYSQL_ASSOC) ) )
        {
            switch( $row['set_name'] )
            {
                case 'contentsCss':
                    if ( substr_count($row['set_value'],',') )
                        $css = explode(',',$row['set_value']);
                    else
                        $css = array($row['set_value']);
                    break;
                case 'plugins':
                    $plugins = $row['set_value'];
                    break;
                case 'filemanager':
                    $filemanager_dirname = $row['set_value'];
                    $infofile = sanitize_path(dirname(__FILE__).'/ckeditor/filemanager/'.$filemanager_dirname.'/info.php');
                    if(file_exists($infofile))
                    {
                        $filemanager_include = NULL;
                        @include $infofile;
                        if($filemanager_include)
                        {
                            $filemanager_include = str_replace('{$CAT_URL}',CAT_URL,$filemanager_include);
                        }
                    }
                    break;
                case 'toolbar':
                    if($row['set_value'] !== 'Full')
                        $toolbar = $row['set_value'];
                    break;
                default:
                    if ( substr_count( $row['set_value'], '#####' ) ) // array values
                        $row['set_value'] = explode( '#####', $row['set_value'] );
                    $config[] = $row;
                    break;
            }   // end switch
        }
    }

    if(count($css))
    {
        foreach( $css as $i => $file )
        {
            if( file_exists(sanitize_path(CAT_PATH.'/templates/'.DEFAULT_TEMPLATE.'/'.$file)) )
                $css[$i] = sanitize_url(CAT_URL.'/templates/'.DEFAULT_TEMPLATE.'/'.$file);
            elseif( file_exists(sanitize_path(CAT_PATH.'/templates/'.DEFAULT_TEMPLATE.'/css/'.$file)) )
                $css[$i] = sanitize_url(CAT_URL.'/templates/'.DEFAULT_TEMPLATE.'/css/'.$file);
            elseif( defined('DEFAULT_TEMPLATE_VARIANT') && file_exists(sanitize_path(CAT_PATH.'/templates/'.DEFAULT_TEMPLATE.'/css/'.DEFAULT_TEMPLATE_VARIANT.'/'.$file)) )
                $css[$i] = sanitize_url(CAT_URL.'/templates/'.DEFAULT_TEMPLATE.'/css/'.DEFAULT_TEMPLATE_VARIANT.'/'.$file);
            elseif( file_exists(sanitize_path(CAT_PATH.'/templates/'.DEFAULT_TEMPLATE.'/css/default/'.$file)) )
                $css[$i] = sanitize_url(CAT_URL.'/templates/'.DEFAULT_TEMPLATE.'/css/default/'.$file);
            elseif( file_exists(sanitize_path(dirname(__FILE__).'/config/custom/'.$file)) )
                $css[$i] = sanitize_url(CAT_URL.'/modules/ckeditor4/config/custom/'.$file );
            elseif( file_exists(sanitize_path(dirname(__FILE__).'/config/default/'.$file)) )
                $css[$i] = sanitize_url(CAT_URL.'/modules/ckeditor4/config/default/'.$file );
            else
                unset($css[$i]);
        }
    }

    if($filemanager_plugin)
    {
        $plugins = ( $plugins == '' )
                 ? $filemanager_plugin
                 : $plugins.','.$filemanager_plugin;
    }

    global $parser;
    $parser->setPath(realpath(dirname(__FILE__).'/templates/default'));
    $output = $parser->get(
        'wysiwyg',
        array(
            'name'    => $name,
            'id'      => $id,
            'width'   => $width,
            'height'  => $height,
            'config'  => $config,
            'plugins' => $plugins,
            'toolbar' => $toolbar,
            'css'     => implode( '\', \'', $css ),
            'content' => htmlspecialchars(str_replace(array('&gt;','&lt;','&quot;','&amp;'),array('>','<','"','&'),$content)),
            'filemanager_include' => $filemanager_include,
        )
    );
    if($print) echo $output;
    return $output;
}
?>