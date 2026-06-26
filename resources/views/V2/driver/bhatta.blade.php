@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Driver Bhatta</div></div>
        @include('V2.driver.partials.workspace-head')

        <div class="cv2-card cv2-mt">
            <div class="cv2-card-h"><h3>Bhatta Ledger</h3></div>
            <div class="cv2-card-b">
                <div class="cv2-exit-banner" style="background:#fff7e6;border-color:#f0d9a8;color:#8a5a00;">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>The Driver Bhatta (trip-allowance) ledger has no backing table in the current schema, so it is not wired at Gate 2 (no-schema-change rule). A schema decision is required before entries can be recorded — see the Human-Attention flag dated 2026-06-15.</div>
                </div>
                <table class="cv2-table cv2-mt">
                    <thead><tr><th>Date</th><th>Reference</th><th>Particulars</th><th>Type</th><th style="text-align:right;">Amount</th></tr></thead>
                    <tbody>
                        @forelse($entries as $e)
                        <tr><td>{{ $e->entry_date ?? '—' }}</td><td>{{ $e->reference ?? '—' }}</td><td>{{ $e->particulars ?? '—' }}</td><td>{{ $e->entry_type ?? '—' }}</td><td class="cv2-t-mono" style="text-align:right;">₹{{ number_format((float)($e->amount ?? 0)) }}</td></tr>
                        @empty
                        <tr><td colspan="5" class="text-center cv2-empty" style="padding:24px;">No bhatta ledger available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=2.1') }}"></script>@endsection
