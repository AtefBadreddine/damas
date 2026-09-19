
<script src="<?= asset('tinymce/tinymce.min.js'); ?>"></script>
<script>
$(function(){
    tinymce.init({

        selector: '.tinyeditor',
        language: 'en',
        menubar: true,
        directionality : '<?= @$direction ? $direction : "rtl"; ?>',
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        height: 200,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: "newdocument undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | fontsizeselect | bullist numlist | outdent indent | link unlink | forecolor backcolor",
        setup: function(editor) {
        }
    });
});
</script>