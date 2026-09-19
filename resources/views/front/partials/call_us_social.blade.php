<?php /* <div class="floating-message-inline callus-inline-custom">
  <?= Form::open(["url" => route("front.callus"), "id" => "form-callus-landing"]); ?>
  <div class="header-overlay-container">
  <div class="panel header-contactform bluring clearfix">
  <h4 class="panel-heading text-center anim">

  <span class="pull-right whatsappidspn" onclick="location.replace('https://damas.net/whatsapp_share?icon=5');"> <span><i class="flaticon-app"></i></span> </span>

  <span class="ctitle"><?= trans("front.ask for a free consultation"); ?></span>
  </h4>
  <div class="panel-body bluring">
  <div class="row">
  <div class="form-group col-xs-6 rtlpl5">
  <input type="text" name="name" placeholder="* <?= trans("front.name"); ?>" class="bluring form-control">
  </div>
  <div class="form-group col-xs-6 rtlpr5">
  <input type="text" name="fame" placeholder="* <?= trans("front.fame"); ?>" class="bluring form-control">
  </div>
  </div>
  <div class="form-group">
  <input type="email" name="email" placeholder="* <?= trans("front.email"); ?>..." class="bluring form-control">
  </div>
  <div class="form-group" dir="ltr">
  <input type="text" name="mobile" id="InputMobile" placeholder="+90 123456789" class="bluring form-control">
  </div>
  <div class="form-group">
  <textarea name="message" placeholder="* <?= trans("front.is the property for housing or tourism? how many rooms?"); ?>..." rows="2" class="bluring form-control"></textarea>
  </div>
  <div class="row">
  <div class="col-md-6 col-xs-5 form-group pl5 rtlpl5">
  <select name="communication_time" class="form-control" title="<?= trans("front.communication time"); ?>">
  <option value=""><?= trans("front.communication time"); ?></option>
  <option dir="ltr">9 - 12 AM</option>
  <option dir="ltr">12 - 3 PM</option>
  <option dir="ltr">3 - 6 PM</option>
  <option dir="ltr">6 - 9 PM</option>
  <option dir="ltr"><?= trans("front.any time"); ?></option>
  <option dir="ltr"><?= trans("front.now"); ?></option>
  </select>
  </div>
  <div class="col-md-4 col-xs-5 form-group pl5 rtlpr5">
  <select name="budget" class="form-control" title="<?= trans("front.budget"); ?>">
  <option value=""><?= trans("front.budget"); ?></option>
  <option dir="ltr">&lt; 50K $</option>
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
  <div class="col-md-2 col-xs-2 form-group pr5 sml_send">
  <div class="select">
  <button type="submit"><img src="https://damas.net/img/send-icon.png" class="img-responsive" alt="Send"></button>
  </div>
  </div>
  </div>
  <input type="hidden" name="form_type" value="<?= @$form_type; ?>">
  </div>
  </div>
  </div>
  <?= Form::close(); ?>
  </div>
  <div class="most-popular callus-social">
  @include("front.blog.partials.social", ["callus_form" => true])
  </div>
 */ ?>














<?php
$current_lang = LaravelLocalization::getCurrentLocale();
?>
<section class="down-form-content <?= isset($class) ? $class : '' ?>" <?= isset($style) ? 'style="' . $style . '"' : '' ?> id="section_callcenter_left">

    <div class="down-form">
        <?= Form::open(["url" => route("front.callus"), "id" => "form-callus-lg"]); ?>

        <!--        <div class="panel-heading text-center anim text-center-title">
                <span class="pull-right whatsappidspn" onclick="location.replace('https://damas.net/whatsapp_share?icon=5');"> <span><i class="flaticon-app"></i></span> </span>
                    <div class="whatsapp">
                        <a target="_blank" href="https://damas.net/whatsapp_share?icon=5">
                            <div class="whatsapp-icon"><i class="fa fa-whatsapp"></i></div>
                        </a>
                    </div>
                    <span class="ctitle"><?= trans("front.ask for a free consultation"); ?></span>
                </div>-->



        <div class="form-info-new">
            <div class="clientimg"><img src="<?= asset("img/client.png"); ?>"></div>
            <div class="tel">
                <div class="service"><?= trans("front.AskAdvice") ?></div>
                <div class="num">+905551605000</div>
            </div>

            <div class="whatsapp">
                <a target="_blank" href="{{ route('front.whatsapp_share') }}?icon=22">
                    <div class="whatsapp-icon"><i class="fa fa-whatsapp"></i></div>
                </a>
            </div>
        </div>






        <div class="line1">
            <div class="name"><input type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>"></div>
<!--			<div class="fame"><input type="text" name="fame" placeholder="* <?= trans("front.fame"); ?>"></div>-->
            <!--			<div class="email">
                                            <input type="text" name="email" placeholder="* <?= trans("front.email"); ?>..." class="inptemail bluring" />
                                    </div>-->
        </div>
        <div style="clear: both"></div>
        <div class="tel">



            <input type="text" name="mobile" value="{{ @session()->get('call_country') }}" placeholder="+90 123456789" id="mobile-sm"></div>
        <div style="clear: both"></div>
        <div class="text"><textarea rows="4" name="message" placeholder=" <?= trans("front.is the property for housing or tourism? how many rooms?"); ?>"><?= trans("front.is the property for housing or tourism? how many rooms?"); ?></textarea></div>
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
                    @if(Helper::is_mobile())
                    <option value="" id="bd"><?= trans("front.budget"); ?></option>
                    @else
                    <option value="" id="bd"><?= trans("front.budget"); ?> (<?= trans("front.optional"); ?>)</option>
                    @endif
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
    </div>
    @if(Helper::get_device()=='full')
    <?php /* ?>
      <div class="most-popular callus-social">
      @include("front.blog.partials.social", ["callus_form" => true])
      </div>
      <?php */ ?>
    @endif
</section>