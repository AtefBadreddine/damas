@extends('admin.layouts.app', ["app_title" => "Lists"])
@section('main_content')
<style>
.list-group{margin-left:15px;margin-top:5px}
.list-group .list-group{margin-left:35px}
</style>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Manage Lists</h3>
        <!--<div class="pull-left">
            <?= Form::select("location", ["header" => "هيدر", "footer" => "فوتر"], Input::get('location'), ["class" => "form-control"]); ?>
        </div>-->
    </div>
    <div class="box-body">
        
        <div class="col-md-12">
            <?= Form::open(); ?>
            <div class="col-md-12">
                @include("admin.apparence.partials.links",['menu_new'=>false])
            </div>
            <?= Form::close(); ?>
            <!-- Lists -->
            <div class="col-md-12">
                <!--<p class="text-danger"> <i class="fa fa-warning"></i> <b>Note</b></p>-->
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Arabic version links</div>
                    <div class="panel-body">
                        <?= Helper::menu_tree_admin(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", "ar"]])->toArray()); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
               <div class="panel panel-default">
                    <div class="panel-heading">English version links</div>
                    <div class="panel-body">
                        <?= Helper::menu_tree_admin(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", "en"]])->toArray(), "en"); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
               <div class="panel panel-default">
                    <div class="panel-heading">French version links</div>
                    <div class="panel-body">
                        <?= Helper::menu_tree_admin(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", "fr"]])->toArray(), "fr"); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Persian version links</div>
                    <div class="panel-body">
                        <?= Helper::menu_tree_admin(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", "fa"]])->toArray(),"fa"); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Russian version links</div>
                    <div class="panel-body">
                        <?= Helper::menu_tree_admin(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", "ru"]])->toArray(),"ru"); ?>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
    
@endsection
