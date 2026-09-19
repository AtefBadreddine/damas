@extends('admin.layouts.app', ["app_title" => "WhatsApp Contacts"])
@section('main_content')
@if(session('contact_success'))
    <div class="alert alert-success">{{ session('contact_success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add contact</h3>
            </div>
            <form method="POST" action="{{ route('admin.whatsapp_contacts.store') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="box-body">
                    <div class="form-group">
                        <label for="contact-name">Name</label>
                        <input id="contact-name" class="form-control" name="name" value="{{ old('name') }}" maxlength="191" autocomplete="name">
                    </div>
                    <div class="form-group">
                        <label for="contact-phone">Phone number <span class="text-danger">*</span></label>
                        <input id="contact-phone" class="form-control" type="tel" name="phone" value="{{ old('phone') }}" maxlength="50" placeholder="+968 9XXX XXXX" autocomplete="tel" dir="ltr" required>
                        <p class="help-block">Include the country code. Spaces, brackets, and dashes are accepted.</p>
                    </div>
                    <div class="form-group">
                        <label for="contact-notes">Notes</label>
                        <textarea id="contact-notes" class="form-control" name="notes" rows="4" maxlength="5000">{{ old('notes') }}</textarea>
                    </div>
                    <p class="help-block">Saving a contact does not send a message or record their consent.</p>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add contact
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Contacts ({{ $contacts->total() }})</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('admin.whatsappapi') }}" class="btn btn-default btn-sm">Webhook viewer</a>
                </div>
            </div>
            <div class="box-body">
                <form method="GET" action="{{ route('admin.whatsapp_contacts') }}">
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" type="search" name="q" value="{{ $search }}" maxlength="191" placeholder="Search name or number" aria-label="Search contacts" style="max-width: 100%;">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" style="background-color:#13aaa8 !important;height: 39px; border-top-right-radius: 5px !important;border-bottom-right-radius: 5px !important">Search</button>
                                @if($search !== '')
                                    <a href="{{ route('admin.whatsapp_contacts') }}" class="btn btn-default">Clear</a>
                                @endif
                            </span>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Notes</th>
                                <th>Consent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td dir="auto">{{ $contact->name ?: '—' }}</td>
                                    <td dir="ltr" style="white-space: nowrap;">+{{ $contact->phone }}</td>
                                    <td dir="auto" style="white-space: pre-wrap; overflow-wrap: anywhere; min-width: 150px;">{{ $contact->notes ?: '—' }}</td>
                                    <td>
                                        @if($contact->opted_out_at)
                                            <span class="label label-danger">Opted out</span>
                                        @elseif($contact->opted_in_at)
                                            <span class="label label-success">Opted in</span>
                                        @else
                                            <span class="label label-default">Not recorded</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No contacts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                {!! $contacts->render() !!}
            </div>
        </div>
    </div>
</div>
@endsection