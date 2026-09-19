<?php $infos = Helper::get_params(); ?>
<div class="social">
    <h3 class="colored blog-heading"> تواصل معنا </h3>
    
    <ul class="amp-social-links"> 
        <li class="amp-facebook"> <a href="<?= $infos->facebook; ?>" target="_blank" aria-label="Link to AMP HTML Facebook"> <i class="fa fa-facebook"></i> </a> </li>
        <li class="amp-twitter"> <a href="<?= $infos->twitter; ?>" target="_blank" aria-label="Link to AMP HTML Twitter"> <i class="fa fa-twitter"></i> </a> </li> 
        <li class="amp-instagram"> <a href="<?= $infos->instagram; ?>" target="_blank" aria-label="Link to AMP HTML Instagram"> <i class="fa fa-instagram"></i> </a> </li>
        <li class="amp-youtube"> <a href="<?= $infos->youtube; ?>" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-youtube"></i> </a> </li> 
        <li class="amp-linkedin"> <a href="<?= $infos->linkedin; ?>/" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-linkedin"></i> </a> </li>
        <li class="amp-whatsapp"> <a href="https://www.damas.net/whatsapp_share?icon=5" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-whatsapp"></i> </a> </li> 
    </ul>
</div>