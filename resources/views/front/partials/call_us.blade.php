<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$whatsappContext = isset($project) ? $project : (isset($locationCountry) ? $locationCountry : null);
$telccountry = Helper::whatsappNumber($whatsappContext);

?>
<section class="down-form-content call-center <?=isset($class)?$class:''?>" <?=isset($style)?'style="'.$style.'"':''?> id="section_callcenter">
<div class="title"><i class="flaticon-call-center"></i>
<h1><?= trans("front.ask free consultation"); ?></h1>


</div>
<div class="down-form">
	<?= Form::open(["url" => route("front.callus"), "id" => "form-callus-lg"]); ?>

		<div class="whatsapp">
            <a target="_blank" href="<?= Helper::whatsappShareUrl(@$form_type=='Landing - Down'?'9':'4', $whatsappContext) ?>">
                <div class="whatsapp-icon">
                    <i class="fa fa-whatsapp"></i>
                </div>
            </a>
        </div>

		<div class="line1">
			<div class="name"><input type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>"></div>
<!--			<div class="fame"><input type="text" name="fame" placeholder="* <?= trans("front.fame"); ?>"></div>-->

<!--			<div class="email">
				<input type="text" name="email" placeholder="* <?= trans("front.email"); ?>..." class="inptemail bluring" />
			</div>-->
		</div>
		<div style="clear:both"></div>
		<div class="tel">
			<input type="text" name="mobile" placeholder="+90 123456789" value="{{ @session()->get('call_country') }}" id="mobile-sm" />
		</div>
		<div style="clear: both"></div>
		<div class="text"><textarea rows="3" name="message" placeholder=" <?= trans("front.is the property for housing or tourism? how many rooms?"); ?>"></textarea></div>
		<div style="clear: both"></div>
		<div class="options">
			<div class="time">
				<select name="communication_time" title="<?= trans("front.communication time"); ?>">
					@if(Helper::is_mobile())
						<option value="" id="tm"><?= trans("front.communication time"); ?></option>
					@else
						<option value="" id="tm"><?= trans("front.communication time"); ?> (<?= trans("front.optional"); ?>)</option>
					@endif
					<option value="9 - 12">9 - 12</option>
					<option value="12 - 15">12 - 15</option>
					<option value="15 - 18">15 - 18</option>
					<option value="18 - 21">18 - 21</option>
					<option value="Any Time"><?= trans("front.any time"); ?></option>
					<option value="Now"><?= trans("front.now"); ?></option>
				</select>
			</div>
			<div class="budget">
				<select name="budget" title="<?= trans("front.budget"); ?>">

					<option value="" id="bd"><?= trans("front.budget"); ?> (<?= trans("front.optional"); ?>)</option>

				<option dir="ltr">50K $ - 100K $</option>
				<option dir="ltr">100K $ - 150K $</option>
				<option dir="ltr">150K $ - 250K $</option>
				<option dir="ltr">250K $ - 400K $</option>
				<option dir="ltr">400K $ - 600K $</option>
				<option dir="ltr">600K $ - 1M $</option>
				<option dir="ltr">1M $ - 2M $</option>
				<option dir="ltr">+2M $</option>
				</select>
			</div>
			
			<div class="btn">
			<input type="hidden" name="form_type" value="<?= @$form_type; ?>">
			<button type="submit" class="send" style="background:transparent;border:0px">
			<img src="<?= asset("img/send.png"); ?>">
			</button></div>
		</div>


	<?= Form::close(); ?>
	<div style="clear: both"></div>
        <div class="image"></div>
<!--	<div class="img">
		@if(Helper::get_device()!='mob')
		<img class="lazyimg" <?= isset($ajax)?'':'data-' ?>src="<?= asset("img/call-center2.png"); ?>">
		@endif
	</div>-->
</div>
</section>