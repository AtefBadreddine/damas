<div class="row alikes projects">
<?php $ii=1; ?>
    @foreach($projects as $project)
    <aside class="col-md-6 col-sm-6 col-xs-12">
	<div class="item">
        @include("front.partials.project_item", ["open_blank" => true,"ajax" => (isset($ajax)?$ajax:true),"class"=>"card-small",'pos'=>$ii])
    </div>
	</aside>
	<?php $ii++; ?>
    @endforeach
    <div class="clearfix"></div>
</div>

<!-- load more -->
<?php if ( count($projects) > 0 and $projects->total() > $paginate_number ): ?>
<div id="projects-paginate" class="alikes text-center">
    <aside class="col-md-12 col-sm-1 col-xs-12" style="width:100%;margin:0 0 20px 0">
        <button class="btn btn-primary btnLoadMoreProjets" id="show_more" style="margin-top:0"><i class="fa fa-list"></i>  <?= trans("front.load more"); ?>
<div class="lds-ring">
<div></div>
<div></div>
<div></div>
<div></div>
</div>

</button>
    </aside>
</div>
<?php endif; ?>