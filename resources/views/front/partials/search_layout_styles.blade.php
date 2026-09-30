<style>
    
.top_control_sec {
    padding: 0px 10px 5px 10px;
}
.left_sec {
    margin-top: 15px;
}
.right_sec {
    margin: 15px 0px 0px 0px;
}
.control_icons{
    float: left;
    width: auto;
    padding-top: 5px;
    margin-top: 5px;
}
.control_icons a{
    float: left;
    width: 16px;
    margin-right: 20px;
    cursor: pointer;
}
.control_icons a.map_btn{
    width: 25px;
}
.control_icons a svg{
    width: 100%;
}
.control_icons a svg path{
    fill: #4d4d4d;
}
.control_icons a.active svg path{
    fill: #17A8A9;
}

.int_content {
    margin-bottom: 10px;
    padding: 0px;
    background: transparent;
    box-shadow: none;
}
.fixed_sec{
    margin-bottom: 0px;
}
    .top_control_sec h1 {
    float: right;
    width: auto;
    text-align: right;
    font-size: 28px;
    color: #058687;
    direction: rtl;
}
.pr_count{
    float: right;
    font-size: 15px;
    color: #4d4d4d;
    margin: 9px;
}
.top_control_sec h1 strong {
    font-size: 15px;
    color: #4d4d4d;
}
.content_section{
    float: left;
    width: calc(100% - 0px);
    position: relative;
    left: 0px;
    background-color: #ffffff;
    -webkit-box-shadow: 0px 3px 6px 0px rgb(171 171 171 / 50%);
    -moz-box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);
    box-shadow: 0px 3px 6px 0px rgb(171 171 171,0.5);
    border-radius: 20px;
    margin: 10px 0px 15px 0px;
    padding: 20px;
    text-align:right;
    direction: rtl;
}
.content_section .cont{
    float: left;
    width: 100%;
    height: auto;
    /*max-height: 86px;*/
    max-height: 350px;
	overflow: hidden;
    transition: all 1s;

}
.content_section.show .cont{
    height: auto;
    max-height: none;
    transition: all 1s;
}
.content_section .cont img{
    height: auto;
}
.fast_search {
    padding-top: 0px;
    margin-top: 0px;
    margin-bottom: 15px;
    min-height: 385px;
}

.close_filter_btn,
.control_icons a.filter_btn{
    width: 50px;
    height: 50px;
    padding: 14px;
    margin: -15px 13px 0px 0px;
    display: none;
    cursor: pointer;
}
.close_filter_btn{
    position: absolute;
    top: 13px;
    left: 15px;
    opacity: 0.8;
    z-index: 999;
}
.close_filter_btn svg{
    width: 22px;
}
.close_filter_btn svg path{
    fill: #058687;
}

.fast_search .top_title {
    padding: 10px 15px 10px 15px;
    position: relative;
}
.fast_search .form-group svg{
    position: absolute;
    right: 11px;
    width: 18px;
    top: 12px;
    z-index: 99;
}
.fast_search .form-group:nth-child(4) svg{
    width: 14px;
}
.fast_search .form-group svg path{
    fill: #808080;
}
.fast_search .bootstrap-select .dropdown-toggle {
    padding-right: 35px;
}
section.form form .budget .dropdown-toggle {
    padding-right: 35px;
}

