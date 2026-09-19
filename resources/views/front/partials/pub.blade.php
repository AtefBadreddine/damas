<?php
$pubs = Helper::getPub();
?>
	<?php
	if(isset($pubs[$_index])){
		$pub = $pubs[$_index];
		$oclass = '';
		if($_index==1)
			$oclass = 'accidental';
		elseif($_index==2)
			$oclass = 'three';
		elseif($_index==0)
			$oclass = 'one';
	?>
	<div class="offer_sec <?= $oclass ?>">
		<img  loading="lazy" src="<?= Helper::media_url($pub->media); ?>" alt="damasturk"/>
		<h2>{{ $pub->getTitle() }}</h2>


		<ul class="jazzira_font">
			<?php
			$conts = explode('#;#',$pub->getContent());
			foreach($conts as $c){
				if($c!=''){ ?>
				<li>
					<p>{{ $c }}</p>
				</li>
				<?php }
				} ?>
		</ul>
                <a class="more" href="<?= $current_lang == 'ar' ? $pub->link : str_replace('damas.net/', 'damas.net/' . $current_lang . '/', $pub->link) ?>"><?= trans("front.details"); ?></a>
	</div>
	<?php } ?>