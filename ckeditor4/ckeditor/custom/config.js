/**
 *
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         ckeditor4
 *
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
    config.toolbar_Smart =
        [
            { name: 'line1', groups: [ 'undo', 'font' ], items: [ 'Undo', 'Redo', 'Format', 'Font', 'FontSize', 'Styles', '-', 'About', 'Source', '-', 'Maximize' ] },
            '/',
            { name: 'line2', items: [
                'Bold', 'Italic', 'Underline', 'Strike', '-',
                'Subscript', 'Superscript', '-',
                'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',
                'Outdent', 'Indent', 'Blockquote', '-',
                'TextColor', 'BGColor', '-',
                'BulletedList', 'NumberedList', '-',
                'Link', 'Unlink', 'Anchor', 'Image', 'cmsplink', '-',
            ]}
        ];
    config.toolbar_Simple =
        [
            { name: 'line2', items: [
                'Bold', 'Italic', 'Underline', 'Strike', '-',
                'Subscript', 'Superscript', '-',
                'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',
                'Outdent', 'Indent', 'Blockquote', '-',
                'TextColor', 'BGColor', '-',
                'BulletedList', 'NumberedList', '-',
                'Link', 'Unlink', 'Anchor', 'Image', 'cmsplink', '-',
            ]}
        ];
    config.removePlugins = 'forms,language,iframe';

    config.extraAllowedContent ={
        'div span p a em strong ': {
            attributes: ['itemscope','itemtype','itemprop'],
        },
        'time':{
            attributes: ['itemprop','datetime']
        }
    };

};