.fast_search .form-group.btn_sec {
    width: 100%;
    clear: both;
    margin: 8px 0 0;
    padding: 0 15px 15px;
}
.fast_search .form-group.btn_sec .send_btn {
    width: 100%;
    background-color: #0a8181;
    color: #ffffff;
    border: 0;
    padding: 10px 35px;
    border-radius: 10px;
    font-size: 17px;
    transition: all 0.3s;
    cursor: pointer;
    outline: none !important;
    box-shadow: 0 0.875rem 1.8125rem -0.8125rem rgb(0 0 0 / 30%), 0 0.875rem 1.8125rem -0.8125rem rgb(23 168 169);
    background-image: linear-gradient(90deg, #02898a, #17a8a9);
}
.fast_search .form-group.btn_sec .send_btn svg {
    width: 15px;
    position: relative;
    top: auto;
    right: auto;
    margin-inline-start: 6px;
}
.fast_search .form-group.btn_sec .send_btn svg path {
    fill: #ffffff;
}
.fast_search .form-group.btn_sec .send_btn:hover {
    box-shadow: 0 3px 29px 2px rgb(183 183 183 / 100%);
}

.cleared_filter{
    position: absolute;
    left: 8px;
    top: 8px;
    font-size: 14px;
    color: red;
    cursor: pointer;
    display: none;
}
.cleared_filter a{
    color: red;
    padding: 5px 10px;
}

.top_control_sec h1 strong{
    font-size: 15px;
    color: #4d4d4d;
}

.categories_sec{
    float: right;
    width: calc(100% - 0px);
    margin: 0px 0px 0px 0px;
    padding: 0px 0px;
    position: relative;
    display: none;
}
.categories_sec a.scroll-right{
    position: absolute;
    right: -6px;
    top: 1px;
    width: 20px;
    height: 30px;
    border-radius: 100%;
    text-align: center;
    color: #058687;
    font-size: 17px;
    padding-top: 4px;
    cursor: pointer;
    /*    background-color: rgba(4, 135, 135,0.6);*/
}
.categories_sec a.scroll-left{
    position: absolute;
    left: -6px;
    top: 1px;
    width: 20px;
    height: 30px;
    border-radius: 100%;
    text-align: center;
    color: #058687;
    font-size: 17px;
    padding-top: 4px;
    cursor: pointer;
    /*    background-color: rgba(4, 135, 135,0.6);*/
}
.categories_sec ul{
    float: left;
    width: 100%;
    display: flex;
    padding: 3px 0px 0px 0px;
    direction: rtl;
    transition: all 0.5s;
    margin: 0px;
    overflow-x: scroll;
    overflow-y: hidden;
    white-space: nowrap;
}
.categories_sec ul li{
    float: right;
    list-style: none;
    margin: 0px 2px;
    background-color: #ffffff;
    border-radius: 18px;
    padding: 6px 10px 3px 10px;
    text-align: center;
    color: #058687;
    display: inline-block;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.3s;
    border: 1px solid #c5c5c5;
    height: 30px;
}
.categories_sec ul li a{
    color: #058687;
    font-size: 13px;
}
.categories_sec ul li.filter{
    background-color: #058687;
    padding: 0px;
    width: 35px;
    height: 35px;
    margin-top: -2px;
}
.categories_sec ul li.filter .filter_btn{
    float: right;
    display: block;
    padding: 7px 2px 0px 2px;
    width: 35px;
    height: 35px;
}
.categories_sec ul li .filter_btn svg{
    width: 18px;
}
.categories_sec ul li.active,
.categories_sec ul li:hover{
    background-color: #058687;
    color: #ffffff;
    transition: all 0.3s;
}
.categories_sec ul li.active a,
.categories_sec ul li:hover a{
    color: #ffffff;
    text-decoration: none;
}
    .share_links_sec{
        display: none;
    }
    .show_less_btn,
.show_more_btn{
    float: none;
    width: auto;
    text-align: center;
    background-color: rgba(255,255,255,0.5);
    padding: 8px 15px 10px 15px;
    display: inline-block;
    position: relative;
    margin: 0px 15px;
    cursor: pointer;
    box-shadow: 0 0.875rem 1.8125rem -0.8125rem rgb(0 0 0 / 30%), 0 0.875rem 1.8125rem -0.8125rem rgb(23 168 169);
    background-image: linear-gradient( 90deg ,#02898a,#17a8a9);
    border-radius: 37px;
    font-size: 15px;
    color: #fff;
}
.show_less_btn{
    display: none;
    background-color: #dcffff;
    color: #5090A5;
    background-image: none;
    border: 2px solid #5090A5;
    padding: 7px 15px 9px 15px;
}
@media (max-width: 812px){
        .categories_sec{
        display: block;
        width: calc(100% - 0px);
        overflow: hidden;
        max-height: 50px;
        padding: 5px 5px 5px 0px;
    }
     .pr_count {
        float: left;
        width: 100%;
        text-align: center;
    }
     #tabs.nav {
        float: right;
        display: block;
        width: calc(100% + 30px);
        left: 15px;
        text-align: right;
        margin: 0px 0px;
        border: 0px;
        margin-top: -29px;
        border-radius: 0px 0px 0px 0px;
        overflow: hidden;
        z-index: 9;
    }
    .control_icons{
        display: none;
    }
    .fast_search .top_title svg path {
        fill: #058687;
    }
    .fast_search .top_title {
        color: #058687;
        background-color: transparent;
        padding: 15px 15px 15px 15px;
    }
    .fixed_sec,
    .fixed_sec.fixed {
        position: relative;
        top: 0px;
    }
    .close_filter_btn,
    .control_icons a.filter_btn{
        display: block;
    }
    .right_sec {
        position: fixed;
        top: 0px;
        left: -100%;
        width: 100%;
        z-index: 99999999;
        height: 100%;
        padding: 0px;
        margin: 0px;
        background-color: rgba(255,255,255,0.6);
        transition: all 0.4s;
    }
    section.form {
        border-radius: 0px;
    }
    section.form.mob_form {
        border-radius: 20px;
        margin-top: 30px;
    }
    .right_sec.show{
        left: 0%;
        transition: all 0.4s;
    }
    .fast_search .form-group {
        width: 49%;
        margin-left: 1%;
    }
    .left_sec {
        position: relative;
        padding-top: 50px;
    }
    .top_control_sec {
        width: 100%;
        position: fixed;
        top: 110px;
        left: 0px;
        z-index: 9999;
        margin: 0px;
        background-color: #e4e4e4;
        padding: 0px 15px 0px 15px;
        -webkit-box-shadow: 0px 7px 8px -5px rgb(156 156 156 / 50%);
        box-shadow: 0px 7px 8px -5px rgb(156 156 156 / 50%);
        transition: all 0.5s;
        min-height: 41px;
    }
    .top_control_sec.scrollMob{
        top: 48px;
        transition: all 0.5s;
    }

    .header.scrolling .main_menu,
    .header {
        box-shadow: none !important;
    }
    .bootstrap-select.btn-group .dropdown-menu ul li a:hover {
        background-color: #ffffff
    }
    .fixed_sec .bootstrap-select.btn-group .dropdown-menu ul li a {
        border-bottom: 1px solid #ffffff !important;
    }
    .fixed_sec .bootstrap-select.btn-group .dropdown-menu ul li.selected a {
        color: #0f6868;
        background-color: #c9ebeb;
        border-bottom: 1px solid #cccccc !important;
    }
    .main_menu .links {
        box-shadow: none;
    }
    .block_sec .card_item {
        width: 50%;
    }
    .top_control_sec h1 {
        font-size: 17px;
        float: right;
        width: auto;
        position: relative;
        top: 2px;
        margin: 0px;
    }
    .top_control_sec h1 strong{
        display: inline-block;
    }
    .top_control_sec p {
        position: absolute;
        top: 26px;
        right: 16px;
        font-size: 15px;
        display: none;
    }
    .fixed_sec .mob_form{
        display: none;
    }
    .fast_search{
        margin-bottom: 0px;
        min-height: 200px;
    }
    section.form.fast_search form {
        min-height: 200px;
    }
    .top_control_sec p {
        position: absolute;
        top: 26px;
        right: 16px;
        font-size: 15px;
    }
    .cleared_filter {
        left: 73px;
        top: 6px;
    }

    .control_icons a.filter_btn {
        width: 36px;
        height: 36px;
        padding: 9px;
        margin: -1px 13px 0px 0px;
        background-color: #ffffff;
        border-radius: 5px;
    }
    .map_btn {
        width: 35px !important;
        height: 35px;
        padding: 7px;
        margin: 0px 13px 0px 0px;
        background-color: #ffffff;
        border-radius: 5px;
    }
    .control_icons {
        padding-top: 5px;
        margin-top: 3px;
    }
    .type_bar_btn, .type_list_btn, .type_block_btn {
        display: none;
    }
    .map_sec {
        margin: 0px 0px 15px 0px;
        border-radius: 0px;
        width: calc(100% + 30px);
        left: -15px;
    }
    .block_sec{
        margin-top: 10px;
    }
    .categories_sec{
        display: block;
    }
    .page_title_mob{
        font-size: 17px;
        float: right;
        width: 100%;
        text-align: center;
        color: #058687;
        direction: ltr;
        position: relative;
        top: 14px;
    }
    .page_title_mob strong{
        color: #4d4d4d;
    }
    .slick-list {
        padding: 10px 0px 11px 10px;
    }
    .block_sec .card_item {
        min-height: 450px;
    }
}
@media (max-width: 480px){
        .share_links_sec{
        display: block;
    }
    .fast_search .form-group.features_select,
    .fast_search .form-group.budget_select {
        width: 100%;
        margin-left: 0%;
    }
    .gm-style-iw-d{
        max-width: 100% !important;
    }
    .block_sec .card_item {
        padding: 0px 0px 15px 0px;
    }
    .block_sec .control_sec .num {
        font-size: 16px;
        position: relative;
        top: 4px;
    }
    .pagination_sec {
        width: calc(100% - 0px);
        left: 0px;
    }
    .top_control_sec {
        width: calc(100% - 0px);
        left: 0px;
        padding: 2px 0px 0px 0px;
        box-shadow: none;
    }
    .list_sec .card_item {
        padding: 0px 0px 15px 0px;
    }
    .list_sec .card_item .project_name {
        font-size: 13px;
        line-height: 19px;
        margin: 6px 0px 0px 0px;
    }
    .list_sec .bootstrap-select.pattern_select{
        display: none;
    }
    .list_sec .card_item .sub_content {
        margin-bottom: 0px;
    }
    .list_sec .control_sec .num strong {
        float: none;
    }
    .list_sec .control_sec .num {
        width: 100%;
        text-align: center;
        top: 16px;
    }
    .list_sec .features_sec ul li {
        font-size: 13px;
    }
    .list_sec .features_sec ul li svg {
        width: 17px;
        position: relative;
        top: 3px;
    }
    .list_sec .card_item .view_cont {
        height: 160px;
    }
    .list_sec .card_item .view_cont a img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .list_sec .btn_style {
        width: 22px;
        height: 22px;
    }
    .list_sec .btn_style svg {
        top: 0px;
        width: 56%;
    }
    .list_sec .btn_style .type_map svg {
        width: 45%;
    }
    .list_sec .card_item .features_sec{
        position: relative;
        padding: 5px 0px 0px 5px;
    }
    .list_sec .card_item .features_sec ul{
        min-height: 52px;
    }
    .list_sec .card_item .features_sec ul li:nth-child(2),
    .list_sec .card_item .features_sec ul li:nth-child(3){
        display: none;
    }
    .list_sec .card_item .features_sec ul li:nth-child(1){
        float: right;
        width: 100%;
    }
    .list_sec .card_item .content{
        min-height: min-content;
    }
    .list_sec .btn_style.like.liked svg.liked_icon {
        top: 6px;
    }
    .map_sec {
        margin: 0px 0px 15px 0px;
        border-radius: 0px;
        width: calc(100% + 30px);
        left: -15px;
        top: 20px;
    }
    .bar_sec .project_name {
        display: none;
    }
    .bar_sec .features_sec {
        padding: 0px;
        display: none;
    }
    .bar_sec .control_sec {
        position: relative;
        width: calc(100% - 131px);
    }
    .bar_sec .control_sec .num {
        position: absolute;
        top: 4px;
        left: 0px;
        width: 100%;
        padding: 5px 5px 0px 5px;
    }
    .bar_sec .item a.details {
        font-size: 11px;
        top: 5px;
    }
    .bar_sec .features_sec ul li {
        font-size: 13px;
    }
    .bar_sec .features_sec ul li p {
        position: relative;
        top: 4px;
    }
    .bar_sec .card_item {
        padding: 0px 0px 15px 0px;
    }
    .list_sec .btn_style.type_video{
        display: none;
    }
    .top_control_sec h1 {
        font-size: 18px;
        margin: 0px;
    }
    .block_sec .features_sec h2 {
        min-height: min-content;
        line-height: 24px;
    }
    .control_icons a.map_btn{
        position: relative;
        top: -2px;
        margin: 0px;
    }   
    .control_icons a.type_block_btn,
    .control_icons a.type_list_btn,
    .control_icons a.type_bar_btn{
        position: relative;
        top: 3px;
    }
    .content_section {
        width: calc(100% - 0px);
        left: 0px;
        margin: 20px 0px 0px 0px;
        overflow: hidden;
    }
    .content_section h1{
        font-size: 25px;
        color: #0f6868;
    }
    .list_sec .shareBtn, .list_sec .btn_style {
        width: 22px !important;
        height: 22px !important;
    }
    .list_sec .shareBtn svg, .list_sec .btn_style svg{
        top: 0px !important;
    }
    .bar_sec .view_cont {
        width: 130px;
    }
    .bar_sec .share_sec.dropdown .shareBtn{
        width: 32px !important;
        height: 32px !important;
    }
    .bar_sec .share_sec.dropdown .shareBtn svg{
        top: 6px !important;
    }
    .type_bar_btn,
    .type_list_btn,
    .type_block_btn{
        display: none;
    }
    .left_sec {
        padding-top: 40px;
    }
    .block_sec{
        margin-top: 17px;
    }

    .control_icons {
        padding-top: 2px;
        margin-top: 0px;
    }
    .control_icons {
        margin-top: 2px;
    }
    .slick-list {
        padding: 5px 0px 11px 10px;
    }
    .cleared_filter {
        top: 13px;
    }
    .block_sec .card_item {
    width: 100%;
}
   .right_sec {
    margin: 0px 0px 0px 0px;
}
}

.content_section .cont img{
max-width:100%;
}
</style>
