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
    .right {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: space-between;
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
        max-height: 60vh;
        overflow-y: scroll;
    }
    .message-container {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        flex-shrink: 0;
    }
    .message-container-left {
        justify-content: flex-start;
    }
    .message-container-right {
        justify-content: flex-end;
    }
    .date-seperator {
        justify-content: center;
        margin: 10px 0;
    }
    .seperator {
        padding: 5px 3px;
        background-color: #777;
        color: #fff;
        border-radius: 5px;
        font-size: 10px;
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
        margin-top: 5px;
        max-width: 50%;
    }
    .message span {
        font-size: 10px;
        color: #ccc;
        font-weight: 700;
    }
    .wa-audio {
        display: block;
        width: min(280px, 65vw);
        max-width: 100%;
    }
    .wa-video {
        display: block;
        max-width: min(360px, 65vw);
        max-height: 320px;
        width: 100%;
        border-radius: 5px;
        background: #111;
    }
    .wa-document {
        display: block;
        max-width: 260px;
        overflow-wrap: anywhere;
        color: white;
        font-weight: 700;
        text-decoration: underline;
    }
    .wa-caption {
        margin-top: 5px;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
    }
    .send {
        width: 100%;
        height: fit-content;
        background-color: #888;
        min-height: 50px;
        border-radius: 20px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 7px 20px;
    }
    .message-input {
        width: 100%;
        vertical-align: middle;
        font-size: 17px;
        outline: none;
        color: #fff;
        padding-right: 20px;
    }
    .send-icon {
        transform: scaleX(-1);
        margin-left: 3px;
    }
    .send-container {
        border-radius: 100%;
        background-color: #13aaa8;
        width: 35px;
        height: 35px;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .right {
        min-height: 0;
        min-width: 0;
        overflow: hidden;
    }
    .right > div:first-child {
        flex: 1;
        min-height: 0;
        display: flex;
        flex-direction: column;
    }
    .profile,
    .send {
        flex-shrink: 0;
    }
    .messages {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        justify-content: flex-start;
    }
    .current-contact {
        background-color: #ccc;
    }
    .message-popup {
        background-color: #ff4747;
        border-radius: 100%;
        width: 20px;
        height: 20px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-evenly;
    }
</style>
<?php
    $contacts = \DB::table('whatsapp_contacts as c')
    ->select('c.*')
    ->selectRaw(
        '(SELECT COUNT(*)
          FROM dms_whatsapp_messages AS m
          WHERE m.contact_phone = dms_c.phone
          AND m.phone_number_id = ?
          AND m.direction = ?
          AND m.admin_read_at IS NULL) AS unread_count',
        [config('whatsapp.phone_number_id'), 'incoming']
    )
    ->selectRaw(
        '(SELECT MAX(m.message_at)
          FROM dms_whatsapp_messages AS m
          WHERE m.contact_phone = dms_c.phone
          AND m.phone_number_id = ?
          AND m.direction = ?) AS latest_message_at',
        [config('whatsapp.phone_number_id'), 'incoming']
    )
    ->orderBy('unread_count', 'desc')
    ->orderBy('latest_message_at', 'desc')
    ->orderBy('c.name', 'asc')
    ->get();
    $contact_id = filter_var(request()->query('contact_id'), FILTER_VALIDATE_INT);
    if ($contact_id !== false && $contact_id !== null && $contact_id > 0) {
        $contact_obj = \DB::table('whatsapp_contacts')->where('id', $contact_id)->first();
    } else {
        $contact_obj = isset($contacts[0]) ? $contacts[0] : null;
    }
    if (!$contact_obj) {
        abort(404, 'Contact not found. Add a contact first.');
    }
    $unread_messages = [];
    foreach(\DB::table('whatsapp_messages')->where('contact_phone', '!=', $contact_obj->phone)->where('direction', 'incoming')->where('admin_read_at', null)->get(['contact_phone']) as $rowObj){
        $contact_id = intval(\DB::table('whatsapp_contacts')->where('phone', $rowObj->contact_phone)->first()->id);
        $unread_messages[$contact_id] = isset($unread_messages[$contact_id]) ? intval($unread_messages[$contact_id])+1 : 1;
    }
    $contact_id = (int) $contact_obj->id;
    $messages = \DB::table('whatsapp_messages')
        ->where('phone_number_id', config('whatsapp.phone_number_id'))
        ->where('contact_phone', $contact_obj->phone)
        ->orderBy('message_at', 'desc')
        ->orderBy('id', 'desc')
        ->take(100)
        ->get();
    $messages = array_reverse($messages);
    $messagesWithDays = [];
    $previousDay = null;
    $utcTimezone = new \DateTimeZone('UTC');
    $omanTimezone = new \DateTimeZone('Asia/Muscat');
    
    foreach ($messages as $messageObj) {
        $messageDate = new \DateTime($messageObj->message_at, $utcTimezone);
        $messageDate->setTimezone($omanTimezone);
    
        $dayKey = $messageDate->format('Y-m-d');
    
        if ($dayKey !== $previousDay) {
            $messagesWithDays[] = $messageDate->format('l, d M Y');
            $previousDay = $dayKey;
        }
    
        $messagesWithDays[] = $messageObj;
    }
    
    $messages = $messagesWithDays;
    $lastIncomingUtc = \DB::table('whatsapp_messages')
    ->where('phone_number_id', config('whatsapp.phone_number_id'))
    ->where('contact_phone', $contact_obj->phone)
    ->where('direction', 'incoming')
    ->orderBy('message_at', 'desc')
    ->orderBy('id', 'desc')
    ->value('message_at');
    \DB::table('whatsapp_messages')->where('contact_phone', $contact_obj->phone)->update(['admin_read_at' => \DB::raw('NOW()')]);
