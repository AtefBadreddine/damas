

<div class="amp-whit-section amp-about">
    <amp-img class='amp-logo-damas' src="{{ asset('img/damas-new-logo-blue3.svg') }}" width="120" height="50" alt="damas"></amp-img>
    <p>
        @if(LaravelLocalization::getCurrentLocale()=='ar')
        باتفاقياتها مع أقوى شركات الإنشاء التركية وأحسنها سمعة وموثوقية، تطمح داماس العقارية أن تبقى في مقدمة الشركات العقارية التركية عبر طرحها مفاهيم حياة عصرية، تلبي رغبة عملائها الكرام، من خلال مجمعات سكنية حديثة وذكية تحوي كافة الخدمات التي تحتاجها الأسرة العصرية، بالتعاون مع:
        @else
        Through its agreements with the strongest and most reliable construction companies in Turkey, Damasturk Real Estate aspires to remain at the forefront of Turkish real estate companies by introducing modern lifestyle concepts that meet the wishes of its customers through modern and smart residential complexes that contain all the services needed by the modern family.
        @endif
        <amp-img class='amp-logos' src="{{ asset('img/Logos.jpg') }}" height="150"></amp-img>
    </p>
    <a href="<?= route('front.aboutus'); ?>" class="amp-more">{{ trans('front.read more')}}</a>
</div>