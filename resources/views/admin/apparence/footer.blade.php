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

            <!--<div class="col-md-6">-->
            <!--    <div class="panel panel-default">-->
            <!--        <div class="panel-heading">Arabic Version Links</div>-->
            <!--        <div class="panel-body">-->
            <!--            <?= Helper::menu_tree_admin(0, 0, Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", "ar"]])->where("footer_section", "links")->toArray()); ?>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="col-md-6">-->
            <!--    <div class="panel panel-default">-->
            <!--        <div class="panel-heading">English Version Links</div>-->
            <!--        <div class="panel-body">-->
            <!--            <?= Helper::menu_tree_admin(0, 0, Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", "en"]])->where("footer_section", "links")->toArray(), "en"); ?>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            <div class="clearfix"></div><hr>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Quick Links</div>
                    <div class="panel-body">
                        <?php $q_links = Helper::query("FooterLink", "orderByPlacement")->where("footer_section", "quick")->toArray(); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <th>Link</th>
                                    <th style="width:80px;"></th>
                                </tr>
                                @foreach($q_links as $q_link)
                                <tr>
                                    <td>- <?= $q_link["title_ar"]; ?> <br>- <?= $q_link["title_en"]; ?> <br>- <?= $q_link["title_fr"]; ?> <br>- <?= $q_link["title_fa"]; ?> <br>- <?= $q_link["title_ru"]; ?></td>
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
            </div>
        </div>
    </div>
</div>

@endsection
