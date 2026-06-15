@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/customer.css?v=1.4') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.customer.index') }}">Customers</a> · {{ $c['name'] }} · Location</div></div>
        @include('V2.customer.partials.workspace-head')
        <div class="cv2-card cv2-mt"
             data-list-url="{{ route('contact.v2.customer.filter.locations', $c['id']) }}"
             id="cv2LocationsCard">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Loading &amp; Unloading Points</h3>
                <select class="cv2-select" id="cv2LocFilter"><option value="">All Types</option><option value="Loading">Loading</option><option value="Unloading">Unloading</option><option value="Both">Both</option></select>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" data-bs-toggle="modal" data-bs-target="#cv2LocationModal"><i class="bi bi-plus-lg"></i>Add Location</button>
            </div>
            <div class="cv2-card-b is-flush" id="cv2LocationsList">
                <div class="text-center cv2-empty" style="padding:24px;">Loading…</div>
            </div>
        </div>
    </div></div>
</div>

{{-- Add Location modal --}}
<div class="modal fade cv2-modal" id="cv2LocationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Location</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2LocationForm" action="{{ route('contact.v2.customer.location.save') }}" method="POST" data-list-url="{{ route('contact.v2.customer.filter.locations', $c['id']) }}">
          @csrf
          <input type="hidden" name="contact_id" value="{{ $c['id'] }}">
          <input type="hidden" name="onsite_contact_person_phone_code" class="cv2-onsite-phcode">
          <input type="hidden" name="onsite_contact_person_whatsapp_code" class="cv2-onsite-wacode">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Company Name <span class="req">*</span></label><input type="text" name="company_name"></div>
            <div class="cv2-field"><label class="cv2-label">Location Name <span class="req">*</span></label><input type="text" name="location_name"></div>
            <div class="cv2-field"><label class="cv2-label">Company Role <span class="req">*</span></label>
              <div class="cv2-radio-group">
                <span class="cv2-radio"><input type="radio" name="company_role" id="cr_cor" value="Consignor"><label for="cr_cor">Consignor</label></span>
                <span class="cv2-radio"><input type="radio" name="company_role" id="cr_cee" value="Consignee"><label for="cr_cee">Consignee</label></span>
              </div>
            </div>
            <div class="cv2-field"><label class="cv2-label">Route Type <span class="req">*</span></label>
              <div class="cv2-radio-group" id="cv2RouteType">
                <span class="cv2-radio"><input type="radio" name="route_type" id="rt_src" value="source"><label for="rt_src">Source</label></span>
                <span class="cv2-radio"><input type="radio" name="route_type" id="rt_dst" value="destination"><label for="rt_dst">Destination</label></span>
                <span class="cv2-radio"><input type="radio" name="route_type" id="rt_mid" value="midpoint"><label for="rt_mid">Midpoint</label></span>
              </div>
            </div>
            <div class="cv2-field cv2-cond" data-rt="source"><label class="cv2-label">Source City <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="source_city_id" style="width:100%;">
                <option value="">Choose source city</option>
                @foreach($routeSourceCities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="cv2-field cv2-cond" data-rt="destination"><label class="cv2-label">Destination City <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="destination_city_id" style="width:100%;">
                <option value="">Choose destination city</option>
                @foreach($routeDestCities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="cv2-field cv2-cond" data-rt="midpoint"><label class="cv2-label">Midpoint City <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="midpoint_city_id" style="width:100%;">
                <option value="">Choose midpoint</option>
                @foreach($routeMidpointCities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="cv2-field is-full"><label class="cv2-label">Address <span class="req">*</span></label><input type="text" name="address"></div>
            <div class="cv2-field"><label class="cv2-label">Postal Code <span class="req">*</span></label><input type="text" name="post_code" maxlength="6"></div>
            <div class="cv2-field"><label class="cv2-label">Location Type <span class="req">*</span></label>
              <div class="cv2-radio-group" id="cv2LocType">
                <span class="cv2-radio"><input type="radio" name="location_type" id="lt_load" value="Loading"><label for="lt_load">Loading</label></span>
                <span class="cv2-radio"><input type="radio" name="location_type" id="lt_unload" value="Unloading"><label for="lt_unload">Unloading</label></span>
                <span class="cv2-radio"><input type="radio" name="location_type" id="lt_both" value="Both"><label for="lt_both">Both</label></span>
              </div>
            </div>
            <div class="cv2-field cv2-cond" data-lt="Loading"><label class="cv2-label">Loading Charge</label>
              <div class="cv2-radio-group" style="margin-bottom:8px;">
                <span class="cv2-radio"><input type="radio" name="loading_charge_type" id="lc_fix" value="Fixed"><label for="lc_fix">Fixed</label></span>
                <span class="cv2-radio"><input type="radio" name="loading_charge_type" id="lc_var" value="Variable"><label for="lc_var">Variable</label></span>
              </div>
              <input type="text" name="loading_charge" placeholder="Loading charge (₹)">
            </div>
            <div class="cv2-field cv2-cond" data-lt="Unloading"><label class="cv2-label">Unloading Charge</label>
              <div class="cv2-radio-group" style="margin-bottom:8px;">
                <span class="cv2-radio"><input type="radio" name="unloading_charge_type" id="uc_fix" value="Fixed"><label for="uc_fix">Fixed</label></span>
                <span class="cv2-radio"><input type="radio" name="unloading_charge_type" id="uc_var" value="Variable"><label for="uc_var">Variable</label></span>
              </div>
              <input type="text" name="unloading_charge" placeholder="Unloading charge (₹)">
            </div>
            <div class="cv2-field"><label class="cv2-label">Charges Paid By</label>
              <div class="cv2-radio-group" id="cv2BroneBy">
                <span class="cv2-radio"><input type="radio" name="brone_by" id="bb_cust" value="customer"><label for="bb_cust">Customer</label></span>
                <span class="cv2-radio"><input type="radio" name="brone_by" id="bb_srl" value="srl"><label for="bb_srl">SRL</label></span>
                <span class="cv2-radio"><input type="radio" name="brone_by" id="bb_mix" value="mixed"><label for="bb_mix">Mixed</label></span>
              </div>
            </div>
            <div class="cv2-field cv2-cond" data-bb="mixed"><label class="cv2-label">Capping Amount <span class="req">*</span></label><input type="text" name="capping_amount" placeholder="Capping amount"></div>
            <div class="cv2-field"><label class="cv2-label">Onsite Contact Person</label><input type="text" name="onsite_contact_person"></div>
            <div class="cv2-field"><label class="cv2-label">Onsite Phone</label><input type="tel" name="onsite_contact_person_phone" data-intl-phone="1"></div>
            <div class="cv2-field"><label class="cv2-label">Onsite WhatsApp</label><input type="tel" name="onsite_contact_person_whatsapp" data-intl-phone="1"></div>
            <div class="cv2-field is-full"><label class="cv2-label">Map Location <span class="req">*</span></label><textarea name="map_location" rows="2"></textarea></div>
            <div class="cv2-field is-full"><label class="cv2-label">Additional Info</label><textarea name="additional_info" rows="2"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2LocationForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Location</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/customer.js?v=1.4') }}"></script>@endsection
