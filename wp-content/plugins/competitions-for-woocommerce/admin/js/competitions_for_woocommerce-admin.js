(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function($){

		var calendar_image = '';

		if (typeof woocommerce_writepanel_params != 'undefined'){
		        calendar_image = woocommerce_writepanel_params.calendar_image;
		} else if (typeof woocommerce_admin_meta_boxes != 'undefined'){
		        calendar_image = woocommerce_admin_meta_boxes.calendar_image;
		}

	    jQuery('.datetimepicker').datetimepicker({
	        defaultDate: "",
	        dateFormat: "yy-mm-dd",
	        numberOfMonths: 1,
	        showButtonPanel: true,
	        showOn: "button",
	        buttonImage: calendar_image,
	        buttonImageOnly: true
	    });

    	var productType = jQuery('#product-type').val();
		if (productType=='competition'){
			jQuery('.show_if_simple').show();
			jQuery('.inventory_options').show();
			jQuery('#inventory_product_data ._manage_stock_field').addClass('hide_if_competition').hide();
			jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('hide_if_competition').hide();
			jQuery('#inventory_product_data ._sold_individually_field').addClass('hide_if_competition').hide();
			jQuery('#inventory_product_data ._stock_field ').addClass('hide_if_competition').hide();
			jQuery('#inventory_product_data ._backorders_field ').parent().addClass('hide_if_competition').hide();
			jQuery('#inventory_product_data ._stock_status_field ').addClass('hide_if_competition').hide();
			jQuery('#competition_tab .required').each(function(index, el) {
			    jQuery(this).attr("required", true);
		});
		} else {
			jQuery('#competition_tab .required').each(function(index, el) {
			    jQuery(this).attr("required", false);
			});
		}

    	jQuery('#product-type').on('change', function(){
	        if  (jQuery(this).val() =='competition'){
	            jQuery('.show_if_simple').show();
	            jQuery('.inventory_options').show();
	            jQuery('#inventory_product_data ._manage_stock_field').addClass('hide_if_competition').hide();
	            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('hide_if_competition').hide();
	            jQuery('#inventory_product_data ._sold_individually_field').addClass('hide_if_competition').hide();
	            jQuery('#inventory_product_data ._stock_field ').addClass('hide_if_competition').hide();
	            jQuery('#inventory_product_data ._backorders_field ').parent().addClass('hide_if_competition').hide();
	            jQuery('#inventory_product_data ._stock_status_field ').addClass('hide_if_competition').hide();
	            jQuery('#competition_tab .required').each(function(index, el) {
	                jQuery(this).attr("required", true);
	            });
	        } else {
	            jQuery('#competition_tab .required').each(function(index, el) {
	                jQuery(this).attr("required", false);
	            });
	        }
    	});

    	jQuery('label[for="_virtual"]').addClass('show_if_competition');

    	jQuery('label[for="_downloadable"]').addClass('show_if_competition');

	    jQuery('.competition-table .action a').on('click',function(event){
	        var logid = $(this).data('id');
	        var postid = $(this).data('postid');
	        var curent = $(this);
	        jQuery.ajax({
	        type : "post",
	        url : ajaxurl,
	        data : {action: "delete_competition_participate_entry", logid : logid, postid: postid, security: competitions_for_woocommerce.add_competition_answer_nonce,},
	        success: function(response) {
	               if (response === 'deleted'){
	                       curent.parent().parent().addClass('deleted').fadeOut('slow');
	               }
	           }
	        });
	        event.preventDefault();
	    });

    	jQuery('#competition-refund').on('click',function(event){
	        if ( window.confirm( woocommerce_admin_meta_boxes.i18n_do_refund ) ) {
	            var product_id = $(this).data('product_id');
	            var curent = $(this);
	            var $wrapper     = $('#competition' );
	            $( "#refund-status" ).empty();
		            $wrapper.block({
		                message: null,
		                overlayCSS: {
		                    background: '#fff',
		                    opacity: 0.6
		            }
	            });
	            jQuery.ajax({
	            type : "post",
	            url : ajaxurl,
	            data : {action: "competition_refund", product_id : product_id , security : competitions_for_woocommerce.competition_refund_nonce},
	            success: function(response) {
	                if(response.error){
	                     $( "#refund-status" ).append( '<div class="error notice"></div>');
	                    $.each(response.error, function(index, value) {
	                        $( "#refund-status .error" ).append( '<p class"error">'+index + ': ' +value + '</p>' );
	                    });
	                }
	                if(response.succes){
	                    $( "#refund-status" ).append( '<div class="updated  notice"></div>');
	                    $.each(response.succes, function(index, value) {
	                        $( "#refund-status .updated " ).append( '<li class"ok">'+index + ': ' +value + '</li>' );
	                    });
	                }
	                $wrapper.unblock();
	               }
	            });
	        }
	            event.preventDefault();
	    });


    	var competitionmaxwinners = jQuery('#_competition_num_winners').val();

	     if ( competitionmaxwinners > 1){
	        $('._competition_multiple_winner_per_user_field').show();
	      } else{
	        $('._competition_multiple_winner_per_user_field').hide();
	      }
	    if (jQuery('#_competition_use_pick_numbers').is(':checked') ){
	     	$('._competition_manualy_winners_field').show();
	    } else {
	    	$('._competition_manualy_winners_field').hide();
	    }
	    jQuery('#relistcompetition').on('click',function(event){
	            event.preventDefault();
	            jQuery('.relist_competition_dates_fields').toggle();
	    });
	    jQuery('#extendcompetition').on('click',function(event){
	            event.preventDefault();
	            jQuery('.extend_competition_dates_fields').toggle();
	    });

        $( document.body )
        	.on( 'wc_add_error_tip_competition', function( e, element, error_type ) {
            var offset = element.position();

            if ( element.parent().find( '.wc_error_tip' ).size() === 0 ) {
                element.after( '<div class="wc_error_tip ' + error_type + '">' + competitions_for_woocommerce[error_type] + '</div>' );
                element.parent().find( '.wc_error_tip' )
                    .css( 'left', offset.left + element.width() - ( element.width() / 2 ) - ( $( '.wc_error_tip' ).width() / 2 ) )
                    .css( 'top', offset.top + element.height() )
                    .fadeIn( '100' );
            }
	        })
	        .on( 'wc_remove_error_tip_competition', function( e, element, error_type ) {
	            element.parent().find( '.wc_error_tip.' + error_type ).remove();
	        })
	        .on( 'keyup change', '#_max_tickets.input_text[type=number]', function() {
	            var max_ticket_field = $( this ), min_ticket_field;

	            min_ticket_field = $( '#_min_tickets' );

	            var max_ticket    = parseInt( max_ticket_field.val());
	            var min_ticket = parseInt( min_ticket_field.val());

	            if ( max_ticket <= min_ticket ) {
	                $( document.body ).triggerHandler( 'wc_add_error_tip_competition', [ $(this), 'i18_max_ticket_less_than_min_ticket_error' ] );
	            } else {
	                $( document.body ).triggerHandler( 'wc_remove_error_tip_competition', [ $(this), 'i18_max_ticket_less_than_min_ticket_error' ] );
	            }
	        })
	         .on( 'keyup change focusout ', '#_competition_num_winners.input_text[type=number]', function() {
	            var competition_num_winners_field = $( this );
	            var competition_winers    = parseInt( competition_num_winners_field.val());

	            if ( competition_winers <= 0 || !competition_winers) {
	                $( document.body ).triggerHandler( 'wc_add_error_tip_competition', [ $(this), 'i18_minimum_winers_error' ] );
	            } else {
	                $( document.body ).triggerHandler( 'wc_remove_error_tip_competition', [ $(this), 'i18_minimum_winers_error' ] );
	            }


	              if ( competition_winers > 1){
	                $('._competition_multiple_winner_per_user_field').show();
	              } else{
	                $('._competition_multiple_winner_per_user_field').hide();
	              }
	        }).on( 'change', '#_competition_use_pick_numbers', function() {
	            if (jQuery('#_competition_use_pick_numbers').is(':checked') ){
	     			$('._competition_manualy_winners_field').show();
			    } else {
			    	$('._competition_manualy_winners_field').hide();
			    }
	        });

          $('button.add_competition_answer').on('click', function() {

	        var key = $('.competition_answers_wrapper input.competition_answer:last').data('answer-id');
	        if (typeof key == 'undefined') {
	            key = 1;
	        } else {
	            key = parseInt(key) + 1;
	        }
	        var $wrapper = $('#wc_competition_answers-tb');
	        var $attributes = $wrapper.find('.answers');
	        var product_type = $('select#product-type').val();
	        var data = {
	            action: 'add_answer',
	            security: competitions_for_woocommerce.add_competition_answer_nonce,
	            key: key,
	        };

	        $wrapper.block({
	            message: null,
	            overlayCSS: {
	                background: '#fff',
	                opacity: 0.6
	            }
	        });

	        $.post(woocommerce_admin_meta_boxes.ajax_url, data, function(response) {
	            $attributes.append(response);

	            $(document.body).trigger('wc-enhanced-select-init');

	            $wrapper.unblock();

	            $(document.body).trigger('woocommerce_added_add_competition_answer');
	        });

	        return false;
	    });


	    $('.competition_answers_wrapper').on('click', '.remove_row', function() {
	        if (window.confirm(competitions_for_woocommerce.remove_wcsbs)) {
	            var $parent = $(this).parent().parent();

	            $parent.find('select, input').val('');
	            $parent.hide();

	        }
	        return false;
	    });

	    var columns = [
	        null,
	        null, {
	            "visible": false
	        }, {
	            "visible": false
	        }, {
	            "visible": false
	        }, {
	            "visible": false
	        },{
	                "visible": false
	            },
	        null, {
	            "orderable": false
	        },
	    ];

	    if ((typeof $('#competition .competition-table th.answer') !== 'undefined' && $('#competition .competition-table th.answer').length && (typeof $('#competition .competition-table th.numbers') == 'undefined' || $('#competition .competition-table th.numbers').length == 0)) ||
	        (typeof $('#competition .competition-table th.numbers') !== 'undefined' && $('#competition .competition-table th.numbers').length && (typeof $('#competition .competition-table th.answer') == 'undefined' || $('#competition .competition-table th.answer').length == 0))
	    ) {
	        columns = [
	            null,
	            null, {
	                "visible": false
	            }, {
	                "visible": false
	            }, {
	                "visible": false
	            }, {
	                "visible": false
	            },{
	                "visible": false
	            },
	            null,
	            null, {
	                "orderable": false
	            },
	        ];
	    }
	    if (typeof $('#competition .competition-table th.answer') !== 'undefined' && $('#competition .competition-table th.answer').length && typeof $('#competition .competition-table th.numbers') !== 'undefined' && $('#competition .competition-table th.numbers').length) {
	        columns = [
	            null,
	            null, {
	                "visible": false
	            }, {
	                "visible": false
	            }, {
	                "visible": false
	            }, {
	                "visible": false
	            },{
	                "visible": false
	            },
	            null,
	            null,
	            null, {
	                "orderable": false
	            },
	        ];
	    }
	    $('#competition .competition-table').DataTable({
	        dom: 'lfBrtip',
	        "order": [0, 'desc'],
	        stateSave: true,
	        "pageLength": 20,
	        "columns": columns,
	        responsive: true,
	        buttons: [
	            'colvis', {
	                extend: 'csv',
	                exportOptions: {
	                    columns: 'th:not(:last-child)',
	                    columns: ':visible'
	                }
	            }, {
	                extend: 'excel',
	                exportOptions: {
	                    columns: 'th:not(:last-child)',
	                    columns: ':visible'
	                }
	            },

	        ],
	        "language": {
	            "sEmptyTable": competitions_for_woocommerce.datatable_language.sEmptyTable,
	            "sInfo": competitions_for_woocommerce.datatable_language.sInfo,
	            "sInfoEmpty": competitions_for_woocommerce.datatable_language.sInfoEmpty,
	            "sInfoFiltered": competitions_for_woocommerce.datatable_language.sInfoFiltered,
	            "sLengthMenu": competitions_for_woocommerce.datatable_language.sLengthMenu,
	            "sLoadingRecords": competitions_for_woocommerce.datatable_language.sLoadingRecords,
	            "sProcessing": competitions_for_woocommerce.datatable_language.sProcessing,
	            "sSearch": competitions_for_woocommerce.datatable_language.sSearch,
	            "sZeroRecords": competitions_for_woocommerce.datatable_language.sZeroRecords,
	            "oPaginate": {
	                "sFirst": competitions_for_woocommerce.datatable_language.oPaginate.sFirst,
	                "sLast": competitions_for_woocommerce.datatable_language.oPaginate.sLast,
	                "sNext": competitions_for_woocommerce.datatable_language.oPaginate.sNext,
	                "sPrevious": competitions_for_woocommerce.datatable_language.oPaginate.sPrevious
	            },
	            "oAria": {
	                "sSortAscending": competitions_for_woocommerce.datatable_language.oAria.sSortAscending,
	                "sSortDescending": competitions_for_woocommerce.datatable_language.oAria.sSortDescending,
	            }
	        }
	    });
	});


