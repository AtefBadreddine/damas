<script>
    $(function(){
        $("#form-callus, #form-callus-lg").on("submit", function(e){
            e.preventDefault();
            var form = $(this);
            $("#phone-full").val($(".inputTelIntr").intlTelInput("getNumber"));
            var btn = form.find("button[type=submit]");
            var act = form.attr("action");
            var infos = form.serialize();
            btn.find(".fa").removeClass("fa-send").addClass("fa-spinner fa-spin");
            btn.attr("disabled", true);
            $.post(act, infos, function(resp){
                console.log(resp);
                if ( resp.input ) {
                    form.find('input[name='+resp.input+']').addClass("animated flash").attr("placeholder", resp.message).focus();
                } else {
                    alert(resp.message);
                }
                btn.find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-send");
                btn.removeAttr("disabled");
            });
            return false;
        });
        $("#mobile-sm, #mobile-lg").intlTelInput({
            preferredCountries: ["undif","tr","sa","qa","sy","iq","kw","bh","ae","ye","jo","dz","ly","eg","sd","om"]
        });

    });
</script>