?>
<main>
    <sction class="left">
        @foreach($contacts as $contact)
            <div class="contact <?= $contact->id == $contact_id ? 'current-contact' : '' ?>" data-id="{{ $contact->id }}">
                <p>{{ $contact->name }}</p>
                <?php if (isset($unread_messages[$contact->id])): ?>
                    <div class="message-popup">
                        <?= (int) $unread_messages[$contact->id] ?>
                    </div>
                <?php else: ?>
                    <p>{{ $contact->notes }}</p>
                <?php endif; ?>
            </div>
        @endforeach
    </sction>
    <section class="right">
        <div>
            <div class="profile">
                <p>{{ $contact_obj->name }}</p>
                <p>+{{ $contact_obj->phone }}</p>
                <p>{{ $contact_obj->notes }}</p>
            </div>
            <div class="messages">
                @foreach($messages as $message)
                    @if(is_string($message) === true)
                    <div class="message-container date-seperator">
                        <div class="seperator">{{ $message }}</div>
                    </div>
                    @else
                    <div class="message-container message-container-<?= $message->direction === 'incoming' ? 'left' : 'right' ?>">
                        <div class="message">
                            @if ($message->message_type === 'image')
                                @if ($message->media_id)
                                    <img src="{{ route('admin.whatsappchat.image', ['id' => $message->id]) }}"
                                        alt="Image from customer"
                                        loading="lazy"
                                        style="display:block;max-width:260px;max-height:300px;width:auto;height:auto;border-radius:5px;"
                                    >
                                @else
                                    <span>[Image unavailable]</span>
                                @endif
                                @if ($message->body)
                                    <div class="wa-caption">{{ $message->body }}</div>
                                @endif
                            @elseif ($message->message_type === 'audio')
                                @if ($message->media_id)
                                    <audio class="wa-audio" controls preload="none"
                                           src="{{ route('admin.whatsappchat.media', ['id' => $message->id]) }}">
                                        Your browser cannot play this audio.
                                    </audio>
                                @else
                                    <span>[Voice message unavailable]</span>
                                @endif
                            @elseif ($message->message_type === 'video')
                                @if ($message->media_id)
                                    <video class="wa-video" controls preload="none"
                                           src="{{ route('admin.whatsappchat.media', ['id' => $message->id]) }}">
                                        Your browser cannot play this video.
                                    </video>
                                @else
                                    <span>[Video unavailable]</span>
                                @endif
                                @if ($message->body && $message->body !== '[Video]')
                                    <div class="wa-caption">{{ $message->body }}</div>
                                @endif
                            @elseif ($message->message_type === 'document')
                                @if ($message->media_id)
                                    <a class="wa-document" href="{{ route('admin.whatsappchat.media', ['id' => $message->id]) }}">📎 {{ $message->media_filename ?: ($message->body ?: 'Download document') }}</a>
                                @else
                                    <span>[Document unavailable]</span>
                                @endif
                                @if ($message->media_filename && $message->body && $message->body !== $message->media_filename)
                                    <div class="wa-caption">{{ $message->body }}</div>
                                @endif
                            @elseif ($message->message_type === 'template')
                                <div class="wa-caption" dir="auto" style="white-space:pre-wrap;overflow-wrap:anywhere;">{{ $message->body }}</div>
                                <small style="display:block">{{ ucfirst($message->status) }}</small>
                            @else
                                {{ $message->body }}
                            @endif
                            <span class="message-time" data-utc="{{ $message->message_at }}"></span>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="send">
            <div class="message-input" contenteditable="true" dir="auto"></div>
            <div class="send-container">
                <img class="send-icon" src="https://damas.net/img/sendIconW.svg" alt="Send Icon" width="21" height="20">
            </div>
        </div>
    </section>
