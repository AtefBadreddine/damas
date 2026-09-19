<?php $p_flavors = $project->flavors;
$style_lang = in_array($current_lang,['en','fr'])?'en':'ar';
?>
<section class="prices-list-content" id="isection_prices">
    <div class="title"><i class="flaticon-price"></i><h<?= $style_lang == 'en' ? '3' : '2' ?>><?= trans("front.approximate prices"); ?></h<?= $style_lang == 'en' ? '3' : '2' ?>></div><!--
    <div class="clearfix"></div>-->
    <div class="prices-list">
        <div class="top">

            <div class="col-md-12 col-sm-12 col-xs-12 section-payment">

                <?php
                if ($project->payment_method != 'نقدي') {
                    ?>




                    <?php if ($style_lang == 'ar') { ?>
                        <div class="money" <?= $project->payment_method == 'نقدي' ? 'style="margin:5px auto 16px auto"' : '' ?>>
                            <div class="txt">
                                <div class="txt1"><span ><?= trans("front.payment method"); ?></span></div>
                                <div class="txt2"><span ><?= trans('front.' . $project->payment_method); ?></span></div>
                            </div>
                        </div>
                        <div class="pay">
                            <div class="progres">
                                <span class="pro">
                                    <?= $project->payment_percent ?>%</span>
                                <span class="txt">
                                    <p><?= trans("front.advance payment"); ?></p>
                                    <strong>
                                        <p><?= trans("front.andTheRest"); ?></p>
                                        <span class="month-number"><?= $project->payment_months ?></span>
                                        <p><?= trans("front.months"); ?></p>
                                    </strong>
                                </span>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="en-type">
                            <div class="pay">
                                <div class="progres">
                                    <span class="pro">
                                        <?= $project->payment_percent ?>%</span>
                                    <span class="txt">
                                        <p>Down<br>Payment</p>
                                    </span>
                                </div>
                            </div>
                            <div class="money" <?= $project->payment_method == 'نقدي' ? 'style="margin:5px auto 16px auto"' : '' ?>>
                                <span class="month-number"><?= $project->payment_months ?></span>
                                <strong>
                                    <p><?= trans("front.months"); ?></p><br>
                                    <p><?= trans("front.andTheRest"); ?></p>
                                </strong>
                            </div>
                        </div>
                    <?php } ?>




                <?php } ?>



                <?php
                if ($project->payment_method == 'نقدي') {
                    ?>
                    <div class="money cash" <?= $project->payment_method == 'نقدي' ? 'style="margin:5px auto 16px auto"' : '' ?>>
                        <i class="flaticon-money"></i>

                        <div class="txt1"><span ><?= trans("front.payment method new"); ?></span></div>
                        <div class="txt2"><span ><?= trans('front.' . $project->payment_method); ?></span></div>

                    </div>

                <?php } ?>


            </div>





        </div>
        <div style="clear: both"></div>


        <div class="list">
            @if(Helper::get_device()!='full')
            <div>
                @endif
                <div style="clear: both"></div>
                <div class="titles">
                    <div class="num-room sub"><div><span><?= trans("front.number of rooms"); ?></span></div></div>
                    <div class="space sub"><div><span><?= trans("front.area (m)"); ?></span></div></div>

                    <div class="price sub"><div>
                            <span><?= trans("front.price"); ?></span>

                            <select class="exchange-currency">
                                <?php $selected_curr = session()->get("currency") == '' ? 'TRY' : session()->get("currency"); //echo $selected_curr;  ?>
                                <?php
                                $ex = unserialize($infos->exchange);
                                if ($ex)
                                    foreach ($ex as $k => $v) {
                                        ?>
                                        <option <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= $k ?>"><?= $k ?></option>
                                    <?php } ?>
                            </select>
                            <?php /* <div class="btn-group"> ?>
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border:0 none;padding:0 3px 0 0;color: white;direction:rtl;background:transparent;">
                              <span class="currency-symbol">(<?php $selected_curr = session()->get("currency")==''?'TRY':session()->get("currency"); echo $selected_curr; ?>)</span>
                              <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu exchange-currency select-options select" style="min-width: 100px;">
                              <?php
                              $ex = unserialize($infos->exchange);
                              if($ex)
                              foreach($ex as $k=>$v){
                              if($selected_curr!=$k){
                              ?>
                              <li data-val="<?=$k?>"><?=$k?></li>
                              <?php }} ?>
                              </ul>
                              <?php </div> */ ?>

                        </div></div>

