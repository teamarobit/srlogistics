<div class="bank-data" data-index="{{ $rowindex }}">
  <input type="hidden" name="row_index[]" value="{{ $rowindex }}">
  <a href="javascript:void(0)" class="text-end text-secondary d-block mb-0 close-bank"><i class="uil uil-times-circle"></i></a>
  <div class="row form-group">
    <div class="col-12 col-md-5">
        <label>Is Primary ? <span class="text-danger">*</span></label>
    </div>
    <div class="col-12 col-md-7 d-flex">
        <div class="form-check">
            <input class="form-check-input bank-status" type="radio" name="is_primary[]" id="is_primary_yes_{{ $rowindex }}" value="Yes" />
            <label class="form-check-label" for="is_primary_yes_{{ $rowindex }}">
                Yes
            </label>
        </div>

        <div class="form-check mx-2">
            <input class="form-check-input bank-status" type="radio" name="is_primary[]" id="is_primary_no_{{ $rowindex }}" value="No" />
            <label class="form-check-label" for="is_primary_no_{{ $rowindex }}">
                No
            </label>
        </div>
    </div>
    <small class="error text-danger b_primary_err" id="is_primary_{{ $rowindex }}_error"></small>
  </div>
  
  <div class="row form-group">
    <div class="col-12 col-md-5">
        <label><span class="cpdglbl">Bank Name <span class="text-danger">*</span></label>
    </div>
    <div class="col-12 col-md-7">
        <select name="bank_id[]" class="form-select select2">
            <option value="">Choose..</option>
            @foreach ($banks as $bank)
            <option value="{{ $bank->id }}">
                {{ $bank->name }}
            </option>
            @endforeach
        </select>
        <small class="error text-danger b_id_err" id="bank_id_{{ $rowindex }}_error"></small>
    </div>
  </div>
  <div class="row form-group">
      <div class="col-12 col-md-5">
          <label>Beneficiary Name</label>
      </div>
      <div class="col-12 col-md-7"> 
        <input type="text" class="form-control" name="beneficiary_name[]">
        <small class="error text-danger b_name_err" id="beneficiary_name_{{ $rowindex }}_error"></small>
      </div>
  </div>
    <div class="row form-group">
        <div class="col-12 col-md-5">
            <label>Account Number <span class="text-danger">*</span></label>
        </div>
        <div class="col-12 col-md-7"> 
            <input type="text" class="form-control" name="account_number[]">
            <small class="error text-danger b_accno_err" id="account_number_{{ $rowindex }}_error"></small>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-12 col-md-5">
          <label>IFSC Code <span class="text-danger">*</span></label>
        </div>
        <div class="col-12 col-md-7"> 
            <input type="text" class="form-control" name="ifsc_code[]">
            <small class="error text-danger b_ifsc_err" id="ifsc_code_{{ $rowindex }}_error"></small>
        </div>
    </div>
    <div class="row form-group">
      <div class="col-12 col-md-5">
          <label>UPI ID</label>
      </div>
      <div class="col-12 col-md-7">
          <input type="text" class="form-control" name="upi_id[]">
          <div class="error text-danger b_upi_err" id="upi_id_{{ $rowindex }}_error"></div>
      </div>
  </div>
</div>