</main>
<script>
    console.log(<?= json_encode($unread_messages) ?>);
    const sendBtn = document.querySelector(".send-container");
    const messageInput = document.querySelector(".message-input");
    const messages = document.querySelector(".messages");
    const timeFormatter = new Intl.DateTimeFormat("en-GB", {
        timeZone: "Asia/Muscat",
        hour: "2-digit",
        minute: "2-digit",
        hourCycle: "h23"
    });
    function formatMessageTime(date) {
        return Number.isNaN(date.getTime()) ? "" : timeFormatter.format(date);
    }
    document.querySelectorAll(".message-time").forEach(element => {
        const date = new Date(element.dataset.utc.replace(" ", "T") + "Z");
        element.textContent = formatMessageTime(date);
    });
    messages.scrollTop = messages.scrollHeight;
    document.querySelectorAll(".contact").forEach(contact => {
        contact.addEventListener("click", () => {
            window.location.replace(`https://damas.net/damas-administrator/whatsappchat?contact_id=${contact.dataset.id}`);
        });
    });
    messageInput.addEventListener("input", () => {
        const lastIncomingUtc = {!! json_encode($lastIncomingUtc, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
        const lastIncomingMs = lastIncomingUtc
            ? new Date(lastIncomingUtc.replace(" ", "T") + "Z").getTime()
            : NaN;
        if (!Number.isFinite(lastIncomingMs) || Date.now() - lastIncomingMs >= 24 * 60 * 60 * 1000) {
            return;
        }
        sendBtn.style.display = messageInput.innerText.trim() ? "flex" : "none";
    });
    sendBtn.addEventListener("click", () => {
        const text = messageInput.innerText.trim();
        // If the text is empty
        if (!text) {
            return;
        }
        // If it's within the last 24 hours
        const lastIncomingUtc = {!! json_encode($lastIncomingUtc, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
        const lastIncomingMs = lastIncomingUtc
            ? new Date(lastIncomingUtc.replace(" ", "T") + "Z").getTime()
            : NaN;
        if (!Number.isFinite(lastIncomingMs) || Date.now() - lastIncomingMs >= 24 * 60 * 60 * 1000) {
            alert("The 24-hour reply window has closed. Send an approved template to start a new conversation.");
            return;
        }
        // If it passes both checks, do the fetch
        const outputJson = JSON.stringify({
            to: {!! json_encode($contact_obj->phone, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!},
            message: text,
            _token: {!! json_encode(csrf_token(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
        });
        const container = document.createElement("div");
        container.className = "message-container message-container-right";
        const bubble = document.createElement("div");
        bubble.className = "message";
        bubble.appendChild(document.createTextNode(text + " "));
        const timestamp = document.createElement("span");
        timestamp.textContent = formatMessageTime(new Date());
        bubble.appendChild(timestamp);
        const status = document.createElement("span");
        status.textContent = " · Unconfirmed";
        bubble.appendChild(status);
        container.appendChild(bubble);
        messages.appendChild(container);
        messages.scrollTop = messages.scrollHeight;
        messageInput.textContent = "";
        sendBtn.style.display = "none";
        fetch("{{ route('admin.whatsappapi.send') }}", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: outputJson
        }).then(response => {
            if (!response.ok) {
                status.textContent = " · Check sending result";
                alert("The server returned an error. Refresh the conversation before trying again.");
            }
        }).catch(error => {
            console.error(error);
            status.textContent = " · Check sending result";
            alert("Couldn't confirm sending. Refresh the conversation before trying again.");
        });
    });
    messageInput.addEventListener("keydown", e => {
        if (e.key === "Enter" && !e.shiftKey && !e.isComposing) {
            e.preventDefault();
            sendBtn.click();
        }
    });
</script>
@endsection
