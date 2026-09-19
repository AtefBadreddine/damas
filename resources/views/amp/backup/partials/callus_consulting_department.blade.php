<div class="form-content">
	<section class="form">
		<div class="info">
			<div class="icon-bg"></div>
			<div class="clientimg"><amp-img  width="51" height="51" layout="responsive" src="<?= asset("img/client.png"); ?>"></amp-img></div>
			<div class="tel">
				<div class="service">قسم الاستشارات العقارية</div>
				<div class="num">+90 552 510 00 05</div>
			</div>

			<div class="whatsapp">
				<a target="_blank" href="https://www.damas.net/whatsapp_share?icon=7&tel=905525100005">
					<div class="whatsapp-icon"><i class="fa fa-whatsapp"></i></div>
				</a>
			</div>
		</div>
		<div class="clearboth"></div>
		
		<form action-xhr="<?= route("amp.front.callus"); ?>" target="_top" method="post" id="form-callus-lg" custom-validation-reporting="show-all-on-submit">
		<div class="name"><input  type="text" name="name" placeholder="* <?= trans("front.name"); ?>" id="show-all-on-submit-name-lg" required>
		<span visible-when-invalid="valueMissing" validation-for="show-all-on-submit-name-lg"></span>
		</div>
		<div class="fame"><input type="text" name="fame" placeholder="* <?= trans("front.fame"); ?>"></div>
		<div class="email">
			<input type="text" name="email" placeholder="* <?= trans("front.email"); ?>..." class="inptemail bluring"  id="show-all-on-submit-email-lg" required>
                        <span visible-when-invalid="valueMissing" validation-for="show-all-on-submit-email-lg"></span>
                        <span visible-when-invalid="typeMismatch" validation-for="show-all-on-submit-email-lg"></span>
		</div>
		<div class="clearboth"></div>
		<div class="tel"><input type="text" name="mobile" id="mobile-sm" placeholder="+90 123456789" id="show-all-on-submit-mobile-lg" required>
                        <span visible-when-invalid="valueMissing" validation-for="show-all-on-submit-mobile-lg"></span></div>
		<div class="textarea"><textarea name="message" rows="2" cols="20" placeholder="* <?= trans("front.i would like more information about this project"); ?>..." id="show-all-on-submit-message-lg" required></textarea>
                        <span visible-when-invalid="valueMissing" validation-for="show-all-on-submit-message-lg"></span></div>
		<div class="clearboth"></div>
		<div class="options">
			<div class="time">
				<select name="communication_time" title="<?= trans("front.communication time"); ?>">
					<option value="" id="tm"><?= trans("front.communication time"); ?></option>
					<option>9 - 12 AM</option>
					<option>12 - 3 PM</option>
					<option>3 - 6 PM</option>
					<option>6 - 9 PM</option>
					<option><?= trans("front.any time"); ?></option>
					<option><?= trans("front.now"); ?></option>
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
			<button type="submit" class="send"><amp-img width="45" height="45" layout="responsive" src="<?= asset("img/send.png"); ?>"></amp-img></button>
		</div>
		
			<div submit-success><template type="amp-mustache"><?= trans("front.thank you for contacting us. We will contact you soon"); ?></template></div>
			<div submit-error><template type="amp-mustache"><?= trans("front.sorry, an error occurred while sending, please try later"); ?></template></div>
		</form>
	</section>
</div>