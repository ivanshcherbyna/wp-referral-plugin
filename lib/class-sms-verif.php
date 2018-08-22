<?php
class IVD_SMSAuth {

    protected $service =[];

    protected $number_sender='';

    protected $name_sender='';



    public function __construct()

    {
//        require_once IVD_PLUGIN_URL_REFERRER . 'lib/smsc_smpp.php';
        $this->service=array(

            'email'=>!empty(get_option('email_service'))?get_option('email_service'):'',

            'login'=>!empty(get_option('login_service'))?get_option('login_service'):'',

            'password'=>!empty(get_option('password_service'))?get_option('password_service'):''

        );

        $this->name_sender=!empty(get_option('name_sender'))?get_option('name_sender'):'';



        add_action('wp_ajax_IVD_send_sms', array($this,'IVD_send_mailtosms'));

        add_action('wp_ajax_IVD_sms_auth_handler', array($this,'IVD_sms_auth_handler'));

    }

    /*

     * AJAX Handler for generate sms code and send

     */

    public function IVD_send_mailtosms(){

        $user_id=$_POST['_user_id'];

        $user_info = get_userdata($user_id);

        $user_name = $user_info->user_login;

        $name_sender=$this->name_sender;

        $service=$this->service;

        $number_sender=get_user_meta($user_id, 'user_registration_number_box_1529446202',true);

        $subject='send to sms';

        $rand_num=random_int(1000,2000);

        //$message='|';

        //$message.=$service['login'];

        //$message.=';';

        // $message.=$service['password'];

        // $message.=';';

        //$message.='+'.$number_sender;

        //$message.=';';

        $message =$name_sender.'. ';

        $message.='Hi '.$user_name.', your SMS-code to enter on site '.home_url().' ';

        $message.='- ';

        $message.='" '.$rand_num.' "';

        $message.='|';

        $message.=' please fill in your account';



        update_user_meta($user_id,'sms_secret_key',$rand_num);

        //if(mail($service['email'],$subject,$message)==true) $result=true;

        //mail('______test_____@gmail.com',$subject,$message);

        if(mail($number_sender.$service['email'],$subject,$message)==true) $result=true;

        else $result=false;

        wp_send_json_success($result);

        wp_die(0);

    }

    /*

    *AJAX handler sms-verif

    */

    function IVD_sms_auth_handler()

    {

        $result=null;

        $response_sms = $_POST['sms_code'];

        $user_id = $_POST['_user_id'];

        $current_correct_sms_code = get_user_meta($user_id, 'sms_secret_key',true);



        if (!empty($response_sms) && !empty($user_id))

        {

            if ($response_sms == $current_correct_sms_code)

            {

                //----------------------------check and return some SUCCESS ACTIONS

                update_user_meta($user_id,'Verified_phone_by_sms','OK');

                //SET +50 units for sms confirm

                !empty(get_user_meta($user_id,'units',true)) ? $old_bonus_for_new_user=get_user_meta($user_id,'units',true) : $old_bonus_for_new_user='0';

                !empty(get_option( 'bonus_for_new_user' ))?$bonus_for_new_user=get_option( 'bonus_for_referrer'):$bonus_for_new_user=0;

                settype($bonus_for_new_user,'int');

                settype($old_bonus_for_new_user,'int');



                update_user_meta($user_id, 'units', $bonus_for_new_user+$old_bonus_for_new_user);



                $result=true;

            } else { // return incorrect message

                // echo 'sms code is incorrect';

                update_user_meta($user_id,'Verified_phone_by_sms','NO');

                $result=false;

            }

        }

        wp_send_json_error($result);

        wp_die(0);

    }

}


$sms_obj = new IVD_SMSAuth();



/*------ custom sms-autentificate----------*/