@extends('admin.layouts.form', ["app_title" => "Sliders", "app_desc" => "Slider Settings"])
@section('main_form')

<fieldset>
    <legend>Slider Settings</legend>
    <div class="form-group col-md-6">
        <label>Image <span class="red">(*)</span></label>
        @include('admin.layouts.media_input', [
            "name" => "media_id",
            "ids"  => [$row->media_id],
            "required"  => true,
        ])
    </div><div class="clearfix"></div>
    <div class="form-group col-md-6 hidden">
        <label>Image (Mobile Version)</label>
        @include('admin.layouts.media_input', [
            "name" => "media_mobile_id",
            "ids"  => [$row->media_mobile_id]
        ])
    </div>
    <div class="form-group col-md-6">
        <label>
            Video (PC Version)
           - MP4 Video Size Not Exceeding 5M
        </label>
        <?= Form::file("video_desktop", ["class" => "form-control"]); ?>
        @if($row->video_desktop)
            <small>
                <a href="" class="btn btn-danger btn-xs delvideo" data-typ="desktop">X</a>
                <a href="<?= asset("videos/$row->video_desktop"); ?>" target="_blank"><?= $row->video_desktop; ?></a>
            </small>
        @endif
    </div>
    <div class="form-group col-md-6">
        <label>Video (Mobile Version)</label>
        <?= Form::file("video_mobile", ["class" => "form-control"]); ?>
        @if($row->video_mobile)
            <small>
                <a href="" class="btn btn-danger btn-xs delvideo" data-typ="mobile">X</a>
                <a href="<?= asset("videos/$row->video_mobile"); ?>" target="_blank"><?= $row->video_mobile; ?></a>
            </small>
        @endif
    </div>
    <script>
    $(function(){
        $(".delvideo").on("click", function(){
            var $this = $(this);
            var field = $this.attr("data-typ");
            $.ajax({
                type: 'POST',
                data: {
                    _token: '<?= csrf_token(); ?>',
                    action: 'deletevideo',
                    field: field
                }
            }).done(function(resp){
                if ( !resp ) $this.closest("small").remove();
            });
            return false;
        });
    });
    </script>
    <div class="clearfix"></div><hr>
    
    <div class="form-group col-md-4">
        <label>Name <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control", "required" => true]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Lang<span class="red">(*)</span></label>
        <?= Form::select("lang", Helper::langs('all'), $row->lang, ["class" => "form-control select2me"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Background Color</label>
        <?= Form::color("background_color", ($row->background_color ? $row->background_color : "#9f805e"), ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Links </label>
        <?= Form::text("slider_link", $row->slider_link, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Content</label>
        <?= Form::textarea("content", $row->content, ["class" => "form-control", "rows" => 3]); ?>
    </div>
    
</fieldset>

@include('admin.layouts.media_input_js')

@endsection
