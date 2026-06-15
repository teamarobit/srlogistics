@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Assets</div></div>
        @include('V2.employee.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Issued Assets</h3>
                <select class="cv2-select"><option>All Types</option><option>Motor Vehicle</option><option>Electronics</option><option>Others</option></select>
                @if($isExited)
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm is-locked" disabled><i class="bi bi-lock"></i>Locked (Exited)</button>
                @else
                    <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2AssetModal"><i class="bi bi-plus-lg"></i>Issue Asset</button>
                @endif
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Asset</th><th>Type</th><th>Issued On</th><th>Status</th><th>Revoked On</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-t-name">DELL Latitude 5440</span><div class="cv2-t-sub">DELL-4471</div></td><td><span class="cv2-pill">Electronics</span></td><td>08 Jun 26</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Assigned</span></td><td>—</td>
                            <td class="cv2-actions">@if($isExited)<span class="cv2-hint">Locked</span>@else<a href="javascript:void(0)" class="cv2-ic-btn is-danger" data-bs-toggle="modal" data-bs-target="#cv2RevokeModal" title="Revoke"><i class="bi bi-arrow-counterclockwise"></i></a>@endif</td></tr>
                        <tr><td><span class="cv2-t-name">Honda Activa</span><div class="cv2-t-sub">AS01EF2231</div></td><td><span class="cv2-pill">Motor Vehicle</span></td><td>20 Mar 24</td><td><span class="cv2-badge is-active"><span class="cv2-badge-dot"></span>Assigned</span></td><td>—</td>
                            <td class="cv2-actions">@if($isExited)<span class="cv2-hint">Locked</span>@else<a href="javascript:void(0)" class="cv2-ic-btn is-danger" data-bs-toggle="modal" data-bs-target="#cv2RevokeModal" title="Revoke"><i class="bi bi-arrow-counterclockwise"></i></a>@endif</td></tr>
                        <tr><td><span class="cv2-t-name">ID Card &amp; Uniform Set</span><div class="cv2-t-sub">KIT-0088</div></td><td><span class="cv2-pill">Others</span></td><td>14 Feb 23</td><td><span class="cv2-badge is-inactive"><span class="cv2-badge-dot"></span>Unassigned</span></td><td>02 Jan 25</td>
                            <td class="cv2-actions"><span class="cv2-hint">Revoked</span></td></tr>
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
        <form id="cv2AssetForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Asset Type <span class="req">*</span></label><select class="cv2-select cv2-modal-select" id="cv2AssetType" name="asset_type" style="width:100%;"><option value="">Choose type…</option><option>Motor Vehicle</option><option>Electronics</option><option>Others</option></select></div>
            <div class="cv2-field is-full"><label class="cv2-label">Asset <span class="req">*</span></label><select class="cv2-select cv2-modal-select" name="asset_id" style="width:100%;"><option value="">Choose asset…</option><option>DELL Latitude 5440</option><option>Honda Activa</option><option>ID Card Kit</option></select><span class="cv2-hint" id="cv2AssetHint"></span></div>
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
        <form id="cv2RevokeForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field is-full"><label class="cv2-label">Revoke Date <span class="req">*</span></label><input type="date" name="revoke_date"></div>
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
@section('js')<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>@endsection
