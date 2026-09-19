@extends('admin.layouts.form', ["app_title" => " Turkstat Statistics", "app_desc" => ""])



@section('main_form')



<fieldset>
    <legend></legend>
	
	<div style="clear:both">
		<div class="form-group col-md-4">
		<label>Year</label>
		<select id="year" name="year" class="form-control statics_fields" placeholder="Year">
		<option value="">Year</option>
		<?php for($i=date('Y');$i>2013;$i--){ ?>
		<option value="<?= $i ?>" <?= Input::get('year')==$i?' selected="selected"':'' ?>><?= $i ?></option>
		<?php } ?>
		</select>
		</div>
		<?php
		$list_months = array('Junary','February','March','April','May','June','July','August','September','October','November','December');
		?>
		<div class="form-group col-md-4">
		<label>Month</label>
		<select id="month" name="month" class="form-control statics_fields" placeholder="Month">
		<option value="">Month</option>
		<?php for($i=1;$i<=12;$i++){ ?>
		<option value="<?= $i ?>" <?= Input::get('month')==$i?' selected="selected"':'' ?>><?= $list_months[$i-1] ?></option>
		<?php } ?>
		</select>
		</div>

		<div class="form-group col-md-4">
		<label style="clear:both;width:100%;padding-bottom:10px;"> Type: </label>
		<label><input type="radio" value="country" class="statics_fields" id="type" name="type" <?= in_array(Input::get('type'),array('country'))?' checked="checked"':'' ?>> Countries</label> &nbsp;
		<label><input type="radio" value="city" class="statics_fields" id="type" name="type" <?= in_array(Input::get('type'),array('city'))?' checked="checked"':'' ?>>Turkish cities</label>
		<input type="hidden" name="iitype" id="iitype" value="<?= Input::get('type') ?>" />
		</div>



	</div>
	<input type="hidden" name="hidden" value="<?= Input::get('type') ?>" />
	<?php if(Input::get('type')){ ?>
	<table class="table table-bordered" style="width:600px;margin:0 auto">
	<thead>
	<th><?= Input::get('type')=='city'?'Cities':'Countries'?></th>
	<th>Sales</th>
	</thead>
	<tbody>
	<?php } ?>
	
<?php if(count($data)>0){
foreach($data as $r){ ?>
	<tr>
	<td><?= Input::get('type')=='city'?$r->city:$r->country ?></td>
	<td><input type="text" value="<?= $r->value ?>" name="value[<?= Input::get('type')=='city'?$r->city:$r->country ?>]" /></td>
	</tr>
<?php
}
}elseif(Input::get('type')){
	if(Input::get('type')=='city')
		$data = $citys;
	else
		$data = $countrys;

foreach($data as $r){ ?>
	<tr>
	<td><?= Input::get('type')=='city'?$r->city:$r->country ?></td>
	<td><input type="text" value="" name="value[<?= Input::get('type')=='city'?$r->city:$r->country ?>]" /></td>
	</tr>
<?php
}
}
?>
</tbody>
	</table>
    
</fieldset>

@endsection