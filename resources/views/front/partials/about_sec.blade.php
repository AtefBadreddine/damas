<div class="int_content about_sec shadow_type">
    <img width="150" height="22" class="damasturk_logo" loading="lazy" title="damasturk" alt="damasturk" src="{{ asset('img/damasBlue.png') }}">
    <img width="97" height="110" class="title_icon" loading="lazy" title="damasturk" alt="damasturk" src="{{ asset('img/aboutIcon.svg') }}">
    <div class="section about"> 
        <div class="right_sec">
            <p><?= trans("front.about us Shortcut text"); ?></p> 
            <a href="{{ route('front.aboutus') }}" class="more_btn shadow_type"><?= trans("front.read more"); ?></a> 
        </div> 
        <div class="left_sec">
            <ul class="brands">
                <li class="title"><h3><?= trans("front.Our partners"); ?></h3></li>
                <li> <a><img style="width: 100% !important;top:3px;" class="" loading="lazy" title="damasturk" alt="damasturk" src="https://www.aladrak.com/uploads/company/thumb-170723054928Aladrak.png"/></a> </li> 
                <li> <a href=""><img style="margin-top: 15% !important;width: 100% !important;height: 10px !important;object-fit:cover !important" class="sinpas" title="damasturk" loading="lazy" alt="damasturk" src="https://marketingtochina.com/wp-content/uploads/2019/08/DamacProperties.png"/></a> </li>
                <li> <a href="{{ route('front.blog.post.show', ['country' => 'turkiye', 'post' => 'avrupa-konutlari']) }}" target="_blank"><img style="bottom:6px;right:2px;" width="60" height="42" loading="lazy" title="damasturk" alt="damasturk" src="{{ asset('img/avrupakonutlari-logo.svg') }}"/></a> </li>
            </ul> 
        </div>
    </div>
</div>