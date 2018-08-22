<?php

class IVD_Safety
{
    /**
     * Safety constructor.
     * @param bool $disallow_file_edit_mode
     */
    public function __construct($disallow_file_edit_mode=false)
    {
        if ($disallow_file_edit_mode == true) {
            define('DISALLOW_FILE_EDIT', true);
        }
        add_filter('init', array($this, 'IVD_my_registration_page_redirect'));
        add_filter('init', array($this, 'IVD_my_lost_password_page_redirect'));
        //add_action('init', array($this, 'IVD_check_test'));//for debug use hook instead 'init'
        remove_action('wp_head', 'wp_generator');//hide Wp version
        add_action( 'parse_query',array($this, 'IVD_wpb_filter_query') );
        add_filter( 'get_search_form', array($this,create_function( '$a', "return null;" )) );
        add_action( 'widgets_init', array($this,'IVD_remove_search_widget') );
        add_filter('the_generator', array($this,'__return_empty_string'));///hide Wp version
        add_filter('style_loader_src', array($this,'IVD_secure_remove_wp_ver_css_js'), 9999);
        add_filter('script_loader_src', array($this,'IVD_secure_remove_wp_ver_css_js'), 9999);

    }

    // Redirect Registration Page
    public function IVD_my_registration_page_redirect()
    {
        global $pagenow;

        if ((strtolower($pagenow) == 'wp-login.php') && (strtolower($_GET['action']) == 'register')) {
            wp_redirect(home_url('/registration/'));
        }
    }

    // Redirect Lost password Page
    public function IVD_my_lost_password_page_redirect()
    {
        global $pagenow;

        if ((strtolower($pagenow) == 'wp-login.php') && (strtolower($_GET['action']) == 'lostpassword')) {
            wp_redirect(home_url('/my-account/lost-password/'));
        }
    }
    // include notice for debug code
    public function IVD_check_test()
    {
        error_reporting(2047);
        ini_set('display_errors', 1);
    }
    /*
     * Developer footer copyright
     */
    public function IVD_footer_admin_text()
    {
        echo 'Develop <a href="mailto:vanjok137@gmail.com" target="_blank">Ivan Developer</a> Thank you for using';
    }
    /*
     * Hide requests & redirect to home
     */
    public function IVD_wpb_filter_query( $query, $error = true ) {
        if ( is_search() ) {
            $query->is_search = false;
            $query->query_vars[s] = false;
            $query->query[s] = false;
            if ( $error == true )
                $query->is_404 = true;
        }
    }
    /*
     * Hide searc widget in front-end (removed in all templates)
     */
    public function IVD_remove_search_widget()
    {
        unregister_widget('WP_Widget_Search');
    }
    /*
     * Hide version Wp
     */
    public function IVD_secure_remove_wp_ver_css_js($src) {
        if(strpos($src, 'ver='))
            $src = remove_query_arg('ver', $src);
        return $src;
    }



}


