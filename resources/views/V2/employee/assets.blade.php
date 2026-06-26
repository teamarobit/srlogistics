@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=2.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Assets</div></div>
        @include('V2.employee.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Issued Assets</h3>
                @if($isExited)
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm is-locked" disabled><i class="bi bi-lock"></i>Locked (Exited)</button>
                @else
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2AssetModal"><i class="bi bi-plus-lg"></i>Issue Asset</button>
                @endif
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Asset</th><th>Type</th><th>Issued On</th><th>Status</th><th>Revoked On</th><th>Comments</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        @forelse($employeeAssets as $ea)
                        @php $assigned = $ea->status=='Assigned'; @endphp
                        <tr>
                            <td><span class="cv2-t-name">{{ $ea->asset?->name ?? '—' }}</span><div class="cv2-t-sub">{{ $ea->asset?->asset_no }}</div></td>
                            <td><span class="cv2-pill">{{ $ea->asset?->type ?? '—' }}</span></td>
                            <td>{{ $ea->created_at ? \Carbon\Carbon::parse($ea->created_at)->format('d M y') : '' }}</td>
                            <td><span class="cv2-badge {{ $assigned?'is-active':'is-inactive' }}"><span class="cv2-badge-dot"></span>{{ $ea->status }}</span></td>
                            <td>{{ $ea->revoke_date ? \Carbon\Carbon::parse($ea->revoke_date)->format('d M y') : '—' }}</td>
                            <td>{{ $ea->comment ?? '—' }}</td>
                            <td class="cv2-actions">
                                @if($isExited)
                                    <span class="cv2-hint">Locked</span>
                                @elseif($assigned)
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-revoke-asset" data-id="{{ $ea->id }}" data-bs-toggle="modal" data-bs-target="#cv2RevokeModal" title="Revoke"><i class="bi bi-arrow-counterclockwise"></i></a>
                                @else
                                    <span class="cv2-hint">Revoked</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center cv2-empty" style="padding:24px;">No assets issued yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

{{-- Issue Asset modal --}}
<div class="modal fade cv2-modal" id="cv2AssetModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Issue Asset</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2AssetForm" action="{{ route('contact.v2.employee.asset.save') }}">
          <input type="hidden" name="contact_id" value="{{ $contact->id }}">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Asset Type <span class="req">*</span></label><select class="cv2-select cv2-modal-select" id="cv2AssetType" name="asset_type" style="width:100%;"><option value="">Choose type…</option><option value="Motor Vehicle">Motor Vehicle</option><option value="Electronics">Electronics</option><option value="Others">Others</option></select></div>
            <div class="cv2-field is-full"><label class="cv2-label">Asset <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="asset_id" style="width:100%;"><option value="">Choose asset…</option>@foreach($assets as $a)<option value="{{ $a->id }}" data-type="{{ $a->type }}">{{ $a->name }} {{ $a->asset_no ? '('.$a->asset_no.')' : '' }}</option>@endforeach</select><span class="cv2-hint" id="cv2AssetHint"></span></div>
            <div class="cv2-field is-full"><label class="cv2-label">Comments</label><textarea name="comment" rows="2" placeholder="Condition / handover notes (optional)"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2AssetForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Issue</button>
      </div>
    </div>
  </div>
</div>

{{-- Revoke Asset modal --}}
<div class="modal fade cv2-modal" id="cv2RevokeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Revoke Asset</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2RevokeForm" action="{{ route('contact.v2.employee.asset.revoke') }}">
          <input type="hidden" name="employeeasset_id" id="cv2RevokeAssetId" value="">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Revoke Date <span class="req">*</span></label><input type="date" name="revoke_date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Revoke Reason <span class="req">*</span></label><textarea name="revoke_reason" rows="3"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2RevokeForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Revoke</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=2.2') }}"></script>@endsection
