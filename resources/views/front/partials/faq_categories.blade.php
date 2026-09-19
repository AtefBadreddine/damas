<section class="form fast_search search_filter shadow_type ca_blog_content">
    <h3 class="top_title jazzira_font_bold"><?= trans("front.faq Categories"); ?></h3>
    <ul class="categories_group">
        <?php
        $faqposts = App\Models\Faqpost::orderBy('placement', 'asc')->get();
        foreach ($faqposts as $f) {
            ?>
            <li <?= (isset($slug) and $slug == $f->slug) ? 'class="active"' : '' ?>>
                <a href="{{ route('front.faq_show',$f->slug) }}"><?= $f->getTitle() ?></a>
                <?= $f->icon ?>
            </li>
        <?php } ?>
    </ul>
</section>

<section class="form fast_search search_filter shadow_type">
    <h3 class="top_title jazzira_font_bold"><?= trans("front.Look for information"); ?></h3>
    <form action="<?= route("front.faq"); ?>" method="get">
        <div class="form-group">
            <input class="form-control" name="s" placeholder="<?= trans("front.whatAreYouLookingFor"); ?>" value="{{ Input::get('s') }}" />
            <button class="search_btn"><i class="fa fa-search"></i></button>
        </div>
    </form>
</section>