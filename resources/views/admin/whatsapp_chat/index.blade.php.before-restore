@extends('admin.layouts.app', ["app_title" => "WhatsApp Chat"])
@section('main_content')
<style>
    main {
        background-color: #ddd;
        height: 80vh;
        width: 100%;
        display: grid;
        grid-template-rows: 1fr;
        grid-template-columns: 1fr 3fr;
    }
    .left {
        background-color: #aaa;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: flex-start;
        overflow-y: scroll;
    }
    .contact {
        background-color: #aaa;
        height: 50px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 5px;
        border: 0.5px solid #888;
        cursor: pointer;
    }
    .profile {
        background-color: #bbb;
        height: 70px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 5px;
    }
    .contact *, .profile * {
        margin: 0;
    }
    .messages {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: flex-end;
        padding: 20px;
    }
    .message-container {
        display: flex;
        flex-direction: row;
        align-items: stretch;
    }
    .message-container-left {
        justify-content: flex-start;
    }
    .message-container-right {
        justify-content: flex-end;
    }
    .message-container-left .message {
        background-color: #444;
    }
    .message-container-right .message {
        background-color: #13aaa8;
    }
    .message {
        color: #fff;
        padding: 10px 5px;
        border-radius: 5px;
    }
    .message span {
        font-size: 10px;
        color: #ccc;
        font-weight: 700;
    }
</style>
<?php 
    $contact_id = $_GET['contact_id'] ?? '';
    $contact = \DB::table('whatsapp_contacts')->where('id', $contact_id)->first();
    $contacts = \DB::table('whatsapp_contacts')->get();
    $messages = \DB::table('whatsapp_messages')->where('contact_phone', $contact->phone)->orderBy('message_at', 'asc')->get() ?? [];
?>
<pre><?= json_encode($contact) ?></pre>
<main>
    <sction class="left">
        @foreach($contacts as $contact)
            <div class="contact" data-id="{{ $contact->id }}">
                <p>{{ $contact->name }}</p>
                <p>{{ $contact->notes }}</p>
            </div>
        @endforeach
    </sction>
    <section class="right">
        <div class="profile">
            <p>{{ $contact->name }}</p>
            <p>{{ $contact->notes }}</p>
        </div>
        <div class="messages">
            @foreach($messages as $message)
                <div class="message-container message-container-<?= $message->direction === 'incoming' ? 'left' : 'right' ?>">
                    <div class="message">
                        {{ $message->body }}
                        <span>{{ $message->message_at }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="send">
            
        </div>
    </section>
</main>
<script>
    [...document.querySelectorAll(".contact")].forEach(curr => {
        curr.addEventListener("click", e => {
            window.location.replace(`https://damas.net/damas-administrator/whatsappchat?contact_id=${curr.dataset.id}`);
        });
    });
</script>
@endsection