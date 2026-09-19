<textarea name="<?= $name; ?>" class="form-control mtinyeditor<?= str_replace('_en','',$name)!=$name?'_en':'' ?>">{!! old($name, $row->$name) !!}</textarea>


<script src="<?= asset('tinymce/tinymce.min.js'); ?>"></script>
<script>
    var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
    var editor_config = {
        path_absolute : "",
        language: 'en',
        directionality : 'rtl',
        selector: ".mtinyeditor",
        plugins: [
            'advlist autolink lists link charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualchars code fullscreen',
            'media nonbreaking save table contextmenu directionality',
            'paste textcolor colorpicker textpattern imagetools codesample toc image'
        ],
        toolbar1: "undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link unlink | image | forecolor backcolor | fontsizeselect",
        relative_urls: false,
        remove_script_host : false,
        height: 250,

    };
    tinymce.init(editor_config);
	
	
	
    var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
    var editor_config = {
        path_absolute : "",
        language: 'en',
        directionality : 'ltr',
        selector: ".mtinyeditor_en",
        plugins: [
            'advlist autolink lists link charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualchars code fullscreen',
            'media nonbreaking save table contextmenu directionality',
            'paste textcolor colorpicker textpattern imagetools codesample toc image'
        ],
        toolbar1: "undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link unlink | image | forecolor backcolor | fontsizeselect",
        relative_urls: false,
        remove_script_host : false,
        height: 250,
    };
    tinymce.init(editor_config);
</script>
