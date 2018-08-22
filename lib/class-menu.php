<?php
final class IVD_Admin_menu{
    public static $name_of_unit='';
    public static $bonus_for_referrer=0;
    public static $bonus_for_new_user=0;
    public static $email_service='';
    public static $login_service='';
    public static $password_service='';
    public static $name_sender='';
    public static $course_of_units=null;
    public static $telegram_channel_url='';
    public static $facebook_channel_url='';
    public static $twitter_channel_url='';
    public static $twitter_channel_title='';
    public static $phone_user_meta_key='';
    public static $progress_bar_value=0;
    public static $wallet_for_by='';



    function __construct()
    {
        add_action('admin_menu', array($this,'IVD_my_plugin_menu_referrals'));
        add_action('init',array($this,'IVD_hide_admin_bar'));
        add_action( 'edit_user_profile', array($this, 'IVD_custom_user_profile_fields' ));
        add_action( 'edit_user_profile_update', array($this,'IVD_save_custom_user_profile_fields') );

        self::$name_of_unit = sanitize_text_field(get_option('name_of_unit'));
        self::$bonus_for_referrer = sanitize_text_field(get_option('bonus_for_referrer'));
        self::$bonus_for_new_user = sanitize_text_field(get_option('bonus_for_new_user'));
        self::$email_service = sanitize_text_field(get_option('email_service'));
        self::$login_service = sanitize_text_field(get_option('login_service'));
        self::$password_service = sanitize_text_field(get_option('password_service'));
        self::$name_sender = sanitize_text_field(get_option('name_sender'));
        self::$course_of_units = sanitize_text_field(get_option('course_of_units'));
        self::$telegram_channel_url = sanitize_text_field(get_option('telegram_channel_url'));
        self::$facebook_channel_url = sanitize_text_field(get_option('facebook_channel_url'));
        self::$twitter_channel_url = sanitize_text_field(get_option('twitter_channel_url'));
        self::$twitter_channel_title = sanitize_text_field(get_option('twitter_channel_title'));
        self::$phone_user_meta_key = !empty(get_option('phone_user_meta_key'))?sanitize_text_field(get_option('phone_user_meta_key')):'user_registration_number_box_1529446202';;
        self::$progress_bar_value=sanitize_text_field(sanitize_text_field(get_option( 'progress_bar_value' )));
        self::$wallet_for_by=sanitize_text_field(sanitize_text_field(get_option( 'wallet_for_by' )));
    }
    /*
     * Add in Settings section plugin menu
     */

        public function IVD_my_plugin_menu_referrals() {

            add_options_page( 'My Plugin Referrals Options',

                'Referral-system-IVD',

                'manage_options',

                'id_referral_sites',

                array($this,'IVD_my_plugin_options_referral'));

        }

    /*
     * Add callback function for view menu page
     */
        public function IVD_my_plugin_options_referral()

