/**
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         ckeditor4
 *
 */

CKEDITOR.dialog.add( 'dropletsDialog', function ( editor ) {
    var xml = CKEDITOR.ajax.loadXml( CKEDITOR.plugins.getPath( 'droplets' ) + 'dialogs/droplets.php' );
    var myRegexp = /\[\[(\w+\?[\w=]+)\]\]/;
    var itemNodes = xml.selectNodes( 'data/element' );
    var items = new Array();    // items array
    var desc = new Array();     // descriptions
    var comments = new Array(); // comments
    var usage = new Array();      // editable usage
    for ( var i = 0 ; i < itemNodes.length ; i++ ) {
        items[i] = new Array( "[[" + itemNodes[i].getAttribute("title") + "]]" );
        desc["[[" + itemNodes[i].getAttribute("title") + "]]"]  = itemNodes[i].getAttribute("description");
        comments["[[" + itemNodes[i].getAttribute("title") + "]]"]  = itemNodes[i].getAttribute("comment");
        var match = myRegexp.exec(itemNodes[i].getAttribute("comment"));
        if (match != null) {
            usage["[[" + itemNodes[i].getAttribute("title") + "]]"] = match[0];
        }
        else {
            usage["[[" + itemNodes[i].getAttribute("title") + "]]"] = "[[" + itemNodes[i].getAttribute("title") + "]]";
        }
    }

    return {
        title: editor.lang.droplets.title,
        minWidth: 400,
        minHeight: 200,
        resizable: CKEDITOR.DIALOG_RESIZE_NONE,
        onOk: function() {
            var dialog = this;
         	var droplet_name = dialog.getValueOf( 'tab1', 'droplet_edit' );
            if(!droplet_name.length) {
                droplet_name = dialog.getValueOf( 'tab1', 'droplets' );
            }
            editor.insertText( droplet_name );
			return true;
        },
        contents: [
            {
                id:         'tab1',
                accessKey:  'C',
                elements: [
                    {
                        id          : 'droplets',
                        type        : 'select',
                        label       : editor.lang.droplets.label,
                        labelStyle  : 'font-weight:bold',
                        items       : items,
                        onMouseUp: function() {
							var droplet_name = this.getValue();
							document.getElementById("droplet_info").innerHTML = desc[droplet_name];
                            document.getElementById("droplet_comment").innerHTML = comments[droplet_name];
                            if(droplet_name in usage) {
                                var dialog = this.getDialog();
                                dialog.getContentElement( 'tab1', 'droplet_edit' ).setValue(usage[droplet_name]);
                            }
						},
						onShow: function() {
							this.onMouseUp();
						}
                    },
                    {
                        id: 'droplet_info_label',
                        type: 'html',
                        html: '<strong>' + editor.lang.droplets.descr +':</strong>'
                    },
                    {
                    	id: 'droplet_info_box',
                    	type: 'html',
                        style: 'white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word;',
                    	html: "<div id='droplet_info'>&nbsp;</div>"
                    },
                    {
                        id: 'droplet_comment_label',
                        type: 'html',
                        html: '<strong>' + editor.lang.droplets.comment + ':</strong>'
                    },
                    {
                    	id: 'droplet_comment_box',
                    	type: 'html',
                        style: 'white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word;',
                    	html: "<div id='droplet_comment'>&nbsp;</div>"
                    },
                    {
                        id: 'droplet_edit',
                        type: 'text',
                        label: editor.lang.droplets.edit,
                        labelStyle: 'font-weight:bold',
                        labelLayout: 'vertical'
                    }

                ]
            }
        ]
    };
});
