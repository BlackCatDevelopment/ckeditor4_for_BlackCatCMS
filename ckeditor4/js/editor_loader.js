if(typeof CodeMirrorAddScript !== 'function')
{
    window.CodeMirrorAddScript = function(url)
    {
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = url;
        head.appendChild(script);
    };
}

if(typeof CodeMirrorAddCSS !== 'function')
{
    window.CodeMirrorAddCSS = function(url)
    {
        var head = document.getElementsByTagName('head')[0];
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = url;
        head.appendChild(link);
    };
}

if(typeof CodeMirrorLoader !== 'function')
{
    window.CodeMirrorLoader = function(area,mode,theme,width,height)
    {
        window.CodeMirrorAddScript(CAT_URL+'/modules/ckeditor4/ckeditor/plugins/codemirror/js/codemirror.mode.'+mode+'.min.js');
        var editor = CodeMirror.fromTextArea(document.getElementById(area), {
            lineNumbers: true,
            mode:        mode,
            theme:       theme
        });
        editor.setSize(width, height);
    };
}

if(typeof CodeMirrorDefer !== 'function')
{
    window.CodeMirrorDefer = function(area,mode,theme,width,height)
    {
        if (window.CodeMirror)
            CodeMirrorLoader(area,mode,theme,width,height);
        else
            setTimeout(function() { CodeMirrorDefer(area,mode,theme,width,height) }, 50);
    }
}

if (typeof CodeMirror !== 'function') {
    window.CodeMirrorAddScript(CAT_URL+'/modules/ckeditor4/ckeditor/plugins/codemirror/js/codemirror.min.js');
    window.CodeMirrorAddScript(CAT_URL+'/modules/ckeditor4/ckeditor/plugins/codemirror/js/codemirror.addons.min.js');
    window.CodeMirrorAddScript(CAT_URL+'/modules/ckeditor4/ckeditor/plugins/codemirror/js/codemirror.addons.search.min.js');
    window.CodeMirrorAddCSS(CAT_URL+'/modules/ckeditor4/ckeditor/plugins/codemirror/css/codemirror.min.css');
}