jQuery(document).ready(function ($) {
    var id=$('#btn_sms_input_hidden').val();
    data = {
        action: 'IVD_send_sms',
        _user_id: id,
    };
    $('#btn_sms_generate').on('click', function () {

        $.post(myajax.url, data, function (response) {
            //response=JSON.parse(response);
            console.log('Получено с сервера:' + response.data);// response for debug in console JS
             if(response.data==true)
                alert('SMS send...');
             else alert('Error');
        });
    })

    $('#btn_sms_check_pass').on('click', function () {
        var sms_input_pass=$('#input_sms_check_pass').val();
        data_check={
            action:'IVD_sms_auth_handler',
            sms_code:sms_input_pass,
            _user_id:id
        }
            console.log(sms_input_pass);
        $.post(myajax.url, data_check, function (response) {
             console.log('Получено с сервера:' + response.data);// response for debug in console JS
            if(response.data==true) {
                $('.not-verify-container').hide();
                alert('IT\'S OK! YOUR NUMBER ACCEPT!');
            }
            else if (response.data==false)
                alert('SORRY! INCORRECT CODE!');
            else alert('Something is wrong...')
        });
    })
    $('#save-social-accounts').on('click', function () {
        social_inputs={
            'fb':$('.social_link_facebook').val(),
            'tw':$('.social_link_twitter').val(),
            'tg':$('.social_link_telegram').val()
        }
        data_social = {
            action: 'save_social_inputs',
            links: social_inputs,
            _user_id:id
        };
        console.log(social_inputs);
        $.post(myajax.url, data_social, function (response) {
            if(response.data==true) {
                alert('IT\'S OK. SAVE.');
            }
            else alert('Something is wrong... please try again')
        });
    })

})
