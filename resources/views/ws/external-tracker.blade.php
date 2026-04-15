@extends('layouts.app')

@section('css')
<link href="{{ asset('css/Workshop/external-tracker.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper srlog-bdwrapper">
        <div class="main-wrap sc-no-sidebar">

            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb sc-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ws.dashboard') }}">Workshop</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ws.external.dispatch') }}">External Dispatch</a></li>
                    <li class="breadcrumb-item active">Tracker</li>
                </ol>
            </nav>

            <div class="sc-page-head d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="mb-0">External Workshop Tracker</h5>
                    <span class="text-muted" style="font-size:12px;">Live status of all vehicles at external workshops &amp; ASCs</span>
                </div>
                <a href="{{ route('ws.external.dispatch') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="uil uil-list-ul me-1"></i> List View
                </a>
            </div>

            {{-- Kanban --}}
            @php
            $lanes = [
                ['label'=>'Dispatched','count'=>2,'class'=>'sc-dsp-dispatched','vehicles'=>[
                    ['EXT-2026-0008','KA-05-AB-1234','Tata Motors ASC','4d','Brand ASC'],
                    ['EXT-2026-0009','TN05-IJ-7890','Eicher ASC','1d','Brand ASC'],
                ]],
                ['label'=>'Under Diagnosis','count'=>1,'class'=>'sc-dsp-diagnosing','vehicles'=>[
                    ['EXT-2026-0007','MH-12-XY-9876','AL Auth SC, Pune','6d','Brand ASC'],
                ]],
                ['label'=>'Repair Started','count'=>2,'class'=>'sc-dsp-repairing','vehicles'=>[
                    ['EXT-2026-0006','DL-01-CD-4567','Benz ASC, Delhi','8d','Warranty'],
                    ['EXT-2026-0005','GJ-03-ZZ-7890','Ram Auto Works','10d','Third Party'],
                ]],
                ['label'=>'Ready to Collect','count'=>2,'class'=>'sc-dsp-ready','vehicles'=>[
                    ['EXT-2026-0004','RJ-14-GA-1111','Eicher ASC, Jaipur','14d','Brand ASC'],
                    ['EXT-2026-0010','KL-09-PQ-5566','Volvo ASC','12d','Warranty'],
                ]],
                ['label'=>'Returned','count'=>3,'class'=>'sc-dsp-returned','vehicles'=>[
                    ['EXT-2026-0003','UP-32-BT-5544','Volvo ASC, Noida','17d','Warranty'],
                    ['EXT-2026-0002','HR-26-YZ-8877','AL Auth SC','22d','Brand ASC'],
                    ['EXT-2026-0001','PB-10-CD-3344','Third Party WS','30d','Third Party'],
                ]],
            ];
            @endphp

            <div class="sc-ext-kanban mb-3">
                @foreach($lanes as $lane)
                <div class="sc-ext-lane">
                    <div class="sc-ext-lane-head">
                        <span>{{ $lane['label'] }}</span>
                        <span class="badge" style="background:#032671;color:#fff;font-size:10px;">{{ $lane['count'] }}</span>
                    </div>
                    @foreach($lane['vehicles'] as $v)
                    <div class="sc-ext-card">
                        <div class="sc-ext-card-reg">{{ $v[1] }}</div>
                        <div class="sc-ext-card-sc">{{ $v[2] }}</div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="{{ $lane['class'] }}" style="font-size:10px;padding:1px 6px;">{{ $lane['label'] }}</span>
                            <span class="sc-ext-card-days {{ intval($v[3]) > 10 ? 'sc-tat-overdue' : (intval($v[3]) > 6 ? 'sc-tat-warning' : 'sc-tat-ok') }}">{{ $v[3] }}</span>
                        </div>
                        <div class="mt-2 d-flex gap-1">
                            <button class="btn btn-outline-secondary btn-sm flex-grow-1" style="font-size:10px;padding:2px 6px;" data-bs-toggle="modal" data-bs-target="#updateStatusModal">Update</button>
                            @if($lane['label']==='Ready to Collect')
                            <a href="{{ route('ws.external.return') }}" class="btn btn-sm flex-grow-1" style="font-size:10px;padding:2px 6px;background:#10863f;color:#fff;">Collect</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

{{-- Update Status Modal --}}
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="uil uil-sync me-2"></i>Update External Job Status</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="sc-form-label">New Status <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm">
                            <option>Dispatched</option>
                            <option>Under Diagnosis</option>
                            <option>Repair Started</option>
                            <option>Ready to Collect</option>
                            <option>Returned</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="sc-form-label">Update Note</label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Latest update from external SC..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Revised Est. Return</label>
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="sc-form-label">Revised Cost Estimate (₹)</label>
                        <input type="number" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn sc-btn-navy btn-sm">Save Update</button>
            </div>
        </div>
    </div>
</div>
@endsection
