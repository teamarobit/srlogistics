
<div class="row toll-row mb-2 d-flex">
    
    <div class="col-12 col-md-2">
        <div class="form-floating mb-3">
            <select name="tollstation_id[]" id="floatingSelect" class="form-select toll-select">
                <option value="">Choose..</option>

                @foreach ($tollstations as $station)
                    <option value="{{ $station->id }}">
                        {{ $station->station_name }}
                    </option>
                @endforeach
            </select>
            <label for="floatingSelect">Toll Stations</label>
        </div>
    </div>
          
    <div class="col-12 col-md-3 px-1">
     <div class="form-floating mb-3">
        <input type="text" class="form-control decimalonly toll-large" id="tollLarge">
        <label for="tollLarge">Large Vehicle Charge</label>
      </div>
    </div>
    
    <div class="col-12 col-md-3 px-1">
     <div class="form-floating mb-3">
        <input type="text" class="form-control decimalonly toll-medium" id="tollMedium">
        <label for="tollMedium">Medium Vehicle Charge</label>
      </div>
    </div>
    
    <div class="col-12 col-md-3 px-1">
     <div class="form-floating mb-3">
        <input type="text" class="form-control decimalonly toll-small" id="tollSmall">
        <label for="tollSmall">Small Vehicle Charge</label>
      </div>
    </div>
    
    <!-- DELETE ICON -->
    <div class="col-12 col-md-1 text-center">
        <span class="removeTollField text-danger" style="cursor:pointer;font-size:20px;">
            <i class="uil uil-trash-alt"></i>
        </span>
    </div>
      
</div>
                            