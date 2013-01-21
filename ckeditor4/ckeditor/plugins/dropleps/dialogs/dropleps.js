/**
 *   @author          LEPTON v2.0 Black Cat Edition Development
 *   @copyright       2013, LEPTON v2.0 Black Cat Edition Development
 *   @link            http://www.lepton2.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        LEPTON2BCE_Modules
 *   @package         ckeditor4
 *
 */

CKEDITOR.dialog.add( 'droplepsDialog', function ( editor ) {
    var xml = CKEDITOR.ajax.loadXml( CKEDITOR.plugins.getPath( 'dropleps' ) + 'dialogs/dropleps.php' );
    var itemNodes = xml.selectNodes( 'data/element' );
    var items = new Array();    // items array
    var desc = new Array();
    var comments = new Array();
    for ( var i = 0 ; i < itemNodes.length ; i++ ) {
        items[i] = new Array( "[[" + itemNodes[i].getAttribute("title") + "]]" );
        desc["[[" + itemNodes[i].getAttribute("title") + "]]"]  = itemNodes[i].getAttribute("description");
        comments["[[" + itemNodes[i].getAttribute("title") + "]]"]  = itemNodes[i].getAttribute("comment");
    }

    return {
        title: 'Choose a DropLep',
        minWidth: 400,
        minHeight: 200,
        resizable: CKEDITOR.DIALOG_RESIZE_NONE,
        onOk: function() {
            var dialog = this;
         	var droplep_name = dialog.getValueOf( 'tab1', 'dropleps' )
            editor.insertText( droplep_name );
			return true;
        },
        contents: [
            {
                id:         'tab1',
                label:      i18n('Choose a DropLep','#cke_dialog_title_75'),
                title:      'Choose a DropLep',
                accessKey:  'C',
                elements: [
                    {
                        id          : 'dropleps',
                        type        : 'select',
                        label       : i18n('Available DropLeps','#cke_81_label'),
                        labelLayout : 'horizontal',
                        items       : items,
                        onMouseUp: function() {
							var droplep_name = this.getValue();
							document.getElementById("droplep_info").innerHTML = desc[droplep_name];
                            document.getElementById("droplep_comment").innerHTML = comments[droplep_name];
						},
						onShow: function() {
							this.onMouseUp();
						}
                    },
                    {
                    	id: 'droplep_info_box',
                    	type: 'html',
                        style: 'white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word;',
                    	html: "<div id='droplep_info'>&nbsp;</div>"
                    },
                    {
                    	id: 'droplep_comment_box',
                    	type: 'html',
                        style: 'white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word;',
                    	html: "<div id='droplep_comment'>&nbsp;</div>"
                    }
                ]
            }
        ]
    };
});

