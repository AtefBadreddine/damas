<script>
$(function(){
    // liste of files
    $(document).on("click", ".btn_list_files", function(){
        var inputs = {};
        inputs["target"] = $(this).attr("data-target");
        inputs["multiple"] = $(this).attr("data-multiple");
        inputs["ids"] = $(inputs["target"]).val();
        $("#ajaxloading").show();
        $.ajax({
            type: 'POST',
            url: '<?= route('admin.ajaxqueries'); ?>',
            data: {
                _token: '<?= csrf_token(); ?>',
                func: 'listFiles',
                inputs: inputs,
            }
        }).done(function(resp){
            $('#content_maj').html(resp);
            $.getScript("<?= asset('admin/js/admin.js'); ?>");
            $('#modelMAJ').modal({
                show: true,
                backdrop: 'static'
            });
            $("#ajaxloading").hide();
        });
        return false;
    });
    // click item
    $(document).on("ifChanged", ".checked_media", function(){
        var id = $(this).val();
        var ids = $("#txt_ids_files").val();
        if ( $(this).is(':checked') ) {
            ids = ids+","+id;
        } else {
            ids = ids.replace(id, '');
        }
        $("#txt_ids_files").val(ids);
    });
    $(document).on("click", ".media_item", function(){
        $this = $(this);
        var id = $this.attr('data-id');
        var check = $this.find("input[class=checked_media]");
        var ids = $("#txt_ids_files").val();
        if ( check.is(':checked') ) {
            check.iCheck('uncheck');
            ids = ids.replace(id, '');
        } else {
            check.iCheck('check');
            ids = ids+","+id;
        }
        $("#txt_ids_files").val(ids);
    });
    // on hidden
    $('#modelMAJ').on('hide.bs.modal', function () {
        var $this = $(this);
        var inputs = {};
        var targetInput = $this.find("input#targetInput").val();
        var ids = $this.find("#txt_ids_files").val();
        inputs["ids"] = ids;
        $("#ajaxloading").show();
        $.ajax({
            type: "POST",
            url: '<?= route("admin.ajaxqueries"); ?>',
            data: {
                _token: '<?= csrf_token(); ?>',
                func: 'getSelectedMediasModal',
                inputs: inputs,
            }
        }).done(function(resp){
            console.log(resp);
            $(targetInput).html(resp);
            $(targetInput).trigger("change.select2");
            $("#ajaxloading").hide();
            return false;
            
        });
        /*$this.find(".checked_media:checked").each(function(){
            str_options += "<option value='"+$(this).val()+"' selected>"+$(this).attr('data-name')+"</option>";
        });*/        
    });
    // empty select file
    $(document).on("click", ".btn_empty_select_media", function(){
        var select = $(this).closest('.select-medias').find("select");
        select.find("option:selected").text("").attr({value: ""});
        select.trigger("change.select2");
    });
    // show modal new media
    $(document).on("click", ".btn_add_media_modal", function(){
        $("#ajaxloading").show();
        var inputs = {};
        inputs["target"] = $(this).attr("data-target");
        $.ajax({
            type: 'POST',
            url: '<?= route('admin.ajaxqueries'); ?>',
            data: {
                _token: '<?= csrf_token(); ?>',
                func: 'addFiles',
                inputs: inputs,
            }
        }).done(function(resp){
            $('#content_maj').html(resp);
            $.getScript("<?= asset('admin/js/admin.js'); ?>");
            $('#modelMAJ').modal({
                show: true,
                backdrop: 'static'
            });
            $("#ajaxloading").hide();
        });
        return false;
    });
    // save new media
    $(document).on("submit", "#form-media", function(event){
        event.preventDefault();
        var $this = $(this);
        var url = $(this).attr('action');
        var formData = new FormData(this);
        $this.find(".btn_save_media").append("<i class='fa fa-spinner fa-spin'></i>");
        $("#ajaxloading").show();
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(resp){
            $("#txt_ids_files").val(resp.ids);
            $('#modelMAJ').modal("hide");
        }).fail(function(xhr, status, error){
            alert('error: ' + error);
            $('#ajaxloading').hide();
        });
        
        return false;
    });
    
    // paginate
    $(document).on("click", ".medias-pagination a", function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var multiple = $(this).closest('.medias-pagination').attr("data-multiple");
        var folder_id = $(this).closest('.medias-pagination').attr("data-folder");
        var ids = $("#txt_ids_files").val();
        $.ajax({
            url : url,
            data: {
                multiple: multiple,
                ids: ids,
                folder_id: folder_id,
            }
        }).done(function (resp) {
            $.getScript("<?= asset('admin/js/admin.js'); ?>");
            $('#medias-container').html(resp);  
        }).fail(function () {
            console.log('Could not be loaded.');
        });
        return false;
    });
    
    // folder filter
    $(document).on("click", ".btn_change_folder", function(e){
        e.preventDefault();
        var folder_id = $(this).attr('data-id');
        var ids = $("#txt_ids_files").val();
        $.ajax({
            url: '<?= route('admin.medias'); ?>',
            type: 'POST',
            data: {
                _token: '<?= csrf_token(); ?>',
                //filter_folder: 1,
                folder_id: folder_id,
                ids: ids
            } 
        }).done(function (resp) {
            console.log(resp);
            $.getScript("<?= asset('admin/js/admin.js'); ?>");
            $('#medias-container').html(resp);  
        }).fail(function () {
            console.log('Could not be loaded.');
        });
        return false;
    });
    
    // check all
    $(document).on("ifChanged", ".checkallmedias", function(){
        var $this = $(this);
        var tbl = $this.closest('#medias-container');
        var inputs = {};
        var ids = $("#txt_ids_files").val();
        if ( $this.is(':checked') ) {
            //tbl.find('input[type=checkbox]').iCheck('check');
            tbl.find("input[type=checkbox]").each(function(){
                $(this).iCheck('check');
                var vl = $(this).val();
                if ( $.isNumeric(vl) )ids = ids+","+vl;
            });
            inputs["action"] = "check";
        } else {
            //tbl.find('input[type=checkbox]').iCheck('uncheck');
            tbl.find("input[type=checkbox]").each(function(){
                $(this).iCheck('uncheck');
                var vl = $(this).val();
                if ( $.isNumeric(vl) ) ids = ids.replace(vl, '');
            });
            inputs["action"] = "uncheck";
        }
        $("#txt_ids_files").val(ids);
    });
    
});
</script>