/**
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
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