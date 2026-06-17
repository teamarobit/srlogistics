@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.sparevendor.index') }}">Spare Vendors</a> · {{ $v['company'] }} · Spare Parts</div></div>
        @include('V2.sparevendor.partials.workspace-head')

        <div class="cv2-card cv2-mt" style="border-left:3px solid var(--cv2-navy);">
            <div class="cv2-card-b" style="display:flex;align-items:center;gap:12px;">
                <i class="bi bi-info-circle" style="font-size:18px;color:var(--cv2-navy);"></i>
                <div><b>Derived from specialisation</b><div class="cv2-hint">These are catalogue parts in this vendor's specialisation categories ({{ count($v['spec']) ? implode(', ', $v['spec']) : 'none set' }}). Manage the global parts catalogue from the Spare Parts master.</div></div>
            </div>
        </div>

        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Supplied Spare Parts <span class="cv2-pill" style="font-weight:600;">{{ $parts->count() }}</span></h3>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Part</th><th>Category</th><th>Part No</th><th>Brand</th><th>Unit</th><th>Unit Price</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($parts as $part)
                            @php $st = ($part->status === 'Active') ? 'is-active' : 'is-inactive'; @endphp
                            <tr>
                                <td><span class="cv2-t-name">{{ $part->name }}</span>@if($part->notes)<div class="cv2-t-sub">{{ \Illuminate\Support\Str::limit($part->notes, 40) }}</div>@endif</td>
                                <td><span class="cv2-pill">{{ optional($part->partCategory)->name ?? '—' }}</span></td>
                                <td class="cv2-t-mono">{{ $part->part_no }}</td>
                                <td>{{ $part->compatible_makes ?? '—' }}</td>
                                <td>{{ $part->unit ?? '—' }}</td>
                                <td class="cv2-t-mono">₹{{ number_format((float) $part->standard_cost, 2) }}</td>
                                <td><span class="cv2-badge {{ $st }}"><span class="cv2-badge-dot"></span>{{ $part->status ?? '—' }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center cv2-empty">No catalogue parts match this vendor's specialisation.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/V2/customer.js?v=1.4') }}"></script>
<script src="{{ asset('js/V2/sparevendor.js?v=2.0') }}"></script>
@endsection
