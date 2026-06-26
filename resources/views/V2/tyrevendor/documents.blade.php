@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/tyrevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
@php $tdsDue = in_array((float)$v['tds'], [0.0, 1.0], true); @endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.tyrevendor.index') }}">Tyre Vendors</a> · {{ $v['company'] }} · Documents</div></div>
        @include('V2.tyrevendor.partials.workspace-head')

        {{-- E6: TDS Declaration mandatory when tds_percentage is 0 or 1 --}}
        @php $hasTds = $coattachments->where('coattachtype_id', 7)->count() > 0; @endphp
        @if($tdsDue)
        <div class="cv2-card cv2-mt" style="border-left:4px solid var(--cv2-warn);">
            <div class="cv2-card-b" style="display:flex;align-items:center;gap:12px;">
                <i class="bi bi-exclamation-triangle" style="font-size:22px;color:var(--cv2-warn);"></i>
                <div><b style="font-size:14px;">TDS Declaration {{ $hasTds ? 'on file' : 'required' }}</b>
                    <div class="cv2-hint">TDS % is {{ rtrim(rtrim(number_format($v['tds'],2),'0'),'.') }} — a signed TDS Declaration (document type 7) must be on file for this vendor.</div></div>
                <span class="cv2-badge {{ $hasTds ? 'is-active' : 'is-warn' }}" style="margin-left:auto;"><span class="cv2-badge-dot"></span>{{ $hasTds ? 'Present' : 'Pending' }}</span>
            </div>
        </div>
        @endif

        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Uploaded Documents</h3></div>
                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead><tr><th>Document</th><th>Type</th><th>Size</th><th>Uploaded</th><th style="text-align:right;">Actions</th></tr></thead>
                        <tbody>
                            @forelse($coattachments as $doc)
                            <tr>
                                <td><span class="cv2-t-name"><i class="bi bi-file-earmark-text"></i> {{ $doc->original_name }}</span></td>
                                <td>{{ optional($doc->coattachtype)->name ?? '—' }}</td>
                                <td>{{ number_format((float)$doc->file_size, 2) }} MB</td>
                                <td>{{ \Carbon\Carbon::parse($doc->created_at)->format('d M y') }}</td>
                                <td class="cv2-actions">
                                    <a href="{{ asset('media/contact/'.$doc->name) }}" target="_blank" class="cv2-ic-btn" title="Download"><i class="bi bi-download"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-doc" title="Delete" data-id="{{ $doc->id }}" data-url="{{ route('contact.v2.tyrevendor.attachment.delete') }}"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5"><div class="cv2-empty"><i class="bi bi-paperclip"></i><h4>No documents yet</h4><p>Upload GST, PAN, TDS or agreements.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Document</h3></div>
                <div class="cv2-card-b">
                    <form id="cv2DocForm" action="{{ route('contact.v2.tyrevendor.attachment.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="contact_id" value="{{ $v['id'] }}">
                        <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Document Type <span class="req">*</span></label>
                            <select class="cv2-select" name="coattachtype_id" style="width:100%;">
                                <option value="">Select type…</option>
                                @foreach($coattachtypes as $ct)<option value="{{ $ct->id }}" {{ ($tdsDue && $ct->id == 7) ? 'selected' : '' }}>{{ $ct->name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">File <span class="req">*</span></label>
                            <input type="file" name="attachment_file" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                        <span class="cv2-hint" style="display:block;margin-bottom:10px;">JPG, PNG or PDF · max 2 MB · up to 2 files per type</span>
                        @if($tdsDue)<span class="cv2-help" style="display:block;margin-bottom:10px;">TDS Declaration is mandatory for this vendor.</span>@endif
                        <button type="submit" class="cv2-btn cv2-btn-primary" style="width:100%;justify-content:center;"><i class="bi bi-cloud-arrow-up"></i>Upload Document</button>
                    </form>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/tyrevendor.js?v=2.1') }}"></script>@endsection
