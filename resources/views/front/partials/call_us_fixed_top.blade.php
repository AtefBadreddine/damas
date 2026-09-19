




<div style="clear: both"></div>
<?= Form::open(["url" => route("front.callus"), "id" => "form-callus-lg"]); ?>
<div class="name"><input class="form-control"  type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>"></div>

<div class="tel"><input class="form-control" type="text" name="mobile" value="{{ @session()->get('call_country') }}" id="mobile-sm" placeholder=""></div>

<div class="textarea"><textarea class="form-control" name="message" rows="2" cols="20" placeholder=" <?= trans("front.is the property for housing or tourism? how many rooms?"); ?>..."><?= trans("front.How can we help you"); ?></textarea></div>

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
    <!--        <div class="budget">
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
            </div>-->
</div>

<button type="submit" class="send">
    <img class="icon" src="<?= asset("img/sendIconW.svg"); ?>" alt="Send Icon"/>
<!--        <p><?= trans("front.Request a free consultation"); ?></p>-->
</button>

</form>
