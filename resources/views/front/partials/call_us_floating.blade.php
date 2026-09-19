<?php
    $is_mobile = Helper::is_mobile();
	if($is_mobile){
		
    $form_type = @$form_type;
    $class_inline = @$class_inline;
    if ( !$form_type ) {
        $name_route = Route::currentRouteName();
        switch ($name_route)
        {
            case "front.index":$form_type = "Pop Up - Home";break;
            case "front.search":$form_type = "Pop Up - Search";break;
            case "front.project":$form_type = "Pop Up - Project";break;
            case "front.contactus":$form_type = "Pop Up - Contact Us";break;
            case "front.landingpage":$form_type = "Pop Up - Landing";break;
            case "front.blog":$form_type = "Pop Up - Blog";break;
            case "front.blog.post":$form_type = "Pop Up - Post";break;
            case "front.blog.category":$form_type = "Pop Up - Post Category";break;
            case "front.privacy":$form_type = "Pop Up - Privacy";break;
            case "front.terms":$form_type = "Pop Up - Terms";break;
        }
    }
?>
<!-- floating message -->
<div class="<?= $class_inline ? "floating-message-inline" : "floating-message"; ?>">
    <div class="container">
		
		@if($is_mobile)
        
        <div class="bluring">
            @include("front.partials.call_us_mobile", [
                "form_type" => $form_type,
                "id" => "form-callus-floating",
                "close_btn" => true,
            ])
        </div>
        
        @else
	
        <?= Form::open(["url" => route("front.callus"), "id" => ($class_inline ? "form-callus-lg" : "form-callus-floating")]); ?>
        <div class="header-overlay-container">
            <div class="panel header-contactform bluring">
                <div class="clearfix"></div>
                <aside class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12 hidden-xs">
                        <div>
                            <img src="<?= asset("img/call-center.png"); ?>" class="img-responsive bluring" alt="call-center">
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                         <h4 class="panel-heading text-center bluring">
                            <img src="<?= asset("img/Phone-icon.png"); ?>" alt="img"> 
                            <?= $is_mobile ? trans("front.let us help you to make dicision 2") : trans("front.let us help you to make dicision"); ?> 
                        </h4>
                        <div class="panel-body bluring">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>..." class="bluring form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="* <?= trans("front.email"); ?>..." class="bluring form-control">
                            </div>
                            <div class="form-group" dir="ltr">
                                <input type="text" name="mobile" value="{{ @session()->get('call_country') }}" id="<?= $class_inline ? 'mobile-lg' : 'InputMobile'; ?>" placeholder="+90 123456789" class="bluring form-control">
                            </div>
                            <div class="form-group">
                                <textarea name="message" placeholder="* <?= trans("front.is the property for housing or tourism? how many rooms?"); ?>..." rows="3" class="bluring form-control"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-6 form-group pl5">
                                    <select name="communication_time" class="form-control" title="<?= trans("front.communication time"); ?>">
                                        @if(Helper::is_mobile())
                                            <option value=""><?= trans("front.communication time"); ?></option>
                                        @else
                                            <option value=""><?= trans("front.communication time"); ?> (<?= trans("front.optional"); ?>)</option>
                                        @endif
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
                                        @if(Helper::is_mobile())
                                            <option value=""><?= trans("front.budget"); ?></option>
                                        @else
                                            <option value=""><?= trans("front.budget"); ?> (<?= trans("front.optional"); ?>)</option>
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
                            </div>
                            <input type="hidden" name="form_type" value="<?= @$form_type; ?>">
                            <div class="row">
                                <div class="col-md-3 col-xs-4">
                                    <button type="submit" class="btn btn-lg bluring"><i class="fa fa-send"></i> <?= trans("front.send"); ?></button>
                                </div>
                                @if(!$class_inline)
                                <div class="col-md-9 col-xs-8">
                                    <p class="close-it text-left"><span class="fa fa-close pull-right"></span> <?= $is_mobile ? trans("front.close free consultation 2") : trans("front.close free consultation"); ?></p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
        <?= Form::close(); ?>
		
		@endif
    </div>
</div>
<!-- floating login -->
<?php } ?>