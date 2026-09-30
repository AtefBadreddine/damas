@extends('admin.layouts.app', ["app_title" => "Footer"])
@section('main_content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Footer Settings</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            
            
            <div class="col-md-12">
                @include("admin.apparence.partials.links")
            </div>
            
            
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Arabic Version Links</div>
                    <div class="panel-body">
                        <?= Helper::menu_tree_admin(0, 0, Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", "ar"]])->where("footer_section", "links")->toArray()); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                    <div class="panel-heading">English Version Links</div>
                    <div class="panel-body">
                        <?= Helper::menu_tree_admin(0, 0, Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", "en"]])->where("footer_section", "links")->toArray(), "en"); ?>
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div><hr>
            
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Useful Links</div>
                    <div class="panel-body">
                        <?php
                            $u_links = Helper::query("FooterLink", "orderByPlacement")->where("footer_section", "useful")->toArray();
                            $footerCountriesById = \App\Models\Country::ordered()->get()->keyBy('id');
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Country</th>
                                <th>Link</th>
                                <th style="width:80px;"></th>
                            </tr>
                            @foreach($u_links as $u_link)
                            <tr>
                                <td>- <?= $u_link["title_ar"]; ?> <br>- <?= $u_link["title_en"]; ?> <br>- <?= $u_link["title_fr"]; ?> <br>- <?= $u_link["title_fa"]; ?> <br>- <?= $u_link["title_ru"]; ?></td>
                                <td><?= isset($footerCountriesById[$u_link["country_id"]]) ? $footerCountriesById[$u_link["country_id"]]->name_en : ''; ?></td>
                                <td><?= $u_link["link"]; ?></td>
                                <td>
                                    <a href="<?= route(Route::currentRouteName(), $u_link["id"]); ?>" class="btn btn-primary btn-xs" title="edit"><i class="fa fa-edit"></i></a>
                                    <?= Form::open(["method" => "DELETE", "url" => route(Route::currentRouteName().".delete", $u_link["id"]), "class" => "inline"]); ?>
                                        <button class="btn btn-danger btn-xs button_confirm" title="delete"><i class="fa fa-trash"></i></button>
                                    <?= Form::close(); ?>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Quick Links</div>
                    <div class="panel-body">
                        <?php $q_links = Helper::query("FooterLink", "orderByPlacement")->where("footer_section", "quick")->toArray(); ?>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Link</th>
                                <th style="width:80px;"></th>
                            </tr>
                            @foreach($q_links as $q_link)
                            <tr>
                                <td>- <?= $q_link["title_ar"]; ?> <br>- <?= $q_link["title_en"] ?> <br>- <?= $q_link["title_fr"] ?> <br>- <?= $q_link["title_fa"]; ?> <br>- <?= $q_link["title_ru"]; ?></td>
                                <td><?= $q_link["link"]; ?></td>
                                <td>
                                    <a href="<?= route(Route::currentRouteName(), $q_link["id"]); ?>" class="btn btn-primary btn-xs" title="edit"><i class="fa fa-edit"></i></a>
                                    <?= Form::open(["method" => "DELETE", "url" => route(Route::currentRouteName().".delete", $q_link["id"]), "class" => "inline"]); ?>
                                        <button class="btn btn-danger btn-xs button_confirm" title="delete"><i class="fa fa-trash"></i></button>
                                    <?= Form::close(); ?>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            
            <!--<div class="col-md-12">
                <?= Form::open(["url" => route("admin.apparence.footer", [0, "posts"])]); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">المقالات المميزة</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>المقالات</label>
                            <select name="posts[]" class="form-control select2me" multiple>
                                @foreach(Helper::query("Post", "all") as $post)
                                    <option value="<?= $post->id; ?>"><?= $post->title_ar; ?></option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </div>
                <?= Form::close(); ?>
            </div>-->
            
        </div>
    </div>
</div>

@endsection