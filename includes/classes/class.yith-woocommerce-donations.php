<?php
if( !defined( 'ABSPATH' ) )
    exit;

if( !class_exists( 'YITH_WC_Donations' ) ){

    class YITH_WC_Donations
    {

        protected $_donation_id;
        protected static $_instance;
        protected $_panel;
        protected $_panel_page;
        protected $_official_documentation;
        protected $_premium_landing_url;
        protected $_premium_live_demo;
        protected $_premium;
        protected $_suffix;
        protected $_messages;

        public function __construct()
        {

            //Init class attributes
            $this->_panel = null;
            $this->_panel_page = 'yith_wc_donations';
            $this->_official_documentation = 'http://yithemes.com/docs-plugins/yith-donations-for-woocommerce';
            $this->_premium_landing_url = 'http://yithemes.com/themes/plugins/yith-donations-for-woocommerce/';
            $this->_premium_live_demo   =   'http://plugins.yithemes.com/yith-donations-for-woocommerce/';
            $this->_premium = 'premium.php';
            $this->_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';


            // Load Plugin Framework
            add_action('after_setup_theme', array($this, 'plugin_fw_loader'), 1);
            //Add action links
            add_filter('plugin_action_links_' . plugin_basename(YWCDS_DIR . '/' . basename(YWCDS_FILE)), array($this, 'action_links'));
            //Add row meta
            add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 4);

            add_action( 'init', array( $this, 'init_ywds_plugin'));

            add_action( 'admin_menu', array($this, 'add_yith_donations_menu' ), 5 );
            add_action('woocommerce_before_add_to_cart_button', array($this, 'add_form_donation'), 35);

            add_action('wp_enqueue_scripts', array($this, 'add_free_frontend_style_script'));
            //Add menu field under YITH_PLUGIN
            add_action( 'yith_wc_donations_premium', array( $this, 'premium_tab' ) );

            add_filter('woocommerce_is_purchasable', array($this, 'set_donation_purchasable'), 10, 2 );

           add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'get_cart_donation_item_from_session' ), 11, 2 );
           add_filter( 'woocommerce_add_cart_item', array( $this, 'add_cart_donation_item' ), 11, 1 );

           add_filter( 'woocommerce_cart_item_name', array( $this, 'print_cart_item_donation' ), 10 ,3 );

            add_action( 'woocommerce_add_order_item_meta', array( $this, 'add_order_item_meta' ), 10, 3 );
            add_filter( 'woocommerce_order_item_name', array( $this, 'print_donation_in_order' ), 10, 2 );


            add_action( 'wp_ajax_ywcds_add_donation', array( $this, 'ywcds_add_donation_ajax' ) );
            add_action( 'wp_ajax_nopriv_ywcds_add_donation', array( $this, 'ywcds_add_donation_ajax' ) );

            add_action( 'wp_loaded', array( $this, 'add_donation_single_product' ) , 25 );
            add_action( 'wp_loaded', array( $this, 'ywcds_add_donation'), 25 );


            if (is_admin()) {

                add_action('admin_menu', array($this, 'add_yith_donations_menu'), 5);
                add_action('admin_enqueue_scripts', array($this, 'add_free_admin_style_script'));
                $this->_include();
                add_action('woocommerce_admin_field_ajax-products', 'YWCDS_Ajax_Products::output');
                add_action('woocommerce_admin_field_donation-product-link', 'YWCDS_Donation_Product_Link::output');
            }

            add_action('widgets_init', array($this, 'register_donations_widget'));

            $this->_donation_id = get_option('_ywcds_donation_product_id');


        }

        /** return single instance of class
         * @author YIThemes
         * @since 1.0.0
         * @return YITH_WC_Donations
         */
        public static function get_instance()
        {

            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function plugin_fw_loader()
        {
            if (!defined('YIT') || !defined('YIT_CORE_PLUGIN')) {
                require_once(YWCDS_DIR . 'plugin-fw/yit-plugin.php');
            }
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed
         * @use plugin_action_links_{$plugin_file_name}
         */
        public function action_links($links)
        {

            $links[] = '<a href="' . admin_url("admin.php?page={$this->_panel_page}") . '">' . __('Settings', 'ywcds') . '</a>';
            $premium_live_text = defined( 'YWCDS_FREE_INIT' ) ?  __( 'Premium live demo', 'ywcds' ) : __( 'Live demo', 'ywcds' );

            $links[] = '<a href="'.$this->_premium_live_demo.'" target="_blank">'.$premium_live_text.'</a>';

            if ( defined( 'YWCDS_FREE_INIT' ) ) {
                  $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'ywcds' ) . '</a>';
              }

            return $links;
        }

        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use plugin_row_meta
         */
        public function plugin_row_meta($plugin_meta, $plugin_file, $plugin_data, $status)
        {
            /* if ( ( defined( 'YWCDS_INIT' ) && ( YWCDS_INIT == $plugin_file ) ) ||
                 ( defined( 'YWCDS_FREE_INIT' ) && ( YWCDS_FREE_INIT == $plugin_file ) )
             ) {

                    $plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __( 'Plugin Documentation', 'ywcds' ) . '</a>';
             }*/

            return $plugin_meta;
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri()
        {
            return defined('YITH_REFER_ID') ? $this->_premium_landing_url . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing_url .'?refer_id=1030585';
        }

        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  void
         */
        public function premium_tab()
        {
            $premium_tab_template = YWCDS_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if (file_exists($premium_tab_template)) {
                include_once($premium_tab_template);
            }
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function add_yith_donations_menu()
        {
            if ( !empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs = apply_filters('ywcds_add_premium_tab', array(
                'settings' => __('Settings', 'ywcca'),
                'premium-landing'   =>      __( 'Premium Version', 'ywcds' )
            ));

            $args = array(
                'create_menu_page' => true,
                'parent_slug' => '',
                'page_title' => __('Donations', 'ywcds'),
                'menu_title' => __('Donations', 'ywcds'),
                'capability' => 'manage_options',
                'parent' => '',
                'parent_page' => 'yit_plugin_panel',
                'page' => $this->_panel_page,
                'admin-tabs' => $admin_tabs,
                'options-path' => YWCDS_DIR . '/plugin-options'
            );

            $this->_panel = new YIT_Plugin_Panel_WooCommerce($args);
        }

        /**include custom woocommerce field
         * @author YIThemes
         * @since 1.0.0
         *
         */
        private function _include()
        {
            include_once(YWCDS_TEMPLATE_PATH . '/admin/ajax-products.php');
            include_once(YWCDS_TEMPLATE_PATH . '/admin/donation-product-link.php');
        }

        /**include admin style and script
         * @author YIThemes
         * @since 1.0.0
         */
        public function add_free_admin_style_script()
        {

            wp_register_script('ywcds_free_admin', YWCDS_ASSETS_URL . 'js/ywcds_free_admin' . $this->_suffix . '.js', array('jquery'), '1.0.0', true);
            wp_enqueue_script('ywcds_free_admin');

            $ywcds_localize_script = array(
                'i18n_matches_1' => _x('One result is available, press enter to select it.', 'enhanced select', 'woocommerce'),
                'i18n_matches_n' => _x('%qty% results are available, use up and down arrow keys to navigate.', 'enhanced select', 'woocommerce'),
                'i18n_no_matches' => _x('No matches found', 'enhanced select', 'woocommerce'),
                'i18n_ajax_error' => _x('Loading failed', 'enhanced select', 'woocommerce'),
                'i18n_input_too_short_1' => _x('Please enter 1 or more characters', 'enhanced select', 'woocommerce'),
                'i18n_input_too_short_n' => _x('Please enter %qty% or more characters', 'enhanced select', 'woocommerce'),
                'i18n_input_too_long_1' => _x('Please delete 1 character', 'enhanced select', 'woocommerce'),
                'i18n_input_too_long_n' => _x('Please delete %qty% characters', 'enhanced select', 'woocommerce'),
                'i18n_selection_too_long_1' => _x('You can only select 1 item', 'enhanced select', 'woocommerce'),
                'i18n_selection_too_long_n' => _x('You can only select %qty% items', 'enhanced select', 'woocommerce'),
                'i18n_load_more' => _x('Loading more results&hellip;', 'enhanced select', 'woocommerce'),
                'i18n_searching' => _x('Searching&hellip;', 'enhanced select', 'woocommerce'),
                'ajax_url' => admin_url('admin-ajax.php'),
                'search_products_nonce' => wp_create_nonce('search-products'),

            );

            wp_localize_script('ywcds_free_admin', 'ywcds_admin_i18n', $ywcds_localize_script);
        }

        /**include user style and script
         * @author YIThemes
         * @since 1.0.0
         */
        public function add_free_frontend_style_script()
        {

            wp_register_script('ywcds_free_frontend', YWCDS_ASSETS_URL . 'js/ywcds_free_frontend' . $this->_suffix . '.js', array('jquery'), '1.0.0', false);
            wp_enqueue_script('ywcds_free_frontend');

            $yith_wcds_frontend_l10n = array(
                'ajax_url' => admin_url('admin-ajax.php', is_ssl() ? 'https' : 'http'),
                'is_user_logged_in' => is_user_logged_in(),
                'ajax_loader_url' => YWCDS_ASSETS_URL . 'assets/images/ajax-loader.gif',
                'actions' => array(
                    'add_donation_to_cart' => 'ywcds_add_donation',
                ),
                'messages' => $this->_messages
            );

            wp_localize_script('ywcds_free_frontend', 'yith_wcds_frontend_l10n', $yith_wcds_frontend_l10n);

            wp_enqueue_style('ywcds_style_free_frontend', YWCDS_ASSETS_URL . 'css/ywcds_free_frontend.css');

        }

        /**create YITH Product Donation and init default messages
         * @author YIThemes
         * @since 1.0.0
         */
        public function init_ywds_plugin()
        {

            $donation_id = get_option('_ywcds_donation_product_id', -1);

            if ($donation_id == -1) {

                $args = array(
                    'post_author' => get_current_user_id(),
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'post_title' => __('YITH Donations for WooCommerce', 'ywcds'),
                    'post_content' => ''
                );

                $donation_id = wp_insert_post($args);

                /*Update the options meta of our donation*/
                update_post_meta($donation_id, '_stock_status', 'instock');
                update_post_meta($donation_id, '_tax_status', 'none');
                update_post_meta($donation_id, '_tax_class', 'zero-rate');
                update_post_meta($donation_id, '_visibility', 'hidden');
                update_post_meta($donation_id, '_stock', '');
                update_post_meta($donation_id, '_virtual', 'yes');
                update_post_meta($donation_id, '_featured', 'no');
                update_post_meta($donation_id, '_manage_stock', 'no');
                update_post_meta($donation_id, '_sold_individually', 'yes');
                update_post_meta($donation_id, '_sku', 'yith-wc-donations');
                update_option('_ywcds_donation_product_id', $donation_id);
            }

            $this->_messages = $this->_init_messages();

        }

        /**init messages default
         * @author YIThemes
         * @since 1.0.0
         * @return mixed|void
         */
        private function _init_messages()
        {

            $messages = array(
                'no_number' => __('Please enter a valid value', 'ywcds'),
                'empty' => __('Please enter a number', 'ywcds'),
                'already' => __('You have already added a donation to cart', 'ywcds'),
                'success' => __('Thanks for your donation', 'ywcds'),
                'text_button' => __( 'Add donation', 'ywcds' ),
                'negative'  =>  __( 'Please enter a number >0', 'ywcds' )
            );

            return apply_filters('ywcds_init_messages', $messages);
        }

        /**print from donation, in single page product/s
         * @author YIThemes
         * @since 1.0.0
         */
        public function add_form_donation()
        {
            $product_ass_id = get_option( 'ywcds_product_donation' );
            global $product;

            if ( empty( $product_ass_id ) || $product->id != $product_ass_id )
                return;

            $args = array(
                'message_for_donation' => get_option( 'ywcds_message_for_donation' ),
                'product_id' => $product->id,
            );
            echo yith_wcds_get_template( 'add-donation-form-single-product.php', $args, true );
        }


        public function add_donation_single_product(){


            if( isset( $_REQUEST['amount_single_product'] ) && $_REQUEST['amount_single_product']!='' && isset( $_REQUEST['add-to-cart'] ) ){

                $product_id =   $_REQUEST['add-to-cart'];
                $amount     =   $_REQUEST['amount_single_product'];
                $res    =   $this->add( $product_id, '',1, $amount );

            }
        }

        public function add( $product_id, $variation_id=-1, $quantity=1, $amount)
        {
            if ( !empty( $amount ) ) {


                if (!is_numeric($amount))
                    return 'no_number';

                $amount = floatval($amount);

                if ( $amount != null && $amount > 0 ) {

                    $cart_item_data =   array(
                        'ywcds_amount'      =>  $amount,
                        'ywcds_product_id'  =>  $product_id != $this->_donation_id ?   $product_id  :   -1 ,
                        'ywcds_variation_id'    =>  $variation_id,
                        'ywcds_data_added'      =>  date("Y-m-d H:i:s"),
                        'ywcds_quantity'        =>  $quantity
                    );

                    WC()->cart->add_to_cart( $this->_donation_id, 1, '', array(), $cart_item_data );

                   if( $product_id != $this->_donation_id )
                        wc_add_notice( $this->get_message('success') );

                    return 'true';

                }
                else {

                    return 'negative';
                }

            } else {
                return 'empty';
            }
        }



        public function ywcds_add_donation(){

            if (!defined('DOING_AJAX') || !DOING_AJAX) {
                if ( isset( $_GET['add_donation_to_cart'] ) ) {
                    $product_id = $_GET['add_donation_to_cart'];
                    $amount = isset( $_GET['ywcds_amount'] ) ? $_GET['ywcds_amount'] : '' ;
                    $this->add( $product_id,'',1, $amount );

                }
            }
        }


        /*
         * adjust the product based on cart session data
         * @since 1.0
         */
        public function get_cart_donation_item_from_session( $cart_item, $values ) {


                if ( $cart_item['product_id']== $this->_donation_id && isset( $values['ywcds_amount'] ) && !empty( $values['ywcds_amount'] ) ) {

                    $cart_item['ywcds_amount'] = $values['ywcds_amount'];
                    $cart_item['ywcds_product_id'] = isset( $values['ywcds_product_id'] ) ? $values['ywcds_product_id'] : -1 ;
                    $cart_item['ywcds_variation_id']    =  isset( $values['ywcds_variation_id'] ) ?  $values['ywcds_variation_id'] : '' ;
                    $cart_item['ywcds_quantity']        = isset( $values['ywcds_quantity'] ) ?  $values['ywcds_quantity'] : '';
                    $cart_tem['ywcds_data_added']       =   isset( $values['ywcds_data_added'] )    ?   $values['ywcds_data_added'] : '';

                    $cart_item = $this->add_cart_donation_item($cart_item);
                }


            return $cart_item;
        }

        /*
         * change the price of the item in the cart
         * @since 1.0
         */
        public function add_cart_donation_item( $cart_item ) {

            if ( $cart_item['product_id'] == $this->_donation_id ){


               $cart_item['data']->price = $cart_item['ywcds_amount'];
           }

            return $cart_item;
        }

        public function add_order_item_meta( $item_id, $values, $cart_item_key ){

            $cart_item =    WC()->cart->get_cart_item( $cart_item_key );

            if( isset( $cart_item['ywcds_amount'] ) ){

                $product_ass_id =   !empty( $cart_item['ywcds_variation_id'] )?  $cart_item['ywcds_variation_id']   :   $cart_item['ywcds_product_id'];

                if( $product_ass_id!=-1 ) {
                    $product = wc_get_product($product_ass_id);

                    $donation_name = sprintf(__('Donation ( %s )', 'ywcds'), $product->get_title());

                    wc_add_order_item_meta($item_id, '_ywcds_donation_name', $donation_name);
                }

            }



        }

        public function print_donation_in_order( $name, $item ){

            if( isset( $item['item_meta']['_ywcds_donation_name'] ) ){

                return $item['item_meta']['_ywcds_donation_name'][0];
            }

            return $name;
        }

        /**
         *
         */
        public function print_cart_item_donation( $product_title, $cart_item, $cart_item_key ){

            $product_id =   $cart_item['product_id'];

            if( $product_id ==  $this->_donation_id ){

                $product_ass_id =   !empty( $cart_item['ywcds_variation_id']) ? $cart_item['ywcds_variation_id'] : $cart_item['ywcds_product_id'];

                if( $product_ass_id!=-1 ) {
                    $product = wc_get_product($product_ass_id);

                    return 'Donation( ' . $product->get_title() . ' )';
                }
                return $product_title;

            }
            return $product_title;
        }



        public function ywcds_add_donation_ajax()
        {
            if (    isset(  $_GET['add_donation_to_cart'] )   ) {
                $product_id = $_GET['add_donation_to_cart'];
                $amount = $_GET['ywcds_amount'];
                $result = $this->add( $product_id,'',1, $amount );
                $message = '';

                switch ($result) {

                    case 'no_number':
                        $message = $this->_messages['no_number'];
                        break;

                    case 'empty':
                        $message = $this->_messages['empty'];
                        break;

                    case 'already'  :
                        $message = $this->_messages['already'];
                        break;

                    case 'negative':
                        $message    =   $this->_messages['negative'];
                        break;
                    default :
                        $message = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', wc_get_page_permalink('cart'), __('View Cart', 'woocommerce'), $this->_messages['success']);
                        break;
                }

                if ($result == 'true')
                    WC_AJAX::get_refreshed_fragments();
                else
                    wp_send_json(
                        array(
                            'result' => $result,
                            'message' => $message
                        )
                    );
            }
        }

        public function set_donation_purchasable($purchasable, $product)
        {
            $donation_id = get_option('_ywcds_donation_product_id');

            if ( $product->id == $donation_id )
                return true;

            return $purchasable;
        }


        public function register_donations_widget()
        {

            register_widget('YITH_Donations_Form_Widget');
        }

        public function get_message($key)
        {

            return $this->_messages[$key];
        }


    }
}