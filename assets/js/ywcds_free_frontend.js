/**
 * Created by Your Inspiration on 30/06/2015.
 */

jQuery(document).ready( function( $ ) {

    var add_donation_to_cart    =   function ( el, val ){

        var data ={
            add_donation_to_cart : -1,
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
                        view_cart= ' <a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' +
                        wc_add_to_cart_params.i18n_view_cart + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>'  ;
                    }
                    message_container.html( yith_wcds_frontend_l10n.messages.success+ view_cart );


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

    $(document).on('click', '.ywcds_submit_widget', function( ev ){

        var t           =       $(this),
            form        =       t.parents('#ywcds_add_donation_form'),
            amount      =       form.find('.ywcds_amount').val();

        ev.preventDefault();

        add_donation_to_cart( t,amount );
        return false;

    })

    $(document).on('click', '.single_add_to_cart_button', function( el ){

        var t                       =   $(this),
            form                    =   $(document).find('#ywcds_add_donation_form_single_product'),
            amount_single_product   =   form.find('.ywcds_amount_single_product'),
            is_obligatory           =   form.data( 'donation_is_obligatory'),
            min                     =   form.data('min_donation'),
            max                     =   form.data( 'max_donation'),
            woocommerce_breadcrumb  =   $(document).find('.woocommerce-breadcrumb'),
            error_message           =   '<div class="woocommerce-error">';



        if( form.length ){

            $('.woocommerce-error, .woocommerce-message').remove();

            var check   =   check_amount( amount_single_product.val(),min, max, is_obligatory );

            if( check!= 'ok' ) {

                switch (check) {

                    case 'nan' :
                        error_message += yith_wcds_frontend_l10n.messages.no_number + '</div>';
                        break;
                    case 'less_zero' :
                        error_message += yith_wcds_frontend_l10n.messages.negative + '</div>';
                        break;
                    case 'empty':
                        error_message += yith_wcds_frontend_l10n.messages.obligatory + '</div>';
                        break;
                    case 'min'  :
                        error_message += yith_wcds_frontend_l10n.messages.min_don + '</div>';
                        break;
                    case 'max'  :
                        error_message += yith_wcds_frontend_l10n.messages.max_don + '</div>';
                        break;

                }

                woocommerce_breadcrumb.after(error_message);
                $(document).scrollTop(0);
                el.preventDefault();
                return false;
            }
        }

    });

    var check_amount    =   function( value, min, max, is_obligatory ){

        if( isNaN( value ) )
            return 'nan';

        if( value=='' && is_obligatory )
            return 'empty';

        if( value<0 )
            return 'less_zero';

        if( value!='' &&( min!='' && value<min ) )
            return 'min';

        if( value!='' && ( max!='' && value>max ) )
            return 'max';

        return 'ok'
    }
});