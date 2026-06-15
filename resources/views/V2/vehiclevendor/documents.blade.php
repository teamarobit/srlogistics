@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/vehiclevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.vehiclevendor.index') }}">Vehicle Vendors</a> · {{ $v['company'] }} · Documents</div></div>
        @include('V2.vehiclevendor.partials.workspace-head')

        {{-- E6: TDS Declaration required when tds_percentage is 0 or 1 --}}
        @if($v['tds'] === 0 || $v['tds'] === 1)
        <div class="cv2-note is-warn cv2-mt">
            <i class="bi bi-exclamation-triangle"></i>
            <div>TDS percentage is <b>{{ $v['tds'] }}</b> — a <b>TDS Declaration</b> (document type 7) is <b>mandatory</b> for this vendor. Upload it below if not already present.</div>
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
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> tds-declaration.pdf</span> @if($v['tds']===0||$v['tds']===1)<span class="cv2-bank-badge" style="margin-left:6px;">Required</span>@endif</td><td>TDS Declaration</td><td>96 KB</td><td>14 Apr 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                            <tr><td><span class="cv2-t-name"><i class="bi bi-file-earmark-pdf" style="color:var(--cv2-bad);"></i> transport-agreement.pdf</span></td><td>Agreement</td><td>1.1 MB</td><td>02 May 26</td><td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn"><i class="bi bi-download"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="cv2-card">
                <div class="cv2-card-h"><h3>Add Document</h3></div>
                <div class="cv2-card-b">
                    <div class="cv2-field" style="margin-bottom:12px;"><label class="cv2-label">Document Type</label><select class="cv2-select" style="width:100%;"><option value="">Select type…</option><option>GST Certificate</option><option>PAN</option><option>TDS Declaration</option><option>Agreement</option></select></div>
                    <div class="cv2-dropzone"><i class="bi bi-cloud-arrow-up"></i>Drop files here or click to upload</div>
                    <span class="cv2-hint" style="display:block;margin-top:8px;">JPG, PNG or PDF · max 2 MB · up to 2 files per type</span>
                </div>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/vehiclevendor.js?v=1.0') }}"></script>@endsection
