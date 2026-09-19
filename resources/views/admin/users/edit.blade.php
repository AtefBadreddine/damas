@extends('admin.layouts.form', ["app_title" => "Users", "app_desc" => "User Information"])
@section('main_form')

<!--<div class="pull-left">
    <img src="<?= asset('img/user.jpg'); ?>" width="80" alt="">
</div>-->

<fieldset>
    <legend>User</legend>
    <div class="form-group col-md-6">
        <label>User Name<span class="red">(*)</span></label>
        <?= Form::text("username", $row->username, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Email<span class="red">(*)</span></label>
        <?= Form::email("email", $row->email, ["class" => "form-control ltr"]); ?>
    </div>
    
    @if(!$row->id)
        <div class="form-group col-md-6">
            <label>Password<span class="red">(*)</span></label>
            <?= Form::text("password", $row->password, ["class" => "form-control", "required" => true]); ?>
        </div>
    @endif
    
    <div class="clearfix"></div>
    <div class="form-group col-md-6">
        <label>Roles <span class="red">(*)</span></label>
        <?= Form::select("role", ["user" => "Set Permissions", "superadmin" => "All Permissions"], $row->role, ["class" => "form-control select2me selectrole"]); ?> 
    </div>
    <?php $rol = old("role", $row->role); ?>
    <div class="form-group col-md-12 grp-permissions <?= $rol == "superadmin" ? 'hidden' : ''; ?>">
        <select name="permissions[]" class="form-control select2me" multiple>
            @foreach($permissions as $permission)
                <option value="<?= $permission->slug; ?>" <?= $row->can($permission->slug) ? 'selected' : ''; ?>><?= $permission->name; ?></option>
            @endforeach
        </select>
    </div>
    
</fieldset>

<script>
$(function(){
    $(".selectrole").on("change", function(){
        var vl = $(this).val();
        if ( vl == 'user' ) {
            $(".grp-permissions").removeClass("hidden");
        } else {
            $(".grp-permissions").addClass("hidden");
        }
    });
});
</script>

@endsection
