<?php
    $flavors = $project->flavors();
    $flavor = $flavors->orderBy("price", "ASC")->first();
    $open_blank = @$open_blank ? true : false;
    $cardphoto = @$project->cardphoto;
    $is_mobile = @$is_mobile;
?>
<div class="alike-item">
    <span class="try">$ <?= $project_min_price = Helper::decimal_format(@$flavor->price); ?> </span>
    <a href="<?= route('front.project', $project->slug); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?>>
        <img src="<?= Helper::get_thumbnail($cardphoto, 360, 280); ?>" alt="<?= $project->getDescription(); ?>" class="img-responsive">
    </a>
    <aside>
        <h3> 
            <?= $project->name_en; ?>
            <a href="" class="likeCardItem" data-url="<?= route("front.likeitem"); ?>" data-typ="project" data-code="<?= $project->id; ?>"><i class="fa fa-heart-o pull-right"></i></a>
            <i class="flaticon-share share pull-right"></i>
            <span class="pull-right social shareBtnsFloating" data-url="<?= route('front.project', $project->slug); ?>" data-text="<?= $project->getName(); ?>">
                <a href="" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
                <a href="" class="btnshare" data-network="twitter"><i class="fa fa-twitter"></i></a>
            </span>
        </h3>
        <p><?= $project->getIntroCard(); ?></p>
        <ul>
            <li><span class="flaticon-house-key"></span> <small><?= $project->delivered_date ?: $project->project_etat; ?></small></li>
            <li><img src="<?= asset("img/full-size.png"); ?>" alt="area <?= $project->name_en; ?>"> <?= @$flavors->max('area')." - ".@$flavors->min('area'); ?> <?= trans("front.m"); ?><sup>2</sup> </li>
            <!--<li><span class="fa fa-bed"></span> <?= @$flavor->room.' + '.@$flavor->salon; ?></li>-->
            <li><span class="flaticon-payment-method"></span> <small><?= trans("front.$project->payment_method"); ?></small></li>
        </ul>
        @if(!$is_mobile)
            <a class="button text-center" href="<?= route('front.project', $project->slug); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?>><b><?= trans("front.details"); ?></b></a>
        @endif
    </aside>
</div>

<!-- schema -->
<script type="application/ld+json">
{
    "@context": "http://www.schema.org",
    "@type": "Product",
    "name": "<?= $project->getName(); ?>",
    "offers" : {
        "@type": "Offer",
        "price": "<?= $project_min_price; ?>",
        "priceCurrency": "USD"
    },
    "image": "<?= Helper::media_url($cardphoto); ?>"
}
</script>