<?php
if( !defined( 'ABSPATH' ) )
    exit;

if( !class_exists( 'YWCDS_Donation_Product_Link' ) ){

    class YWCDS_Donation_Product_Link{

        public static function output( $option ){

            $link           =   isset( $option['link_text'] ) ? $option['link_text'] : '';
            $before_text    =   isset( $option['before_text'] ) ? $option['before_text'] : '';
            $after_text     =   isset( $option['after_text'] ) ? $option['after_text'] : '';
            $post_id        =   isset( $option['post_id'] ) ? $option['post_id'] : '';
            ?>
            <style>
                .forminp-donation-product-link{
                    font-size: 13px;
                    font-style: italic;
                    padding-left: 20px;
                }

            </style>

            <tr valign="top" >
                <td class="forminp forminp-<?php echo sanitize_title( $option['type'] ) ?>" colspan="2">
                  <?php edit_post_link(  $link, $before_text, $after_text, $post_id );?>
                </td>

            </tr>
<?php
        }
    }
}