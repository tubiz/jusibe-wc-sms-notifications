<?php
/*
	Plugin Name:			Jusibe SMS Notifications for WooCommerce
	Plugin URI: 			https://jusibe.com
	Description:			Send SMS order notifications to admins and customers from your WooCommerce store. Powered by Jusibe.com
	Author: 				Tunbosun Ayinla
	Author URI: 			https://bosun.me
	Version:                1.3.1
	WC requires at least:   3.0.0
	WC tested up to:        3.8
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

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
	return;
}

require_once JUSIBE_WC_SMS_DIR . '/includes/class-jusibe-sms.php';

if ( is_admin() ) {
	require_once JUSIBE_WC_SMS_DIR . '/includes/admin/class-jusibe-sms-admin.php';
}
