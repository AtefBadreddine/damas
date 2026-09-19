<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WhatsApp webhook events</title>
    <style>
        body { font-family: sans-serif; margin: 24px; color: #222; }
        details { border: 1px solid #ddd; border-radius: 6px; margin: 12px 0; padding: 12px; }
        summary { cursor: pointer; }
        pre { white-space: pre-wrap; overflow-wrap: anywhere; background: #f5f5f5; padding: 16px; }
        .pagination { display: flex; gap: 12px; list-style: none; padding: 0; }
    </style>
</head>
<body>
    <h1>WhatsApp webhook events</h1>
    <p>Newest first. Times are UTC. Reload this page to see new events.</p>
    @if(session('whatsapp_success'))
        <div class="alert alert-success">{{ session('whatsapp_success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('admin.whatsappapi.send') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="whatsapp-to">Recipient number — country code included, digits only</label>
            <input id="whatsapp-to" class="form-control" type="text" name="to" value="{{ old('to') }}" placeholder="905xxxxxxxxx" pattern="[1-9][0-9]{6,14}" required>
        </div>
        <div class="form-group">
            <label for="whatsapp-message">Message</label>
            <textarea id="whatsapp-message" class="form-control" name="message" rows="4" maxlength="4096" required>{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send WhatsApp message</button>
    </form>
    @forelse($events as $event)
        <details>
            <summary>#{{ $event->id }} — {{ $event->received_at }} UTC</summary>
            <pre dir="ltr">{{ json_encode(json_decode($event->payload), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
        </details>
    @empty
        <p>No webhook events received yet.</p>
    @endforelse
    {!! $events->render() !!}
</body>
</html>