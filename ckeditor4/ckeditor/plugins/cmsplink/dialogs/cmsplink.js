/**
 *   @author          LEPTON v2.0 Black Cat Edition Development
 *   @copyright       2013, LEPTON v2.0 Black Cat Edition Development
 *   @link            http://www.lepton2.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        LEPTON2BCE_Modules
 *   @package         ckeditor4
 *
 */

var prefix = 'cmsplink';

CKEDITOR.dialog.add( 'cmsplinkDlg', function( editor ) {
    var xml = CKEDITOR.ajax.loadXml( CKEDITOR.plugins.getPath( 'cmsplink' ) + 'dialogs/cmsplink.php' );
    var itemNodes = xml.selectNodes( 'data/pageslist/item' );
    var items = new Array();    // items array
    var pages = new Array();
    for ( var i = 0 ; i < itemNodes.length ; i++ ) {
        var node = itemNodes[i];
        items[i] = new Array( node.getAttribute("value"), node.getAttribute("id") );
        pages[node.getAttribute("id")] = node.getAttribute("value");
    }

    return {
        title: editor.lang.cmsplink.title,
        minWidth: 380,
        minHeight: 130,
        contents: [{
            id: 'tab1',
            label: 'Tab1',
            title: 'Tab1',
            elements : [{
                id: 'pageslist',
                type: 'select',
                label: editor.lang.cmsplink.page,
                items: items
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
            var dialog    = this;
            var selection = editor.getSelection().getSelectedText();
            var page_id   = dialog.getValueOf( 'tab1', 'pageslist' );
            var css_class = dialog.getValueOf( 'tab1', 'pagelinkclass' );
            var rel       = dialog.getValueOf( 'tab1', 'cmbRel' );
            var use_title = ( dialog.getValueOf( 'tab1', 'pagelinkusepagename' ) == 1 ? true : false );
            var insert    = '<a href="['+prefix+page_id+']" title="'+pages[page_id]+'"'+(rel==0?'':' rel="'+rel+'"')+(css_class==''?'':' class="'+css_class+'"')+'>'+(use_title?pages[page_id]:selection)+'</a>';
            editor.insertHtml(insert);
            return true;
        },
        resizable: 3
    };
});