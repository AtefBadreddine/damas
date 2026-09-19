
<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>تسجيل الدخول</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="robots" content="noindex">
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?= asset("img/favicona.png"); ?>" />
        <link rel="stylesheet" href="<?= asset('css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= asset('css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?= asset('admin/css/admin.min.css'); ?>">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

    </head>
    <body class="hold-transition login-page" dir="rtl">
        <!--        <div class="login-box">
                    <div class="login-logo">
                        <a href="<?= route('front.index'); ?>"><b>داماس العقارية</b></a>
                    </div>
                    <div class="login-box-body">
                        <h3 class="login-box-msg">تسجيل الدخول</h3>
                        @include('partials.form_errors')
        <?= Form::open(); ?>
                        <div class="form-group has-feedback">
        <?= Form::text("username", null, ["class" => "form-control", "placeholder" => "اسم المستخدم"]); ?>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
        <?= Form::password("password", ["class" => "form-control", "placeholder" => "كلمة المرور"]); ?>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-8"></div>
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">دخول</button>
                            </div>
                        </div>
        <?= Form::close(); ?>
                    </div>
                </div>-->




        <div class="full-section">
            <img class="crm-logo" src="<?= asset("admin/img/logo-admin-new.svg"); ?>" alt="Damas"/>
            <div class="justify-content-center align-items-center h-100">

                <div class="section-left"></div>
                <div class="section-right">
                    <h2 class="mb-3">
                        Welcome in DAMAS ADMIN
                    </h2>
                    @include('partials.form_errors')
                    <div class="mb-5">
                        <div class="card-body">
                            <?= Form::open(); ?>
                            <div class="form-group has-feedback">
                                <?= Form::text("username", null, ["class" => "form-control", "placeholder" => "Username"]); ?>
                                <span>Username</span>
                            </div>
                            <div class="form-group has-feedback">
                                <?= Form::password("password", ["class" => "form-control", "placeholder" => "Password"]); ?>
                                <span>Password</span>
                            </div>
                            <div class="col-xs-8"></div>
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                            <?= Form::close(); ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>





    </body>
</html>