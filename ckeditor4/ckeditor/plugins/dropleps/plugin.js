/**
 *   @author          LEPTON v2.0 Black Cat Edition Development
 *   @copyright       2013, LEPTON v2.0 Black Cat Edition Development
 *   @link            http://www.lepton2.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        LEPTON2BCE_Modules
 *   @package         ckeditor4
 *
 */

CKEDITOR.plugins.add( 'dropleps', {
    lang : ['en','de'],
    icons: 'dropleps',
    init: function( editor ) {
        editor.addCommand( 'droplepsDialog', new CKEDITOR.dialogCommand( 'droplepsDialog' ) );
        editor.ui.addButton( 'dropleps', {
            label: 'Insert DropLep',
            command: 'droplepsDialog',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'droplepsDialog', this.path + 'dialogs/dropleps.js' );
    }
});

CKEDITOR.plugins.setLang( 'dropleps', 'en', {
    title : 'Insert DropLep',
    label : 'Available DropLeps'
});

CKEDITOR.plugins.setLang( 'dropleps', 'de', {
    title : 'DropLep einfügen',
    label : 'Verfügbare DropLeps'
});