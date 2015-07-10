<?php
if( !defined( 'ABSPATH' ) )
    exit;


$setting    =    array(

    'settings'  =>  array(
        'section_general_settings'     => array(
            'name' => __( 'General settings', 'ywcds' ),
            'type' => 'title',
            'id'   => 'ywcds_section_general'
        ),

        'projecy_name'  =>  array(
            'name'  =>  __( 'Project Name', 'ywcds'),
            'desc'  =>  __( 'Enter your Donation Project name', 'ywcds' ),
            'type'  =>  'text',
            'id'    =>  'ywcds_project_title',
            'std'   =>  __( 'Project 1', 'ywcds' ),
            'default'   =>  __( 'Project 1', 'ywcds' ),
        ),

        'select_product_for_donation'   =>  array(
            'type'          =>  'ajax-products',
            'id'            =>  'ywcds_product_donation',
            'name'          =>  __( 'Select a product', 'ywcds' ),
            'desc'          =>  __( 'Choose a product to associate with the donation', 'ywcds' ),
            'ajax_action'   =>  'woocommerce_json_search_products',
            'placeholder'  =>  __( 'Search for a product', 'ywcds' ),
            'multiple'      =>  'false',
            'std'       =>  '',
            'default'   =>  ''
        ),

        'link_product_donation' =>  array(
            'name'  =>  '',
            'desc'  =>  '',
            'type'  =>  'donation-product-link',
            'link_text'  =>  __( 'click here', 'ywcds' ),
            'before_text'   =>  __( 'To let the plugin work correctly, a special product has been created to manage your donations. ', 'ywcds' ),
            'after_text'   =>  __(' Show it', 'ywcds' ),
            'post_id'   =>  get_option( '_ywcds_donation_product_id' ),
            'id'    =>  'ywcds_product_link'
        ),

        'section_general_settings_end' => array(
            'type' => 'sectionend',
            'id'   => 'ywtm_section_general_end'
        )
    )
);

return apply_filters( 'yith_wc_donations__free_settings', $setting );