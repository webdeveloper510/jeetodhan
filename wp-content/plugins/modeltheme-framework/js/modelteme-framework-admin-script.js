jQuery(function($) {
    'use strict';
    jQuery('button.add_lottery_answer').on('click', function() {
        var key = jQuery('.mt_all_possible_answers_wrapper input.lottery_answer:last').data('answer-id');
        if (typeof key == 'undefined') {
            key = 1;
        } else {
            key = parseInt(key) + 1;
        }
        var $wrapper = jQuery('#mt_add_question_product_options');
        var $attributes = $wrapper.find('.answers');
        var product_type = jQuery('select#product-type').val();
        var data = {
            action: 'woocommerce_add_lottery_answer',
            security: woocommerce_lottery_pn.add_lottery_answer_nonce,
            key: key,
        };

        jQuery.post(woocommerce_admin_meta_boxes.ajax_url, data, function(response) {
            $attributes.append(response);
            jQuery(document.body).trigger('wc-enhanced-select-init');
            jQuery(document.body).trigger('woocommerce_added_add_lottery_answer');
        });
        return false;
    });

    jQuery('.mt_all_possible_answers_wrapper').on('click', '.mt_remove_row', function() {
        if (window.confirm(woocommerce_lottery_pn.remove_answer)) {
            var $parent = $(this).parent().parent();
            $parent.find('select, input').val('');
            $parent.hide();
        }
        return false;
    });

});