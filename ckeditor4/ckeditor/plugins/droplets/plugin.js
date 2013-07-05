/**
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         ckeditor4
 *
 */

CKEDITOR.plugins.add( 'droplets', {
    lang : ['en','de'],
    icons: 'droplets',
    init: function( editor ) {
        editor.addCommand( 'dropletsDialog', new CKEDITOR.dialogCommand( 'dropletsDialog' ) );
        editor.ui.addButton( 'droplets', {
            label: 'Insert Droplet',
            command: 'dropletsDialog',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'dropletsDialog', this.path + 'dialogs/droplets.js' );
    }
});

CKEDITOR.plugins.setLang( 'droplets', 'en', {
    title : 'Insert Droplet',
    label : 'Available Droplets'
});

CKEDITOR.plugins.setLang( 'droplets', 'de', {
    title : 'Droplet einfügen',
    label : 'Verfügbare Droplets'
});