@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.loadvendor.index') }}">Load Vendors</a> · {{ $v['company'] }} · Documents</div></div>
        @include('V2.loadvendor.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Uploaded Documents</h3></div>
                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead><tr><th>Document</th><th>Type</th><th>Size</th><th>Uploaded</th><th style="text-align:right;">Actions</th></tr></thead>
                        <tbody>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> gst-certificate.pdf</span></td><td>GST Certificate</td><td>402 KB</td><td>10 Apr 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-image" style="color:var(--cv2-navy);"></i> pan-card.jpg</span></td><td>PAN</td><td>176 KB</td><td>10 Apr 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> broker-agreement.pdf</span></td><td>Agreement</td><td>980 KB</td><td>28 Apr 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Document</h3></div>
                <div class="cv2-card-b">
                    <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Document Type</label><select class="cv2-select" style="width:100%;"><option value="">Select type…</option><option>GST Certificate</option><option>PAN</option><option>Agreement</option></select></div>
                    <div class="cv2-dropzone"><i class="bi bi-cloud-arrow-up"></i>Drop files here or click to upload</div>
                    <span class="cv2-hint" style="display:block;margin-top:8px;">JPG, PNG or PDF · max 2 MB · up to 2 files per type</span>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
