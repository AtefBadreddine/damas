


<section class="form fast_search search_filter shadow_type ca_blog_content">
    <p class="top_title  jazzira_font_bold"><?= trans("front.Blog Categories"); ?></p>
    <ul class="categories_group">
        <?php foreach ($categories as $cat) { ?>
            <li <?= (isset($slug) and $slug == $cat->slug) ? 'class="active"' : '' ?>>
                <a href="<?= $cat->listingUrl() ?>"><?= $cat->getName() ?></a>
                <?= $cat->icon ?>
            </li>
        <?php } ?>
    </ul>
</section>

<section class="form fast_search search_filter shadow_type">
    <p class="top_title jazzira_font_bold"><?= trans("front.Look for information"); ?></p>
    <?= Form::open(["id" => "form-search", 'method' => "get", 'url' => isset($listingUrl) ? $listingUrl : route($type == 'news' ? 'front.news' : ($type == 'developer' ? 'front.developer.index' : ($type == 'report' ? 'front.report.index' : 'front.blog.index')))]); ?>
    <div class="form-group">
        <input class="form-control" name="search" value="{{ Input::get('s') }}" placeholder="<?= trans("front.whatAreYouLookingFor"); ?>" />
        <button class="search_btn"><i class="fa fa-search"></i></button>
    </div>
    <?= Form::close(); ?>
</section>
