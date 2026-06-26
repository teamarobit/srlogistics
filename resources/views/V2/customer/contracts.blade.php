@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · {{ $c['name'] }} · Contract</div></div>
        @include('V2.customer.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-card-h"><h3>Contracts</h3>
                <a href="{{ route('contact.v2.customer.contract.create', $c['id']) }}" class="cv2-btn cv2-btn-primary cv2-btn-sm"><i class="bi bi-plus-lg"></i>Add Contract</a></div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Contract No</th><th>Type</th><th>Routes</th><th>Advance</th><th>Payment Within</th><th>Validity</th><th>Status</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        @forelse($contracts as $contract)
                            @php
                                $today  = \Carbon\Carbon::today();
                                $status = 'Inactive';
                                if ($contract->contract_type_id == 6) { $status = 'Life Time'; }
                                elseif ($contract->start_date && $contract->end_date && $contract->start_date <= $today && $contract->end_date >= $today) { $status = 'Active'; }
                                $statusClass = ['Active'=>'is-active','Life Time'=>'is-active','Inactive'=>'is-inactive'][$status] ?? 'is-inactive';
                            @endphp
                            <tr>
                                <td class="cv2-t-mono">{{ $contract->contract_no ?? '—' }}</td>
                                <td><span class="cv2-pill">{{ optional($contract->contracttype)->name ?? '—' }}</span></td>
                                <td>{{ $contract->routes->count() }} route{{ $contract->routes->count() == 1 ? '' : 's' }}</td>
                                <td class="cv2-t-mono">₹{{ number_format($contract->advance_payment ?? 0, 0) }}</td>
                                <td>{{ $contract->payment_within_day ?? 0 }} days</td>
                                <td>
                                    @if($contract->contract_type_id == 6)
                                        No expiry
                                    @else
                                        {{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d M y') : '—' }} – {{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d M y') : '—' }}
                                    @endif
                                </td>
                                <td><span class="cv2-badge {{ $statusClass }}"><span class="cv2-badge-dot"></span>{{ $status }}</span></td>
                                <td class="cv2-actions">
                                    <a href="javascript:void(0)" class="cv2-ic-btn cv2-edit-contract" data-id="{{ $contract->id }}" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('contact.v2.customer.ratechart', $c['id']) }}" class="cv2-ic-btn" title="Rate chart"><i class="bi bi-cash-stack"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-contract" data-id="{{ $contract->id }}" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center cv2-empty">No contracts added yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.8') }}"></script>@endsection
