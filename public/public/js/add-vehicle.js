// GST form autofill
$('#fetchData').click(function(){
    const vcData = {
        name: "John Doe",
        c_no: "1011",
        e_no: "1020",
        rc_date: "12/09/2025",
        i_date: "12/09/2025",
        p_date: "12/09/2025",
        t_date: "16/09/2025",
        rto: "kolkata"
    };
    
    if(!$('#vc_no').val().length) {
        alert('Vehicle number is required');
        return;
    } else {
        $('#name').val(vcData.name);
        $('#c_no').val(vcData.c_no);
        $('#e_no').val(vcData.e_no);
        $('#rc_date').val(dateFormat(vcData.rc_date, $('#rc_date')));
        $('#i_date').val(dateFormat(vcData.i_date, $('#i_date')));
        $('#data.p_date').val(dateFormat(vcData.p_date,$('#data.p_date')));
        $('#t_date').val(dateFormat(vcData.t_date,$('#t_date')));
        $('#rto').val(vcData.rto);
    }
    
    $(function() {
    //   $('input[data-role="tagsinput"]').tagsinput();
    $("input").tagsinput('items')
    });
});