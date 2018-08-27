<?php
/*

Plugin Name: Referral system for users-IVD_debug
Description: Users can have units & to increase their
Version: 1.0
Author: Ivan Shcherbyna
Text Domain: referr-system
Domain Path: /languages
Domain: ivd-referral
License: GPLv3

*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
define('IVD_PLUGIN_URL_REFERRER',plugin_dir_url (__FILE__));

if ( !class_exists( 'IVD_Referrals' ) ) :
require_once __DIR__ . '/lib/class-menu.php';
require_once __DIR__ . '/lib/class-referrals.php';
require_once __DIR__ . '/lib/class-sms-verif.php';
require_once __DIR__ . '/lib/class-shotcodes.php';
require_once __DIR__ . '/lib/class-safety.php';

$admin_menu = new IVD_Admin_menu();
$referalSystem = new IVD_Referrals();
$safety_debug_mode= new IVD_Safety(true);
$shortcodes = new IVD_Shortcodes();


endif;