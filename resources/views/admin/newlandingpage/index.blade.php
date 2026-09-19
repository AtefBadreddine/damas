@extends('admin.layouts.app', ["app_title" => "Landing Pages"])
@section('main_content')

<style>
    tbody tr td:nth-child(6){
        width: 140px;
    }
    tbody tr td:nth-child(6) form,
    tbody tr td:nth-child(6) button,
    tbody tr td:nth-child(6) a{
        float: left;
        margin: 0px 5px 0px 0px;
    }
	.button_refresh_cache{display:none}
</style>
    <?php
        $lignes = [
            "id"    =>  "",
            "title"  =>  "Title",
            "created_at"  =>  "Created at",
            "views"  =>  "Views",
            //"lang"  =>  "Lang",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Landing Pages List",'d_link'=>true
    ])
    
	
	
	
	
<script>
$('.button_refresh_cache').click(function(){
	$(this).children('i').addClass('fa-spin');
	
	var url="<?= route('front.landingpage', 'slug'); ?>".replace('slug',$(this).data('slug')).replace('.com/',($(this).data('lang')=='en'?'.com/en/':'.com/')) + "?cron_job=true&id=2319508&hash=77e84768cef2ae5949bf793cac3d7711b010d17fe604dccd84493d56367970167dcda121f54";

$.ajax({beforeSend:function(request){},url:url + '&device=full',
success: function(data){




$.ajax({beforeSend:function(request){},url:url + '&device=mob',
success: function(data){
	
},error:function(){console.log('error');}});

$('.button_refresh_cache').children('i').removeClass('fa-spin');
alert('تم تحديث الكاش بنجاح');


	},error:function(){console.log('error');}});

/*
var url = "https://"+subdom+".imtilak.net/dev/generate_mobile_tmp/?device=mobile&device_view=mobile"+hash;
$.ajax({beforeSend:function(request){},url:url,success: function(data){console.log(data);loadBarPercent(3);},error:function(){console.log('error');}});
var url = "https://"+subdom+".imtilak.net/en/?device=full&device_view=full"+hash;
$.ajax({beforeSend:function(request){},url:url,success: function(data){console.log(data);loadBarPercent(3);},error:function(){}});
var url = "https://"+subdom+".imtilak.net/en/dev/generate_mobile_tmp/?device=mobile&device_view=mobile"+hash;
$.ajax({beforeSend:function(request){},url:url,success: function(data){console.log(data);loadBarPercent(3);},error:function(){console.log('error');}});
*/
})
</script>
@endsection
