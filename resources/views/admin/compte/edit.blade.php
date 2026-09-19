@extends('admin.layouts.app', ["app_title" => "My Account"])
@section('main_content')

@include('partials.form_errors')

<?= Form::open(); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Account Information</h3>
    </div>
    <div class="box-body">
        
        <div class="form-group col-md-4">
            <label>Name <span class="red">(*)</span></label>
            <?= Form::text("name", $user->name, ["class" => "form-control"]); ?>
        </div>
        <div class="form-group col-md-4">
            <label>User Name</label>
            <span class="form-control" disabled><?= $user->username; ?></span>
        </div>
        <div class="form-group col-md-4">
            <label>Email</label>
            <span class="form-control" disabled><?= $user->email; ?></span>
        </div>
        <div class="clearfix"></div>
        <fieldset>
            <legend>Password</legend>
            <div class="form-group col-md-4">
                <label>Current Password <span class="red">(*)</span></label>
                <?= Form::password("password", ["class" => "form-control", "required" => true]); ?>
            </div>
            <div class="form-group col-md-4">
                <label>New Password</label>
                <?= Form::password("new_password", ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-4">
                <label>Confirm New Password</label>
                <?= Form::password("new_password_confirmation", ["class" => "form-control"]); ?>
            </div>
        </fieldset>
   
    </div>
    <div class="box-footer">
        <button class="btn btn-primary">Update</button>
    </div>
</div>
<?= Form::close(); ?>

@endsection