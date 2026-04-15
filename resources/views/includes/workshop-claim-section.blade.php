{{--
    Reusable workshop-type + workshop-select section for claim modals.

    Variables:
      $prefix    — ID/name prefix to avoid clashes across pages (e.g. 'vd', 'sc')
      $workshops — Collection of Workshop models (passed from controller)

    Output elements:
      radio    name="{prefix}WorkshopType"  value="Own|External"
      select   id="{prefix}WorkshopSelect"  name="workshop_id"
      readonly inputs: {prefix}ScContactPerson, {prefix}ScPhone, {prefix}ScCity
      hidden ref field: {prefix}CashlessScClaimRef
--}}
@php $p = $prefix ?? 'vd'; @endphp

{{-- Workshop type radios --}}
<div class="col-12">
    <label class="form-label" style="font-size:12px;font-weight:600;">Workshop Type <span class="text-danger">*</span></label>
    <div class="d-flex gap-3 mt-1">
        <div class="form-check">
            <input class="form-check-input" type="radio"
                   name="{{ $p }}WorkshopType" id="{{ $p }}WsOwn" value="Own" checked
                   onchange="vdFilterWorkshop{{ $p }}('Own')">
            <label class="form-check-label" for="{{ $p }}WsOwn" style="font-size:13px;font-weight:600;">
                Own Workshop
                <span style="font-size:11px;color:#888;font-weight:400;display:block;">Vehicle sent to your company's workshop</span>
            </label>
        </div>
        <div class="form-check ms-4">
            <input class="form-check-input" type="radio"
                   name="{{ $p }}WorkshopType" id="{{ $p }}WsExternal" value="External"
                   onchange="vdFilterWorkshop{{ $p }}('External')">
            <label class="form-check-label" for="{{ $p }}WsExternal" style="font-size:13px;font-weight:600;">
                External Workshop / ASC
                <span style="font-size:11px;color:#888;font-weight:400;display:block;">Sent to empanelled 3rd party or brand ASC</span>
            </label>
        </div>
    </div>
</div>

{{-- Workshop select --}}
<div class="col-12">
    <div style="background:#f8f9fc;border-radius:6px;padding:14px 14px 10px;border:1px solid #e4e7ef;">
        <div style="font-size:11px;font-weight:700;color:#032671;text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;">
            <i class="uil uil-store me-1"></i>Select Workshop
        </div>
        <div class="row g-2">
            <div class="col-12">
                <label class="form-label" style="font-size:12px;font-weight:600;">Workshop <span class="text-danger">*</span></label>
                <select id="{{ $p }}WorkshopSelect" name="workshop_id"
                        class="form-select form-select-sm" style="width:100%;">
                    <option value="">Search by name or city…</option>
                    @if(isset($workshops))
                        @php
                            $ownWs      = $workshops->where('ownership','Own');
                            $externalWs = $workshops->where('ownership','External');
                        @endphp
                        @if($ownWs->count())
                        <optgroup label="Own Workshops" class="{{ $p }}-own-opts">
                            @foreach($ownWs as $ws)
                            <option value="{{ $ws->id }}"
                                data-contact="{{ $ws->manager_name }}"
                                data-phone="{{ $ws->contact_phone }}"
                                data-city="{{ $ws->city }}{{ $ws->state ? ', '.$ws->state : '' }}"
                                data-ownership="Own">
                                {{ $ws->name }}{{ $ws->city ? ' — '.$ws->city : '' }}
                            </option>
                            @endforeach
                        </optgroup>
                        @endif
                        @if($externalWs->count())
                        <optgroup label="External Workshops / ASCs" class="{{ $p }}-ext-opts">
                            @foreach($externalWs as $ws)
                            <option value="{{ $ws->id }}"
                                data-contact="{{ $ws->manager_name }}"
                                data-phone="{{ $ws->contact_phone }}"
                                data-city="{{ $ws->city }}{{ $ws->state ? ', '.$ws->state : '' }}"
                                data-ownership="External">
                                {{ $ws->name }}{{ $ws->city ? ' — '.$ws->city : '' }}
                            </option>
                            @endforeach
                        </optgroup>
                        @endif
                    @endif
                </select>
                <small class="text-muted" style="font-size:11px;">
                    Not listed? <a href="{{ route('ws.master.workshops') }}" target="_blank" style="color:#032671;">Add to Workshop Master</a>
                </small>
            </div>

            {{-- Auto-fill display --}}
            <div class="col-md-4" id="{{ $p }}ScContactWrap" style="display:none;">
                <label class="form-label" style="font-size:12px;">Contact Person</label>
                <input type="text" id="{{ $p }}ScContactPerson" class="form-control form-control-sm" readonly style="background:#fff;">
            </div>
            <div class="col-md-4" id="{{ $p }}ScPhoneWrap" style="display:none;">
                <label class="form-label" style="font-size:12px;">Phone</label>
                <input type="text" id="{{ $p }}ScPhone" class="form-control form-control-sm" readonly style="background:#fff;">
            </div>
            <div class="col-md-4" id="{{ $p }}ScCityWrap" style="display:none;">
                <label class="form-label" style="font-size:12px;">City</label>
                <input type="text" id="{{ $p }}ScCity" class="form-control form-control-sm" readonly style="background:#fff;">
            </div>

            {{-- Cashless claim ref (External + Cashless only) --}}
            <div id="{{ $p }}CashlessScClaimRef" class="col-12" style="display:none;">
                <label class="form-label" style="font-size:12px;">Insurer Claim Ref (raised by workshop)</label>
                <input type="text" class="form-control form-control-sm" name="extScClaimRef"
                       placeholder="Claim ref from workshop / insurer">
            </div>
        </div>
    </div>
</div>
