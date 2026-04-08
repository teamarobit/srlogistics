<div class="contact-person" data-index="{{ $rowindex }}">
  <input type="hidden" name="row_index[]" value="{{ $rowindex }}">
  <a href="javascript:void(0)" class="text-end text-secondary d-block mb-0 close-sec"><i class="uil uil-times-circle"></i></a>
  <div class="row form-group">
    <div class="col-12 col-md-5">
        <label>Name <span class="text-danger">*</span></label>
    </div>
    <div class="col-12 col-md-7">
        <input type="text" class="form-control" name="contact_person_name[{{ $rowindex }}]">
        <div class="error text-danger cpnameerr" id="contact_person_name_{{ $rowindex }}_error"></div>
    </div>
  </div>
  <div class="row form-group">
    <div class="col-12 col-md-5">
        <label><span class="cpdglbl">Position </label>
    </div>
    <div class="col-12 col-md-7">
        <input type="text" class="form-control" name="contact_person_designation[{{ $rowindex }}]">
        <div class="error text-danger cpdgerr" id="contact_person_designation_{{ $rowindex }}_error"></div>
    </div>
  </div>
  <div class="row form-group">
      <div class="col-12 col-md-5">
          <label>Phone <span class="text-danger">*</span></label>
      </div>
      <div class="col-12 col-md-7">
          <div class="row">
              <input type="hidden" name="contact_person_ph_code[]" class="phone_code">
              <div class="col-12 col-md-12">
                  <input type="text" class="form-control telinput " name="contact_person_phone[{{ $rowindex }}]">
                  <div class="error text-danger cpph" id="contact_person_phone_{{ $rowindex }}_error"></div>
              </div>
          </div>
      </div>
  </div>
    <div class="row form-group">
        <div class="col-12 col-md-5">
            <label>WhatsApp</label>
        </div>
        <div class="col-12 col-md-7">
            <div class="row">
                <input type="hidden" name="contact_person_whatsapp_code[]" class="phone_code">
                <div class="col-12 col-md-12">
                    <input type="text" class="form-control telinput " name="contact_person_whatsapp[{{ $rowindex }}]" />
                    <div class="error text-danger cpwa" id="contact_person_whatsapp_{{ $rowindex }}_error"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
      <div class="col-12 col-md-5">
          <label>Email</label>
      </div>
      <div class="col-12 col-md-7">
          <div class="row">
              <div class="col-9 pe-0">
                  <input type="text" class="form-control" name="contact_person_email[{{ $rowindex }}]">
                  <div class="error text-danger cpeml" id="contact_person_email_{{ $rowindex }}_error"></div>
              </div>
              <div class="col-3">
                  <span class="badge bg-secondary"><i class="uil uil-envelope-alt"></i></span>
              </div>
          </div>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-12 col-md-5">
          <label>Comment</label>
      </div>
      <div class="col-12 col-md-7">
          <textarea class="form-control" rows="3" placeholder="" name="contact_person_comment[{{ $rowindex }}]"></textarea>
          <div class="error text-danger cpcmt" id="contact_person_comment_{{ $rowindex }}_error"></div>
      </div>
  </div>
</div>