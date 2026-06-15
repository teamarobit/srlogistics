@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.sparevendor.index') }}">Spare Vendors</a> · {{ $v['company'] }} · Documents</div></div>
        @include('V2.sparevendor.partials.workspace-head')

        {{-- E6 — TDS Declaration rule banner --}}
        @if($v['tds'] <= 1)
        <div class="cv2-card cv2-mt" style="border-left:3px solid var(--cv2-warn);">
            <div class="cv2-card-b" style="display:flex;align-items:center;gap:12px;">
                <i class="bi bi-exclamation-triangle" style="font-size:20px;color:var(--cv2-warn);"></i>
                <div><b>TDS Declaration required</b><div class="cv2-hint">This vendor's TDS is {{ $v['tds'] }}% (0% or 1%) — a TDS Declaration document must be on file.</div></div>
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
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> gst-certificate.pdf</span></td><td>GST Certificate</td><td>412 KB</td><td>12 Apr 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-image" style="color:var(--cv2-navy);"></i> pan-card.jpg</span></td><td>PAN</td><td>188 KB</td><td>12 Apr 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> tds-declaration.pdf</span> <span class="cv2-badge is-warn"><span class="cv2-badge-dot"></span>TDS</span></td><td>TDS Declaration</td><td>96 KB</td><td>20 Apr 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> dealership-agreement.pdf</span></td><td>Agreement</td><td>1.0 MB</td><td>02 May 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Document</h3></div>
                <div class="cv2-card-b">
                    <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Document Type</label><select class="cv2-select" style="width:100%;"><option value="">Select type…</option><option>GST Certificate</option><option>PAN</option><option>TDS Declaration</option><option>Agreement</option></select></div>
                    <div class="cv2-dropzone"><i class="bi bi-cloud-arrow-up"></i>Drop files here or click to upload</div>
                    <span class="cv2-hint" style="display:block;margin-top:8px;">JPG, PNG or PDF · max 2 MB · up to 2 files per type.</span>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>
<script src="{{ asset('js/V2/sparevendor.js?v=1.0') }}"></script>
@endsection
