<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= @$app_title; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="image/vnd.microsoft.icon" href="https://damas.net/favicon-32x32.png" />
    <link rel="stylesheet" href="<?= asset('admin/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?= asset('admin/css/font-awesome.css'); ?> ">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.css">-->
    <link rel="stylesheet" href="<?= asset('admin/css/admin.min.css'); ?>">
    <link rel="stylesheet" href="<?= asset('admin/css/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?= asset('admin/select2/select2.css'); ?>">
    <link rel="stylesheet" href="<?= asset('admin/css/icheck.css'); ?>">
    <link rel="stylesheet" href="<?= asset('admin/css/style.css'); ?>">
    
    <script src="<?= asset('js/jquery.min.js'); ?>"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<style>
	.content-wrapper{direction:ltr}
	.hiddenz{opacity:0.2}
	</style>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.3.2/css/flag-icons.min.css" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    
    <?php $auth_user = Auth::user(); ?>
    
    <header class="main-header">
        <a href="<?= route('admin.index'); ?>" class="logo">
            <span class="logo-lg"><b><i style="font-size: 18px;">DAMAS ADMIN</i></b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu hidden">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?= asset('img/user.jpg'); ?>" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <li class="dropdown notifications-menu hidden">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <li class="dropdown tasks-menu hidden">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <h3>Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= asset('img/user.jpg'); ?>" class="user-image" alt="User Image">
                            <span><?= $auth_user->name; ?> </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="<?= asset('img/user.jpg'); ?>" class="img-circle" alt="User Image">
                                <p><?= $auth_user->name; ?></p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left"><a href="<?= route("admin.compte"); ?>" class="btn btn-default btn-flat">My Account</a></div>
                                <div class="pull-right"><a href="<?= route('logout'); ?>" class="btn btn-danger btn-flat">Log Out</a></div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
    <aside class="main-sidebar">
        <section class="sidebar">
<!--            <div class="user-panel">
                <div class="pull-right image">
                    <img src="<?= asset('img/user.jpg'); ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-right info">
                    <p><?= $auth_user->name; ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>-->
<!--            <div class="text-center">
                <a class="damasLink" href="<?= route("front.index"); ?>" target="_blank"><b>Damas.net</b></a>
            </div>-->
            <!--<form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="بحث...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>-->
            @include('admin.layouts.menu')
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1><?= @$app_title; ?> <small><?= @$app_desc; ?></small></h1>
        </section>
        <section class="content">
            @if (session('flashmessage'))
                <div class="alert alert-<?= session('flashmessage.typ'); ?>"><?= session('flashmessage.message'); ?></div>
            @endif
            
            @yield('main_content')
        </section>
    </div>
    
    <div class="modal fade" role="dialog" id="modelMAJ">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="content_maj"></div>
        </div>
    </div>
    
    <div id="ajaxloading"><div id="ajaxspinner"></div></div>

    <footer class="main-footer hidden">
        <strong>Copyright &copy; 2014-2015.</strong> All rights reserved.
    </footer>

</div>

<script src="<?= asset('js/bootstrap.min.js'); ?>"></script>
<script src="<?= asset('admin/select2/select2.min.js'); ?>"></script>
<script src="<?= asset('admin/js/icheck.min.js'); ?>"></script>
<script src="<?= asset('admin/js/bootbox.min.js'); ?>"></script>
<script src="<?= asset('admin/js/app.js'); ?>?v=02"></script>
<script src="<?= asset('admin/js/admin.js'); ?>?v=03"></script>
@if( Route::currentRouteName()!='admin.projects' && Route::currentRouteName()!='admin.newsletter' && Route::currentRouteName()!='admin.blog.posts' )
<script>
    var somethingChanged = false;
    $('form input').change(function() { 
        somethingChanged = true; 
    });
    $(window).bind('beforeunload', function(e){
        if(somethingChanged) return "You made some changes and it's not saved?";
        else e = null;
    });
    $(document).on("click", ".btn_submit", function(){
        somethingChanged = false;
    });
	


</script>
@endif

@yield('scriptjs')

@if(Route::currentRouteName()=='admin.statistics')
<script>
$('.statics_fields').change(function(){

	if($('#year').val()!='' && $('#month').val()!='' && $('#iitype').val()!='')
	window.location.href = '?year='+$('#year').val()+'&month='+$('#month').val()+'&type='+$('#iitype').val();
});
$('.statics_fields').on('ifChecked', function(event){
	$('#iitype').val(this.value);
	if($('#year').val()!='' && $('#month').val()!='' && this.value!='')
	window.location.href = '?year='+$('#year').val()+'&month='+$('#month').val()+'&type='+this.value;
});
</script>
@endif

</body>
</html>
