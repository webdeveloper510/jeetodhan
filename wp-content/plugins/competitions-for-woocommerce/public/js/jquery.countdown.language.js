/* http://keith-wood.name/countdown.html
 */
(function($) {
	$.competitions_for_woocommerce_countdown.regionalOptions['us'] = {
		labels: [competitions_for_woocommerce_language_data .labels.Years, competitions_for_woocommerce_language_data .labels.Months, competitions_for_woocommerce_language_data .labels.Weeks, competitions_for_woocommerce_language_data .labels.Days, competitions_for_woocommerce_language_data .labels.Hours, competitions_for_woocommerce_language_data .labels.Minutes, competitions_for_woocommerce_language_data .labels.Seconds],
		labels1: [competitions_for_woocommerce_language_data .labels1.Year, competitions_for_woocommerce_language_data .labels1.Month, competitions_for_woocommerce_language_data .labels1.Week, competitions_for_woocommerce_language_data .labels1.Day, competitions_for_woocommerce_language_data .labels1.Hour, competitions_for_woocommerce_language_data .labels1.Minute, competitions_for_woocommerce_language_data .labels1.Second],
		
		compactLabels: [competitions_for_woocommerce_language_data .compactLabels.y, competitions_for_woocommerce_language_data .compactLabels.m, competitions_for_woocommerce_language_data .compactLabels.w, competitions_for_woocommerce_language_data .compactLabels.d,  competitions_for_woocommerce_language_data .compactLabels.h, competitions_for_woocommerce_language_data .compactLabels.min, competitions_for_woocommerce_language_data .compactLabels.s],
		whichLabels: function(amount) {
			return (amount == 1 ? 1 : (amount >= 2 && amount <= 4 ? 2 : 0));
		},
		digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
		timeSeparator: ':', isRTL: false};
	$.competitions_for_woocommerce_countdown.setDefaults($.competitions_for_woocommerce_countdown.regionalOptions['us']);
})(jQuery);
