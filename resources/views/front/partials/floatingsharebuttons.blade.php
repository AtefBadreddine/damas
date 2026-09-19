<?php
    $class_mobile = @$class_mobile;
    $infos = Helper::get_params();
?>
<!-- share buttons -->
<div class="<?= $class_mobile ? $class_mobile : "sharefloating"; ?> shareBtnsFloatingg">
    @if($class_mobile)<span class="sharecollect"><i class="fa fa-share-alt"></i></span>@endif
    <a class="btn btnshare fa fa-facebook" data-network="facebook" data-text="Damas Turk" rel="rel"></a>
    <a class="btn btnshare fa fa-twitter" data-network="twitter" data-text="Damas Turk"  rel="nofollow"></a>
    <a class="btn btnshare fa fa-whatsapp" data-network="whatsapp" data-text="Damas Turk"  rel="nofollow"></a>

</div>