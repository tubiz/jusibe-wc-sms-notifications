<?php
/**
 * Plugin Name: WooCommerce - Jusibe SMS Notifications
 * Plugin URI: http://bosun.me/jusibe-woocommerce-order-sms-notifications/
 * Description: Send SMS order notifications to admins and customers from your WooCommerce store. Powered by Jusibe.com
 * Author: Tunbosun Ayinla
 * Author URI: http://bosun.me
 * Version: 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! defined( 'JUSIBE_WC_SMS_FILE' ) ) {
	define( 'JUSIBE_WC_SMS_FILE', __FILE__ );
}
if ( ! defined( 'JUSIBE_WC_SMS_DIR' ) ) {
	define( 'JUSIBE_WC_SMS_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'JUSIBE_WC_SMS_URL' ) ) {
	define( 'JUSIBE_WC_SMS_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'JUSIBE_WC_SMS_BASENAME' ) ) {
	define( 'JUSIBE_WC_SMS_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
   return ;
}

require_once JUSIBE_WC_SMS_DIR . '/includes/class-jusibe-sms.php';

if( is_admin() ){
	require_once JUSIBE_WC_SMS_DIR . '/includes/admin/class-jusibe-sms-admin.php';
}
