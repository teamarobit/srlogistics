@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">
@endsection

@section('content')
@php $contacts->appends(request()->query()); @endphp
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.insuranceprovider.dashboard') }}">Insurance Vendor Dashboard</a> · All Vendors</div>
                    <h1>Insurance Vendors</h1>
                    <div class="cv2-sub">{{ $stats['total'] }} vendors · {{ $stats['active'] }} active</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.insuranceprovider.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <button type="button" id="cv2IpAddBtn" class="cv2-btn cv2-btn-primary" data-bs-toggle="modal" data-bs-target="#cv2IpModal"><i class="bi bi-plus-lg"></i>Add Insurance Vendor</button>
                </div>
            </div>

            <div class="cv2-card">
                <form method="GET" action="{{ route('contact.v2.insuranceprovider.index') }}" class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" name="name" value="{{ $search_name }}" placeholder="Search by company or contact…"></div>
                    <select class="cv2-select" name="state" onchange="this.form.submit()">
                        <option value="">All States</option>
                        @foreach($states as $st)
                            <option value="{{ $st->id }}" @selected((string)$search_state === (string)$st->id)>{{ $st->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="cv2-btn cv2-btn-soft"><i class="bi bi-funnel"></i>Filter</button>
                    <a href="{{ route('contact.v2.insuranceprovider.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</a>
                </form>

                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead>
                            <tr>
                                <th style="width:34px;"><input type="checkbox"></th>
                                <th>Contact No</th><th>Company</th><th>Contact Person</th><th>Code</th>
                                <th>Phone</th><th>GST Number</th><th>State</th><th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $p)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="cv2-t-mono">{{ $p->contactno }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:11px;">
                                        @if($p->contact_image)
                                            <img src="{{ asset('media/contact/'.$p->contact_image) }}" alt="logo" class="cv2-avatar" style="width:34px;height:34px;border-radius:9px;object-fit:cover;">
                                        @else
                                            <span class="cv2-avatar" style="width:34px;height:34px;font-size:12px;border-radius:9px;">{{ strtoupper(mb_substr($p->company_name ?? '?',0,1)) }}</span>
                                        @endif
                                        <div><span class="cv2-t-name">{{ $p->company_name }}</span><div class="cv2-t-sub">{{ $p->email }}</div></div>
                                    </div>
                                </td>
                                <td>{{ $p->contact_name }}</td>
                                <td><span class="cv2-pill">{{ $p->contact_code }}</span></td>
                                <td class="cv2-t-mono">{{ trim(($p->ph_prefix ? $p->ph_prefix.' ' : '').$p->phone) }}</td>
                                <td class="cv2-t-mono">{{ $p->gst_number ?: '—' }}</td>
                                <td>{{ $p->state?->name ?? '—' }}</td>
                                <td>
                                    @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$p->status]??'is-inactive'; @endphp
                                    <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $p->status }}</span>
                                </td>
                                <td class="cv2-actions">
                                    <a href="javascript:void(0)" class="cv2-ic-btn cv2-ip-edit" title="Edit" data-id="{{ $p->id }}" data-url="{{ route('contact.v2.insuranceprovider.json', $p->id) }}"><i class="bi bi-pencil"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn cv2-ip-toggle" title="Toggle status" data-id="{{ $p->id }}" data-url="{{ route('contact.v2.insuranceprovider.toggle-status', $p->id) }}"><i class="bi bi-toggle-on"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-ip-del" title="Delete" data-id="{{ $p->id }}" data-url="{{ route('contact.v2.insuranceprovider.destroy', $p->id) }}"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" style="text-align:center;padding:28px;color:#94a3b8;">No insurance vendors found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($contacts->total() > 0)
                <div class="cv2-pager">
                    <span>Showing {{ $contacts->firstItem() }}–{{ $contacts->lastItem() }} of {{ $contacts->total() }}</span>
                    <div class="cv2-pages">
                        <a href="{{ $contacts->previousPageUrl() ?: 'javascript:void(0)' }}"><i class="bi bi-chevron-left"></i></a>
                        @for($i = 1; $i <= $contacts->lastPage(); $i++)
                            <a href="{{ $contacts->url($i) }}" class="{{ $i === $contacts->currentPage() ? 'is-active' : '' }}">{{ $i }}</a>
                        @endfor
                        <a href="{{ $contacts->nextPageUrl() ?: 'javascript:void(0)' }}"><i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- Add / Edit Insurance Vendor modal (E8: flat record, single modal for all CRUD) --}}
