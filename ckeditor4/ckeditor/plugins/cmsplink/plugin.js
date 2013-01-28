/**
 *   @author          LEPTON v2.0 Black Cat Edition Development
 *   @copyright       2013, LEPTON v2.0 Black Cat Edition Development
 *   @link            http://www.lepton2.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        LEPTON2BCE_Modules
 *   @package         ckeditor4
 *
 */

CKEDITOR.plugins.add( 'cmsplink', {
    lang : ['en','de'],
    icons: 'cmsplink',
    init: function( editor ) {
        editor.addCommand( 'cmsplinkDlg', new CKEDITOR.dialogCommand( 'cmsplinkDlg' ) );
        editor.ui.addButton( 'cmsplink', {
            label: editor.lang.cmsplink.btnlabel,
            command: 'cmsplinkDlg',
            toolbar: 'links'
        });
        CKEDITOR.dialog.add( 'cmsplinkDlg', this.path + 'dialogs/cmsplink.js' );
    }
});

CKEDITOR.plugins.setLang( 'cmsplink', 'en', {
    btnlabel     : 'Insert/Edit internal link',
    title        : 'Insert internal link',
    name         : 'Insert internal link',
    page         : 'Page',
    cssclass     : 'CSS-Class',
    usepagetitle : 'use pagetitle',
    advrel       : 'Advisory Relation',
    notset       : 'Not set'
});

CKEDITOR.plugins.setLang( 'cmsplink', 'de', {
    btnlabel     : 'Internen Seitenlink einfügen/ändern',
    title        : 'Internen Link einfügen',
    name         : 'Internen Link einfügen',
    page         : 'Seite',
    cssclass     : 'CSS-Klasse',
    usepagetitle : 'Benutze Seitentitel',
    advrel       : '&lt;rel&gt; Auswahl',
    notset       : 'Nicht gesetzt'
});