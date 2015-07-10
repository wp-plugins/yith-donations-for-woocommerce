<?php
if( !defined( 'ABSPATH' ) ){
    exit;
}

if( !class_exists( 'YWCDS_Ajax_Products' ) ){


    class YWCDS_Ajax_Products{
        public static function output( $option ){

            $placeholder    =   isset( $option['placeholder'] ) ? $option['placeholder'] : '';
            $multiple       =   isset( $option['multiple'] ) ?  $option['multiple'] : 'false';
            $action         =   isset( $option['ajax_action'] ) ? $option['ajax_action'] : '';
            $taxonomy       =   isset( $option['taxonomy'] )    ?   $option['taxonomy'] :   '';
            $product_ids =  explode( ',', get_option( $option['id']  ) ) ;

            $json_ids   =   array();

            foreach( $product_ids as $product_id ){

                $product = wc_get_product( $product_id );
                if( !empty( $product ) )
                    $json_ids[ $product_id ] = wp_kses_post( html_entity_decode( $product->get_formatted_name() ) );
            }

            ?>

            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr( $option['id'] ); ?>"><?php echo esc_html( $option['title'] ); ?></label>
                </th>
                <td class="forminp forminp-<?php echo sanitize_title( $option['type'] ) ?>">
                    <input type="hidden" style="width:80%;" class="ywcds_enhanced_select" id="<?php echo esc_attr( $option['id'] );?>" name="<?php echo esc_attr( $option['id'] );?>" data-placeholder="<?php echo $placeholder; ?>" data-action="<?php echo $action;?>" data-multiple="<?php echo $multiple;?>" data-selected="<?php echo esc_attr( json_encode( $json_ids ) ); ?>"
                           value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" />
                    <span class="description"><?php echo esc_html( $option['desc'] );?></span>
                </td>

            </tr>
        <?php
        }
    }
}