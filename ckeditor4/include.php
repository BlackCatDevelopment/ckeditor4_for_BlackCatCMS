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
 *   @copyright       2013 - 2015 Black Cat Development
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
    $query   = "SELECT * from `:prefix:mod_wysiwyg_admin_v2` where `editor`=:name";
    $result  = CAT_Helper_Array::getInstance()->db()->query($query,array('name'=>WYSIWYG_EDITOR));
    $config  = array();
    $css     = array();
    $plugins = NULL;
    $filemanager_dirname = $filemanager_include = $filemanager_plugin = $toolbar = NULL;
    if($result->rowCount())
    {
        while( false !== ( $row = $result->fetch() ) )
        {
            switch( $row['set_name'] )
            {
                case 'allowedContent':
                    if($row['set_value'] == 'true')
                        $config[] = array('set_name'=>'allowedContent','set_value'=>true);
                    break;
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

        global $page_id;
        $variant  = CAT_Helper_Page::getPageSettings($page_id,'internal','template_variant');
        if(!$variant)
            $variant = ( defined('DEFAULT_TEMPLATE_VARIANT') && DEFAULT_TEMPLATE_VARIANT != '' )
                     ? DEFAULT_TEMPLATE_VARIANT
                     : 'default';

        $paths = array(
            CAT_PATH.'/templates/'.DEFAULT_TEMPLATE.'/css/'.$variant,
            CAT_PATH.'/templates/'.DEFAULT_TEMPLATE.'/css/default',
            CAT_PATH.'/templates/'.DEFAULT_TEMPLATE.'/css',
            CAT_PATH.'/templates/'.DEFAULT_TEMPLATE,
            dirname(__FILE__).'/config/custom',
            dirname(__FILE__).'/config/default',
        );

        foreach( $css as $i => $file )
        {
            foreach($paths as $path)
            {
                $filename = CAT_Helper_Directory::sanitizePath($path.'/'.$file);
                if(file_exists($filename))
                {
                    $css[$i] = str_ireplace(CAT_Helper_Directory::sanitizePath(CAT_PATH),CAT_URL,$filename);
                    continue 2;
                }
            }
        }
    }

    if(file_exists(CAT_Helper_Directory::sanitizePath(CAT_PATH.'/templates/'.DEFAULT_TEMPLATE.'/js/styles.js')))
    {
        $config[] = array(
            'set_name' => 'stylesSet',
            'set_value' => DEFAULT_TEMPLATE.':'.CAT_URL.'/templates/'.DEFAULT_TEMPLATE.'/js/styles.js'
        );
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