/**
 * Created by Your Inspiration on 30/06/2015.
 */

jQuery(document).ready(function($){

    var  getEnhancedSelectFormatString = function() {
        var formatString = {
            formatMatches: function( matches ) {
                if ( 1 === matches ) {
                    return ywcds_admin_i18n.i18n_matches_1;
                }

                return ywcds_admin_i18n.i18n_matches_n.replace( '%qty%', matches );
            },
            formatNoMatches: function() {
                return ywcds_admin_i18n.i18n_no_matches;
            },
            formatAjaxError: function( jqXHR, textStatus, errorThrown ) {
                return ywcds_admin_i18n.i18n_ajax_error;
            },
            formatInputTooShort: function( input, min ) {
                var number = min - input.length;

                if ( 1 === number ) {
                    return ywcds_admin_i18n.i18n_input_too_short_1;
                }

                return ywcds_admin_i18n.i18n_input_too_short_n.replace( '%qty%', number );
            },
            formatInputTooLong: function( input, max ) {
                var number = input.length - max;

                if ( 1 === number ) {
                    return ywcds_admin_i18n.i18n_input_too_long_1;
                }

                return ywcds_admin_i18n.i18n_input_too_long_n.replace( '%qty%', number );
            },
            formatSelectionTooBig: function( limit ) {
                if ( 1 === limit ) {
                    return ywcds_admin_i18n.i18n_selection_too_long_1;
                }

                return ywcds_admin_i18n.i18n_selection_too_long_n.replace( '%qty%', limit );
            },
            formatLoadMore: function( pageNumber ) {
                return ywcds_admin_i18n.i18n_load_more;
            },
            formatSearching: function() {
                return ywcds_admin_i18n.i18n_searching;
            }
        };

        return formatString;
    }
    var  loadEnhancedSelect =   function() {

        $( ':input.ywcds_enhanced_select' ).filter( ':not(.enhanced)' ).each( function() {
            var t   =   $(this);


            var select2_args = {
                allowClear:  t.data( 'allow_clear' ) ? true : false,
                placeholder: t.data( 'placeholder' ),
                minimumInputLength: t.data( 'minimum_input_length' ) ? t.data( 'minimum_input_length' ) : '3',
                escapeMarkup: function( m ) {
                    return m;
                },
                ajax: {
                    url:         ywcds_admin_i18n.ajax_url,
                    dataType:    'json',
                    quietMillis: 250,
                    data: function( term, page ) {

                        return {
                            term:     term,
                            action:   t.data( 'action' ) ,
                            security: ywcds_admin_i18n.search_products_nonce
                        };
                    },
                    results: function( data, page ) {

                        var terms = [];
                        if ( data ) {
                            $.each( data, function( id, text ) {
                                terms.push( { id: id, text: text } );
                            });
                        }
                        return { results: terms };
                    },
                    cache: true
                }
            };

            if ( t.data( 'multiple' ) === true ) {
                select2_args.multiple = true;
                select2_args.initSelection = function( element, callback ) {
                    var data     = $.parseJSON( element.attr( 'data-selected' ) );
                    var selected = [];

                    $( element.val().split( "," ) ).each( function( i, val ) {
                        selected.push( { id: val, text: data[ val ] } );
                    });
                    return callback( selected );
                };
                select2_args.formatSelection = function( data ) {
                    return '<div class="selected-option" data-id="' + data.id + '">' + data.text + '</div>';
                };
            } else {
                select2_args.multiple = false;
                select2_args.initSelection = function( element, callback ) {

                    var selected    = $.parseJSON( element.attr( 'data-selected' ) );
                    var data = {id: element.val(), text: selected[ element.val() ]};
                    return callback( data );
                };
            }

            select2_args = $.extend( select2_args, getEnhancedSelectFormatString() );
            t.select2( select2_args ).addClass( 'enhanced' );

        });

    }
    var  admin_field_init   =   function(){

        var check_field     =   $('#ywcds_check_product_for_donation'),
            select_field    =   $('#ywcds_product_donation');

        if( check_field.is( ":checked" ) )
            select_field.parents('tr').hide();
        else
            select_field.parents('tr').show();

        check_field.on('change', function(){

            var t   =   $(this);
            if( t.is( ":checked" ) )
                select_field.parents('tr').hide();
            else
                select_field.parents('tr').show();
        });
    }

    $('body').on('ywcds-enhanced-select-init', function () {
        loadEnhancedSelect();
    }).trigger( 'ywcds-enhanced-select-init' );


});