        {

            if (!current_user_can('manage_options')) {

                wp_die(__('You do not have sufficient permissions to access this page.'));

            }


            // if this fails, check_admin_referer() will automatically print a "failed" page and die.

            if (isset($_POST['save']) && check_admin_referer( 'name_of_my_check_nonces', 'check_of_nonce_field' )) {

                if (isset ($_POST['name_of_unit']) && isset ($_POST['bonus_for_referrer']) && isset ($_POST['bonus_for_new_user'])) {

                    update_option('name_of_unit', sanitize_text_field($_POST['name_of_unit']));

                    update_option('bonus_for_referrer', sanitize_text_field($_POST['bonus_for_referrer']));

                    update_option('bonus_for_new_user', sanitize_text_field($_POST['bonus_for_new_user']));

                    update_option('email_service', sanitize_email($_POST['email_service']));

                    update_option('login_service', sanitize_text_field($_POST['login_service']));

                    update_option('password_service', sanitize_text_field($_POST['password_service']));

                    update_option('name_sender', sanitize_text_field($_POST['name_sender']));

                    update_option('course_of_units', sanitize_text_field($_POST['course_of_units']));

                    update_option('telegram_channel_url', sanitize_text_field($_POST['telegram_channel_url']));

                    update_option('facebook_channel_url', sanitize_text_field($_POST['facebook_channel_url']));

                    update_option('twitter_channel_url', sanitize_text_field($_POST['twitter_channel_url']));

                    update_option('twitter_channel_title', sanitize_text_field($_POST['twitter_channel_title']));

                    update_option('phone_user_meta_key', sanitize_text_field($_POST['phone_user_meta_key']));

                    update_option('progress_bar_value', sanitize_text_field($_POST['progress_bar_value']));

                    update_option('wallet_for_by', sanitize_text_field($_POST['wallet_for_by']));

                } //SAVE META OPTION

            }

            ?>



            <h3 class="heading">PLUGIN SETTINGS FOR USE REFERRAL PARAMS</h3>

            <img class="plugin-admin-image" src="<?php echo IVD_PLUGIN_URL_REFERRER;?>image.jpg">

            <div style="color: blue">For correct use this plugin you must has correct data</div>

            <form method="POST">

                <table class="form-table">
                    <th>
                        <hr>
                        <tr>
                            <td><label style="color: green; font-weight: bold">General settings</label></td>
                        </tr>
                    </th>
                    <tr>

                        <th><label for="name_of_unit" style="color: green;">Name of unit/token/currency</label></th>

                        <td><input type="text" class="input-text form-control" name="name_of_unit" required

                                   value="<?php echo !empty($_POST['name_of_unit'])? $_POST['name_of_unit']: self::$name_of_unit; ?>"/></td>

                    </tr>

                    <tr>

                        <th><label for="bonus_for_referrer" style="color: green;">Count of bonus for referrer</label></th>

                        <td><input type="number" class="input-text form-control" name="bonus_for_referrer" required

                                   value="<?php echo !empty($_POST['bonus_for_referrer'])? $_POST['bonus_for_referrer']: self::$bonus_for_referrer; ?>"/></td>

                    </tr>

                    <tr>

                        <th><label for="bonus_for_new_user" style="color: green;">Count of bonus for new account</label></th>

                        <td><input type="number" class="input-text form-control" name="bonus_for_new_user"

                                   value="<?php echo !empty($_POST['bonus_for_new_user'])? $_POST['bonus_for_new_user']: self::$bonus_for_new_user; ?>"/></td>

                    </tr>

                    <tr>

                        <th><label for="course_of_units" style="color: green;">COURSE OF token to $</label></th>

                        <td><input type="text" class="input-text form-control" name="course_of_units"

                                   value="<?php echo !empty($_POST['course_of_units'])? $_POST['course_of_units']: self::$course_of_units;?>"/>

                        </td>

                    </tr>
                    <tr>

                        <th><label for="progress_bar_value" style="color: green;">Progress bar value (from Soft cap to Hard cap) 0-350</label></th>

                        <td><input type="number" class="input-text form-control" name="progress_bar_value" min="0" max="350"

                                   value="<?php echo !empty($_POST['progress_bar_value'])? $_POST['progress_bar_value']: self::$progress_bar_value;?>"/>

                        </td>

                    </tr>
                    <tr>

                        <th><label for="wallet_for_by" style="color: green;">Wallet for Buy token </label></th>

                        <td><input type="text" class="input-text form-control" name="wallet_for_by"

                                   value="<?php echo !empty($_POST['wallet_for_by'])? $_POST['wallet_for_by']:  self::$wallet_for_by;?>"/>

                        </td>

                    </tr>
                    <th>
                        <hr>
                        <tr>
                            <td><label style="color: blue; font-weight: bold">Social section</label></td>
                        </tr>
                    </th>
                    <tr>


                        <th><label for="telegram_channel_url" style="color: blue;">Telegram channel</label></th>

                        <td><input type="text" class="input-text form-control" name="telegram_channel_url"

                                   value="<?php echo !empty($_POST['telegram_channel_url'])? $_POST['telegram_channel_url']: self::$telegram_channel_url;?>"/>

                        </td>

                    </tr>

                    <tr>

                        <th><label for="facebook_channel_url" style="color: blue;">Facebook group</label></th>

                        <td><input type="text" class="input-text form-control" name="facebook_channel_url"

                                   value="<?php echo !empty($_POST['facebook_channel_url'])? $_POST['facebook_channel_url']: self::$facebook_channel_url;?>"/>

                        </td>

                    </tr>

                    <tr>

                        <th><label for="twitter_channel_url" style="color: blue;">Twitter URL</label></th>

                        <td><input type="text" class="input-text form-control" name="twitter_channel_url"

                                   value="<?php echo !empty($_POST['twitter_channel_url'])? $_POST['twitter_channel_url']: self::$twitter_channel_url;?>"/>

                        </td>

                    </tr>

                    <tr>

                        <th><label for="twitter_channel_title" style="color: blue;">Twitter title</label></th>

                        <td><input type="text" class="input-text form-control" name="twitter_channel_title"

                                   value="<?php echo !empty($_POST['twitter_channel_title'])? $_POST['twitter_channel_title']: self::$twitter_channel_title;?>"/>

                        </td>

                    </tr>

                    <th>
                        <hr>
                        <tr>
                            <td><label style="color: blue; font-weight: bold">SMS auth/verification section</label></td>
                        </tr>
                    </th>
                    <tr>

                        <th><label for="email_service">SMS Authentication email service https://mxt.smsglobal.com for example(@email.smsglobal.com)</label></th>

                        <td><input type="text" class="input-text form-control" name="email_service"

                                   value="<?php echo !empty($_POST['email_service'])? $_POST['email_service']: self::$email_service;?>"/>

                        </td>

                    </tr>

                    <tr>

                        <th><label for="login_service">SMS Authentication login account. FOR DEVELOPER</label></th>

                        <td><input type="text" class="input-text form-control" name="login_service"

                                   value="<?php echo !empty($_POST['login_service'])? $_POST['login_service']: self::$login_service;?>"/>

                        </td>

                    <tr>

                        <th><label for="password_service">SMS Authentication password account. FOR DEVELOPER</label></th>

                        <td><input type="password" class="input-text form-control" name="password_service"

                                   value="<?php echo !empty($_POST['password_service'])? $_POST['password_service']: self::$password_service;?>"/>

                        </td>

                    <tr>

                        <th><label for="name_sender">SMS Name-sender </label></th>

                        <td><input type="text" class="input-text form-control" name="name_sender"

                                   value="<?php echo !empty($_POST['name_sender'])? $_POST['name_sender']: self::$name_sender;?>"/>

                        </td>

                    </tr>

                    <tr>

                        <th><label for="phone_user_meta_key" style="color: red;font-weight: bold;">SMS Authentication 'option metakey for user phone number in wd db'. FOR DEVELOPER</label></th>

                        <td><input type="text" class="input-text form-control" name="phone_user_meta_key" title="default value 'user_registration_number_box_1529446202'"

                                   value="<?php echo !empty($_POST['phone_user_meta_key'])? $_POST['phone_user_meta_key']: self::$phone_user_meta_key;?>"/>

                        </td>

                    </tr>





                </table>

                <input class="button button-primary" type="submit" name="save" value="Save changes"/>
                <?php wp_nonce_field('name_of_my_check_nonces','check_of_nonce_field');?>
            </form>

            <?php
            add_filter('admin_footer_text', array($this, 'IVD_footer_admin_text'));//change admin label bottom
        }
      /*
       *  Hide admin panel top if not admin
       */
        public function IVD_hide_admin_bar(){
            if( !empty(get_current_user())):

                show_admin_bar(false);

            endif;
        }


