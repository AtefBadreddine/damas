

<!-- Start Share icons -->
<div class="shareSection">
    <p><?=trans("front.SharePageTitle")?></p>
    <div class="shareBtnsFloating sharepost">
        <?php $share_pg = urlencode(route('front.landingpage', $landing->slug)); ?>
        <a href="https://facebook.com/sharer.php?u=<?= $share_pg ?>" target="_blank" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
        <a href="https://twitter.com/intent/tweet?url=<?= $share_pg ?>" target="_blank" class="btnshare" data-network="twitter"><i class="fa fa-twitter"></i></a>
        <a href="https://api.whatsapp.com/send?text=<?= $share_pg ?>" target="_blank" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
    </div>
</div>