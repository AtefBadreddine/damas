<?php $p_flavors = $project->flavors;
$style_lang = in_array($current_lang,['en','fr'])?'en':'ar';
?>
<table dir="<?= in_array($current_lang, ['en', 'fr']) ? 'ltr' : 'rtl' ?>">
    <tr>
        <th><?= trans("front.number of rooms"); ?></th>
        <th class="color_one"><?= trans("front.area (m)"); ?></th>
        <th class="color_two">
            <select class="selectpicker currency">
			<?php
			//$selected_curr = session()->get("currency") == '' ? 'USD' : session()->get("currency");
			$selected_curr = 'USD';
			$ex = unserialize($infos->exchange);
			if ($ex)
				foreach ($ex as $k => $v) {
					?>
					<option data-icon="flag_icon <?= $k ?>" class="<?= $k ?>" <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= $k ?>"><?= $k ?></option>
				<?php } ?>
                <!--<option data-icon="flag_icon TRY" class="TRY" value="en">TRY</option>
                <option data-icon="flag_icon USD" class="USD" value="fr">USD</option>
                <option data-icon="flag_icon EUR" class="EUR" value="ar">EUR</option>
                <option data-icon="flag_icon GBP" class="GBP" value="ar">GBP</option>
                <option data-icon="flag_icon SAR" class="SAR" value="ar">SAR</option>
                <option data-icon="flag_icon IQD" class="IQD" value="ar">IQD</option>
                <option data-icon="flag_icon AED" class="AED" value="ar">AED</option>
                <option data-icon="flag_icon KWD" class="KWD" value="ar">KWD</option>
                <option data-icon="flag_icon OMR" class="OMR" value="ar">OMR</option>
                <option data-icon="flag_icon SYP" class="SYP" value="ar">SYP</option>
                <option data-icon="flag_icon QAR" class="QAR" value="ar">QAR</option>
                <option data-icon="flag_icon BHD" class="BHD" value="ar">BHD</option>
                <option data-icon="flag_icon JOD" class="JOD" value="ar">JOD</option>
                <option data-icon="flag_icon DZD" class="DZD" value="ar">DZD</option>
                <option data-icon="flag_icon YER" class="YER" value="ar">YER</option>-->
            </select>
        </th>
        <th class="color_three"><?= trans("front.observations"); ?></th>
    </tr>
	<?php
	foreach(Helper::query("ProjectType", "all") as $typ){
		$TType[$typ->id] = $typ->getName();
	}
	?>
	@foreach($p_flavors as $flavor)
	@if($flavor->sold_out==false)
    <tr>
        <td><?php
		if(!in_array($flavor->type,[5,6]))
			echo ($flavor->room == 0 and $flavor->salon == 0) ? '0' : ($flavor->room . '+' . $flavor->salon);
		else
			echo @$TType[$flavor->type];
		?></td>
        <td><?= $flavor->area; ?></td>
        <td>
		@if($sclass!='resale')
			<?php
			if ($ex)
				foreach ($ex as $k => $v) {
					if ($project->is_price_usd == 1) {
						$nbre = $flavor->price / (float) $ex['USD'];
						$nbre = round($nbre * (float) $ex[$k], -2);
					} elseif ($project->is_price_usd == 2) {
						$nbre = $flavor->price / (float) $ex['EUR'];
						$nbre = round($nbre * (float) $ex[$k], -2);
					} elseif ($project->is_price_usd == 3) {//OMR
						$nbre = $flavor->price / (float) $ex['OMR'];
						$nbre = round($nbre * (float) $ex[$k], -2);
					} else {
						$nbre = round($flavor->price * (float) $ex[$k], -2);
					}
					?>
					<span class="tprice tp<?= $k ?> <?= ($selected_curr != $k ? 'hidden' : '') ?>"><?= number_format($nbre, 0, ',', '.'); ?></span>
				<?php } ?>
		@else
			-
		@endif
		</td>
        <td>
		<?php
			$remarq = $flavor->getObservation();
			echo $remarq == '' ? '-' : $remarq;
		?>
		</td>
    </tr>
	@endif
	@endforeach
    <!--<tr>
        <td>1+1</td>
        <td>68</td>
        <td><b>500.000.000</b></td>
        <td>-</td>
    </tr>-->
</table>