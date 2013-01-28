/**
 *   @author          LEPTON v2.0 Black Cat Edition Development
 *   @copyright       2013, LEPTON v2.0 Black Cat Edition Development
 *   @link            http://www.lepton2.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        LEPTON2BCE_Modules
 *   @package         ckeditor4
 *
 */

CKEDITOR.dialog.add( 'cmsplinkDlg', function( editor ) {
    var xml = CKEDITOR.ajax.loadXml( CKEDITOR.plugins.getPath( 'cmsplink' ) + 'dialogs/cmsplink.php' );

    return {
        title: editor.lang.cmsplink.title,
        minWidth: 380,
        minHeight: 130,
        contents: [{
            id: 'tab1',
            label: 'Tab1',
            title: 'Tab1',
            elements : [{
                type: 'html',
                html: '<label class="cke_dialog_ui_labeled_label" for="pageslist">' + editor.lang.cmsplink.page + '</label><div class="cke_dialog_ui_labeled_content" role="presentation"><div class="cke_dialog_ui_input_select" role="presentation">' + xml.getInnerXml( 'data/pageslist' ) + '</div></div>'
            }, {
            	id: 'pagelinkclass',
            	type: 'text',
            	label: editor.lang.cmsplink.cssclass,
            }, {
            	id: 'pagelinkusepagename',
            	type: 'checkbox',
            	label: editor.lang.cmsplink.usepagetitle,
				value: 1,
            },{
				id: 'cmbRel',
				type: 'select',
				label: editor.lang.cmsplink.advrel,
				items:
				[
					[ editor.lang.cmsplink.notset,	0 ],
					[ "Fancybox",	"fancybox" ],
					[ "Lightbox",	"lightbox" ],
					[ "PrettyPhoto","prettyPhoto" ],
					[ "Alternate",	"alternate" ],
					[ "Copyright",	"copyright" ],
					[ "Designates",	"designates" ],
					[ "No follow",	"nofollow" ],
					[ "Stylesheet",	"stylesheet" ],
					[ "Thumbnail",	"thumbnail" ]
				],
				setup: function ( obj ) {
					if ( obj.adv['advRel'] ) this.setValue( obj.adv['advRel'] );
				}
			}] // end elements
        }], // end contents
        onOk: function() {
            return true;
        },
        resizable: 3
    };
});