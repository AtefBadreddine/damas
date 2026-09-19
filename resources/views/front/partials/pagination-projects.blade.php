<?php /*
@if ($projects->lastPage() > 1)
	<li class="page-item {{ ($projects->currentPage() == 1) ? ' disabled' : '' }}">
		<a class="page-link" href="{{ $projects->url(1) }}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M.279 4.33l4.1-4.054a.96.96 0 011.347 0 .942.942 0 010 1.338L3.319 3.992h7.677a1.027 1.027 0 011.015 1.016 1 1 0 01-1 1H3.324l2.4 2.375a.94.94 0 010 1.337.956.956 0 01-1.347 0l-4.1-4.054A.942.942 0 01.279 4.33z"></path></svg></a>
	</li>
	@for ($i = 1; $i <= $projects->lastPage(); $i++)
	<?php
			$link_limit = 7;
			$half_total_links = floor($link_limit / 2);
			$from = $projects->currentPage() - $half_total_links;
			$to = $projects->currentPage() + $half_total_links;
			if ($projects->currentPage() < $half_total_links) {
			   $to += $half_total_links - $projects->currentPage();
			}
			if ($projects->lastPage() - $projects->currentPage() < $half_total_links) {
				$from -= $half_total_links - ($projects->lastPage() - $projects->currentPage()) - 1;
			}
			?>
			@if ($from < $i && $i < $to)
				<li class="page-item {{ ($projects->currentPage() == $i) ? ' active' : '' }}">
					<a class="page-link" href="{{ $projects->url($i) }}">{{ $i }}</a>
				</li>
			@endif
	@endfor
	<li class="page-item {{ ($projects->currentPage() == $projects->lastPage()) ? ' disabled' : '' }}">
		<a class="page-link" href="{{ $projects->url($projects->currentPage()+1) }}" ><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M11.721 5.67l-4.1 4.054a.96.96 0 01-1.347 0 .942.942 0 010-1.338l2.407-2.378H1.004A1.027 1.027 0 01-.007 5a1 1 0 011-1H8.68l-2.4-2.375a.94.94 0 010-1.337.956.956 0 011.347 0l4.1 4.054a.942.942 0 01-.006 1.328z"></path></svg></a>
	</li>
@endif
*/ ?>
@if(count($projects)>0 and $cnt_projs>0)

<nav class="pagination_list" aria-label="Page navigation example">
<ul class="pagination justify-content-end num" style=" width: 100%;text-align:center;min-height: auto;">
<li>
<a class="btn load_more {{ ($projects->currentPage()==$projects->lastPage())?'d-none':'' }}" 
href="{{ isset($first_page)?$projects->url($projects->currentPage()):$projects->url($projects->currentPage()+1) }}" >
<i class="fa fa-spinner fa-spin"></i></a>
</li>
</ul>
</nav>
@endif