<div class="modal fade cv2-modal" id="cv2IpModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="cv2IpModalTitle">Add Insurance Vendor</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        {{-- Fields mirror the existing V1 Insurance Provider add/edit modal exactly --}}
        <form id="cv2IpForm" action="javascript:void(0)" enctype="multipart/form-data"
              data-save-url="{{ route('contact.v2.insuranceprovider.save') }}"
              data-update-url="{{ route('contact.v2.insuranceprovider.update', '__ID__') }}"
              data-media-base="{{ asset('media/contact') }}/">
          @csrf
          <input type="hidden" name="edit_id" id="cv2IpEditId" value="">
          <input type="hidden" name="phone_code" id="cv2IpPhoneCode" value="">
          <div class="cv2-form-grid">

            {{-- Company Logo (optional) --}}
            <div class="cv2-field is-full">
              <label class="cv2-label">Company Logo</label>
              <div class="cv2-dropzone" id="cv2IpDrop"><i class="bi bi-cloud-arrow-up"></i>Drop logo here or click to upload</div>
              <input type="file" name="contact_image" id="cv2IpFile" accept="image/jpeg,image/png,image/webp" hidden>
              <div id="cv2IpPreview" class="mt-2"></div>
              <span class="cv2-hint">JPG, PNG or WebP · max 2 MB</span>
              <span class="cv2-err text-danger small d-block mt-1"></span>
            </div>

            <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" name="company_name" maxlength="100" placeholder="e.g. New India Assurance"><span class="cv2-err text-danger small d-block mt-1"></span></div>
            <div class="cv2-field"><label class="cv2-label">Contact Person <span class="req">*</span></label><input type="text" name="contact_name" maxlength="100" placeholder="Representative name"><span class="cv2-err text-danger small d-block mt-1"></span></div>

            <div class="cv2-field"><label class="cv2-label">Contact Code <span class="req">*</span></label><input type="text" name="contact_code" maxlength="100" placeholder="e.g. INS-001"><span class="cv2-err text-danger small d-block mt-1"></span></div>
            <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="phone" id="cv2IpPhone" data-intl-phone="1" placeholder="9876543210"><span class="cv2-err text-danger small d-block mt-1"></span></div>

            <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="email" maxlength="100" placeholder="claims@company.in"><span class="cv2-err text-danger small d-block mt-1"></span></div>
            <div class="cv2-field"><label class="cv2-label">GST Number</label><input type="text" name="gst_number" maxlength="20" placeholder="18AAACN4165C1ZK"><span class="cv2-err text-danger small d-block mt-1"></span></div>

            <div class="cv2-field"><label class="cv2-label">State</label><select class="cv2-select cv2-modal-select" name="state_id" id="cv2IpState" style="width:100%;"><option value="">— Select State —</option>@foreach($states as $st)<option value="{{ $st->id }}">{{ $st->name }}</option>@endforeach</select><span class="cv2-err text-danger small d-block mt-1"></span></div>

            <div class="cv2-field is-full">
              <label class="cv2-label">Status</label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="status" id="cv2IpStAct" value="Active" checked><label for="cv2IpStAct">Active</label></span>
                <span class="cv2-radio"><input type="radio" name="status" id="cv2IpStIn" value="Inactive"><label for="cv2IpStIn">Inactive</label></span>
              </div>
              <span class="cv2-err text-danger small d-block mt-1"></span>
            </div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2IpForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Insurance Vendor</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/V2/insuranceprovider.js?v=1.0') }}"></script>
@endsection
