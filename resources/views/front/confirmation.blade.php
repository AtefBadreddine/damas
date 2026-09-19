@extends('front.layout')
@section('main_content')
	<?php
	$infos = Helper::get_params();
	$lang = LaravelLocalization::getCurrentLocale();
	$current_lang = $lang;
	$device = 'web';
	if(Helper::is_mobile())
	$device = 'mobile';
	?>

<?php
if(App::isLocal()){ ?>

<?php }else{ ?>

	<?php /*<style><?php include(public_path()."/css/confirmation". ($current_lang=='en'?'-en':'') .".min.css"); ?></style> */ ?>

<?php } ?>

<style>
.btn-default{
		    background-color: #0b7f7f;color:white;    margin-top: 28px;
		}
.btn-default:hover{
		    background-color: #132440;color:white;
		}
    .pagesuccess {
        padding: 40px 0 23px 0;
        text-align:center;
    }

	.blk_form_mail{
		position:relative !important
	}
	
	.blk_form_mail picture img {
	    width: 50%;
	}
	

	<?php //@if($device == 'web') ?>
	@media(min-width: 650px){
	.blk_form_mail form{
    position: absolute;
	left: 26.5%;
    padding: 0 0 0 17px;
    bottom: 50%;
    width: 45%;
    text-align: center;
	}	
	.blk_form_mail form input{
		border-radius: 13px !important;
	}
	.blk_form_mail form .btn-primary{
	padding: 5px;
    height: 31px;
	line-height: 1;
	color:white;
	border-radius: 5px !important;
    background-color: #005c73;
    border-color: #005c73 !important;
    border-radius: 13px !important;
    margin-left: 7px !important;
    padding: 3px 15px 4px 15px !important;
    font-size: 0.9rem !important;
    height: 100%;
    font-family: 'Montserrat' , sans-serif !important;
    transition: all 200ms ease;
	}
	.blk_form_mail form .btn-primary:hover {
    background-color: #078383 !important;
    border-color: #078383 !important;
	}


}
	<?php //@else ?>

/*MOB*/
@media(max-width: 650px){
	.blk_form_mail{
	margin: 0 auto;
    max-width: 442px;
	width: 100%;
	}
	.blk_form_mail picture img {
	    width: 100%;
	}
	.blk_form_mail form{
    position: absolute;
	left:0;
    width: 80%;
    bottom: 48% !important;
	text-align: center;
	margin: 0 calc(25% / 2);
	}
	.blk_form_mail form input{
		padding: 5px;
		height: 31px;
		border-radius: 5px !important;
	}
	.blk_form_mail form .btn-primary{
	padding: 5px;
    height: 31px;
	line-height: 1;
	color:white;
	border-radius: 5px !important;
    background-color: #005c73;
    border-color: #078383 !important;
    border-radius: 13px !important;
    margin-left: 7px !important;
    padding: 3px 15px 4px 15px !important;
    font-size: 0.9rem !important;
    height: 100%;
    font-family: 'Montserrat' , sans-serif !important;
    transition: all 200ms ease;
	}

	
	.blk_form_mail form div.input-group{
	    width: 100% !important;
	}
	.blk_form_mail form div.input-group input, .blk_form_mail form div.input-group span button.btn.btn-primary {
	    height: 25px !important;
	    font-size: 0.75rem !important;
	    border-radius: 13px !important;
	}
	


}
<?php //@endif ?>
</style>

<section class="pagesuccess">
    <div class="container text-center" <?= $lang=='en'?'style="max-width:900px"':''?>>
        <!--<div class="alert alert-success">
            <b><?= trans("front.thank you for contacting us. We will contact you soon"); ?></b>
        </div>

		<div class="panel panblk_form_mailel-default">-->
            <!--<div class="panel-heading"><h4 class="panel-title"><?= trans("front.signup to our newsletter confiramation"); ?></h4></div>-->
            <div class="blk_form_mail">

			<!--
			<img src="<?= asset("img/confirmation_".$device."_". ($lang=='pe'?'fa':$lang) .".jpg")?>" class="img-responsive" style="width:100%;border-radius:38px"/>
			-->
			
			<picture>
			   <source media="(min-width: 650px)" srcset="<?= asset("img/confirmation_all.jpg")?>">
			   <source media="(max-width: 650px)" srcset="<?= asset("img/confirmation_all.jpg")?>">
			   <img src="<?= asset("img/confirmation_all.jpg")?>" class="blog_photo" 
			   loading="lazy"  width="100%" height="528" style="height:auto;">
			   	<?php if(!isset($_GET['t'])){ ?>
                    <?= Form::open(); ?>
                        <div class="input-group form-group" style="direction: ltr">
                            <input type="email" name="email" class="form-control" placeholder="Enter your e-mail..." style="border-radius:0;" required>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit" style="border-radius:0;color:white;">Submit</button>
			    				<!--<?= @session()->get('callus_success') ?>-->
			    				<!--<?= @$_GET['page'] ?>-->
                            </span>
                        </div>
                    <?= Form::close(); ?>
			    <?php } ?>
			</picture>
			
            </div>
        
		<a href="<?= route("front.index"); ?>" class="btn btn-default">
            <i class="fa fa-home"></i> <?= trans("front.back to homepage"); ?>
        </a>
        <a href="<?= @$_SERVER["HTTP_REFERER"]; ?>" class="btn btn-default">
            <i class="fa fa-chevron-left"></i> <?= trans("front.previous page"); ?>
        </a>
    </div>
</section>

<?php //session()->forget("callus_success"); ?>

@endsection
