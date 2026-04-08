
<div class="row rto-row mb-2">
    
    <div class="col-12 col-md-2">
        <div class="form-floating mb-3">
            <select name="rto_id[]" id="floatingSelect" class="form-select rto-select">
                <option value="">Choose..</option>
                @foreach ($rtos as $rto)
                    <option value="{{ $rto->id }}">
                        {{ $rto->name }}
                    </option>
                @endforeach
            </select>
            <label for="floatingSelect">RTO</label>
        </div>
    </div>
    
    <div class="col-12 col-md-3 px-1">
        <div class="form-floating mb-3">
            <input type="text" class="form-control decimalonly rto-large" id="rtoLarge">
            <label for="rtoLarge">Large Vehicle Charge</label>
        </div>
    </div>
    
    <div class="col-12 col-md-3 px-1">
        <div class="form-floating mb-3">
            <input type="text" class="form-control decimalonly rto-medium" id="rtoMedium">
            <label for="rtoMedium">Medium Vehicle Charge</label>
        </div>
    </div>
    
    <div class="col-12 col-md-3 px-1">
        <div class="form-floating mb-3">
            <input type="text" class="form-control decimalonly rto-small" id="rtoSmall">
            <label for="rtoSmall">Small Vehicle Charge</label>
        </div>
    </div>
    
    <!-- DELETE ICON -->
    <div class="col-12 col-md-1 text-center">
        <span class="removeRtoField text-danger" style="cursor:pointer;font-size:20px;">
            <i class="uil uil-trash-alt"></i>
        </span>
    </div>
  
</div>
