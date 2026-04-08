
$(document).ready(function(){
    
    let activeTab = sessionStorage.getItem('activeTab');

    if (activeTab) {

        $('#pills-tab button[data-bs-target="' + activeTab + '"]').tab('show');

        sessionStorage.removeItem('activeTab');
    }
    
    
    
    
    
    

    // Setup CSRF for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).on('keydown', '#activity_notes', function (e) {
        //console.log('Keydown detected');
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            saveActivityNote();
        }
    });
    $(document).on('click', '#activityBtn', function (e) {
        //console.log('Button clicked');
        e.preventDefault();
        saveActivityNote();
    });
    
    function saveActivityNote() { 
        
        //console.log("func call ----");

        let contactId = $("#edit_contactid_input").val();
        let note = $('#activity_notes').val();
        
        //console.log("note:", note);
        //console.log("contactId:", contactId);
        
        if (!note) {
            $('#err_activity_notes').text('Note is required.');
            return false;
        }
    
        $('#err_activity_notes').text('');
        $('#activity_notes').prop('disabled', true);
        $('#activityBtn').prop('disabled', true);
        
        // console.log("URL:", ACTIVITY_NOTE_URL);
        // console.log("note:", note);
        // console.log("contactId:", contactId);
    
        $.ajax({
            url: ACTIVITY_NOTE_URL,
            type: "POST",
            data: {
                activity_notes: note,
                contact_id: contactId
            },
            success: function (response) { 
    
                if (response.success) {
    
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
    
                    $('#activity_notes').val('');
                    
                    // store tab
                    sessionStorage.setItem('activeTab', '#activity');
    
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
    
                $('#activity_notes').prop('disabled', false);
                $('#activityBtn').prop('disabled', false);
                
                location.reload(true);
            },
            error: function (xhr) {
                console.log("Status:", xhr.status);
                console.log("Response:", xhr.responseText);
    
                if (xhr.status === 419) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Session expired. Please refresh the page.'
                    });
                } else if (xhr.responseJSON?.errors?.activity_notes) {
                    $('#err_activity_notes')
                        .text(xhr.responseJSON.errors.activity_notes[0]);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong!'
                    });
                }
    
                $('#activity_notes').prop('disabled', false);
                $('#activityBtn').prop('disabled', false);
            }
        });
    }
    
    
    
    
    
});