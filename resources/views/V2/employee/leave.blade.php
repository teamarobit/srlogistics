@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=2.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Leave Tracker</div></div>
        @include('V2.employee.partials.workspace-head')

        <div class="cv2-card cv2-mt">
            <div class="cv2-card-b" style="display:flex;align-items:center;gap:12px;">
                <i class="bi bi-info-circle" style="font-size:20px;color:var(--cv2-navy);"></i>
                <div>
                    <b>Leave Tracker has no backend source at Gate 2 (read-only)</b>
                    <div class="cv2-hint">Leave balances and history will be wired once the leave-management module is built. No leave records can be added here yet.</div>
                </div>
            </div>
        </div>

        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Leave History</h3>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Reason</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($leaves as $lv)
                        <tr><td><span class="cv2-pill">{{ $lv->type ?? '—' }}</span></td><td>{{ $lv->from ?? '' }}</td><td>{{ $lv->to ?? '' }}</td><td class="cv2-t-mono">{{ $lv->days ?? '' }}</td><td>{{ $lv->reason ?? '' }}</td><td>{{ $lv->status ?? '' }}</td></tr>
                        @empty
                        <tr><td colspan="6" class="text-center cv2-empty" style="padding:24px;">No leave records available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=2.0') }}"></script>@endsection
