(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {

		$(".competition-time-countdown").each(function(index) {

			var time = $(this).data('time');
			var format = $(this).data('format');
			var compact = false;

			if (format == '') {
				format = 'yowdHMS';
			}
			var etext = '';
			if ($(this).hasClass('future')) {
			   etext = '<div class="started">' + competitions_for_woocommerce_data.started + '</div>';
			} else {
			   etext = '<div class="over">' + competitions_for_woocommerce_data.finished + '</div>';

			}
			if (competitions_for_woocommerce_data.compact_counter == 'yes') {
				compact = true;
			} else {
				compact = false;
			}

			$(this).competitions_for_woocommerce_countdown({
				until: $.competitions_for_woocommerce_countdown.UTCDate(-(new Date().getTimezoneOffset()), new Date(time * 1000)),
				format: format,
				expiryText: etext,
				compact: compact
			});

		});

		$('form.cart input[name ="quantity"]:not(#qty_dip)').on('change', function() {
			var qty = $(this).val();
			var priceelement = $(this).closest('form').find('.atct-price');
			var price = priceelement.data('price');
			var id = priceelement.data('id');
			var newprice = qty * price;
			newprice = number_format(newprice, competitions_for_woocommerce_data.price_decimals, competitions_for_woocommerce_data.price_decimal_separator, competitions_for_woocommerce_data.price_thousand_separator);
			var oldtext = $(priceelement).children('.woocommerce-Price-amount').clone().children().remove().end().text();
			if( oldtext ){
				var newtext = $(priceelement).children('.woocommerce-Price-amount').html().replace(oldtext, newprice);
				$(priceelement).children('.woocommerce-Price-amount').html(newtext);
			}


		});

		$('#competitions-ticket-numbers').on('click','ul:not(.working) li.tn:not(.taken, .in_cart, .reserved)',function(e){

			var max_qty = $('input[name=max_quantity]').val();
			var current_number = $( this );

			if( max_qty <= 0 && ! current_number.hasClass('selected')){
				$.alertable.alert(competitions_for_woocommerce_data.maximum_text);
				return;
			}
			if($('#competitions-ticket-numbers').hasClass('guest')){
				$.alertable.alert(competitions_for_woocommerce_data.logintext, { 'html' : true } );
				return;
			}

			$( this ).addClass('working');
			$( '.tickets_numbers_tab' ).addClass('working');

			var numbers = $( 'ul.tickets_numbers');
			var competition_id = numbers.data( 'product-id' );
			var selected_number = $( this ).data( 'ticket-number' );

			$('html, body').css("cursor", "wait");
			numbers.addClass('working');
			jQuery.ajax({
				type : "get",
				url : competitions_for_woocommerce_data.ajax_url.toString().replace( '%%endpoint%%', 'competitions_for_woocommerce_get_taken_numbers' ),
				data : { 'selected_number' : selected_number, 'competition_id' : competition_id, 'reserve_ticket' : competitions_for_woocommerce_data.reserve_ticket , security: competitions_for_woocommerce_data.ajax_nonce },
				success: function(response) {

					$( 'ul.tickets_numbers').children('li.tn').each(function(index, el) {
						if( jQuery.inArray( $( this ).data( 'ticket-number' ).toString(), response.taken ) !== -1){
							$( this ).addClass('taken');
						}
						if( jQuery.inArray( $( this ).data( 'ticket-number' ).toString(), response.in_cart ) !== -1){
							$( this ).addClass('in_cart');
						}
						if( jQuery.inArray( $( this ).data( 'ticket-number' ).toString(), response.reserved ) !== -1){
							$( this ).addClass('in_cart');
						}
					});
					if( jQuery.inArray( selected_number.toString(), response.taken ) > 0) {
						$.alertable.alert(competitions_for_woocommerce_data.sold_text);
						numbers.removeClass('working');
						$( '.tickets_numbers_tab' ).addClass('working');
						current_number.removeClass('working');
						return;
					}

					if( jQuery.inArray( selected_number.toString(), response.in_cart ) > 0) {
						$.alertable.alert(competitions_for_woocommerce_data.in_cart_text);
						numbers.removeClass('working');
						$( '.tickets_numbers_tab' ).addClass('working');
						current_number.removeClass('working');
						return;
					}

					if( jQuery.inArray( selected_number.toString(), response.taken ) === -1) {
						current_number.toggleClass('selected');
					}
					var competition_tickets_numbers = $('input[name=competition_tickets_number]').val();
					var competition_tickets_numbers_array = [];
					if( competition_tickets_numbers ) {
						competition_tickets_numbers_array = competition_tickets_numbers.split(',');
					}
					if (current_number.hasClass('selected') && (jQuery.inArray(selected_number , competition_tickets_numbers_array ) === -1)) {
						competition_tickets_numbers_array.push( parseInt(selected_number) );
						$('input[name=competition_tickets_number]').val( competition_tickets_numbers_array.join(',') );
						$('input[name=max_quantity]').val( parseInt(max_qty) - 1);
					} else {
						competition_tickets_numbers_array = jQuery.grep(competition_tickets_numbers_array, function(value) {
						  return value != selected_number;
						});
						$('input[name=competition_tickets_number]').val( competition_tickets_numbers_array.join(',') );
						$('input[name=max_quantity]').val( parseInt(max_qty) + 1);
					}

					$('input[name=quantity]:not(#qty_dip)').val( parseInt(competition_tickets_numbers_array.length) ).trigger('change');
					jQuery( document.body ).trigger('sa-wachlist-action',[response.taken,competition_id, selected_number] );
					$('html, body').css("cursor", "auto");
					numbers.removeClass('working');
					$( '.tickets_numbers_tab' ).addClass('working');
					current_number.removeClass('working');

					if ( $('input[name=quantity]:not(#qty_dip)').val() > 0) {
						$(':input[name=add-to-cart]').removeClass('competition-must-pick');
					} else {
						$(':input[name=add-to-cart]').addClass('competition-must-pick');
					}
				},
				error: function() {
					numbers.removeClass('working');
					$( '.tickets_numbers_tab' ).addClass('working');
					current_number.removeClass('working');
				}
		});


	});

	$(document).on('click','.competition-answers li',function(e){
		var answer_id = $(this).data('answer-id');
		if($(this).hasClass('selected')){
			answer_id = -2;
		}
		$('input[name=competition_answer]').val( parseInt(answer_id) );
		$(this).siblings("li.selected").removeClass("selected").removeClass("false");
		$(this).toggleClass("selected");

		if ( $('input[name=competition_true_answers]').val() ) {
			var competition_true_answers = $('input[name=competition_true_answers]').val().split(',');

			if( answer_id == -2) {
				$(':input[name=add-to-cart]').addClass('competition-must-answer-true');
			}else if(jQuery.inArray( answer_id.toString(), competition_true_answers ) === -1) {
				$(this).toggleClass('false');
				$(':input[name=add-to-cart]').addClass('competition-must-answer-true');
			} else{
				$(':input[name=add-to-cart]').removeClass('competition-must-answer-true');
			}
		}
		if ( $('input[name=competition_answer]').val() > 0) {
			$(':input[name=add-to-cart]').removeClass('competition-must-answer');
			$('#lucky-dip, .lucky-dip-button').prop('disabled', false).prop('title', '').attr('alt', '');

		} else {
			$(':input[name=add-to-cart]').addClass('competition-must-answer');
			$('#lucky-dip, .lucky-dip-button').prop('disabled', true).prop('title', competitions_for_woocommerce_data.please_answer).attr('alt', competitions_for_woocommerce_data.please_answer);
		}
	});
	$(document).on('change','#competition_answer_drop',function(e){
		var answer_id = $(this).val();
		$('input[name=competition_answer]').val( parseInt(answer_id) );
		if ( $('input[name=competition_true_answers]').val() ) {
			competition_true_answers = $('input[name=competition_true_answers]').val().split(',');

			if( jQuery.inArray( answer_id.toString(), competition_true_answers ) === -1) {
				$(this).toggleClass('false');
				$(':input[name=add-to-cart]').addClass('competition-must-answer-true');
			} else{
				$(':input[name=add-to-cart]').removeClass('competition-must-answer-true');
			}
		}
		if ( $('input[name=competition_answer]').val() > 0) {
			$(':input[name=add-to-cart]').removeClass('competition-must-answer');
			$('#lucky-dip, .lucky-dip-button').prop('disabled', false).prop('title', '').attr('alt', '');

		} else {
			$(':input[name=add-to-cart]').addClass('competition-must-answer');
			$('#lucky-dip, .lucky-dip-button').prop('disabled', true).prop('title', competitions_for_woocommerce_data.please_answer).attr('alt', competitions_for_woocommerce_data.please_answer);
		}
	});


	$(document).on('submit','.cart.pick-number', function(e){
		var message = '';
		var pass = true;
		if ( $(':input[name=add-to-cart]').hasClass('competition-must-pick') ){
			message = message + competitions_for_woocommerce_data.please_pick;
			pass = false;
		}
		if ( $(':input[name=add-to-cart]').hasClass('competition-must-answer') ){
			message = message + competitions_for_woocommerce_data.please_answer;
			pass = false;
		}
		if ( $(':input[name=add-to-cart]').hasClass('competition-must-answer-true') ){
			message = message + competitions_for_woocommerce_data.please_true_answer;
			pass = false;
		}
		if ( pass == false ){
			$.alertable.alert(message).always(function() {
				$('.cart.pick-number').find(':submit').removeClass('loading');
			});
			e.preventDefault();
		}

	});
	$(document).on('click','.lucky-dip-button',function(e){
		e.preventDefault();
		if ( $(':input[name=add-to-cart]').hasClass('competition-must-answer-true') ){
			$.alertable.alert(competitions_for_woocommerce_data.please_true_answer)
			return;
		}
		var competition_answer = false;
		var numbers = $( 'ul.tickets_numbers');
		var competition_id = $(this).data( 'product-id' );
		var qty = parseInt( $(this).parent().find('input[name="qty_dip"]').val() );
		var max_qty = parseInt( $('input[name=max_quantity]').val() );
		var new_max_qty = max_qty - qty;
		if( max_qty <= 0 ){
			$.alertable.alert(competitions_for_woocommerce_data.maximum_text);
			return;
		}
		if (  qty > max_qty ){
			$.alertable.alert(competitions_for_woocommerce_data.maximum_add_text +' '+ max_qty);
			return;
		}
		if ( $('input[name=competition_answer]').val() > 0) {
			competition_answer = $('input[name=competition_answer]').val();
		}
		$('.qty.lucky-dip').attr('max', new_max_qty)
		$('input[name=max_quantity]').val(new_max_qty)
		if ( new_max_qty < 1 ){
			$('div.lucky_dip button').prop('disabled', true);
		}
		jQuery.ajax({
			type : "get",
			url : competitions_for_woocommerce_data.ajax_url.toString().replace( '%%endpoint%%', 'competitions_for_woocommerce_lucky_dip' ),
			data : { 'competition_id' : competition_id, 'competition_answer' : competition_answer,'qty' : qty, security: competitions_for_woocommerce_data.ajax_nonce },
			success: function(response) {
				$.alertable.alert( response.message, { html : true } );
				jQuery.each(response.ticket_numbers, function(index, value){
					$( 'li.tn[data-ticket-number=' + value + ' ]' ).addClass('in_cart');
				});
				jQuery( document.body).trigger('competition_lucky_dip_finished',[response,competition_id] );
				$('input[name=max_quantity]').val( parseInt(new_max_qty));
				$('.qty.lucky-dip').val('1');
				$(document.body).trigger('wc_fragment_refresh');
				$(document.body).trigger('added_to_cart');
			},
			error: function() {

			}
		});
		$(document.body).trigger('wc_fragment_refresh');
		$(document.body).trigger('added_to_cart');

		e.preventDefault();
	});



	});



})( jQuery );

number_format = function(number, decimals, dec_point, thousands_sep) {
	number = number.toFixed(decimals);

	var nstr = number.toString();
	nstr += '';
	x = nstr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? dec_point + x[1] : '';
	var rgx = /(\d+)(\d{3})/;

	while (rgx.test(x1))
		x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

	return x1 + x2;
}