       public function IVD_custom_user_profile_fields( $user )

        {

            $reflink = esc_url(home_url() . '?ref=' . $user->ID);

            $counter = sanitize_text_field(get_user_meta(sanitize_text_field($_GET['user_id']),'counter',true));

            $verify_status=get_user_meta(sanitize_text_field($_GET['user_id']),'Verified_phone_by_sms',true);

            // $facebook_account=get_user_meta(sanitize_text_field$_GET['user_id']),'user_registrationfacebook_account',true);

            //$twitter_account=get_user_meta(sanitize_text_field$_GET['user_id']),'user_registrationtwitter_account',true);

            //$telegram_account=get_user_meta(sanitize_text_field$_GET['user_id']),'user_registration_telegram_account',true);



            echo '<h3 class="heading" style="color: #00a57d;">Client reward program account</h3>';



            ?>

            <hr style="height: 2px;">

            <table class="form-table">

                <tr>

                    <th><label for="reflink" style="color: blue">Referral link</label></th>

                    <td><input type="text" class="input-text form-control" readonly name="reflink" id="reflink_id" value="<?php echo esc_url($reflink); ?>"style="max-width: 500px;width: 100%; border: solid 1px blue"/></td>

                </tr>

                <tr>

                    <th><label for="units">AMOUNT UNITS</label></th>

                    <td><input type="number" class="input-text form-control" name="units" id="units_id" value="<?php echo sanitize_text_field(get_user_meta($_GET['user_id'],'units',true)); ?>"style="background: #7987a5;color: #ffffff" /></td>

                </tr>



                <tr>

                    <th><label for="counter">Count of referr</label></th>

                    <td><input type="number" class="input-text form-control"  min="0" name="counter" id="counter_id" value="<?php echo sanitize_text_field($counter); ?>"style="background: #00a57d;color: #ffffff" /></td>

                </tr>

                <tr>

                    <th><label for="verify">Status Phone Number (ONLY "OK"/"NO")</label></th>

                    <td><input type="text" class="input-text form-control"   name="verify" id="verify_id" value="<?php echo sanitize_text_field($verify_status); ?>"style="background: <?php if($verify_status=="OK")echo '#00a57d;'; else echo 'red;';?>color: #ffffff" /></td>

                </tr>

                <!--        <tr>-->

                <!--            <th><label for="facebook">Facebook acount</label></th>-->

                <!--            <td><input type="text" class="input-text form-control"   name="facebook" id="facebook_id" value="--><?php //echo sanitize_text_field($facebook_account); ?><!--"style="background:royalblue; color: #ffffff" /></td>-->

                <!--        </tr>-->

                <!--        <tr>-->

                <!--            <th><label for="twitter">Twitter acount</label></th>-->

                <!--            <td><input type="text" class="input-text form-control"   name="twitter" id="twitter_id" value="--><?php //echo sanitize_text_field($twitter_account); ?><!--"style="background:royalblue;color: #ffffff" /></td>-->

                <!--        </tr>-->

                <!--    <tr>-->

                <!--            <th><label for="telegram">Telegram  acount</label></th>-->

                <!--            <td><input type="text" class="input-text form-control"   name="telegram" id="telegram_id" value="--><?php //echo sanitize_text_field($telegram_account); ?><!--"style="background:royalblue; color: #ffffff" /></td>-->

                <!--        </tr>-->

            </table>

            <hr style="height: 2px;">

            <?php

        }

