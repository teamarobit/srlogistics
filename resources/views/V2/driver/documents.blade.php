@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Documents</div></div>
        @include('V2.driver.partials.workspace-head')
        <div class="cv2-grid cv2-grid-2-1 cv2-mt">
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Uploaded Documents</h3></div>
                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead><tr><th>Document</th><th>Type</th><th>Size</th><th>Uploaded</th><th style="text-align:right;">Actions</th></tr></thead>
                        <tbody>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-image" style="color:var(--cv2-navy);"></i> dl-front.jpg</span></td><td>Driving Licence</td><td>241 KB</td><td>{{ $d['doj'] }}</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-image" style="color:var(--cv2-navy);"></i> aadhaar.jpg</span></td><td>Aadhaar Card</td><td>198 KB</td><td>{{ $d['doj'] }}</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> signed-form.pdf</span></td><td>Signed Driver Form</td><td>512 KB</td><td>{{ $d['doj'] }}</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> police-verification.pdf</span></td><td>Police Verification</td><td>720 KB</td><td>05 Feb 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-image" style="color:var(--cv2-navy);"></i> photo.jpg</span></td><td>Photo</td><td>96 KB</td><td>05 Feb 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="cv2-pager"><span><i class="bi bi-info-circle"></i> Driving Licence &amp; Aadhaar are managed in Licence &amp; Identity, not here.</span></div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Document</h3></div>
                <div class="cv2-card-b">
                    <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Document Type</label><select class="cv2-select" style="width:100%;"><option value="">Select type…</option><option>Police Verification</option><option>Photo</option><option>Address Proof</option><option>Other</option></select></div>
                    <div class="cv2-dropzone"><i class="bi bi-cloud-arrow-up"></i>Drop files here or click to upload</div>
                    <span class="cv2-hint" style="display:block;margin-top:8px;">JPG, PNG or PDF · max 2 MB · up to 2 files per type</span>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=1.0') }}"></script>@endsection
