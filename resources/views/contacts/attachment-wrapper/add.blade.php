<hr id="hrl_{{ $rowindex }}">
<div class="add-attachment-sec" id="attsec_{{ $rowindex }}">
    <div class="row form-group align-items-center">
        <div class="col-12 col-md-4 d-flex justify-content-end order-md-last">
            <button type="button" class="remove-item btn btn-danger btn-sm remove-attachment-btn" data-rowindex="{{ $rowindex }}"><i class="uil uil-trash"></i> Remove </button>
        </div>
        <div class="col-12 col-md-2">
            <label>Document Type: <span class="text-danger">*</span></label>
        </div>
        <div class="col-12 col-md-6">
            <select class="form-select atypin" name="coattachtypes[]" id="coattachtypes_{{ $rowindex }}">
                <option value="">Select ID</option>
                @if( $coattachtypes->count())
                    @foreach( $coattachtypes as $type)
                       <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                @endif
            </select>
            <small class="error text-danger atyperr" id="add_coattachtype_{{ $rowindex }}_error"></small>
        </div>
        
    </div>
    
    <hr>
    
    <!--dropzone-->
    <div class="dropzone" id="dropzone{{ $rowindex }}"></div>
    <small class="error text-danger atterr" id="add_coattachments_{{ $rowindex }}_error"></small>
    
</div>