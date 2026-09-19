@extends('admin.layouts.app', ['app_title' => 'Chat'])
@section('main_content')

<?php
    $new_messages = Helper::query("ChatMessage", "where", ["field" => "parent_id", "value" => 0])->orderBy("updated_at", "DESC")->get();
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary direct-chat direct-chat-warning">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                <div class="box-toolss pull-right">
                    <!--<span class="badge bg-green"><?= count($new_messages); ?></span>-->
                </div>
                <div class="pull-left">
                    <a href="" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Reload page</a>
                    <a href="<?= route("admin.support"); ?>" class="btn btn-default btn-sm">List of Messages</a>
                </div>
            </div>
            <div class="box-body">
                <div class="direct-chat-messages" style="min-height:250px;height:100%;">
                   
                    @if($message->id)
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">{{ $message->author }}</span>
                                <span class="direct-chat-timestamp pull-left"><?= ($message->created_at); ?></span>
                            </div>
                            <img class="direct-chat-img" src="<?= asset("img/user.jpg") ?>" alt="">
                            <div class="direct-chat-text">
                                {{ $message->message }}
                            </div>
                        </div>
                        
                        @foreach($responses as $rep)
                        <hr>
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">{{ $rep->author }}</span>
                                <span class="direct-chat-timestamp pull-left"><?= ($rep->created_at); ?></span>
                            </div>
                            <img class="direct-chat-img" src="<?= asset("img/user.jpg") ?>" alt="">
                            <div class="direct-chat-text">
                                {{ $rep->message }}
                            </div>
                            @if($rep->viewed == 0)
                                <b class="text-danger"><i class="fa fa-warning"></i> غير مقروء</b>
                            @endif
                        </div>
                        @endforeach
                        
                    @else
                        @foreach($new_messages as $nm)
                        <a href="<?= route("admin.support", $nm->id); ?>">
                            <div class="direct-chat-msg">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-right">
                                        {{ $nm->author }}
                                        @if($nm->viewed == 0)
                                            <i class="fa fa-refresh fa-spin fa-fw"></i>
                                        @endif
                                    </span>
                                    <span class="direct-chat-timestamp pull-left"><?= ($nm->created_at); ?></span>
                                </div>
                                <img class="direct-chat-img" src="<?= asset("img/user.jpg") ?>" alt="">
                                <div class="direct-chat-text" <?= $nm->viewed==0 ? 'style="background: #3c8dbc;"' : ''; ?>>
                                    {{ $nm->message }}
                                </div>
                            </div>
                        </a>
                        <hr>
                        @endforeach
                    @endif
                    
                </div>
                
            </div>
            <!-- /.box-body -->
            
            @if($message->id)
            <div class="box-footer">
                <?= Form::open(); ?>
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Message ..." class="form-control" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default btn-flat">Send</button>
                        </span>
                    </div>
                <?= Form::close(); ?>
            </div>
            @endif
            
            <!-- /.box-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <!-- /.col -->        
</div>

@if(!$message->id)
<script>
    setTimeout(rld, 10000);
    function rld() {
        location.reload();
    }
</script>
@endif

@endsection
