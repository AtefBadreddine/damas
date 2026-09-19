<?php
$infos = Helper::get_params();
$callus_form = @$callus_form;
?>
<div class="social">
    @if(!$callus_form)
    <h3 class="colored blog-heading"><?= trans("front.connect with us"); ?></h3>
    @endif
<!--        <aside>
            <a href="<?= $infos->facebook; ?>" rel="nofollow" target="_blank"><img src="<?= asset("img/facebook.png"); ?>" alt="facebook"> <?= trans("front.facebook"); ?></a>
        </aside>
        <aside>
            <a href="<?= $infos->twitter; ?>" rel="nofollow" target="_blank"><img src="<?= asset("img/twitter.png"); ?>" alt="twitter"> <?= trans("front.twitter"); ?></a>
        </aside>
        <aside>
            <a href="https://damas.net/whatsapp_share?icon=5" rel="nofollow" target="_blank"><img src="<?= asset("img/googleplus.png"); ?>" alt="googleplus"> <?= trans("front.googleplus"); ?></a>
        </aside>
        <aside>
            <a href="<?= $infos->instagram; ?>" rel="nofollow" target="_blank"><img src="<?= asset("img/instagram.png"); ?>" alt="instagram"> <?= trans("front.instagram"); ?></a>
        </aside>
        <aside>
            <a href="<?= $infos->linkedin; ?>" rel="nofollow" target="_blank"><img src="<?= asset("img/linkedin.png"); ?>" alt="linkedin"> <?= trans("front.linkedin"); ?></a>
        </aside>
        <aside>
            <a href="<?= $infos->youtube; ?>" rel="nofollow" target="_blank"><img src="<?= asset("img/youtube.png"); ?>" alt="youtube"> <?= trans("front.youtube"); ?></a>
        </aside>-->
    <ul class="social-links"> 
        <li class="facebook-link"> <a href="<?= $infos->facebook; ?>" target="_blank" aria-label="Link to AMP HTML Facebook"> <i class="fa fa-facebook"></i> </a> </li>
        <li class="twitter-link"> <a href="<?= $infos->twitter; ?>" target="_blank" aria-label="Link to AMP HTML Twitter"> <i class="fa fa-twitter"></i> </a> </li> 
        <li class="whatsapp-link"> <a href="https://damas.net/whatsapp_share?icon=5" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-whatsapp"></i> </a> </li> 
        <li class="instagram-link"> <a href="<?= $infos->instagram; ?>" target="_blank" aria-label="Link to AMP HTML Instagram"> <i class="fa fa-instagram"></i> </a> </li>
        <li class="youtube-link"> <a href="<?= $infos->youtube; ?>" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-youtube"></i> </a> </li> 
        <li class="linkedin-link"> <a href="<?= $infos->linkedin; ?>" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-linkedin"></i> </a> </li>
    </ul>
</div>