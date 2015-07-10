/**
 * Created by Your Inspiration on 30/06/2015.
 */

jQuery(document).ready( function( $ ) {

    var add_donation_to_cart    =   function ( el, prod ,val ){

        var data ={
            add_donation_to_cart : prod,
            ywcds_amount         : val,
            action               : yith_wcds_frontend_l10n.actions.add_donation_to_cart
        }

        var current_form    =  el.parents('.ywcds_form_container');
        $.ajax({
            type: 'GET',
            url: yith_wcds_frontend_l10n.ajax_url,
            data: data,
            dataType: 'json',
            beforeSend: function(){
               current_form.find( '.ajax-loading' ).css( 'visibility', 'visible' );
            },
            complete: function(){
                current_form.find( '.ajax-loading' ).css( 'visibility', 'hidden' );
            },
            success: function( response ) {

                var this_page = window.location.toString();

                this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );
                var message_container   =   current_form.find('.ywcds_message');

                if( response.fragments ) {
                    update_cart(el, this_page, response);

                    message_container.removeClass('woocommerce-error');

                    if( typeof ywcds_params!=='undefined' && typeof ywcds_params.donation_in_cart !== 'undefined' )
                        ywcds_params.donation_in_cart   =   1;

                    var view_cart   =   '';
                    // View cart text
                    if ( ! wc_add_to_cart_params.is_cart && el.parent().find( '.added_to_cart' ).size() === 0 ) {
                        el.after( ' <a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' +
                        wc_add_to_cart_params.i18n_view_cart + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>' ) ;
                    }
                    message_container.html( yith_wcds_frontend_l10n.thanks_message );


                }
                else {

                    var response_result = response.result,
                        response_message = response.message;

                        current_form.find('.ywcds_amount').css('border', '1px solid red');
                        message_container.addClass('woocommerce-error');
                        message_container.html(response_message);
                }

                message_container.show();

            }
        });

    }

    var update_cart             =   function( el, this_page, response){

        fragments   =   response.fragments;
        cart_hash   =   response.cart_has;
        // Block fragments class
        if ( fragments ) {
            $.each( fragments, function( key, value ) {
                $( key ).addClass( 'updating' );
            });
        }

        // Block widgets and fragments
        $( '.shop_table.cart, .updating, .cart_totals' ).fadeTo( '400', '0.6' ).block({
            message: null,
            overlayCSS: {
                opacity: 0.6
            }
        });

        // Changes button classes
        el.addClass( 'added' );



        // Replace fragments
        if ( fragments ) {
            $.each( fragments, function( key, value ) {
                $( key ).replaceWith( value );
            });
        }

        // Unblock
        $( '.widget_shopping_cart, .updating' ).stop( true ).css( 'opacity', '1' ).unblock();

        // Cart page elements
        $( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function() {

            $( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

            $( 'body' ).trigger( 'cart_page_refreshed' );
        });

        $( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
            $( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
        });
    }

    $(document).on('click', '.ywcds_submit', function( ev ){

        var t           =       $(this),
            form        =       t.parents('#ywcds_add_donation_form'),
            amount      =       form.find('.ywcds_amount').val(),
            product_id  =       form.find('.ywcds_product_id').val();

        ev.preventDefault();

        add_donation_to_cart( t,product_id,amount );

        return false;

    })
});