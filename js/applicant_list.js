$('#applicant_allbt').on('click',function(){
        $('input[name="appli_nob[]"]').prop('checked', true);
    });

    $('#applicant_allnbt').on('click',function(){
        $('input[name="appli_nob[]"]').prop('checked', false);
    });