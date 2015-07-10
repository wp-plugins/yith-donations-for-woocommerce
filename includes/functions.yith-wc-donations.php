<?php

if( !defined( 'ABSPATH' ) )
    exit;

if( !function_exists( 'yith_wcds_locate_template' ) ) {
    /**
     * Locate the templates and return the path of the file found
     *
     * @param string $path
     * @param array $var
     * @return void
     * @since 1.0.0
     */
    function yith_wcds_locate_template( $path, $var = NULL ){
        global $woocommerce;

        if( function_exists( 'WC' ) ){
            $woocommerce_base = WC()->template_path();
        }
        elseif( defined( 'WC_TEMPLATE_PATH' ) ){
            $woocommerce_base = WC_TEMPLATE_PATH;
        }
        else{
            $woocommerce_base = $woocommerce->plugin_path() . '/templates/';
        }

        $template_woocommerce_path =  $woocommerce_base . $path;
        $template_path = '/' . $path;
        $plugin_path = YWCDS_TEMPLATE_PATH . '/' . $path;

        $located = locate_template( array(
            $template_woocommerce_path, // Search in <theme>/woocommerce/
            $template_path,             // Search in <theme>/
        ) );

        if( ! $located && file_exists( $plugin_path ) ){
            return apply_filters( 'yith_wcds_locate_template', $plugin_path, $path );
        }

        return apply_filters( 'yith_wcds_locate_template', $located, $path );
    }
}

if( !function_exists( 'yith_wcds_get_template' ) ) {
    /**
     * Retrieve a template file.
     *
     * @param string $path
     * @param mixed $var
     * @param bool $return
     * @return void
     * @since 1.0.0
     */
    function yith_wcds_get_template( $path, $var = null, $return = false ) {
        $located = yith_wcds_locate_template( $path, $var );


        if ( $var && is_array( $var ) )
            extract( $var );

        if( $return )
        { ob_start(); }

        // include file located
        include( $located );

        if( $return )
        { return ob_get_clean(); }
    }
}