@extends('admin.layouts.app', ["app_title" => "خريطة الموقع"])
@section('main_content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">إدارة روابط الخريطة</h3>
        <!--<div class="pull-left">
            <?= Form::select("location", ["header" => "هيدر", "footer" => "فوتر"], Input::get('location'), ["class" => "form-control"]); ?>
        </div>-->
    </div>
    <div class="box-body">
        
        <div class="row">
            <?= Form::open(); ?>
            <div class="col-md-12">
                @include("admin.sitemap_cat.partials.links")
            </div>
            <?= Form::close(); ?>
            <!-- Lists -->
            <div class="col-md-12">
                <!--<p class="text-danger"> <i class="fa fa-warning"></i> <b>Note</b></p>-->
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">روابط النسخة العربية</div>
                    <div class="panel-body">
                        <?= str_replace('<ul class="list-group"></ul>','',Helper::menu_tree_admin(0, 0, Helper::query("SitemapCats", "orderByPlacement", ["lang" => ["all", "ar"]])->toArray())); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                    <div class="panel-heading">روابط النسخة الإنجليزية</div>
                    <div class="panel-body">
                        <?= str_replace('<ul class="list-group"></ul>','',Helper::menu_tree_admin(0, 0, Helper::query("SitemapCats", "orderByPlacement", ["lang" => ["all", "en"]])->toArray(), "en")); ?>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
    
@endsection
