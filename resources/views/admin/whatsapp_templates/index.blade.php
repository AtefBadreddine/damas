@extends('admin.layouts.app', ['app_title' => 'WhatsApp Templates'])
@section('main_content')
<style>
.wa-templates {max-width:1200px;margin:20px auto;padding:16px}
.wa-templates [hidden] {display:none!important}
.wa-templates-grid {display:grid;grid-template-columns:1.2fr 1fr;gap:24px}
.wa-templates input[type=text] {width:100%;padding:10px}
.wa-templates label {display:block;margin:12px 0 6px}
.wa-recipient-list {max-height:350px;overflow-y:auto;border:1px solid #ddd;margin:12px 0}
.wa-recipient-list label {display:flex;align-items:center;gap:10px;margin:0;padding:10px;border-bottom:1px solid #eee;cursor:pointer}
.wa-recipient-list small {display:block}
.wa-template-preview {background:#dcf8c6;color:#18251c;padding:20px;border-radius:12px}
.wa-template-part {white-space:pre-wrap;overflow-wrap:anywhere;margin-bottom:12px}
.wa-template-button {display:block;background:#fff;color:#167d70;padding:10px;text-align:center;margin-top:8px;border-radius:5px}
.wa-template-feedback {margin:16px 0;padding:12px;background:#f3f4f5;white-space:pre-wrap}
.wa-template-feedback[data-error=yes] {border-left:4px solid #c73939}
.wa-templates button {margin:8px 6px 0 0;padding:8px 14px}
.wa-templates button:disabled {opacity:.5;cursor:not-allowed}
.wa-template-table {width:100%;border-collapse:collapse}
.wa-template-table td,.wa-template-table th {text-align:left;vertical-align:top;padding:10px;border-bottom:1px solid #ddd}
.wa-template-table tr[data-status=accepted] {background:#f0faf1}
.wa-template-table tr[data-status=failed],.wa-template-table tr[data-status=unknown] {background:#fff3f0}
.wa-template-table tr[data-status=sending] {background:#eef5ff}
.wa-table-wrap {max-height:450px;overflow:auto}
.wa-templates progress {width:100%;height:20px}
@media(max-width:750px){.wa-templates-grid{grid-template-columns:1fr}}
</style>
<div class="wa-templates">
<h1>WhatsApp templates</h1>
@if ($loadError)
    <div class="wa-template-feedback" data-error="yes">{{ $loadError }}</div>
    <a href="{{ route('admin.whatsapp_templates') }}">Reload templates</a>
@else
    <p><strong>{{ $template['name'] }}</strong> · {{ $template['language'] }} · Approved</p>
    <div class="wa-templates-grid">
        <form id="wa-template-form" action="{{ route('admin.whatsapp_templates.send') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label for="wa-contact-search">Search contacts</label>
            <input type="text" id="wa-contact-search" placeholder="Name or phone number">
            <div>
                <button type="button" id="wa-select-all">Select all contacts</button>
                <button type="button" id="wa-select-visible">Select search results</button>
                <button type="button" id="wa-clear">Clear selection</button>
            </div>
            <p id="wa-selection-count" aria-live="polite" style="margin-top:10px"></p>
            <div class="wa-recipient-list">
                @foreach ($contacts as $contact)
                    <?php $validPhone = preg_match('/^[1-9][0-9]{6,14}$/D', (string) $contact->phone); ?>
                    <label class="wa-recipient-row">
                        <input type="checkbox" class="wa-recipient" value="{{ $contact->id }}"
                            data-phone="{{ $contact->phone }}" data-name="{{ $contact->name }}"
                            data-valid="{{ $validPhone ? '1' : '0' }}" {{ $validPhone ? '' : 'disabled' }}>
                        <span>{{ $contact->name }}<small>+{{ $contact->phone }}{{ $validPhone ? '' : ' — fix this number before sending' }}</small></span>
                    </label>
                @endforeach
            </div>
            @foreach ($template['parts'] as $part)
                @foreach ($part['fields'] as $field)
                    <label for="wa-param-{{ $field['key'] }}">{{ ucfirst($part['type']) }} variable {{ $field['position'] }}</label>
                    <input type="text" id="wa-param-{{ $field['key'] }}" data-param="{{ $field['key'] }}" maxlength="1024" required>
                @endforeach
            @endforeach
            <p>Entered variable values will be the same for every recipient in this batch.</p>
            <label><input type="checkbox" id="wa-consent" required> All selected contacts agreed to receive these WhatsApp messages.</label>
            <button id="wa-template-send" type="submit" class="btn btn-primary">Send to selected contacts</button>
            <p style="margin-top:12px">Keep this tab open while sending. Marketing messages may incur Meta charges.</p>
        </form>
        <div>
            <h3>Message preview</h3>
            <div class="wa-template-preview" dir="auto">
                @foreach ($template['parts'] as $part)
                    <div class="wa-template-part" data-part="{{ $part['type'] }}">{{ $part['text'] }}</div>
                @endforeach
                @foreach ($template['buttons'] as $button)
                    <div class="wa-template-button">{{ $button['text'] }}</div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="wa-template-feedback" class="wa-template-feedback" role="status" hidden></div>
    <section id="wa-batch-panel" hidden>
        <h3>Batch progress</h3>
        <p id="wa-batch-summary" aria-live="polite"></p>
        <progress id="wa-batch-progress" max="1" value="0"></progress>
        <button type="button" id="wa-pause">Pause after current message</button>
        <button type="button" id="wa-resume" hidden>Resume remaining recipients</button>
        <button type="button" id="wa-discard" hidden>Prepare a new batch</button>
        <p>Accepted means Meta accepted the request. Unknown results are never resent automatically.</p>
        <div class="wa-table-wrap"><table class="wa-template-table">
            <thead><tr><th>Recipient</th><th>Result</th><th>Details</th><th>Chat</th></tr></thead>
            <tbody id="wa-batch-rows"></tbody>
        </table></div>
    </section>
@endif
</div>
@if ($template)
<script>
(function () {
    'use strict';
    const el = id => document.getElementById(id);
    const form = el('wa-template-form'), send = el('wa-template-send'), search = el('wa-contact-search');
    const boxes = Array.from(document.querySelectorAll('.wa-recipient'));
    const feedback = el('wa-template-feedback'), consent = el('wa-consent');
    const pause = el('wa-pause'), resume = el('wa-resume'), discard = el('wa-discard');
    const template = {!! json_encode($template, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
    const storageKey = {!! json_encode($batchStorageKey, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
    const chatBase = {!! json_encode(route('admin.whatsapp_chat'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
    const csrf = form.querySelector('[name=_token]').value;
    const labels = {queued:'Queued',sending:'Sending',accepted:'Accepted',failed:'Failed',unknown:'Unknown — check',blocked:'Not sent — paused'};
    let batch = null, running = false, pauseRequested = false, storageOK = true;
    const rowViews = new Map();
    function notify(text, error) {
        feedback.hidden = false; feedback.textContent = text; feedback.dataset.error = error ? 'yes' : 'no';
    }
    function requestId() {
        const bytes = new Uint8Array(16); window.crypto.getRandomValues(bytes);
        return Array.from(bytes,n => n.toString(16).padStart(2,'0')).join('');
    }
    function uniqueRecipients() {
        const seen = new Set();
        return boxes.filter(box => {
            if (!box.checked || box.dataset.valid !== '1' || seen.has(box.dataset.phone)) return false;
            seen.add(box.dataset.phone); return true;
        });
    }
    // The admin layout loads iCheck after this Blade section. iCheck replaces
    // the visible checkbox and does not react to a plain `box.checked = ...`.
    // Route every programmatic change through iCheck when it has initialized,
    // while retaining the native fallback for pages where it is unavailable.
    function setBoxChecked(box, checked) {
        const parent = box.parentElement;
        const iCheckReady = window.jQuery && window.jQuery.fn &&
            typeof window.jQuery.fn.iCheck === 'function' && parent &&
            /(^|\s)icheckbox/.test(parent.className);
        if (iCheckReady) {
            window.jQuery(box).iCheck(checked ? 'check' : 'uncheck');
        } else {
            box.checked = checked;
        }
    }
    function selectionCount() {
        const selected = boxes.filter(box => box.checked).length, unique = uniqueRecipients().length;
        const visible = boxes.filter(box => !box.closest('label').hidden).length;
        el('wa-selection-count').textContent = selected+' selected · '+unique+' unique numbers · '+visible+'/'+boxes.length+' contacts shown'+
            (selected>unique ? '. Duplicate numbers will receive one message.' : '');
        send.disabled = Boolean(batch) || unique === 0 || !storageOK;
    }
    boxes.forEach(box => box.addEventListener('change',selectionCount));
    // iCheck emits `ifChanged` instead of relying only on the native change
    // event. Delegation also works when the layout initializes iCheck later.
    if (window.jQuery) {
        window.jQuery(document).on('ifChanged.waTemplates', '.wa-recipient', selectionCount);
    }
    search.addEventListener('input',function () {
        const query = this.value.toLocaleLowerCase().trim();
        boxes.forEach(box => box.closest('label').hidden = !(box.dataset.name+' '+box.dataset.phone).toLocaleLowerCase().includes(query));
        selectionCount();
    });
    function selectContacts(visibleOnly, checked) {
        if (batch) return;
        boxes.forEach(box => {
            if (box.dataset.valid === '1' && (!visibleOnly || !box.closest('label').hidden)) {
                setBoxChecked(box, checked);
            }
        });
        selectionCount();
    }
    el('wa-select-all').addEventListener('click',() => selectContacts(false,true));
    el('wa-select-visible').addEventListener('click',() => selectContacts(true,true));
    el('wa-clear').addEventListener('click',() => selectContacts(false,false));
    function preview() {
        template.parts.forEach(part => {
            const text = part.text.replace(/\{\{([0-9]+)\}\}/g,(match,position) => {
                const input = document.querySelector('[data-param="'+part.type+'_'+position+'"]');
                return input && input.value.trim() ? input.value.trim() : match;
            });
            document.querySelector('[data-part="'+part.type+'"]').textContent = text;
        });
    }
    form.querySelectorAll('[data-param]').forEach(input => input.addEventListener('input',preview));
    function save() {
        try { sessionStorage.setItem(storageKey,JSON.stringify(batch)); return true; }
        catch (error) {
            storageOK=false; pauseRequested=true;
            notify('Progress could not be saved in this tab. Sending is paused; check results before starting another batch.',true);
            return false;
        }
    }
    function chatUrl(id) { const url=new URL(chatBase,window.location.origin); url.searchParams.set('contact_id',id); return url.href; }
    function buildRows() {
        const container=el('wa-batch-rows'); container.replaceChildren(); rowViews.clear();
        batch.items.forEach(item => {
            const row=document.createElement('tr'), name=document.createElement('td'), status=document.createElement('td');
            const details=document.createElement('td'), linkCell=document.createElement('td'), link=document.createElement('a');
            name.textContent=item.name+' (+'+item.phone+')';
            link.href=chatUrl(item.contact_id); link.target='_blank'; link.rel='noopener'; link.textContent='Open chat';
            linkCell.appendChild(link); row.append(name,status,details,linkCell); container.appendChild(row);
            rowViews.set(item.request_id,{row,status,details});
        });
    }
    function render() {
        el('wa-batch-panel').hidden=!batch && storageOK;
        Array.from(form.elements).forEach(element => { element.disabled=Boolean(batch) ||
            (element.classList.contains('wa-recipient') && element.dataset.valid !== '1'); });
        selectionCount();
        if (!batch) {
            pause.hidden=true; resume.hidden=true; discard.hidden=storageOK;
            if (!storageOK) el('wa-batch-summary').textContent='Saved progress could not be restored. Check previous chat messages before preparing a new batch.';
            return;
        }
        const counts={queued:0,sending:0,accepted:0,failed:0,unknown:0,blocked:0};
        batch.items.forEach(item => {
            counts[item.status]++; const view=rowViews.get(item.request_id);
            view.row.dataset.status=item.status; view.status.textContent=labels[item.status]; view.details.textContent=item.detail || '';
        });
        const remaining=counts.queued+counts.blocked;
        el('wa-batch-summary').textContent=counts.accepted+' accepted · '+counts.failed+' failed · '+counts.unknown+
            ' unknown · '+remaining+' remaining · '+counts.sending+' sending';
        const progress=el('wa-batch-progress'); progress.max=batch.items.length; progress.value=counts.accepted+counts.failed+counts.unknown;
        pause.hidden=!running; pause.disabled=pauseRequested; pause.textContent=pauseRequested?'Pausing after current request…':'Pause after current message';
        resume.hidden=running || !remaining; resume.disabled=!storageOK || batch.hash !== template.hash; discard.hidden=running;
    }
    async function run() {
        if (running || !batch || !storageOK || batch.hash !== template.hash) return;
        running=true; pauseRequested=false;
        batch.items.forEach(item => { if (item.status==='blocked') item.status='queued'; });
        if (!save()) { running=false; render(); return; }
        notify('Sending one recipient at a time. Keep this tab open.',false); render();
        for (const item of batch.items) {
            if (pauseRequested) break;
            if (item.status !== 'queued') continue;
            item.status='sending'; item.detail='';
            // Save the in-flight marker BEFORE sending. Refresh must never silently resend it.
            if (!save()) { item.status='queued'; break; }
            render();
            const body=new FormData();
            body.append('_token',csrf); body.append('request_id',item.request_id); body.append('contact_id',item.contact_id);
            body.append('expected_phone',item.phone); body.append('template_hash',batch.hash); body.append('consent','1');
            Object.entries(batch.params).forEach(([key,value]) => body.append('params['+key+']',value));
            const abort=new AbortController(), timeout=setTimeout(() => abort.abort(),90000);
            try {
                const response=await fetch(form.action,{method:'POST',credentials:'same-origin',redirect:'error',signal:abort.signal,
                    headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},body});
                const result=await response.json();
                if (typeof result.message !== 'string' || typeof result.ok !== 'boolean') throw new Error('Unexpected response');
                item.detail=result.message;
                if (result.attempted) {
                    item.status=['accepted','sent','delivered','read'].includes(result.status)?'accepted':result.status==='failed'?'failed':'unknown';
                } else {
                    item.status=result.stop_batch || response.status===401 || response.status===403 || response.status>=500?'blocked':'failed';
                }
                if (result.stop_batch || item.status==='unknown' || item.status==='blocked' || response.status>=500) {
                    pauseRequested=true; notify('Batch paused: '+result.message,true);
                }
            } catch (error) {
                item.status='unknown'; item.detail='No reliable response. Check the chat and recipient. This entry will not be resent automatically.';
                pauseRequested=true; notify('The connection was interrupted. The remaining recipients are paused.',true);
            } finally { clearTimeout(timeout); }
            save(); render();
            if (!pauseRequested) await new Promise(resolve => setTimeout(resolve,750));
        }
        running=false;
        const remaining=batch.items.some(item => item.status==='queued' || item.status==='blocked');
        if (!remaining && !pauseRequested) notify('Batch finished. Review the individual results below.',false);
        render();
    }
    form.addEventListener('submit',function(event) {
        event.preventDefault();
        if (batch || running || !form.reportValidity() || !storageOK) return;
        const recipients=uniqueRecipients(); if (!recipients.length) return;
        const lead=recipients.length===1?recipients[0].dataset.name+' (+'+recipients[0].dataset.phone+')':recipients.length+' unique recipients';
        if (!window.confirm('Send '+template.name+' to '+lead+'? Marketing charges may apply.')) return;
        const params={}; form.querySelectorAll('[data-param]').forEach(input => params[input.dataset.param]=input.value.trim());
        batch={version:1,hash:template.hash,params,items:recipients.map(box => ({contact_id:box.value,name:box.dataset.name,
            phone:box.dataset.phone,request_id:requestId(),status:'queued',detail:''}))};
        buildRows(); run();
    });
    pause.addEventListener('click',() => {
        pauseRequested=true; notify('Pausing after the current request. Queued recipients will wait until you resume.',false); render();
    });
    resume.addEventListener('click',() => run());
    discard.addEventListener('click',() => {
        if (running || !window.confirm('Start a new selection? This removes this tab\'s batch list, but keeps all saved chat messages.')) return;
        try { sessionStorage.removeItem(storageKey); } catch(error) { notify('Could not clear saved progress.',true); return; }
        batch=null; storageOK=true; boxes.forEach(box => setBoxChecked(box, false));
        setBoxChecked(consent, false);
        el('wa-batch-rows').replaceChildren(); rowViews.clear(); feedback.hidden=true; render();
    });
    window.addEventListener('beforeunload',event => { if(running) { event.preventDefault(); event.returnValue=''; } });
    // Restore progress, but never automatically send on page load.
    try {
        const saved=sessionStorage.getItem(storageKey);
        if(saved) {
            const parsed=JSON.parse(saved);
            if(parsed.version!==1 || !Array.isArray(parsed.items) || !parsed.items.length || typeof parsed.params!=='object' ||
                parsed.params===null || parsed.items.some(item => !Object.prototype.hasOwnProperty.call(labels,item.status) ||
                    !/^[a-f0-9]{32}$/.test(item.request_id) || !/^[1-9][0-9]*$/.test(item.contact_id))) throw new Error('Invalid saved batch');
            batch=parsed;
            batch.items.forEach(item => { if(item.status==='sending') {
                item.status='unknown'; item.detail='The page closed during this request. Check the chat and recipient; this entry will not be resent automatically.';
            } });
            const ids=new Set(batch.items.map(item=>item.contact_id));
            boxes.forEach(box=>setBoxChecked(box, ids.has(box.value)));
            Object.entries(batch.params).forEach(([key,value])=> {
                const input=Array.from(form.querySelectorAll('[data-param]')).find(input=>input.dataset.param===key); if(input) input.value=value;
            });
            setBoxChecked(consent, true); buildRows(); save(); preview();
            notify(batch.hash===template.hash?'Previous batch restored and paused. Review results, then resume remaining recipients.':
                'The approved template changed. This batch cannot be resumed. Review results before preparing a new batch.',batch.hash!==template.hash);
        }
    } catch(error) {
        storageOK=false; notify('Saved progress could not be read. Check previous chat messages before restarting a batch.',true);
    }
    render();
})();
</script>
@endif
@endsection
