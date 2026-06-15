@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/driver.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
@php $lock = !empty($isExited) ? 'is-locked' : ''; @endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.driver.index') }}">Drivers</a> · {{ $d['name'] }} · Assets</div></div>
        @include('V2.driver.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Issued Assets</h3>
                @if(empty($isExited))
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2AssetModal"><i class="bi bi-plus-lg"></i>Issue Asset</button>
                @endif
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Asset</th><th>Issued On</th><th>Status</th><th>Remark</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        @forelse($employeeAssets as $a)
                        <tr>
                            <td><span class="cv2-t-name">{{ optional($a->asset)->name ?? '—' }}</span></td>
                            <td>{{ $a->created_at ? $a->created_at->format('d M y') : '—' }}</td>
                            <td>@if($a->status === 'Assigned')<span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Assigned</span>@else<span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>Unassigned</span>@endif</td>
                            <td>{{ $a->comment ?? '—' }}</td>
                            <td class="cv2-actions">
                                @if($a->status === 'Assigned' && empty($isExited))
                                <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-revoke-asset" data-id="{{ $a->id }}" title="Revoke"><i class="bi bi-arrow-counterclockwise"></i></a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center cv2-empty" style="padding:24px;">No assets issued yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

<div class="modal fade cv2-modal" id="cv2AssetModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Issue Asset</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2AssetForm" action="{{ route('contact.v2.driver.asset.save') }}" method="POST" data-revoke-url="{{ route('contact.v2.driver.asset.revoke') }}">
          @csrf
          <input type="hidden" name="contact_id" value="{{ $d['id'] }}">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Asset <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="asset_id" style="width:100%;"><option value="">Choose asset</option>@foreach($assets as $as)<option value="{{ $as->id }}">{{ $as->name }}</option>@endforeach</select></div>
            <div class="cv2-field"><label class="cv2-label">Issue Date</label><input type="date" name="issue_date"></div>
            <div class="cv2-field"><label class="cv2-label">Condition</label><input type="text" name="condition" placeholder="e.g. Good"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Remark</label><textarea name="remark" rows="2"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2AssetForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Asset</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/driver.js?v=2.0') }}"></script>@endsection
