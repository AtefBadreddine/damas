<div class="about-damas mobile-screen" dir="rtl" >
    <div class="damas" onclick="location.replace('<?= route('front.aboutus'); ?>')">
	<img class="<?= isset($is_search_p)?'lazyimg':'' ?>" <?= isset($is_search_p)?'data-':'' ?>src="{{ asset('img/damas-new-logo-blue4.svg') }}" alt="damas"></div>
    <div class="about_d" onclick="location.replace('<?= route('front.aboutus'); ?>')">
	<p>{{ trans('front.about_damass_txt') }}</p>
    </div>

    <div class="section-brands">
        <a href="<?= route('front.aboutus'); ?>" class="read-more_d">{{ trans('front.read more')}}</a>
    </div>


    <div class="section-brands">
        <ul>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'emlak-konut')) ?>" target="_blank"><img class="<?= isset($is_search_p)?'lazyimg':'' ?>" <?= isset($is_search_p)?'data-':'' ?>src="{{ asset('img/emlakkonut-logo.svg') }}" title="logo"></a>
            </li>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'sinbas')) ?>"><img class=" sinpas <?= isset($is_search_p)?'lazyimg':'' ?>" <?= isset($is_search_p)?'data-':'' ?>src="{{ asset('img/sinpas-logo.png') }}" title="logo"></a>
            </li>
            <li>
                <a class="agaoglu" href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'aga-oglu')) ?>" target="_blank"><img class="<?= isset($is_search_p)?'lazyimg':'' ?>" <?= isset($is_search_p)?'data-':'' ?>src="{{ asset('img/agaoglu-logo.svg') }}" title="logo"></a>
            </li>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'kelesoglu')) ?>"><img class=" kalesh <?= isset($is_search_p)?'lazyimg':'' ?>" <?= isset($is_search_p)?'data-':'' ?>src="{{ asset('img/kelesoglu-logo.png') }}" title="logo"></a>
            </li>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'avrupa-konutlari')) ?>" target="_blank"><img class="<?= isset($is_search_p)?'lazyimg':'' ?>" <?= isset($is_search_p)?'data-':'' ?>src="{{ asset('img/avrupakonutlari-logo.svg') }}" title="logo"></a>
            </li>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'nef')) ?>" target="_blank"><img class=" nef <?= isset($is_search_p)?'lazyimg':'' ?>" <?= isset($is_search_p)?'data-':'' ?>src="{{ asset('img/nef-logo.png') }}" title="logo"></a>
            </li>
        </ul>
    </div>


</div>