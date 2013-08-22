var sActiveFolder;
var bIsLoaded = false;
var iIntervalId;
var oListManager = new Object();

// initialize
oListManager.Init = function()
{
	this.List  = $('ul#tableFiles');
	this.UpRow = $('li#trUp');
	this.Rows  = new Object();
}

// reset list
oListManager.Clear = function()
{
	// Remove all rows available
	$(this.List).children().not('#trUp').remove();
	// Reset the rows collection
	this.Rows = new Object();
}

// add row
oListManager.AddItem = function( folderName, folderPath )
{
	// Create the new row.
	var oCell = document.createElement("li");
	oCell.className = 'FolderListFolder';
	// Build the link to view the folder.
	var sLink = '<a href="#" onclick="OpenFolder(\'' + folderPath + '\');return false;">' + folderName + '</a>';
    $(oCell).html(sLink);
    // Add the row
	this.Rows[folderPath] = oCell;
    $(this.List).append(oCell);
}

// decide if to show up link
oListManager.ShowUpFolder = function( upFolderPath )
{
    var showit = ( upFolderPath != null ? true : false );
	if ( showit )
	{
        $(this.UpRow).show().click( function(e) {
            e.preventDefault;
            LoadFolders(upFolderPath);
        });
	}
    else {
        $(this.UpRow).hide().unbind();
    }
}

function CheckLoaded()
{
	if ( window.top.IsLoadedActualFolder
		&& window.top.IsLoadedCreateFolder
		&& window.top.IsLoadedUpload
		&& window.top.IsLoadedResourcesList )
	{
		window.clearInterval( iIntervalId );
		bIsLoaded = true;
		OpenFolder( sActiveFolder );
	}
}

function GetFoldersCallBack( fckXml )
{
	if ( oConnector.CheckError( fckXml ) != 0 )
		return;
	// Get the current folder path.
	var oNode = fckXml.SelectSingleNode( 'Connector/CurrentFolder' );
	var sCurrentFolderPath = oNode.attributes.getNamedItem('path').value;
	var oNodes = fckXml.SelectNodes( 'Connector/Folders/Folder' );
	for ( var i = 0; i < oNodes.length; i++ )
	{
		var sFolderName = oNodes[i].attributes.getNamedItem('name').value;
		oListManager.AddItem( sFolderName, sCurrentFolderPath + sFolderName + "/" );
	}
	OpenFolder( sActiveFolder );
}

// load folders
function LoadFolders( folderPath )
{
	// Clear the folders list.
	oListManager.Clear();

	// Get the parent folder path.
	var sParentFolderPath;
	if ( folderPath != '/' )
		sParentFolderPath = folderPath.substring( 0, folderPath.lastIndexOf( '/', folderPath.length - 2 ) + 1 );

	// Show/Hide the Up Folder.
	oListManager.ShowUpFolder( sParentFolderPath );

	if ( folderPath != '/' )
	{
		sActiveFolder = folderPath;
		oConnector.CurrentFolder = sParentFolderPath;
		oConnector.SendCommand( 'GetFolders', null, GetFoldersCallBack );
	}
	else
		OpenFolder( '/' );
}

function OpenFolder( folderPath )
{
	sActiveFolder = folderPath;

	if ( ! bIsLoaded )
	{
		if ( ! iIntervalId )
			iIntervalId = window.setInterval( CheckLoaded, 100 );
		return;
	}

	// Change the style for the select row (to show the opened folder).
	for ( var sFolderPath in oListManager.Rows )
	{
		oListManager.Rows[ sFolderPath ].className =
			( sFolderPath == folderPath ? 'FolderListCurrentFolder' : 'FolderListFolder' );
	}

	// Set the current folder in all frames.
	window.parent.frames['frmActualFolder'].SetCurrentFolder( oConnector.ResourceType, folderPath );
	window.parent.frames['frmCreateFolder'].SetCurrentFolder( oConnector.ResourceType, folderPath );
	window.parent.frames['frmUpload'].SetCurrentFolder( oConnector.ResourceType, folderPath );

	// Load the resources list for this folder.
	window.parent.frames['frmResourcesList'].LoadResources( oConnector.ResourceType, folderPath );
}

function SetResourceType( type )
{
	oConnector.ResourceType = type;
	LoadFolders( '/' );
}


jQuery(document).ready( function()
{
	oListManager.Init();
	LoadFolders( '/' );
});