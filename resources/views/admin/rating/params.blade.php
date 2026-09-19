@extends('admin.layouts.app', ["app_title" => "Rating messages"])
@section('main_content')

<?= Form::open(); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Rating messages</h3>
    </div>
    <div class="box-body">
        <fieldset>
		<legend>Temporary Off:</legend>
            <div class="form-group col-md-6">
                <label>Message (Ar) <span class="red">(*)</span></label>
                <?= Form::textarea("off_msg_ar", $row->off_msg_ar, ["style"=>"direction:rtl;text-align: right;","class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (En) <span class="red">(*)</span></label>
                <?= Form::textarea("off_msg_en", $row->off_msg_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Fr) <span class="red">(*)</span></label>
                <?= Form::textarea("off_msg_fr", $row->off_msg_fr, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Pe) <span class="red">(*)</span></label>
                <?= Form::textarea("off_msg_fa", $row->off_msg_fa,["style"=>"direction:rtl;text-align: right;","class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Ru) <span class="red">(*)</span></label>
                <?= Form::textarea("off_msg_ru", $row->off_msg_ru, ["class" => "form-control"]); ?>
            </div>
        </fieldset>
		
        <fieldset>
		<legend>Fresh:</legend>
            <div class="form-group col-md-6">
                <label>Message (Ar) <span class="red">(*)</span></label>
                <?= Form::textarea("fresh_msg_ar", $row->fresh_msg_ar, ["style"=>"direction:rtl;text-align: right;","class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (En) <span class="red">(*)</span></label>
                <?= Form::textarea("fresh_msg_en", $row->fresh_msg_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Fr) <span class="red">(*)</span></label>
                <?= Form::textarea("fresh_msg_fr", $row->fresh_msg_fr, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Pe) <span class="red">(*)</span></label>
                <?= Form::textarea("fresh_msg_fa", $row->fresh_msg_fa,["style"=>"direction:rtl;text-align: right;","class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Ru) <span class="red">(*)</span></label>
                <?= Form::textarea("fresh_msg_ru", $row->fresh_msg_ru, ["class" => "form-control"]); ?>
            </div>
        </fieldset>
		
        <fieldset>
		<legend>Tour:</legend>
            <div class="form-group col-md-6">
                <label>Message (Ar) <span class="red">(*)</span></label>
                <?= Form::textarea("tour_msg_ar", $row->tour_msg_ar, ["style"=>"direction:rtl;text-align: right;","class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (En) <span class="red">(*)</span></label>
                <?= Form::textarea("tour_msg_en", $row->tour_msg_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Fr) <span class="red">(*)</span></label>
                <?= Form::textarea("tour_msg_fr", $row->tour_msg_fr, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Pe) <span class="red">(*)</span></label>
                <?= Form::textarea("tour_msg_fa", $row->tour_msg_fa,["style"=>"direction:rtl;text-align: right;","class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Ru) <span class="red">(*)</span></label>
                <?= Form::textarea("tour_msg_ru", $row->tour_msg_ru, ["class" => "form-control"]); ?>
            </div>
        </fieldset>
		
        <fieldset>
		<legend>Deal:</legend>
            <div class="form-group col-md-6">
                <label>Message (Ar) <span class="red">(*)</span></label>
                <?= Form::textarea("deal_msg_ar", $row->deal_msg_ar, ["style"=>"direction:rtl;text-align: right;","class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (En) <span class="red">(*)</span></label>
                <?= Form::textarea("deal_msg_en", $row->deal_msg_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Fr) <span class="red">(*)</span></label>
                <?= Form::textarea("deal_msg_fr", $row->deal_msg_fr, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Pe) <span class="red">(*)</span></label>
                <?= Form::textarea("deal_msg_fa", $row->deal_msg_fa,["style"=>"direction:rtl;text-align: right;","class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Message (Ru) <span class="red">(*)</span></label>
                <?= Form::textarea("deal_msg_ru", $row->deal_msg_ru, ["class" => "form-control"]); ?>
            </div>
        </fieldset>
		

    </div>
    <div class="box-footer">
        <button class="btn btn-primary">update</button>
    </div>
</div>
<?= Form::close(); ?>

@endsection
