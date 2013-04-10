<?php
    if(!defined('CAT_PATH'))
        require dirname(__FILE__).'/../../../../../config.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo WEBSITE_HEADER; ?> - File manager</title>

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo CAT_URL ?>/modules/lib_jquery/jquery-ui/themes/base/jquery-ui.css">
		<script type="text/javascript" src="<?php echo CAT_URL ?>/modules/lib_jquery/jquery-core/jquery-core.min.js"></script>
		<script type="text/javascript" src="<?php echo CAT_URL ?>/modules/lib_jquery/jquery-ui/ui/jquery-ui.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
 	   <script type="text/javascript" src="js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="js/i18n/elfinder.de.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            // Helper function to get parameters from the query string.
            function getUrlParam(paramName) {
                var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
                var match = window.location.search.match(reParam) ;
                return (match && match.length > 1) ? match[1] : '' ;
            }

            if(typeof jQuery != 'undefined') {
                jQuery().ready(function() {
                    var funcNum = getUrlParam('CKEditorFuncNum');
                    var mode = '<?php echo $_GET['mode']; ?>';

                    var elf = $('#elfinder').elfinder({
                        url : 'http://localhost/_projects/bcwa/modules/ckeditor4/ckeditor/filemanager/elfinder/php/connector.php?mode=' + mode,
                        getFileCallback : function(file) {
                            window.opener.CKEDITOR.tools.callFunction(funcNum, file);
                            window.close();
                        },
                        resizable: false
                    }).elfinder('instance');
                });
            } else {
                alert('jQuery not loaded!');
            }
        </script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>