<!--                                    <div class="date"><div><span><?= trans("front.created date"); ?></span></div></div>-->
                    <div class="notes sub"><div><span><?= trans("front.observations"); ?></span></div></div>
                </div>
                <?php $i = 0; ?>
                @foreach($p_flavors as $flavor)
                <?php $i++; ?>
                <div style="clear: both"></div>
                <div class="line<?= $i == '1' ? '1' : '2' ?>">
                    <div class="col1 sub"><div><?= ($flavor->room == 0 and $flavor->salon == 0) ? '0' : ($flavor->room . ' + ' . $flavor->salon); ?></div></div>
                    <div class="col2 sub"><div><?= $flavor->area; ?></div></div>
                    <?php list($sclass, $slab) = $project->getStatus(); ?>

                    <div class="col4 sub">
                        <div>
                            @if($sclass!='resale')
                            @if($flavor->offer)
                            <button class="btn btn-primary btn-xs btn-floating-message"><?= $flavor->offer; ?></button>
                            @else
                            <?php
                            //$nbre = $flavor->price;
                            if ($ex)
                                foreach ($ex as $k => $v) {
                                    if ($project->is_price_usd == 1) {
                                        $nbre = $flavor->price / (float) $ex['USD'];
                                        $nbre = round($nbre * (float) $ex[$k], -2);
                                    }elseif ($project->is_price_usd == 3) {//omr
                                        $nbre = $flavor->price / (float) $ex['OMR'];
                                        $nbre = round($nbre * (float) $ex[$k], -2);
                                    } else {
                                        $nbre = round($flavor->price * (float) $ex[$k], -2);
                                    }
                                    ?>
                                    <span class="tprice tp<?= $k ?> <?= ($selected_curr != $k ? 'hidden' : '') ?>"><?= number_format($nbre, 0, ',', '.'); ?></span>
                                <?php } ?>

                            @endif
                            @else
                            -

                            @endif
                        </div>
                    </div>


<!--                                    <div class="col3"><div><?= $flavor->date_created; ?></div></div>-->
                    <div class="col5 sub"><div><?php
                            $remarq = $flavor->getObservation();
                            echo $remarq == '' ? '-' : $remarq;
                            ?></div></div>
                </div>
                @endforeach


                <?php /* ?>
                  <table class="table">
                  <thead>
                  <tr class="titles">



                  <div class="notes"><div><span><?= trans("front.observations"); ?></span></div></div>




                  <td><div class="num-room"><div><span><?= trans("front.number of rooms"); ?></span></div></div></td>
                  <td><div class="space"><div><span><?= trans("front.area (m)"); ?></span></div></div></td>
                  <td><div class="date"><div><span><?= trans("front.created date"); ?></span></div></div></td>
                  <td>
                  <div class="price"><div>
                  <span style="float:right"><?= trans("front.price"); ?></span>
                  <div class="btn-group" style="">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border:0 none;padding:0 3px 0 0;color: white;direction:rtl;background:transparent;">
                  <span class="currency-symbol">(<?php $selected_curr = session()->get("currency")==''?'TRY':session()->get("currency"); echo $selected_curr; ?>)</span>
                  <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu exchange-currency select-options select" style="min-width: 100px;">
                  <?php
                  $ex = unserialize($infos->exchange);
                  if($ex)
                  foreach($ex as $k=>$v){
                  if($selected_curr!=$k){
                  ?>
                  <li data-val="<?=$k?>"><?=$k?></li>
                  <?php }} ?>
                  </ul>
                  </div>
                  </div></div>
                  </td>
                  <td><div class="notes"><div><span><?= trans("front.observations"); ?></span></div></div></td>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $i=0; ?>
                  @foreach($p_flavors as $flavor)
                  <?php $i++; ?>
                  <tr class="line<?=$i=='1'?'1':'2'?>">
                  <td><div class="col1"><div><?= ($flavor->room==0 and $flavor->salon==0)?'0':($flavor->room.' + '.$flavor->salon); ?></div></div></td>
                  <td><div class="col2"><div><?= $flavor->area; ?></div></div></td>
                  <td><div class="col3"><div><?= $flavor->date_created; ?></div></div></td>
                  <td><div class="col4"><div>

                  @if($flavor->offer)
                  <button class="btn btn-primary btn-xs btn-floating-message"><?= $flavor->offer; ?></button>
                  @else
                  <?php
                  //$nbre = $flavor->price;
                  if($ex)
                  foreach($ex as $k=>$v){
                  if($project->is_price_usd==1){
                  $nbre = $flavor->price/(float)$ex['USD'];
                  $nbre = round($nbre*(float)$ex[$k], -2);
                  }else{
                  $nbre = round($flavor->price*(float)$ex[$k], -2);
                  }
                  ?>
                  <span class="tprice tp<?=$k?> <?=($selected_curr!=$k?'hidden':'')?>"><?= number_format($nbre , 0, ',', '.'); ?></span>
                  <?php } ?>

                  @endif
                  </div></div>
                  </td>
                  <td>
                  <div class="col5"><div><?php
                  $remarq=($current_lang=='en')?$flavor->observation_en:$flavor->observation;
                  echo $remarq==''?'-':$remarq; ?></div></div>
                  </td>
                  </tr>
                  @endforeach
                  </tbody>
                  </table><?php */ ?>
                @if(Helper::get_device()!='full')
            </div>
            @endif
        </div>
        <h5 class="date-title"><strong>*</strong><?= trans("front.dateOfUpdate"); ?> <span><?= str_replace('-', '/', $project->edit_date) ?></span></h5>
    </div>
</section>