const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      }
});

Dropzone.autoDiscover = false;

const MAX_ATTACHMENTS = 2;
let attachmentIndex = 0;
let dzInstance = null;
let editDzInstance = null;

function initDropzone() {
    const myDropzone = document.getElementById(`myDropzone`);
    if (!myDropzone) return;

    // Prevent double init
    if (myDropzone.dropzone) return;

    dzInstance = new Dropzone(myDropzone, {
        url: '/upload/images',
        paramName: "files",
        maxFiles: MAX_ATTACHMENTS,
        maxFilesize: 2,
        acceptedFiles: ".webp,.jpg,.jpeg,.png,.pdf",
        addRemoveLinks: true,
        parallelUploads: MAX_ATTACHMENTS,
        autoProcessQueue: false,
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') }
    });
    
    // Event: file exceeds max
    dzInstance.on("maxfilesexceeded", function(file) {
        dzInstance.removeFile(file); // Remove the extra file
        Toast.fire({
                      icon: 'error',
                      title: "Maximum 2 attachments allowed!"
                    });
    });
}

function editInitDropzone() {
    const myDropzone = document.getElementById(`edit_myDropzone`);
    if (!myDropzone) return;

    // Prevent double init
    if (myDropzone.dropzone) return;

    editDzInstance = new Dropzone(myDropzone, {
        url: '/upload/images',
        paramName: "files",
        maxFiles: MAX_ATTACHMENTS,
        maxFilesize: 2,
        acceptedFiles: ".webp,.jpg,.jpeg,.png,.pdf",
        addRemoveLinks: true,
        parallelUploads: MAX_ATTACHMENTS,
        autoProcessQueue: false,
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') }
    });
    
    // Event: file exceeds max
    editDzInstance.on("maxfilesexceeded", function(file) {
        editDzInstance.removeFile(file); // Remove the extra file
        Toast.fire({
                      icon: 'error',
                      title: "Maximum 2 attachments allowed!"
                    });
    });
}

function setDateRangePicker(selector, date) {
    
    let picker = $(selector).data('daterangepicker');

    if (!date) {
        $(selector).val('');
        return;
    }

    let formattedDate = moment(date, 'DD/MM/YYYY');

    picker.setStartDate(formattedDate);
    picker.setEndDate(formattedDate);

    $(selector).val(formattedDate.format('DD/MM/YYYY'));
}

