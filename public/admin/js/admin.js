$(document).ready(function(){
    
    // select2me
    if ($().select2) {
        $('select.select2me').select2({
            allowClear: true,
            placeholder: "اختر",
            dir: "rtl",
            language: "ar",
            language: {
                noResults: function () {
                    return "You must enter more characters...";
                }
            }
        });
        
    }
    
    // iCheck
    if ($().iCheck && !document.getElementById('anchors-page')) {
        $('input[type="checkbox"], input[type="radio"]').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    }
    
    // edit & close form
    $(document).on("click", ".btn_submit", function(){
        var cls = $(this).attr("data-tolist");
        var frm = $(this).closest('form');
        if ( cls ) {
            frm.append('<input type="hidden" name="redirect_to_list" value="'+cls+'">');
        } else {
            $('input[name="redirect_to_list"]').remove();
        }        
        // return false;
    });
    
    // Confirm form submit
    $(".button_confirm").on('click', function(){
        var frm = $(this).closest('form');
        bootbox.confirm("تأكيد الإجراء ؟", function(result) {
            if ( result ) {
                frm.submit();
            }
        });
        return false;
    });
    // Confirm ahref 
    $(".href_confirm").on('click', function(){
        var url = $(this).attr('href');
        bootbox.confirm("تأكيد الإجراء ؟", function(result) {
            if ( result ) {
                location.replace(url);
            }
        });
        return false;
    });
    
    // check all
    $(".checkall").on("ifChanged", function(){
        var $this = $(this);
        var tbl = $this.closest('table');
        if ( $this.is(':checked') ) {
            tbl.find('input[type=checkbox]').iCheck('check');
        } else {
            tbl.find('input[type=checkbox]').iCheck('uncheck');
        }
    });
    
});
