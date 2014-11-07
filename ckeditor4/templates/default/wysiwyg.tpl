<textarea name="{$name}" id="{$id}" style="width:{$width};height:{$height};">{$content}</textarea>
<script>
    CKEDITOR.replace(
        '{$name}',
        {
            baseHref: '{$CAT_URL}'
            ,customConfig: '{$CAT_URL}/modules/ckeditor4/ckeditor/custom/config.js'
            {if $css},contentsCss: [ '{$css}' ]{/if}
            {if $toolbar},toolbar: '{$toolbar}'{/if}
            {$filemanager_include}
            {foreach $config cfg}
            ,{$cfg.set_name}: {if $cfg.set_value != 'true' && $cfg.set_value != 'false' }'{/if}{$cfg.set_value}{if $cfg.set_value != 'true' && $cfg.set_value != 'false' }'{/if}
            {/foreach}
            ,extraPlugins: 'xml,ajax,panelbutton,cmsplink,droplets{if isset($plugins)},{$plugins}{/if}',
            width: "{$width}",
			height: "{$height}"
        }
    );
</script>