@extends('admin.layouts.form', ["app_title" => "المستخدمين", "app_desc" => "الصلاحيات"])
@section('main_form')

<fieldset>
    <legend></legend>
    <div class="form-group col-md-6">
        <label>الإسم <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>الصلاحيات</label>
        <select name="permissions[]" class="form-control select2me" multiple>
            @foreach($permissions as $permission)
                <?php $per_rol = DB::table("permission_role")->where("role_id", $row->id)->where("permission_id", $permission->id)->first(); ?>
                <option value="<?= $permission->slug; ?>" <?= $per_rol ? 'selected' : ''; ?>><?= $permission->name; ?></option>
            @endforeach
        </select>
    </div>
</fieldset>

@endsection