        /**
         *   @param User Id $user_id
         */
        public function IVD_save_custom_user_profile_fields( $user_id )

        {

            //$custom_data = $_POST['reflink'];

            // update_user_meta( $user_id, 'reflink', $custom_data );

            $custom_data_units = sanitize_text_field($_POST['units']);

            update_user_meta($user_id, 'units', $custom_data_units );

            $custom_data_counter = sanitize_text_field($_POST['counter']);

            update_user_meta($user_id, 'counter', $custom_data_counter );

            $custom_verify_status = sanitize_text_field($_POST['verify']);

            update_user_meta($user_id, 'Verified_phone_by_sms', $custom_verify_status );



    //    $facebook = sanitize_text_field($_POST['facebook']);

    //    update_user_meta($user_id, 'facebook_account', $facebook );

    //    $twitter = sanitize_text_field($_POST['twitter']);

    //    update_user_meta($user_id, 'twitter_account', $twitter );

    //    $telegram = sanitize_text_field($_POST['telegram']);

    //    update_user_meta($user_id, 'telegram_account', $telegram );





        }

        public function IVD_footer_admin_text()
        {
            echo 'Develop <a href="mailto:vanjok137@gmail.com" target="_blank" title="send message to vanjok137@gmail.com">Ivan Developer</a> thank you for using';
            wp_enqueue_style('admin_style',IVD_PLUGIN_URL_REFERRER.'assets/style.css');
        }

}

