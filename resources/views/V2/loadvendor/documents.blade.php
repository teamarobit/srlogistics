@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.loadvendor.index') }}">Load Vendors</a> · {{ $v['company'] }} · Documents</div></div>
        @include('V2.loadvendor.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Uploaded Documents</h3></div>
                <div class="cv2-card-b is-flush" id="cv2DocList">
                    <table class="cv2-table">
                        <thead><tr><th>Document</th><th>Type</th><th>Size</th><th>Uploaded</th><th style="text-align:right;">Actions</th></tr></thead>
                        <tbody>
                            @forelse($coattachments as $doc)
                                @php $ext = strtolower(pathinfo($doc->name, PATHINFO_EXTENSION)); @endphp
                                <tr>
                                    <td><span class="cv2-t-name">
                                        <i class="bi {{ $ext === 'pdf' ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image' }}" style="color:{{ $ext === 'pdf' ? 'var(--cv2-bad)' : 'var(--cv2-navy)' }};"></i>
                                        {{ $doc->original_name ?? $doc->name }}
                                    </span></td>
                                    <td>{{ optional($doc->coattachtype)->name ?? '—' }}</td>
                                    <td>{{ number_format(($doc->file_size ?? 0) * 1024, 0) }} KB</td>
                                    <td>{{ $doc->created_at ? $doc->created_at->format('d M y') : '—' }}</td>
                                    <td class="cv2-actions">
                                        <a href="{{ asset('media/contact/'.$doc->name) }}" target="_blank" class="cv2-ic-btn" title="Download"><i class="bi bi-download"></i></a>
                                        <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-doc" data-id="{{ $doc->id }}" title="Delete"><i class="bi bi-trash3"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center cv2-empty">No documents uploaded yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Document</h3></div>
                <div class="cv2-card-b">
                    <form id="cv2DocForm" action="{{ route('contact.v2.loadvendor.attachment.save') }}" method="POST" enctype="multipart/form-data" data-list-url="{{ route('contact.v2.loadvendor.documents', $v['id']) }}">
                        @csrf
                        <input type="hidden" name="contact_id" value="{{ $v['id'] }}">
                        <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Document Type <span class="req">*</span></label>
                            <select class="cv2-select" name="coattachtype_id" style="width:100%;">
                                <option value="">Select type…</option>
                                @foreach($coattachtypes as $ct)
                                    <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">File <span class="req">*</span></label>
                            <input type="file" name="attachment_file" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                        <span class="cv2-hint" style="display:block;margin-bottom:12px;">JPG, PNG or PDF · max 2 MB · up to 2 files per type</span>
                        <button type="submit" class="cv2-btn cv2-btn-primary" style="width:100%;justify-content:center;"><i class="bi bi-cloud-arrow-up"></i>Upload Document</button>
                    </form>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/loadvendor.js?v=1.3') }}"></script>@endsection
