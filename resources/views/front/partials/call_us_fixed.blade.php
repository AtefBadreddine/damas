<?php
if(!isset($hide_whatsapp))
	$hide_whatsapp = false;
	
	$whatsappContext = isset($project) ? $project : (isset($locationCountry) ? $locationCountry : null);
	$whatsappTel = Helper::whatsappNumber($whatsappContext);
	$whatsappTelDisplay = Helper::whatsappNumberDisplay($whatsappContext);




$ccountry = ((strpos(request()->getPathInfo(), '/oman') !== false or strpos(request()->getPathInfo(), '/muscat') !== false)?'oman':'turkey');
	
?>




<div class="info">
    <div class="tel">
	<?php /*            <img class="icon" src="<?= asset("img/callCenterIcon.svg"); ?>" alt="Call Center Icon"/> */ ?>
        <a title="Call" class="telephone faa-ring animated faa-slow" href="tel:<?= $whatsappTel ?>">
<svg width="20" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 294.2 288.2" xml:space="preserve"> <g> <path d="M270.5,220.9c-0.6,3.1-1,6.3-1.9,9.3c-4.1,13.5-8.2,27.1-12.5,40.6c-4.4,14-13.8,19.6-28.2,16.8 C150,272.2,88.4,231.8,43.8,166c-9.8-14.5-18-30.1-24.9-46.5c-8.2-19.5-14.1-39.4-18.2-60c-2.4-12.4,2.2-22.1,14.1-26.2 C30.3,27.9,46,23,61.9,18.8c13.1-3.5,22.4,2.4,26.3,15.3c5.5,18,10.9,36,16.6,53.9c2.7,8.6,0.3,15.4-6.3,21 c-5.9,4.9-12.1,9.4-18,14.3c-6.5,5.3-7.3,10.9-2.5,17.9c18.7,27.4,41.8,50.4,69.1,69.2c7.2,4.9,12.7,4.1,18.2-2.7 c4.5-5.6,8.8-11.3,13.3-16.9c6.4-7.9,12.8-9.9,22.5-6.9c18,5.5,36,11,53.9,16.5C265.8,203.6,270.3,209.6,270.5,220.9z"></path> <path d="M294.2,142.3c-0.2,1.1,0,3.7-0.9,5.9c-1.1,2.8-8.6,4.7-12.6,2.6c-2.2-1.1-4.4-4.4-4.5-6.8 c-2.8-63.1-53.6-117.7-116.5-124.9c-3-0.3-6-0.7-8.9-0.9c-6.4-0.5-8.3-3.1-7.9-11.1c0.3-5.3,2.7-7.5,8.6-7.1 c32.4,1.9,61.5,12.8,86.7,33.3c32.4,26.4,50.7,60.7,55.7,102.1C294,137.3,294,139.2,294.2,142.3z"></path> <path d="M241.9,140.7c-0.3,7.9-2.3,10.5-7,10.8c-8,0.5-10.2-1.2-11.3-8.3c-5.7-40.4-33-67.5-73.5-72.7c-6.5-0.8-8.2-3.7-7.3-12 c0.5-4.6,3.2-6.6,9-6.1c42.1,3.6,78.5,34.3,88.1,77.3C240.9,133.8,241.5,138.1,241.9,140.7z"></path> </g> </svg>
        </a>
        <p class="jazzira_font_bold"><?= trans("front.AskAdvice"); ?></p>
        <a title="Call" class="num" href="tel:<?= $whatsappTel ?>"><?= $whatsappTelDisplay ?></a>
    </div>
	<?php if($hide_whatsapp==false){ ?>
    <a title="whatsapp" href="<?= Helper::whatsappShareUrl(8, $whatsappContext) ?>" class="whatsapp" target="_blank">
        <img loading="lazy" width="55" height="55" class="icon faa-tada animated faa-slow" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="whatsapp-icon"/>
		<?php /* <!--<svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39"><path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path><path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path></svg>-->  */ ?>
    </a>
	<?php } ?>
</div>
<div style="clear: both"></div>
<?= Form::open(["url" => route("front.callus"), "id" => "form-callus-lg"]); ?>
<div class="name"><input class="form-control"  type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>"></div>


@if(isset($_GET['ct']))
<input type="hidden" value="{{ $_GET['ct'] }}" name="ccountry" />
@else
<input type="hidden" value="{{ isset($ccountry)?$ccountry:'turkey' }}" name="ccountry" />
@endif
<div style="clear: both"></div>
<div class="tel"><input class="form-control" type="text" name="mobile" value="{{ @session()->get('call_country') }}" id="mobile-sm" placeholder=""></div>
<div class="textarea"><textarea class="form-control" name="message" rows="2" cols="20" placeholder=" <?= trans("front.How can we help you"); ?>..."></textarea></div>
<div style="clear: both"></div>
<div class="options">
    <div class="time">
        <select class="form-control" name="communication_time" title="<?= trans("front.communication time"); ?>">
            <option value="" id="tm"><?= trans("front.communication time"); ?></option>
            <option value="9 - 12">9 - 12</option>
            <option value="12 - 15">12 - 15</option>
            <option value="15 - 18">15 - 18</option>
            <option value="18 - 21">18 - 21</option>
            <option value="Any Time"><?= trans("front.any time"); ?></option>
            <option value="Now"><?= trans("front.now"); ?></option>
        </select>
    </div>
	<?php /*    <!--        <div class="budget">
                <div class="dropdown">
                    <button class="form-control dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?= trans("front.budget"); ?>  <span class="number"></span>
                    </button>
                    <div id="budgetMenu" class="dropdown-menu shadow_type" aria-labelledby="dropdownMenuButton">
                        <div class="range-slider">
                            <span class="rangeValues number"></span>
                            <input value="50000" class="min_budj" min="50000" max="2000000" step="50000" type="range">
                            <input value="100000" class="max_budj" min="50000" max="2000000" step="50000" type="range">
                        </div>
                    </div>
                </div>
            </div>-->  */ ?>
</div>

<button type="submit" class="send">
    <img class="icon" src="<?= asset("img/sendIconW.svg"); ?>" alt="Send Icon" width="21" height="20"/>
	<?php /*<!--        <p><?= trans("front.Request a free consultation"); ?></p>-->*/ ?>
</button>

</form>
