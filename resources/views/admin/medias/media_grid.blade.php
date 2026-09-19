<?php
    $arr_ids = isset($inputs["ids"]) ? explode(",", $inputs["ids"]) : [];
    $multiple = @$inputs["multiple"];
?>
<div id="medias-container">
    @if(count($rows) and $multiple==1)
        <div class="form-group">
            <label><input type="checkbox" class="checkallmedias"> Select all</label>
        </div>
    @endif
    <ul class="mailbox-attachments clearfix">
        <?php foreach ( $rows as $media ): ?>
        <?php $fpath = asset("".$media->path.$media->filename); ?>
        <li class="media_item pull-right" data-id="<?= $media->id; ?>" style="width:150px;">
            <span class="mailbox-attachment-icon has-img">
                <img src="<?= Helper::get_thumbnail($media, 150, 120); ?>">
            </span>
            <div class="mailbox-attachment-info">
                <a href="<?= Helper::media_url($media); ?>" target="_blank" class="mailbox-attachment-name"><i class="fa fa-camera"></i> <?= $media->name_en; ?></a>
                <span class="mailbox-attachment-size">
                    '
                    <span class="pull-left">
                        <?php if ( $multiple == 1 ): ?>
                            <input type="checkbox" class="checked_media" value="<?= $media->id; ?>" data-name="<?= $media->name_en; ?>" <?= in_array($media->id, $arr_ids) ? 'checked' : ''; ?>>
                        <?php else: ?>
                            <input type="radio" name="radio_media" class="checked_media" value="<?= $media->id; ?>" data-name="<?= $media->name_en; ?>" <?= in_array($media->id, $arr_ids) ? 'checked' : ''; ?>>
                        <?php endif; ?>
                    </span>
                </span>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="medias-pagination text-center clearfix" data-multiple="<?= $multiple; ?>" data-folder="<?= @$inputs["folder_id"]; ?>">
        <?php $rows->setPath(route('admin.medias')); ?>
        <?= $rows->render(); ?>
    </div>
</div>