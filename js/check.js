jQuery(document).ready(function ($) {
    if($('.verify-view.verify-container').attr('data')=='OK') {
        $('#user_registration_number_box_1529446202').attr('readonly', true);
    }
    else{
        $('#user_registration_number_box_1529446202').attr('readonly', false);
    }
    $('#user_registration_input_box_1529446044').attr('pattern','^0x([A-Fa-f0-9]{40})$');
    $('#user_registration_input_box_1529446044').on('changed', function(){
        var input = $(this).val();
        var arr = [];
        if(input.length == 42){
            for(var i=0; i<2; i++){
                arr.push(input[i]);
            }
            if(arr[0] == '0' && arr[1] == 'x'){
                $('this').val(input);
                console.log('Good');
            }else{
                $('this').val('');
                console.log('You stroke not valid');
            }
        }else{
            $('this').val('');
            console.log('Insufficient number of characters');
        }
    })
    $('#btn_sms_generate').attr('disabled',true);//disabled because not need at now
    $('#input_sms_check_pass').attr('disabled',true);//disabled because not need at now
    $('#btn_sms_check_pass').attr('disabled',true);//disabled because not need at now
})
