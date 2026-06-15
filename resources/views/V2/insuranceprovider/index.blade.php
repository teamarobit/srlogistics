@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/customer.css?v=1.3') }}" rel="stylesheet">
@endsection

@section('content')
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
                    <button type="button" class="cv2-btn cv2-btn-primary" data-bs-toggle="modal" data-bs-target="#cv2IpModal"><i class="bi bi-plus-lg"></i>Add Insurance Vendor</button>
                </div>
            </div>

            <div class="cv2-card">
                <div class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" placeholder="Search by company, contact or code…"></div>
                    <select class="cv2-select"><option>All Cities</option><option>Guwahati</option><option>Dibrugarh</option><option>Jorhat</option><option>Silchar</option><option>Tinsukia</option><option>Nagaon</option></select>
                    <select class="cv2-select"><option>All Status</option><option>Active</option><option>Inactive</option><option>Blacklisted</option></select>
                    <button class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                </div>

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
                            @foreach($providers as $p)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="cv2-t-mono">{{ $p['contactno'] }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:11px;">
                                        <span class="cv2-avatar" style="width:34px;height:34px;font-size:12px;border-radius:9px;">{{ strtoupper(mb_substr($p['company'],0,1)) }}</span>
                                        <div><span class="cv2-t-name">{{ $p['company'] }}</span><div class="cv2-t-sub">{{ $p['email'] }}</div></div>
                                    </div>
                                </td>
                                <td>{{ $p['contact_name'] }}</td>
                                <td><span class="cv2-pill">{{ $p['code'] }}</span></td>
                                <td class="cv2-t-mono">{{ $p['phone'] }}</td>
                                <td class="cv2-t-mono">{{ $p['gst'] }}</td>
                                <td>{{ $p['state'] }}</td>
                                <td>
                                    @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$p['status']]??'is-inactive'; @endphp
                                    <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $p['status'] }}</span>
                                </td>
                                <td class="cv2-actions">
                                    <a href="javascript:void(0)" class="cv2-ic-btn" title="Edit" data-bs-toggle="modal" data-bs-target="#cv2IpModal"><i class="bi bi-pencil"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn" title="Toggle status"><i class="bi bi-toggle-on"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>Showing 1–6 of {{ $stats['total'] }}</span>
                    <div class="cv2-pages">
                        <a href="javascript:void(0)"><i class="bi bi-chevron-left"></i></a>
                        <a href="javascript:void(0)" class="is-active">1</a>
                        <a href="javascript:void(0)">2</a>
                        <a href="javascript:void(0)">3</a>
                        <a href="javascript:void(0)"><i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Add / Edit Insurance Vendor modal (E8: flat record, single modal for all CRUD) --}}
<div class="modal fade cv2-modal" id="cv2IpModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Insurance Vendor</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        {{-- Fields mirror the existing V1 Insurance Provider add/edit modal exactly --}}
        {{-- (contacts/insuranceprovider/index.blade.php): logo, company_name (free text), --}}
        {{-- contact_name, contact_code, phone, email, gst_number (max 20), state_id, status (Active/Inactive). --}}
        <form id="cv2IpForm" action="javascript:void(0)" enctype="multipart/form-data">
          <div class="cv2-form-grid">

            {{-- Company Logo (optional) --}}
            <div class="cv2-field is-full">
              <label class="cv2-label">Company Logo</label>
              <div class="cv2-dropzone" id="cv2IpDrop"><i class="bi bi-cloud-arrow-up"></i>Drop logo here or click to upload</div>
              <span class="cv2-hint">JPG, PNG or WebP · max 2 MB</span>
            </div>

            <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" name="company_name" maxlength="100" placeholder="e.g. New India Assurance"><span class="cv2-err text-danger small d-block mt-1"></span></div>
            <div class="cv2-field"><label class="cv2-label">Contact Person <span class="req">*</span></label><input type="text" name="contact_name" maxlength="100" placeholder="Representative name"><span class="cv2-err text-danger small d-block mt-1"></span></div>

            <div class="cv2-field"><label class="cv2-label">Contact Code <span class="req">*</span></label><input type="text" name="contact_code" maxlength="100" placeholder="e.g. INS-001"><span class="cv2-err text-danger small d-block mt-1"></span></div>
            <div class="cv2-field"><label class="cv2-label">Phone <span class="req">*</span></label><input type="tel" name="phone" data-intl-phone="1" placeholder="9876543210"><span class="cv2-err text-danger small d-block mt-1"></span></div>

            <div class="cv2-field"><label class="cv2-label">Email</label><input type="email" name="email" maxlength="100" placeholder="claims@company.in"></div>
            <div class="cv2-field"><label class="cv2-label">GST Number</label><input type="text" name="gst_number" maxlength="20" placeholder="18AAACN4165C1ZK"></div>

            <div class="cv2-field"><label class="cv2-label">State</label><select class="cv2-select cv2-modal-select" name="state_id" style="width:100%;"><option value="">— Select State —</option><option>Assam</option><option>West Bengal</option><option>Meghalaya</option></select></div>

            <div class="cv2-field is-full">
              <label class="cv2-label">Status</label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="status" id="cv2IpStAct" value="Active" checked><label for="cv2IpStAct">Active</label></span>
                <span class="cv2-radio"><input type="radio" name="status" id="cv2IpStIn" value="Inactive"><label for="cv2IpStIn">Inactive</label></span>
              </div>
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
<script src="{{ asset('js/V2/customer.js?v=1.3') }}"></script>
@endsection

