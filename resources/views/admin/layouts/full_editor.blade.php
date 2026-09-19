<textarea name="<?= $name; ?>" class="form-control tinyeditor<?= str_replace(['_ru','_en','_fr'],'',$name)!=$name?'_en':'' ?>">{!! old($name, $row->$name) !!}</textarea>

@section('scriptjs')
<script src="<?= asset('tinymce/tinymce.min.js'); ?>"></script>
<script>
    var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
    var editor_config = {
		//content_css : "p{font-size: 14pt;}",
		content_css : "https://damas.net/css/admin.css",
        path_absolute : "",
        language: 'en',
        directionality : 'rtl',
        selector: ".tinyeditor",
        plugins: [
            'advlist autolink lists link charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualchars code fullscreen',
            'media nonbreaking save table contextmenu directionality',
            'paste textcolor colorpicker textpattern imagetools codesample toc image'
        ],
        toolbar1: "undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link unlink | image | forecolor backcolor | fontsizeselect",
        relative_urls: false,
        remove_script_host : false,
        height: <?= isset($height)?$height:400 ?>,
        /*file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";        
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'مدير الملفات',
                width : x * 0.9,
                height : y * 0.9,
                resizable : "yes",
                close_previous : "no"
            });
        }*/
    };
    tinymce.init(editor_config);
	
	
	
    var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
    var editor_config = {
		content_css : "https://damas.net/css/admin.css",
		//content_css : "p{font-size: 14pt;},blockquote{border-radius:4px;padding:2px 5px;border:2px solid #0b7f7f;border-style:dashed;}",
        path_absolute : "",
        language: 'en',
        directionality : 'ltr',
        selector: ".tinyeditor_en",
        plugins: [
            'advlist autolink lists link charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualchars code fullscreen',
            'media nonbreaking save table contextmenu directionality',
            'paste textcolor colorpicker textpattern imagetools codesample toc image'
        ],
        toolbar1: "undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link unlink | image | forecolor backcolor | fontsizeselect",
        relative_urls: false,
        remove_script_host : false,
        height: <?= isset($height)?$height:400 ?>,
        /*file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";        
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'مدير الملفات',
                width : x * 0.9,
                height : y * 0.9,
                resizable : "yes",
                close_previous : "no"
            });
        }*/
    };
    tinymce.init(editor_config);
</script>

@endsection