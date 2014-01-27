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

$module_description = 'CKEditor 4.1.3; CKE ist ein WYSIWYG Editor und kann sowohl im Backend als auch im Frontend verwendet werden';

$LANG = array(
    'Choose a Droplet' => 'Droplet wählen',
    'Available Droplets' => 'Verfügbare Droplets',
    'Comment' => 'Kommentar',
    'insertpre_class' => 'CSS Klasse für &lt;pre&gt; Element',
    'insertpre_style' => 'Style-Angabe(n) für &lt;pre&gt; Element',
    'allowedContent' => 'Advanced Content Filter (ACF) deaktivieren (Details hierzu siehe <a href="http://docs.ckeditor.com/#!/guide/dev_advanced_content_filter">http://docs.ckeditor.com/#!/guide/dev_advanced_content_filter</a>)',
    'autoParagraph' => 'Bestimmt, ob Inline-Inhalte innerhalb des Body in Blöcke eingefaßt werden.',
    'autoGrow_minHeight' => '<span style="color:red;">Erfordert autogrow Plugin</span> Minimale Höhe des Eingabebereichs bei Verwendung von autoGrow',
    'autoGrow_maxHeight' => '<span style="color:red;">Erfordert autogrow Plugin</span> Maximale Höhe des Eingabebereichs bei Verwendung von autoGrow',
    'autoGrow_onStartup' => '<span style="color:red;">Erfordert autogrow Plugin</span> Beim Start ausführen',
    'codemirror_theme' => '<span style="color:red;">erfordert codemirror Plugin</span> CodeMirror Skin - wird bei der Quelltextansicht verwendet',
    'contentsCss' => 'CSS Datei(en) für das Styling der Editorinhalte. Diese sollte(n) zum Frontend-Template passen. Mehrere Dateien mit Komma separieren.',
    'CKEditor v4.0 does not have traditional toolbars. See <a href="http://docs.ckeditor.com/#!/guide/dev_toolbar">'
    . 'http://docs.ckeditor.com/#!/guide/dev_toolbar</a> to learn how to configure the toolbar.'
        =>  'CKEditor v4.0 besitzt keine traditionellen Toolbars mehr. Lesen Sie die Dokumentation unter '
          . '<a href="http://docs.ckeditor.com/#!/guide/dev_toolbar">http://docs.ckeditor.com/#!/guide/dev_toolbar</a>'
          . ' für nähere Informationen.',
);