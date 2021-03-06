var oListManager = new Object() ;

oListManager.Clear = function()
{
	document.body.innerHTML = '' ;
}

// Build the link to view the folder.
oListManager.GetFolderRowHtml = function( folderName, folderPath )
{
	var sLink = '<a href="#" onclick="OpenFolder(\'' + ProtectPath( folderPath ) + '\');return false;">' ;
	return 	'<div class="file" title="'+ folderName +'">' +
			'<div>' + sLink +
			'<img class="icon" alt="" src="images/FolderBig.png" border="0" width="48" height="48" ><\/a>' +
			'<\/div>' +
            '<br /><div class="filename">'+ sLink + folderName +'<\/a>' + '<\/div>' +
            '<\/div>';
}

// Build the link to view the folder.
oListManager.GetFileRowHtml = function( fileName, fileUrl, fileSize ){

	var sLink = '<a href="#" onclick="OpenFile(\'' + ProtectPath( fileUrl ) + '\');return false;">' ;
	var relLink = '<a href="'+ fileUrl +'" rel="lightbox">' ;

	// Get the file icon.
	var sIcon = oIcons.GetIcon( fileName ) ;

	if( sIcon == 'gif' || sIcon == 'jpg' || sIcon == 'jpeg' || sIcon == 'png' ){
		var imgTag = '<img class="thumb" alt="" src="' + fileUrl + '" />' ;
	}
	else {
		var imgTag = '<img class="icon" alt="" src="images/icons/' + sIcon + '.gif" />';
	}

    return '<div class="file" title="'+ fileName +'">' +
		'<span class="fSize">' +
		'<nobr><img alt="' + sIcon + '" title="' + sIcon + '" src="images/icons/' + sIcon + '.gif" width="16" height="16" border="0"> '
		+ fileSize +
		' kB</nobr><\/span>' +
		'<div class="thumbnail">' + sLink + imgTag +'<\/a>' +
		'<\/div>' +
        '<br /><div class="filename"><nobr>' + sLink + fileName +	'<\/a>' + '</nobr><\/div>' +
        '<\/div>' ;
}

function OpenFolder( folderPath )
{
	// Load the resources list for this folder.
	window.parent.frames['frmFolders'].LoadFolders( folderPath ) ;
}

function OpenFile( fileUrl )
{
    //PATCH: Using CKEditors API we set the file in preview window.
 	funcNum = GetUrlParam('CKEditorFuncNum') ;
    window.top.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl.replace( '#', '%23' ));
    window.top.close() ;
    window.top.opener.focus() ;
}

function ProtectPath(path)
{
	path = path.replace( /\\/g, '\\\\') ;
	path = path.replace( /'/g, '\\\'') ;
	return path ;
}

function LoadResources( resourceType, folderPath )
{
	oListManager.Clear() ;
	oConnector.ResourceType = resourceType ;
	oConnector.CurrentFolder = folderPath ;
	oConnector.SendCommand( 'GetFoldersAndFiles', null, GetFoldersAndFilesCallBack ) ;
}

function GetFoldersAndFilesCallBack( fckXml )
{
	if ( oConnector.CheckError( fckXml ) != 0 )
		return ;

	// Get the current folder path.
	var oFolderNode = fckXml.SelectSingleNode( 'Connector/CurrentFolder' ) ;
	if ( oFolderNode == null )
	{
		alert( 'The server didn\'t reply with a proper XML data. Please check your configuration.' ) ;
		return ;
	}
	var sCurrentFolderPath	= oFolderNode.attributes.getNamedItem('path').value;
	var sCurrentFolderUrl	= oFolderNode.attributes.getNamedItem('url').value;
	var oHtml               = new StringBuilder( '<div id="tableFiles"><div>' ) ;

	// Add the Folders.
	var oNodes ;
	oNodes = fckXml.SelectNodes( 'Connector/Folders/Folder' ) ;
	for ( var i = 0 ; i < oNodes.length ; i++ )
	{
		var sFolderName = oNodes[i].attributes.getNamedItem('name').value ;
		oHtml.Append( oListManager.GetFolderRowHtml( sFolderName, sCurrentFolderPath + sFolderName + "/" ) ) ;
	}

	// Add the Files.
	oNodes = fckXml.SelectNodes( 'Connector/Files/File' ) ;
	for ( var j = 0 ; j < oNodes.length ; j++ )
	{
		var oNode = oNodes[j] ;
		var sFileName = oNode.attributes.getNamedItem('name').value ;
		var sFileSize = oNode.attributes.getNamedItem('size').value ;

		// Get the optional "url" attribute. If not available, build the url.
		var oFileUrlAtt = oNodes[j].attributes.getNamedItem('url') ;
		var sFileUrl    = oFileUrlAtt != null ? oFileUrlAtt.value : encodeURI( sCurrentFolderUrl + sFileName ).replace( /#/g, '%23' ) ;
        sFileUrl        = sFileUrl.replace( /^\//, '' );
		// hide index.php in browse media - added for WebsiteBaker
		if (sFileName != "index.php")
		{
			oHtml.Append( oListManager.GetFileRowHtml( sFileName, sFileUrl, sFileSize ) ) ;
		}
	}

	oHtml.Append( '<\/div><\/div>' ) ;

	document.body.innerHTML = oHtml.ToString() ;

}

function Refresh()
{
	LoadResources( oConnector.ResourceType, oConnector.CurrentFolder ) ;
}

function GetUrlParam( paramName )
{
    var oRegex = new RegExp( '[\?&]' + paramName + '=([^&]+)', 'i' ) ;
    var oMatch = oRegex.exec( window.top.location.search ) ;

    if ( oMatch && oMatch.length > 1 )
        return decodeURIComponent( oMatch[1] ) ;
    else
        return '' ;
}


jQuery(document).ready( function()
{
	window.top.IsLoadedResourcesList = true ;
});