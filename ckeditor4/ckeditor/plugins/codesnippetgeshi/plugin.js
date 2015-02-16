/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

 /**
 * @fileOverview Rich code snippets for CKEditor using GeSHi syntax highlighter (http://qbnz.com/highlighter/).
 */

'use strict';

( function() {
	CKEDITOR.plugins.add( 'codesnippetgeshi', {
		requires: 'ajax,codesnippet',

		init: function( editor ) {
			var writer = new CKEDITOR.htmlParser.basicWriter(),
				geSHiHighlighter = new CKEDITOR.plugins.codesnippet.highlighter( {
					languages: languages,
					highlighter: function( code, language, callback ) {
						// AJAX data to be sent in the request.
						var requestConfig = JSON.stringify( {
							lang: language,
							html: code
						} );

						// We need to pass an empty string if config.codesnippet is not defined,
						// because CKEDITOR#getUrl expects a String.
						CKEDITOR.ajax.post( CKEDITOR.getUrl( editor.config.codeSnippetGeshi_url || '' ), requestConfig, 'application/json', function( highlighted ) {
							// If no response is given it means that we have i.e. 404, so we'll set
							// empty content.
							if ( !highlighted ) {
								callback( '' );
								return;
							}

							var fragment = CKEDITOR.htmlParser.fragment.fromHtml( highlighted || '' );

							// GeSHi returns <pre> as a top-most element. Since <pre> is
							// already a part of the widget, consider children only.
							fragment.children[ 0 ].writeChildrenHtml( writer );

							// Return highlighted code.
							callback( writer.getHtml( true ) );
						} );
					}
				} );

			editor.plugins.codesnippet.setHighlighter( geSHiHighlighter );
		}
	} );

	// A list of default languages supported by GeSHi.
	var languages = {
		apache: 'Apache Configuration',
		css: 'Cascading Style Sheets (CSS)',
		diff: 'Diff',
		div: 'DIV',
		html4strict: 'HTML',
		html5: 'HTML5',
		javascript: 'JavaScript',
		'php-brief': 'PHP-brief',
		php: 'PHP',
		sql: 'SQL',
		xml: 'XML',
	};
} )();

/**
 * Sets GeSHi URL which, once queried with Ajax, will return highlighted code.
 *
 *		config.codeSnippetGeshi_url = 'http:\/\/example.com\/geshi\/colorize.php';
 *
 * Check the [Code Snippet GeSHi documentation](#!/guide/dev_codesnippetgeshi) for
 * more information.
 *
 * @cfg {String} [codeSnippetGeshi_url=null]
 * @member CKEDITOR.config
 */
