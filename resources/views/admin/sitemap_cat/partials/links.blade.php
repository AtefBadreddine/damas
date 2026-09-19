<div class="panel panel-default">
    <div class="panel-heading">الروابط</div>
    <div class="panel-body">
        <div class="row">
            <div class="form-group col-sm-4">
                <label>نص الرابط بالعربي <!--<span class="red">(*)</span>--></label>
                <?= Form::text("title_ar", $menu->title_ar, ["class" => "form-control", "required" => true]); ?>
            </div>
            <div class="form-group col-sm-4">
                <label>نص الرابط بالإنجليزي</label>
                <?= Form::text("title_en", $menu->title_en, ["class" => "form-control ltr"]); ?>
            </div>
            <div class="form-group col-sm-4">
                <label>نسخة الموقع</label>
                <?= Form::select("lang", Helper::langs("all"), $menu->lang, ["class" => "form-control select2me"]); ?>
            </div>
            <div class="form-group col-sm-4">
                <label>نوع الرابط <span class="red">(*)</span></label>
                <?= Form::select("link_type", [
                    ""    =>  "",
                    "city"    =>  "مدينة",
                    "post"    =>  "مقال",
                    "category"    =>  "تصنيف العقار",
                    "region"    =>  "منطقة",
                    "url"    =>  "رابط مخصص",
                    "parent"    =>  "رابط أب",
                ], $menu->link_type, ["class" => "form-control select2me", "required" => true]); ?>
            </div>
            <div id="sect_options">
                <?php
                    $datas = $menu->attributesToArray();
                    $datas["route_name"] = Route::currentRouteName();
                ?>
                <?= Helper::ajax_selectLinksMenu_sitemap($datas); ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-4">
                <label>الترتيب</label>
                <?= Form::text("placement", $menu->placement, ["class" => "form-control"]); ?>
            </div>
            
            @if($datas["route_name"] == "admin.apparence.footer")
                <div class="col-sm-4">
                    <label>القسم</label>
                    <?= Form::select("footer_section", ["links" => "القسم العلوي", "useful" => "روابط مفيدة", "quick" => "روابط سريعة"], $menu->footer_section, ["class" => "form-control select2me"]); ?>
                </div>
            @endif
            
        </div>
    </div>                    
    <div class="panel-footer">
        <button class="btn btn-primary">حفظ</button>
    </div>
</div>


<style>.panel-body ul:first-child {padding:0;}.list-group-item{padding:5px;}</style>
   
<script>
$(function(){
    $(document).on("change", "select[name=link_type]", function(){
        var vl = $(this).val();
        var inputs = {};
        inputs['link_type'] = vl;
        inputs['lang'] = $("select[name=lang]").val();
        inputs['route_name'] = '<?= Route::currentRouteName(); ?>';
        $("#ajaxloading").show();
        $.ajax({
            type: 'POST',
            url: '<?= route('admin.ajaxqueries'); ?>',
            data: {
                _token: '<?= csrf_token(); ?>',
                func: 'selectLinksMenu_sitemap',
                inputs: inputs,
            }
        }).done(function(resp){
            $.getScript("<?= asset("admin/js/admin.js"); ?>");
            $("#sect_options").html(resp);
            $('#ajaxloading').hide();
        }).fail(function(xhr, status, error){
            alert('error: ' + error);
            $('#ajaxloading').hide();
        });

    });
});
</script>