<?php
$current_lang = LaravelLocalization::getCurrentLocale();
//$photoCard = $post->photoCard;
$infos = Helper::get_params();
$is_mobile = Helper::is_mobile();
?>
@section('styles')

<?php if (App::isLocal()) { ?>





    <?= Html::style("resources/assets/css/vacancies_full.css"); ?>
    <?php if ($current_lang == 'ar' || $current_lang == 'fa') { ?>

    <?php } else { ?>
        <?= Html::style("resources/assets/css/vacancies-en.css"); ?>
    <?php } ?>


<?php } else { ?>

    <?= Html::style("css/vacancies_full.min.css"); ?>
<?php if ($current_lang == 'ar' || $current_lang == 'fa') { ?>

    <?php } else { ?>
        <?= Html::style("css/vacancies-en.min.css"); ?>
    <?php } ?>
<?php } ?>


@endsection
<?php
$current_lang = LaravelLocalization::getCurrentLocale();
?>
<?php
//$page_title = $row->getSeoTitle();
$page_title = trans("front.job Submitted title one");
$page_description = trans("front.job Submitted title two");
?>
@extends('front.layout', [
"page_title" => $page_title,
"page_description"  =>  $page_description,
"og_image"          =>    asset('img/job-opportunities-share-photo.jpg')
])
@section('main_content')





<div id="fullpage" class="full-type">

    <div class="container">

        <div class="submitted_sec">

            <p class="text">

                <strong class="jazzira_font_bold">
                    <?= trans("front.job Submitted title one") ?>
                </strong>
                <br>
                <?= trans("front.job Submitted title two") ?>
                <br>
                <?= trans("front.job Submitted title three") ?>
                <br>

                <span class="email"><a class="email num" href="mailto:hr@damas.net">hr@damas.net</a></span>

                <br>
                <?= trans("front.job Submitted title four") ?>
                <b class="num career_code" id="careerCode">{{ @$_GET['job_code'] }}</b>
                <button id="copyAlert" class="btn btn-sm btn-primary" onclick="myFunction()"><?= trans("front.job Click copy") ?></button>

            </p>


        </div>
    </div>


</div>







@endsection



@section('scriptjs')


<script src="{{ URL::to('js/jquery.form.js') }}"></script> 
<!--<script type="text/javascript" src="{{ URL::to('js/scrol_overflow.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/scrollpage.js') }}"></script>-->
<script>

	var ClickToCopyCode = "<?= trans("front.job Click copy") ?>";
	var copied = "<?= trans("front.job copied") ?>";

	function myFunction() {
		/* Get the text field */
		var copyText = document.getElementById("careerCode").innerText;
		var alertText = document.getElementById("copyAlert");


		navigator.clipboard.writeText(copyText);


		alertText.innerText = copied;
		setTimeout(function () {
			alertText.innerText = ClickToCopyCode;
		}, 750);
	}




(function (global) {

if(typeof (global) === "undefined") {
	throw new Error("window is undefined");
}

var _hash = "!";
var noBackPlease = function () {
	global.location.href += "#";

	global.setTimeout(function () {
		global.location.href += "!";
	}, 50);
};

global.onhashchange = function () {
	if (global.location.hash !== _hash) {
		global.location.hash = _hash;
	}
};

global.onload = function () {
	noBackPlease();


	document.body.onkeydown = function (e) {
		var elm = e.target.nodeName.toLowerCase();
		if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
			e.preventDefault();
		}
		
		e.stopPropagation();
	};
}
})(window);
</script>


@endsection