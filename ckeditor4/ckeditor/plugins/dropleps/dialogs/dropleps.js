/**
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
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
        title: editor.lang.dropleps.title,
        minWidth: 400,
        minHeight: 200,
        resizable: CKEDITOR.DIALOG_RESIZE_NONE,
        onOk: function() {
            var dialog = this;
         	var droplep_name = dialog.getValueOf( 'tab1', 'dropleps' );
            editor.insertText( droplep_name );
			return true;
        },
        contents: [
            {
                id:         'tab1',
                accessKey:  'C',
                elements: [
                    {
                        id          : 'dropleps',
                        type        : 'select',
                        label       : editor.lang.dropleps.label,
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
