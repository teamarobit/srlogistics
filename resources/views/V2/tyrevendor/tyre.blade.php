@extends('layouts.app')
@section('css')<link href="{{ asset('css/V2/tyrevendor.css?v=1.0') }}" rel="stylesheet">@endsection
@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap"><div class="cv2-container">
        <div class="cv2-phead"><div class="cv2-crumb"><a href="{{ route('contact.v2.tyrevendor.index') }}">Tyre Vendors</a> · {{ $v['company'] }} · Tyre</div></div>
        @include('V2.tyrevendor.partials.workspace-head')

        {{-- E4: supplied-items sub-page (Tyre). E7 = no vendor `size` field --}}
        <div class="cv2-card cv2-mt">
            <div class="cv2-filters" style="border-bottom:1px solid var(--cv2-line);">
                <h3 style="font-size:15px;font-weight:700;margin:0;flex:1;">Supplied Tyres</h3>
                <button class="cv2-btn cv2-btn-primary cv2-btn-sm" id="cv2AddTyreBtn" data-bs-toggle="modal" data-bs-target="#cv2TyreModal"><i class="bi bi-plus-lg"></i>Add Tyre</button>
            </div>
            <div class="cv2-card-b is-flush">
                @if($tyres->total() > 0)
                <table class="cv2-table">
                    <thead><tr><th>Serial No</th><th>Brand</th><th>Model</th><th>Size</th><th>Condition</th><th>Purchase Date</th><th>Price</th><th style="text-align:right;">Actions</th></tr></thead>
                    <tbody>
                        @foreach($tyres as $t)
                        @php
                            $tdata = [
                                'id' => $t->id,
                                'tyre_serial_number' => $t->tyre_serial_number,
                                'tyre_brand' => $t->tyre_brand,
                                'tyre_model' => $t->tyre_model,
                                'tyre_size' => $t->tyre_size,
                                'tyre_condition' => $t->tyre_condition,
                                'tyre_purchase_date' => $t->tyre_purchase_date ? \Carbon\Carbon::parse($t->tyre_purchase_date)->format('Y-m-d') : '',
                                'tyre_price' => $t->tyre_price,
                            ];
                            $cc = ['New'=>'is-active','Re-thread'=>'is-warn','Discard'=>'is-inactive'][$t->tyre_condition] ?? 'is-inactive';
                        @endphp
                        <tr>
                            <td class="cv2-t-mono">{{ $t->tyre_serial_number ?: '-' }}</td>
                            <td><span class="cv2-t-name">{{ $t->tyre_brand ?: '-' }}</span></td>
                            <td>{{ $t->tyre_model }}</td>
                            <td>{{ $t->tyre_size ?: '-' }}</td>
                            <td><span class="cv2-badge {{ $cc }}"><span class="cv2-badge-dot"></span>{{ $t->tyre_condition }}</span></td>
                            <td>{{ $t->tyre_purchase_date ? \Carbon\Carbon::parse($t->tyre_purchase_date)->format('d M y') : '-' }}</td>
                            <td class="cv2-t-mono">{!! '&#8377;' !!}{{ number_format((float)$t->tyre_price) }}</td>
                            <td class="cv2-actions">
                                <a href="javascript:void(0)" class="cv2-ic-btn cv2-edit-tyre" data-bs-toggle="modal" data-bs-target="#cv2TyreModal" data-tyre='@json($tdata)'><i class="bi bi-pencil"></i></a>
                                <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del-tyre" data-id="{{ $t->id }}" data-url="{{ route('contact.v2.tyrevendor.tyre.delete') }}"><i class="bi bi-trash3"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="cv2-empty"><i class="bi bi-record-circle"></i><h4>No tyres supplied yet</h4><p>Tyres received from this vendor will appear here.</p></div>
                @endif
            </div>
            @if($tyres->total() > 0)
            <div class="cv2-pager">
                <span>Showing {{ $tyres->firstItem() }}-{{ $tyres->lastItem() }} of {{ $tyres->total() }}</span>
                <div class="cv2-pages">{{ $tyres->links() }}</div>
            </div>
            @endif
        </div>
    </div></div>
</div>

{{-- Add / Edit Tyre modal (E4) --}}
<div class="modal fade cv2-modal" id="cv2TyreModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="cv2TyreModalTitle">Add Tyre</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="cv2TyreForm" action="{{ route('contact.v2.tyrevendor.tyre.save') }}" method="POST"
              data-save-url="{{ route('contact.v2.tyrevendor.tyre.save') }}"
              data-update-url="{{ route('contact.v2.tyrevendor.tyre.update', ['tyreId' => '__ID__']) }}">
          @csrf
          <input type="hidden" name="contact_id" value="{{ $v['id'] }}">
          <div class="cv2-form-grid">
            <div class="cv2-field"><label class="cv2-label">Serial No</label><input type="text" name="tyre_serial_number" placeholder="TYR-XXXX-0000"></div>
            <div class="cv2-field"><label class="cv2-label">Brand</label><input type="text" name="tyre_brand" placeholder="e.g. MRF"></div>
            <div class="cv2-field"><label class="cv2-label">Model <span class="req">*</span></label><input type="text" name="tyre_model" placeholder="e.g. Steel Muscle S1J4"></div>
            <div class="cv2-field"><label class="cv2-label">Size</label><input type="text" name="tyre_size" placeholder="e.g. 1000-20"></div>
            <div class="cv2-field"><label class="cv2-label">Condition <span class="req">*</span></label>
              <select class="cv2-select cv2-modal-select" name="tyre_condition" style="width:100%;">
                <option value="New">New</option><option value="Re-thread">Re-thread</option><option value="Discard">Discard</option>
              </select>
            </div>
            <div class="cv2-field"><label class="cv2-label">Purchase Date</label><input type="date" name="tyre_purchase_date"></div>
            <div class="cv2-field"><label class="cv2-label">Price</label><input type="number" step="0.01" min="0" name="tyre_price" placeholder="22400"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="cv2-btn cv2-btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="cv2TyreForm" class="cv2-btn cv2-btn-primary"><i class="bi bi-check2"></i>Save Tyre</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/tyrevendor.js?v=2.1') }}"></script>@endsection
