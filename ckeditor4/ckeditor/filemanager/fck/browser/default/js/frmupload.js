function SetCurrentFolder( resourceType, folderPath )
{
	var sUrl = oConnector.ConnectorUrl + 'Command=FileUpload' ;
	sUrl += '&Type=' + resourceType ;
	sUrl += '&CurrentFolder=' + encodeURIComponent( folderPath ) ;

	document.getElementById('frmUpload').action = sUrl ;
}

function OnSubmit()
{
	if ( document.getElementById('NewFile').value.length == 0 )
	{
		alert( 'Please select a file from your computer' ) ;
		return false ;
	}

	// Set the interface elements.
	document.getElementById('eUploadMessage').innerHTML = 'Upload a new file in this folder (Upload in progress, please wait...)' ;
	document.getElementById('btnUpload').disabled = true ;

	return true ;
}

function OnUploadCompleted( errorNumber, data )
{
	// Reset the Upload Worker Frame.
	window.parent.frames['frmUploadWorker'].location = 'javascript:void(0)' ;

	// Reset the upload form (On IE we must do a little trick to avout problems).
	if ( document.all )
		document.getElementById('NewFile').outerHTML = '<input id="NewFile" name="NewFile" style="WIDTH: 100%" type="file">' ;
	else
		document.getElementById('frmUpload').reset() ;

	// Reset the interface elements.
	document.getElementById('eUploadMessage').innerHTML = 'Upload a new file in this folder' ;
	document.getElementById('btnUpload').disabled = false ;

	switch ( errorNumber )
	{
		case 0 :
			window.parent.frames['frmResourcesList'].Refresh() ;
			break ;
		case 1 :	// Custom error.
			alert( data ) ;
			break ;
		case 201 :
			window.parent.frames['frmResourcesList'].Refresh() ;
			alert( 'A file with the same name is already available. The uploaded file has been renamed to "' + data + '"' ) ;
			break ;
		case 202 :
			alert( 'Invalid file' ) ;
			break ;
		default :
			alert( 'Error on file upload. Error number: ' + errorNumber ) ;
			break ;
	}
}

window.onload = function()
{
	window.top.IsLoadedUpload = true ;
}