<?php
class IVD_Referrals {
    public static $bonus_for_referrer=0;
    public static $bonus_for_new_user=0;

    public function __construct()

    {
        add_action('init', array($this,'IVD_set_referal_cookie'));
        add_action('user_register',array($this,'IVD_check_reffer'));
        add_action('wp_ajax_IVD_save_social_inputs',array($this,'IVD_save_social_by_ajax'));

        self::$bonus_for_referrer=get_option( 'bonus_for_referrer' );
        self::$bonus_for_new_user=get_option( 'bonus_for_new_user' );
        settype(self::$bonus_for_referrer,'int');
        settype(self::$bonus_for_new_user,'int');

    }

    /**
     * @param $user_id
     * @return mixed
     */
    function IVD_get_exist_user_units($user_id){
         $old_referrer_user_units = get_user_meta( sanitize_text_field($user_id), 'units', true);
        return (int) $old_referrer_user_units;
     }

    /*
    * Function set cookie for referal user
    */
    public function IVD_set_referal_cookie()

    {

        $ref = isset($_GET['ref']) ? $_GET['ref'] : NULL;

        if ($ref == NULL) {

            $ref = 'without_referal';

        }

        else {

            setcookie('my_referal', $ref, time() + (86400 * 30), COOKIEPATH, COOKIE_DOMAIN, false);

        }

    }


    /**Calculate units for referal
     * @param $user_id
     * @return int
     */
    function IVD_calc_user_units($user_id){

        $old_units_referrer_user = $this->IVD_get_exist_user_units($user_id);

        $new_units_referrer_user = $old_units_referrer_user + self::$bonus_for_new_user;

        return (int) $new_units_referrer_user;
    }

    /**
     * @param $referrer_user_id
     * @param $new_user_id
     */
    function IVD_update_user_meta_units($referrer_user_id, $new_user_id)

    {
        sanitize_text_field($referrer_user_id);
        $counter_null = 0;

        if (!empty(get_user_meta($referrer_user_id, 'counter', true))) {

            $counter = get_user_meta($referrer_user_id, 'counter', true);

        } else {

            $counter = $counter_null;

        }

        settype($counter, 'int');

        ++$counter;

        $new_units_referrer_user = $this->IVD_calc_user_units($referrer_user_id);

        update_user_meta($referrer_user_id, 'units', $new_units_referrer_user);// +50 units

        update_user_meta($referrer_user_id, 'counter', $counter);// +1 counter

    }

    /*
    * Function for set bonuses for refer
    */
    public function IVD_check_reffer($created_new_user_id)

    {

        //set if need units for registration

        add_user_meta($created_new_user_id, 'units', self::$bonus_for_referrer);

        //check, get & update units for feferral user +50 units

        $referr_user_id = isset($_COOKIE['my_referal']) ? $_COOKIE['my_referal'] : '';

        if (get_user_by('id',$referr_user_id)){
            $this->IVD_update_user_meta_units($referr_user_id, $created_new_user_id);

            //removed cookie when user checked
            if (isset($_COOKIE['my_referal'])){setcookie('my_referal','registered',time() + (10), COOKIEPATH, COOKIE_DOMAIN, false);}

        }
        else {
            $ref = 'without_referal';
            return setcookie('my_referal', $ref, time() + (10), COOKIEPATH, COOKIE_DOMAIN, false);
        }

    }
    /*
    * AJAX handler for Function for generate inputs for social accounts
    */
    public function IVD_save_social_by_ajax()

    {
        $result=false;

        if (isset($_POST['_user_id'])) {

            $social_links = $_POST['links'];

            $user_id=$_POST['_user_id'];

            if($social_links['fb']) update_user_meta($user_id,'user_registration_facebook_account',$social_links['fb']);

            if($social_links['tw']) update_user_meta($user_id,'user_registration_twitter_account',$social_links['tw']);

            if($social_links['tg']) update_user_meta($user_id,'user_registration_telegram_account',$social_links['tg']);

            $result=true;

            wp_send_json_success($result);

        }

        else return $result;

        wp_die();

    }

}
