@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.loadvendor.index') }}">Load Vendors</a> · {{ $v['company'] }} · Customers</div></div>
        @include('V2.loadvendor.partials.workspace-head')
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Contact Persons</h3>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2PersonModal"><i class="bi bi-plus-lg"></i>Add Contact Person</button>
            </div>
            <div class="cv2-card-b is-flush">
                <table class="cv2-table">
                    <thead><tr><th>Name</th><th>Designation</th><th>Phone</th><th>WhatsApp</th><th>Email</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        <tr><td><span class="cv2-t-name">{{ $v['name'] }}</span></td><td><span class="cv2-pill">Owner / Broker</span></td><td class="cv2-t-mono">{{ $v['phone'] }}</td><td class="cv2-t-mono">{{ $v['phone'] }}</td><td>{{ $v['email'] }}</td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2PersonModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Pranab Kalita</span></td><td><span class="cv2-pill">Operations Manager</span></td><td class="cv2-t-mono">+91 90853 44120</td><td class="cv2-t-mono">+91 90853 44120</td><td>pranab@brahmaputracarriers.in</td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2PersonModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Jyoti Bora</span></td><td><span class="cv2-pill">Accounts</span></td><td class="cv2-t-mono">+91 99540 77310</td><td class="cv2-t-mono">+91 99540 77310</td><td>accounts@brahmaputracarriers.in</td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2PersonModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                        <tr><td><span class="cv2-t-name">Hiren Saikia</span></td><td><span class="cv2-pill">Dispatch</span></td><td class="cv2-t-mono">+91 70028 19045</td><td class="cv2-t-mono">+91 70028 19045</td><td>dispatch@brahmaputracarriers.in</td>
                            <td class="cv2-actions"><a href="javascript:void(0)" class="cv2-ic-btn" data-bs-toggle="modal" data-bs-target="#cv2PersonModal"><i class="bi bi-pencil"></i></a><a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del"><i class="bi bi-trash3"></i></a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>

{{-- Add / Edit Contact Person modal --}}
<div class="modal fade cv2-modal" id="cv2PersonModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Contact Person</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2PersonModalForm" action="javascript:void(0)">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Name <span class="req">*</span></label><input type="text" name="contact_person_name"></div>
            <div class="cv2-field"><label class="cv2-label">Designation <span class="req">*</span></label><input type="text" name="contact_person_designation" placeholder="e.g. Broker / Manager"></div>
            <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="contact_person_phone" data-intl-phone="1"></div>
            <div class="cv2-field"><label class="cv2-label">WhatsApp</label><input type="tel" name="contact_person_whatsapp" data-intl-phone="1"></div>
            <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="contact_person_email"></div>
            <div class="cv2-field"><label class="cv2-label">Comment</label><input type="text" name="contact_person_comment" placeholder="Optional"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2PersonModalForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Contact Person</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>@endsection