jQuery(document).ready(function($) {
    if (typeof $('#_competition_use_answers') !== 'undefined' && $('#_competition_use_answers').is(':checked')) {
        $('#wc_competition_answers-tb').show();
        $('.form-field._competition_only_true_answers_field').show();
        $("#_competition_question").prop('required', true);
    }
    if (typeof $('#_competition_use_pick_numbers') !== 'undefined' && $('#_competition_use_pick_numbers').length) {
        if ($('#_competition_use_pick_numbers').is(':checked')) {
            document.getElementById("_competition_pick_numbers_random").disabled = false;
        } else {
            document.getElementById("_competition_pick_numbers_random").disabled = true;
        }
    }
    $("#_competition_use_pick_numbers").on('change', function() {
        if (this.checked) {
            document.getElementById("_competition_pick_numbers_random").disabled = false;
        } else {
            document.getElementById("_competition_pick_numbers_random").disabled = true;
        }
    });

    if (typeof $('#_competition_pick_numbers_random') !== 'undefined' && $('#_competition_pick_numbers_random').length) {

        if ($('#_competition_pick_numbers_random').is(':checked')) {
            document.getElementById("_competition_pick_number_use_tabs").disabled = true;
            document.getElementById("_competition_pick_number_tab_qty").disabled = true;
            $('._competition_pick_number_use_tabs_field').hide();
            $('._competition_pick_number_tab_qty_field ').hide();
        } else {
            document.getElementById("_competition_pick_number_use_tabs").disabled = false;
            document.getElementById("_competition_pick_number_tab_qty").disabled = false;
            $('#_competition_pick_number_use_tabs-tb').show();
            $('._competition_pick_number_tab_qty_field ').show();
        }
    }
    $("#_competition_pick_numbers_random").on('change', function() {
        if (this.checked) {
            document.getElementById("_competition_pick_number_use_tabs").disabled = true;
            document.getElementById("_competition_pick_number_tab_qty").disabled = true;
            $('._competition_pick_number_use_tabs_field').hide();
            $('._competition_pick_number_tab_qty_field ').hide();
        } else {
            document.getElementById("_competition_pick_number_use_tabs").disabled = false;
            document.getElementById("_competition_pick_number_tab_qty").disabled = false;
            $('._competition_pick_number_use_tabs_field').show();
            $('._competition_pick_number_tab_qty_field ').show();
        }
    });


    $("#_competition_use_answers").on('change', function() {
        if (this.checked) {
            $('#wc_competition_answers-tb').slideDown('fast');
            $("#_competition_question").prop('required', true);
            $('.form-field._competition_only_true_answers_field').show();
        } else {
            $('#wc_competition_answers-tb').slideUp('fast');
            $("#_competition_question").prop('required', false);
            $('.form-field._competition_only_true_answers_field').hide();
        }
    });

    jQuery('.competition-files-table .action a').on('click',function(event){
        console.log('click');
        var logid = $(this).data('id');
        var postid = $(this).data('postid');
        var curent = $(this);
        jQuery.ajax({
        type : "post",
        url : ajaxurl,
        data : {action: "delete_competition_history_csv", logid : logid, postid: postid,  security: competitions_for_woocommerce.add_competition_answer_nonce },
        success: function(response) {
               if (response === 'deleted'){
                       curent.parent().parent().addClass('deleted').fadeOut('slow');
               }
           }
        });
        event.preventDefault();
    });




});




})( jQuery );
