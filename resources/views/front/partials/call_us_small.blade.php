<?php
    $landing = @$landing;
    $is_mobile = Helper::is_mobile();
?>
<?= Form::open(["url" => route("front.callus"), "id" => ($landing == 1 ? "form-callus-landing" : "form-callus")]); ?>
<div class="header-overlay-container">
    <div class="panel header-contactform<?= $is_mobile ? " callus-mobile" : ""; ?>">
         @if($landing == 1)
            <h4 class="panel-heading text-center bluring" style="font-size:24px;"><?= trans("front.let us help you make a decision"); ?></h4>
        @else
            <h4 class="panel-heading text-center bluring clearfix">
                <span><?= trans("front.ask for a free consultation"); ?></span>
                <a class="whatsapp-pulse whatsapp-icon visible-xs" href="https://api.whatsapp.com/send?phone=<?= Helper::mobile_num(); ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>    
            </h4>
        @endif
        <div class="panel-body">
            <div class="form-group">
                <input type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>..." class="bluring form-control">
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="* <?= trans("front.email"); ?>..." class="bluring form-control">
            </div>
            <div class="form-group" dir="ltr">
                <input type="text" value="{{ @session()->get('call_country') }}" name="mobile" id="mobile-sm" placeholder="+90 123456789" class="bluring form-control">
            </div>
            <div class="form-group">
                <textarea name="message" placeholder="* <?= trans("front.what is the desired property"); ?>..." rows="<?= $is_mobile ? "1" : "3"; ?>" class="bluring form-control"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 col-xs-6 form-group pl5">
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
                <div class="col-md-6 col-xs-6 form-group pr5">
                    <select name="budget" class="form-control" title="<?= trans("front.budget"); ?>">
                        <option value=""><?= trans("front.budget"); ?></option>
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
            </div>
            <input type="hidden" name="form_type" value="<?= @$form_type; ?>">
            <button type="submit" class="btn btn-lg btn-block bluring"><?= trans("front.send"); ?> <i class="fa fa-send"></i></button>
            <h5 class="callus-phone"><span class="hidden-xs"><?= trans("front.connect with us"); ?></span> <span dir="ltr"><?= Helper::mobile_num(); ?></span></h5>
        </div>
    </div>
</div>
<?= Form::close(); ?>