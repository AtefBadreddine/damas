<div class="form-content">
    <section class="form">


        <?php if (isset($place) and $place == 'project') { ?>
<!--            <div class="row">

                <?php list($sclass, $slab) = $project->getStatus(); ?>
                @if($sclass!='resale')
                <div class="col-sm-12"><div class="title">
                        <div class="room">
                            @if($flavor->salon==0 and $flavor->room==0)
                            @else
                            <div class="text"><?= trans("front.start"); ?></div>
                            <div class="bed">
                                <i class="flaticon-bed"></i>
                                <span><?= $flavor->salon . "+" . $flavor->room; ?></span>
                            </div>
                            @endif
                            <div class="text"><?= trans("front.from"); ?></div>
                        </div>
                        <div class="num">{{Helper::curr_format()}} <?= $project_min_price; ?></div>
                    </div>
                </div> 
                @endif
            </div>-->
            <div style="clear: both"></div>
            <div class="info">
<!--                <div class="clientimg"><img src="<?= asset("img/client.png"); ?>"></div>-->
                <div class="tel">
    <!--                    <div class="service"><?= $manager->getName(); ?></div>-->
                    <div class="service"><a href="tel:<?= $manager->phone; ?>"><?= trans("front.AskAdvice") ?><img class="faa-ring animated" src="<?= asset("img/call-new.png"); ?>" alt="icon"></a></div>
<!--                    <div class="num"><a href="tel:<?= $manager->phone; ?>"><?= $manager->phone; ?></a></div>-->
                </div>

                <div class="whatsapp">
                    <a target="_blank" href="{{ route('front.whatsapp_share') }}?icon=22">
                        <div class="whatsapp-icon"><i class="fa fa-whatsapp"></i></div>
                    </a>
                </div>
            </div>

        <?php } elseif (isset($form_type) and $form_type = "citizenship - consulting department") { ?>
            <!--المحتوى هنا سيظهر فقط في صفحة الجنسية التركية-->
            <div class="info">
                <div class="icon-bg"></div>
                <div class="clientimg"><img src="<?= asset("img/client.png"); ?>"></div>
                <div class="tel">
                    <div class="service"><?= trans("front.RealEstateConsulting") ?></div>
                    <div class="num"><a href="tel:+905551605000">+90 555 160 50 00</a></div>
                </div>

                <div class="whatsapp">
                    <a target="_blank" href="{{ route('front.whatsapp_share') }}?icon=7&tel=905551605000">
                        <div class="whatsapp-icon"><i class="fa fa-whatsapp"></i></div>
                    </a>
                </div>
            </div>

        <?php } ?>


        <div style="clear: both"></div>
        <?= Form::open(["url" => route("front.callus"), "id" => "form-callus-lg"]); ?>
        <div class="name"><input  type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>"></div>
<!--        <div class="fame"><input type="text" name="fame" placeholder="* <?= trans("front.fame"); ?>"></div>-->
<!--        <div class="email">
            <input type="text" name="email" placeholder="* <?= trans("front.email"); ?>..." class="inptemail bluring" />
        </div>-->
        <div style="clear: both"></div>
        <div class="tel"><input type="text" name="mobile"  value="{{ @session()->get('call_country') }}" id="mobile-sm" placeholder=""></div>
        <div class="textarea"><textarea name="message" rows="2" cols="20" placeholder="<?php if (isset($place) and $place == 'project') { ?>  <?= trans("front.i would like more information about this project"); ?>  <?php } elseif (isset($form_type) and $form_type = "citizenship - consulting department") { ?> <?= trans("front.I would like more information about obtaining Turkish citizenship"); ?>  <?php } ?>"><?php if (isset($place) and $place == 'project') { ?>  <?= trans("front.i would like more information about this project"); ?>  <?php } elseif (isset($form_type) and $form_type = "citizenship - consulting department") { ?> <?= trans("front.I would like more information about obtaining Turkish citizenship"); ?>  <?php } ?></textarea></div>
        <div style="clear: both"></div>
        <div class="options">
            <div class="time">
                <select name="communication_time" title="<?= trans("front.communication time"); ?>">
                    <option value="" id="tm"><?= trans("front.communication time"); ?></option>
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
                    <option value="" id="bd"><?= trans("front.budget"); ?></option>
                    <option>50K $ - 100K $</option>
                    <option>100K $ - 150K $</option>
                    <option>150K $ - 250K $</option>
                    <option>250K $ - 400K $</option>
                    <option>400K $ - 600K $</option>
                    <option>600K $ - 1M $</option>
                    <option>1M $ - 2M $</option>
                    <option>+2M $</option>
                </select>
                <input type="hidden" name="form_type" value="<?= @$form_type ?>"/>
            </div>
        </div>
        <div class="send">
            <button type="submit" class="send" style="
                    background:transparent;border:0px;outline: none"><img src="<?= asset("img/send2.png"); ?>"></button>
        </div>
        </form>
    </section>
</div>