$(document).ready(function() {
    const baseUrl = window.location.origin + window.location.pathname;
    const storageKey = `activeNav_${baseUrl}`;
    
    initDropzone();
    editInitDropzone();
    
    // ==============================================
    
    $(".changedriver_bd").hide();
    $(".open_01driver").on("click", function() {
        $(".changedriver_bd").slideToggle(300); 
        $(this).toggleClass("active");   
    });
    
    $('input[name="datetime"]').daterangepicker({
        singleDatePicker: true,   
        timePicker: true,         
        startDate: moment(),      
        locale: {
          format: 'MM/DD/YYYY hh:mm A' 
        }
    });
      
    $('input[name="datet01"]').daterangepicker({
        singleDatePicker: true,   
        timePicker: false,        
        locale: {
          format: 'DD/MM/YYYY',   
        }
    });
    
    $('#doc_issue_date').daterangepicker({
        singleDatePicker: true,   
        timePicker: false,        
        locale: {
          format: 'DD/MM/YYYY',   
        }
    });
    
    
    $('#doc_expiry_date').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        }
    });

    $('#doc_expiry_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });

    $('#doc_expiry_date').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
    
    $('#edit_doc_issue_date').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
        }
    });
    
    $('#edit_doc_expiry_date').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        }
    });
    
    $('#edit_doc_issue_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    
    $('#edit_doc_expiry_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    
    $('#edit_doc_expiry_date').on('cancel.daterangepicker', function () {
        $(this).val('');
    });
    
    const noteInput = document.getElementById('noteInput');
    noteInput.addEventListener('input', function () {
        this.style.height = 'auto'; // reset height
        this.style.height = (this.scrollHeight) + 'px'; // set new height
    });
    
    $('.clickto-adclass').change(function(){
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').addClass('active');
        } else {
            $('.days-beforeexpiry').removeClass('active');
        }
    });
    
    $('.if-main').click(function(){
        $('.maintanance-wrap').show();
        $('.repair-wrap').hide();
    })
    
    $('.if-rep').click(function(){
        $('.maintanance-wrap').hide();
        $('.repair-wrap').show();
    })
    
    // ==============================================
    
    $('#attachmenttype_dd').select2({
        placeholder: "Search Document Type...",
        dropdownParent: '#documentForm',
        tags: true
    });
    
    $('#edit_attachmenttype_dd').select2({
        placeholder: "Search Document Type...",
        dropdownParent: '#editDocumentForm',
        tags: true
    });
    
    $('.showMore').on('click', function () {
        const __this = $(this);
        var notes = __this.data('notes');

        $('#modalNotesContent').text(notes); // safe (plain text)
    });
    
    $(document).on('click', '.item-edit', function () {
        let button = $(this);
        
        $('#editDocumentForm').attr('action', button.data('url'));
    
        $('#edit_attachmenttype_dd').val(button.data('attachment_type')).trigger('change');
        $('input[name="document_number"]').val(button.data('document_number'));
    
        $('#edit_doc_issue_date').val(button.data('issue_date'));
        $('#edit_doc_expiry_date').val(button.data('expiry_date'));
    
        $('#edit_document_notes').val(button.data('notes'));
        
        setDateRangePicker('#edit_doc_issue_date', button.data('issue_date'));
        setDateRangePicker('#edit_doc_expiry_date', button.data('expiry_date'));
    
        let hasReminder = button.data('has_reminder');
    
        if (hasReminder == 'Yes') {
            $('#edit_setReminder').prop('checked', true);
            $('.days-beforeexpiry').show();
            $('#edit_reminder_days').val(button.data('reminder_days'));
        } else {
            $('#edit_setReminder').prop('checked', false);
            $('.days-beforeexpiry').hide();
            $('#edit_reminder_days').val('');
        }
    
    });
    
    $('#edit_setReminder').on('change', function () {
        if ($(this).is(':checked')) {
            $('.days-beforeexpiry').show();
        } else {
            $('.days-beforeexpiry').hide();
            $('#edit_reminder_days').val('');
        }
    });
    
    $(document).on('click', '.view-files', function () {
        let files = $(this).data('files');
        let container = $('#filePreviewContainer1');
    
        container.html(''); // clear previous
    
        if (!files || files.length === 0) {
            container.html('<p>No files available</p>');
            return;
        }
    
        files.forEach(file => {
    
            let isImage = file.file_type.startsWith('image/');
            let isPdf = file.file_type === 'application/pdf';
    
            let previewHtml = '';
            let fileSize = (file.file_size / 1024).toFixed(2) + ' KB';
    
            let createdAt = new Date(file.created_at);
            let formattedDate = createdAt.toLocaleDateString('en-GB');
    
            if (isImage) {
                previewHtml = `<img src="${file.url}" class="me-3" style="width:50px;height:50px;object-fit:cover;">`;
            }else if (isPdf) {
                previewHtml = `<img src="${PDF_LOGO}" 
                                    class="me-3" style="width:50px;">`;
            }else {
                previewHtml = `<img src="${OTHER_LOGO}" 
                                    class="me-3" style="width:50px;">`;
            }
            
            let fileName = file.file_name;
            let shortName = fileName.length > 15 
                            ? fileName.substring(0, 15) + '...' 
                            : fileName;
    
            let html = `
                <div class="col-12 col-md-4 attachment-box mb-3">
                    <div class="preview-img d-block w-100 border rounded p-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <a href="${file.url}" download="${file.file_name}">
                                    ${previewHtml}
                                </a>
                                <div style="font-size: 14px;">
                                    <a href="${file.url}" download="${file.file_name}">
                                        <p class="mb-0 file-name">${shortName}</p>
                                    </a>
                                    <p class="mb-0">Size: 
                                        <span class="text-secondary">${fileSize}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="float-end">
                                <i class="uil-trash-alt text-danger delete-attachment-btn"
                                   data-url="${file.delete_url}"
                                   style="cursor:pointer;"></i>
                            </div>
                        </div>
                        <small class="text-secondary d-block mt-2">
                            Attached on ${formattedDate}
                        </small>
                    </div>
                </div>
            `;
    
            container.append(html);
        });
    
        $('#filePreviewModal').modal('show');
    });
    
    $(document.body).on('click', '.delete-attachment-btn', function(){
        var url = $(this).data('url');
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Are you sure to delete it?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Do not delete',
            confirmButtonColor:'#1F75A8',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method      : 'POST',
                    data        : {},
                    url         : url,
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        Toast.fire({
                                      icon: 'success',
                                      title: response.message
                                }).then(() => {
                                    location.reload(true);
                                });
                            
                    },
                    error       : function(data){
                        var response = $.parseJSON(data.responseText);
                        Toast.fire({
                          icon: 'error',
                          title: response.message
                        });
                        
                    }
                });
            } else {
                Toast.fire({
                  icon: 'info',
                  title: 'No action taken.'
                });
            }
        });
    });
    
    $(document).on('click', '.docSubmitForm', function(){
        $('form#documentForm').submit();
    });
    
    $(document).on('click', '.editDocSubmitForm', function(){
        $('form#editDocumentForm').submit();
    });
    
    $('form#documentForm').on('submit', function(e){
        e.preventDefault();
        
        $('.error').html('');
        let submitBtn = $('.docSubmitForm');
        let submitBtnText = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        var formData = new FormData(this);
        
        if($('#myDropzone').length){
            for (let i = 0; i < dzInstance.files.length; i++) {
                formData.append("files[]", dzInstance.files[i]); // Append each file properly
            }
        }
        
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                Toast.fire({
                  icon: 'success',
                  title: response.message,
                  didClose: function(){
                    // window.location.href = response.redirect_url;
                    location.reload(true);
                  }
                });
                
                submitBtn.html(submitBtnText);
            },
            error       : function(data){
                var response = data.responseJSON;
                
                Toast.fire({
                  icon: 'error',
                  title: response.message
                });
                
                $.each(response.data, function(index, value){
                    $('#document_'+index+'_error').text(value[0]);
                });
                
                submitBtn.html(submitBtnText).attr('disabled', false);
            }

        });
        
        return false;
    });
    
    $('form#editDocumentForm').on('submit', function(e){
        e.preventDefault();
        
        $('.error').html('');
        let submitBtn = $('.editDocSubmitForm');
        let submitBtnText = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        var formData = new FormData(this);
        
        if($('#edit_myDropzone').length){
            for (let i = 0; i < editDzInstance.files.length; i++) {
                formData.append("files[]", editDzInstance.files[i]); // Append each file properly
            }
        }
        
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                Toast.fire({
                  icon: 'success',
                  title: response.message,
                  didClose: function(){
                    // window.location.href = response.redirect_url;
                    location.reload(true);
                  }
                });
                
                submitBtn.html(submitBtnText);
            },
            error       : function(data){
                var response = data.responseJSON;
                
                Toast.fire({
                  icon: 'error',
                  title: response.message
                });
                
                $.each(response.data, function(index, value){
                    $('#document_'+index+'_error').text(value[0]);
                });
                
                submitBtn.html(submitBtnText).attr('disabled', false);
            }

        });
        
        return false;
    });
    
    $('form#commentForm').on('submit', function(e){
        e.preventDefault();
        
        $('.error').html('');
        let submitBtn = $('.submitBtn', $(this));
        let submitBtnText = submitBtn.html();
        submitBtn.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').attr('disabled', true);
        var formData = new FormData(this);
        
        $.ajax({
            method      : 'POST',
            data        : formData,
            url         : $(this).attr('action'),
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success     : function(response){
                Toast.fire({
                  icon: 'success',
                  title: response.message,
                  didClose: function(){
                    // window.location.href = response.redirect_url;
                    location.reload(true);
                  }
                });
                
                submitBtn.html(submitBtnText);
            },
            error       : function(data){
                var response = data.responseJSON;
                
                Toast.fire({
                  icon: 'error',
                  title: response.message
                });
                
                $.each(response.data, function(index, value){
                    $('#'+index+'_error').text(value[0]);
                });
                
                submitBtn.html(submitBtnText).attr('disabled', false);
            }

        });
        
        return false;
    });

    const savedNav = localStorage.getItem(storageKey);
    
    let targetEl;
    $(document).on('click', '.nav_click', function(e){
        e.preventDefault();
    
        const navTarget = $(this).data('bs-target');
        
        localStorage.setItem(storageKey, navTarget);
    });

    if(savedNav){
        targetEl = document.querySelector(`.nav_click[data-bs-target="${savedNav}"]`);
    } else {
        targetEl = document.querySelector('.nav_click');
    }

    if(targetEl){
        const tab = new bootstrap.Tab(targetEl);
        tab.show();
    }


});
