<?php

class Stripe_Express_Utils {
  public static function format_stripe_date($seconds) {
    // return date('Y-m-d H:i:s', $seconds);
    return date_i18n( 'F j, Y', $seconds );
  }

  public static function format_amount_with_symbol($amount, $currency) {
    $amount = intval( $amount ) / 100;
    if (class_exists('NumberFormatter')) {
      $formatter = new NumberFormatter(get_locale(), NumberFormatter::CURRENCY);
      return $formatter->formatCurrency($amount, $currency);
    }
    $symbol = Stripe_Express_Currencies::get_currency_symbol($currency);
    return $symbol . $amount;
  }

  /**
	 * Checks Stripe minimum order value authorized per currency
	 */
	public static function get_minimum_amount($currency) {
		// Check order amount
		switch ( $currency ) {
			case 'USD':
			case 'CAD':
			case 'EUR':
			case 'CHF':
			case 'AUD':
			case 'SGD':
				$minimum_amount = 50;
				break;
			case 'GBP':
				$minimum_amount = 30;
				break;
			case 'DKK':
				$minimum_amount = 250;
				break;
			case 'NOK':
			case 'SEK':
				$minimum_amount = 300;
				break;
			case 'JPY':
				$minimum_amount = 5000;
				break;
			case 'MXN':
				$minimum_amount = 1000;
				break;
			case 'HKD':
				$minimum_amount = 400;
				break;
			default:
				$minimum_amount = 50;
				break;
		}

		return $minimum_amount;
	}

  public static function get_receipt_placeholders($customer, $payment_intent) {
    $billDetail = $payment_intent['payment_method']['billing_details'];
    $charge = (end($payment_intent['charges']['data']));
    $placeholders = array();
    $placeholders['customer.email'] = $customer['email'];
    $placeholders['customer.name'] = $customer['name'];
    $placeholders['customer.phone'] = $customer['phone'];
    $placeholders['customer.address.country'] = $customer['address']['country'];
    $placeholders['customer.address.state'] = $customer['address']['state'];
    $placeholders['customer.address.city'] = $customer['address']['city'];
    $placeholders['customer.address.line1'] = $customer['address']['line1'];
    $placeholders['customer.address.line2'] = $customer['address']['line2'];
    $placeholders['customer.address.postal_code'] = $customer['address']['postal_code'];

    $placeholders['description'] = $payment_intent['description'];
    $placeholders['amount'] = intval($payment_intent['amount'] / 100);
    $placeholders['currency'] = $payment_intent['currency'];
    $placeholders['date'] = self::format_stripe_date($payment_intent['created']);
    $placeholders['amount_currency'] = self::format_amount_with_symbol($payment_intent['amount'], $payment_intent['currency']); 
    $placeholders['billing_detail.address.country'] = $billDetail['address']['country'];
    $placeholders['billing_detail.address.state'] = $billDetail['address']['state'];
    $placeholders['billing_detail.address.city'] = $billDetail['address']['city'];
    $placeholders['billing_detail.address.line1'] = $billDetail['address']['line1'];
    $placeholders['billing_detail.address.line2'] = $billDetail['address']['line2'];
    $placeholders['billing_detail.address.postal_code'] = $billDetail['address']['postal_code'];
    $placeholders['billing_detail.email'] = $billDetail['email'];
    $placeholders['billing_detail.name'] = $billDetail['name'];
    $placeholders['billing_detail.phone'] = $billDetail['phone'];
    $placeholders['payment_method'] = $payment_intent['payment_method']['type'];
    $placeholders['payment_method.card.brand'] = $payment_intent['payment_method']['card']['brand'];
    $placeholders['payment_method.card.last4'] = $payment_intent['payment_method']['card']['last4'];

    $placeholders['receipt.url'] = $charge['receipt_url']; 

    return $placeholders;
  }

  public static function get_stripe_success_placeholders($intent, $charge)
  {
    $charge = $charge;
    if(isset($intent)) {
      $charge = end($intent['charges']['data']);
    }
    $placeholders = array();
    $placeholders['{payment_id}'] = $intent['id'];
    $placeholders['{payment_type}'] = $charge['payment_method_details']['type'];
    $placeholders['{amount}'] = $charge['amount'] / 100;
    $placeholders['{currency}'] = $charge['currency'];
    $placeholders['{amount_currency}'] = self::format_amount_with_symbol($charge['amount'], $charge['currency']);
    $placeholders['{description}'] = $charge['description'];
    $placeholders['{metadata}'] = json_encode($charge['metadata']);
    $placeholders['{receipt_url}'] = $charge['receipt_url'];
    $placeholders['{receipt_email}'] = $charge['receipt_email'];
    $placeholders['{customer_email}'] = $charge['billing_details']['email'];
    $placeholders['{customer_name}'] = $charge['billing_details']['name'];
    $placeholders['{customer_phone}'] = $charge['billing_details']['phone'];
    $placeholders['{shipping_address}'] = !empty($charge['shipping']) ? json_encode($charge['shipping']['address']) : null;
    $placeholders['{created}'] = self::format_stripe_date($charge['created']);

    return $placeholders;
  }

  public static function get_stripe_failed_placeholders($object)
  {
    $placeholders = array();
    $placeholders['{payment_id}'] = $object['id'];
    $placeholders['{payment_type}'] = implode(',', $object['payment_method_types']);
    $placeholders['{amount}'] = $object['amount'] / 100;
    $placeholders['{currency}'] = $object['currency'];
    $placeholders['{amount_currency}'] = self::format_amount_with_symbol($object['amount'], $object['currency']);
    $placeholders['{description}'] = $object['description'];
    $placeholders['{metadata}'] = json_encode($object['metadata']);
    $placeholders['{receipt_url}'] = $object['receipt_url'];
    $placeholders['{receipt_email}'] = $object['receipt_email'];

    $payment_error = $object['last_payment_error'];
    if (!empty($payment_error)) {
      $placeholders['{error_message}'] = $payment_error['message'];
      $placeholders['{customer_email}'] = $payment_error['payment_method']['billing_details']['email'];
      $placeholders['{customer_name}'] = $payment_error['payment_method']['billing_details']['name'];
      $placeholders['{customer_phone}'] = $payment_error['payment_method']['billing_details']['phone'];
    }
    $placeholders['{shipping_address}'] = !empty($object['shipping']) ? json_encode($object['shipping']['address']) : null;
    $placeholders['{created}'] = self::format_stripe_date($object['created']);

    return $placeholders;
  }
}
