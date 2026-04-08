<hr id="hrl_{{ $rowindex }}">
<div class="add-attachment-sec" id="attsec_{{ $rowindex }}">
    <div class="row form-group align-items-center">
        <div class="col-12 col-md-4 d-flex justify-content-end order-md-last">
            <button type="button" class="btn btn-link remove-attachment-btn" data-rowindex="{{ $rowindex }}"><i class="fa fa-trash fa-lg text-danger"></i></button>
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
            <small class="error text-danger atyperr" id="edit_coattachtype_{{ $rowindex }}_error"></small>
        </div>
        
    </div>
    
    <hr>
    
    <!--dropzone-->
    <div class="dropzone" id="dropzone{{ $rowindex }}"></div>
    <!--<div class="dzin-box" id="dropzone_{{ $rowindex }}" class="mt-4">
        <div class="dropzone needsclick attin" id="edit_attachments_0_input" action="/upload">
            <div class="dz-message needsclick">    
                <i class="uil uil-upload me-2"></i>Drop files here or click to upload.
                Allowed extensions (jpeg,png,jpg,pdf). Max file size is 2MB
            </div>
        </div>
    </div>-->
    <small class="error text-danger atterr" id="edit_coattachments_{{ $rowindex }}_error"></small>
</div>