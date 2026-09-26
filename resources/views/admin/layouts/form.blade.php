@extends('admin.layouts.app')
@section('main_content')
    
    <?php $route = Route::currentRouteName(); ?>
    
    @include('partials.form_errors')
	




    <?= Form::open(["files" => true]); ?>
        <div class="box">
            <div class="box-body">
                @yield('main_form')
            </div>
            <div class="box-footer clearfix">
			@if(in_array(Route::currentRouteName(),['admin.redirectsearchprojects','admin.clear_cache']))
				<button class="btn btn-primary btn_submit">Update</button>
				<button class="btn btn-danger btn_submit"
                   name="clear_all"
                   value="1">
                   Clear All Cache
               </button>
			@else
                @if(isset($row))
				@if(@$row->id)
                    <button class="btn btn-primary btn_submit">Update</button>
                    <button class="btn btn-primary btn_submit" data-tolist="1">Update and close</button>
                @else
                    <button class="btn btn-primary btn_submit">Create</button>
                    <button class="btn btn-primary btn_submit" data-tolist="1">Create and return to the list</button>
                    <button class="btn btn-primary btn_submit" data-tolist="-1">Create and add another</button>
                @endif
				@elseif(Input::get('type') and Input::get('year') and Input::get('month'))
                    <div style="text-align: center;display:block"><button class="btn btn-primary btn_submit">Save</button></div>
				@endif
			@endif
            </div>
        </div>
    <?= Form::close(); ?>
    
@endsection
