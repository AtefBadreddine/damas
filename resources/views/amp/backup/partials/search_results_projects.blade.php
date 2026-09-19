<div class="row alikes" dir="ltr">
    <amp-carousel width="345"
                  height="400"
                  layout="responsive"
                  type="slides"
                  controls
                   autoplay delay="3000"
                  >
        @foreach($projects as $project)
        <aside class="col-md-6 col-sm-12 col-xs-12">
            @include("amp.partials.project_item", ["search_page" => true])
        </aside>
        @endforeach
    </amp-carousel>
</div>

<!-- load more -->
<?php if (count($projects) > 0 and $projects->total() > $paginate_number): ?>
<!--    <div id="projects-paginate" class="alikes text-center clearfix">
        <aside class="col-md-12 col-sm-1 col-xs-12">
            <a href="<?= route("front.search", [$inputs["project_type"], $inputs["city"]]); ?>" class="btn btn-primary btnLoadMoreProjets"><i class="fa fa-list"></i>  <?= trans("front.load more"); ?></a>
        </aside>
    </div>-->
<?php endif; ?>