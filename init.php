<?php
/**
 * Plugin Name: YITH Donations for WooCommerce
 * Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-donations/
 * Description: YITH Donations for WooCommerce allows you to add donation in your orders.
 * Version: 1.0.1
 * Author: YIThemes
 * Author URI: http://yithemes.com/
 * Text Domain: ywcds
 * Domain Path: /languages/
 *
 * @author Your Inspiration Themes
 * @package YITH Donations for WooCommerce
 * @version 1.0.1
 */

/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !defined( 'ABSPATH' ) ){
    exit;
}

if( !function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if( !function_exists( 'WC' ) ){

    function yith_ywcds_install_woocommerce_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'YITH Donations for WooCommerce is enabled but not effective. It requires WooCommerce in order to work.', 'ywcds' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'yith_ywcds_install_woocommerce_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;
}

if ( defined( 'YWCDS_PREMIUM' ) ) {
    function yith_ywcds_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'You can\'t activate the free version of YITH Donations for WooCommerce while you are using the premium one.', 'ywcds' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'yith_ywcds_install_free_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;
}


if ( !defined( 'YWCDS_VERSION' ) ) {
    define( 'YWCDS_VERSION', '1.0.1' );
}

if ( !defined( 'YWCDS_FREE_INIT' ) ) {
    define( 'YWCDS_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( !defined( 'YWCDS_FILE' ) ) {
    define( 'YWCDS_FILE', __FILE__ );
}

if ( !defined( 'YWCDS_DIR' ) ) {
    define( 'YWCDS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( !defined( 'YWCDS_URL' ) ) {
    define( 'YWCDS_URL', plugins_url( '/', __FILE__ ) );
}

if ( !defined( 'YWCDS_ASSETS_URL' ) ) {
    define( 'YWCDS_ASSETS_URL', YWCDS_URL . 'assets/' );
}

if ( !defined( 'YWCDS_TEMPLATE_PATH' ) ) {
    define( 'YWCDS_TEMPLATE_PATH', YWCDS_DIR . 'templates/' );
}

if ( !defined( 'YWCDS_INC' ) ) {
    define( 'YWCDS_INC', YWCDS_DIR . 'includes/' );
}

if( !defined('YWCDS_SLUG' ) ){
    define( 'YWCDS_SLUG', 'yith-woocommerce-donations' );
}

load_plugin_textdomain( 'ywcds', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


if( !function_exists( 'YITH_Donations' ) ) {

    function YITH_Donations()
    {
        require_once( YWCDS_INC . 'functions.yith-wc-donations.php' );
        require_once( YWCDS_INC .'widgets/class.yith-wc-donations-form-widget.php' );
        require_once( YWCDS_INC . 'classes/class.yith-woocommerce-donations.php' );

        if ( defined( 'YWCDS_PREMIUM' ) && file_exists( YWCDS_INC . 'classes/class.yith-woocommerce-donations-premium.php' ) ) {

            require_once( YWCDS_INC . 'functions.yith-wc-donations-premium.php' );
            require_once( YWCDS_INC . 'widgets/class.yith-wc-donations-summary-widget.php' );
            require_once( YWCDS_INC . 'shortcodes/class.yith-wc-donations-shortcode.php' );
            require_once( YWCDS_INC . 'classes/class.yith-custom-table.php' );
            require_once( YWCDS_INC . 'classes/class.yith-woocommerce-donations-premium.php' );
            return YITH_WC_Donations_Premium::get_instance();
        }

        return YITH_WC_Donations::get_instance();
    }
}


YITH_Donations();