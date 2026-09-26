<!-- Start About Damas -->
<div class="about-damas desktop-screen">
    <div class="damas" onclick="location.replace('<?= route('front.aboutus'); ?>')"><img class="lazyimg" loading="lazy" src="{{ asset('img/damas-new-logo-blue4.svg') }}" alt="damas"></div>

    <div class="about_d" onclick="location.replace('<?= route('front.aboutus'); ?>')">
        @if(LaravelLocalization::getCurrentLocale()=='ar')
        <p>
            هو أقدم نطاق في القطاع العقاري التركي حالياً، انطلق منذ العام <span>2001</span>م، يعتبر أقوى موقع معلوماتي إحصائي تركي، يتبع وكالة <strong>damasturk</strong> التركية المتخصصة بالاستشارات العقارية، ودراسات الاستثمار العقاري....
        </p>
        @else
        <p>
            Through its agreements with the strongest and most reliable construction companies in Turkey, <strong>damasturk</strong> Real Estate aspires to remain at the forefront of Turkish real estate companies by introducing modern lifestyle concepts that meet the wishes of its customers through modern and smart residential complexes that contain all the services needed by the modern family.
        </p>
        @endif


<!--        <img class="lazyimg" data-src="{{ asset('img/Logos.jpg') }}" style="width:100%;margin:10px 0">-->
    </div>

    <div class="section-brands">
        <a href="<?= route('front.aboutus'); ?>" class="read-more_d">{{ trans('front.read more')}}</a>
    </div>


    <div class="section-brands">
        <ul>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'emlak-konut')) ?>" target="_blank"><img class="lazyimg" loading="lazy" src="{{ asset('img/emlakkonut-logo.svg') }}" title="logo"></a>
            </li>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'sinbas')) ?>"><img class="lazyimg sinpas" loading="lazy" src="{{ asset('img/sinpas-logo.png') }}" title="logo"></a>
            </li>
            <li>
                <a class="agaoglu" href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'aga-oglu')) ?>" target="_blank"><img class="lazyimg" loading="lazy" src="{{ asset('img/agaoglu-logo.svg') }}" title="logo"></a>
            </li>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'kelesoglu')) ?>"><img class="lazyimg kalesh" loading="lazy" src="{{ asset('img/kelesoglu-logo.png') }}" title="logo"></a>
            </li>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'avrupa-konutlari')) ?>" target="_blank"><img class="lazyimg" loading="lazy" src="{{ asset('img/avrupakonutlari-logo.svg') }}" title="logo"></a>
            </li>
            <li>
                <a href="<?= route('front.blog.post.show', array('country' => 'turkiye', 'post' => 'nef')) ?>" target="_blank"><img class="lazyimg nef" loading="lazy" src="{{ asset('img/nef-logo.png') }}" title="logo"></a>
            </li>
        </ul>
    </div>


</div>
<!-- End About Damas -->