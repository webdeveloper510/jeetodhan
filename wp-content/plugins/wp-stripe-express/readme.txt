=== Stripe Express ===
Contributors: itstripe
Tags: credit card, stripe, payment, ach, alipay, wechat pay, contact form 7
Requires at least: 4.9
Tested up to: 6.2
Requires PHP: 5.6
Stable tag: 1.11.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Shipping with a variety of standalone Stripe payment widgets, including options for credit cards, Alipay and WeChat pay, and ACH transfers, can be easily integrated into your page by simply choosing the appropriate shortcode.

== Description ==

Accept a wide range of payment methods, including Visa, MasterCard, Alipay, WeChat, Apple Pay, Google Pay, Microsoft Pay, Bancontact, FPX, EPS, SEPA, Giropay, Sofort, iDeal, and more, to build your payment page in minutes without any coding knowledge.

We provide a variety of built-in payment widgets, called 'Elements', for you to easily choose and add as shortcodes. These widgets can be used for customers from countries such as Europe, China, and Japan.

[Online Demo](https://itstripe.com/demo/fixed-amount-button/) | [Documentation](https://docs.itstripe.com/)

### Features
* Payment methods include Credit Card (Visa, MasterCard), SEPA, Sofort, iDeal, Giropay, FPX, P24, Alipay, and WeChat Pay.
* Variety of standalone built-in free widgets for one-time payments, including options for buttons, donations, custom amounts, products, and CF7 redirections.
* Automatically collect tax on Checkout based on customer location.
* Multi currencies support for more payment methods like WeChat pay, Alipay, etc.
* Use URL parameters to set custom values for such as amount, currency, metadata.
* Customize confirmation page.
* Elementor integration.
* 9 built-in themes.
* Web Mobile support.
* One-Click import demos.
* **[Premium]** Standalone built-in widgets for digital wallet and form: Payment Form, Alipay, WeChat and Apple Pay, Google Pay, Microsoft Pay, and more.
* **[Premium]** Payment link for one-time and subscription.
* **[Premium]** Tax collect, coupon code support.
* **[Premium]** ACH debit payment with Plaid Link.
* **[Premium]** Payment success&failed email notifications and customer invoice email.
* **[Premium]** One-To-One email support for our users.

### Highlight Features For Free

#### Common usages
As a website owner:
* If you want to put a payment button on any pages or posts, choose one-time => fixed amount button. [Online Demo](https://itstripe.com/demo/fixed-amount-button)
* If you want your customer to pay as they want on any pages or posts, choose one-time => custom amount button. [Online Demo](https://itstripe.com/demo/custom-amount-button)
* If you want to collect any donations on any pages or posts, choose one-time => donation button. [Online Demo](https://itstripe.com/demo/donation-button)
* If you are looking for a complex payment form like booking an event, choose one-time => CF7 redirection. [Online Demo](https://itstripe.com/demo/contact-form-7-with-pay/)
* If your customers are coming from china, choose Digital Wallet => WeChat/Alipay. [Online Demo](https://itstripe.com/demo/wechat-pay-button) 

### Highlight Features For Premium
Our team aims to provide regular support for this plugin on the WordPress.org forums. But please understand that we do prioritize our premium support. This one-on-one email support is available to people who bought Premium.

### Collect Dynamic Fields from URL Parameters
This plugin feature allows you to collect dynamic fields from URL parameters. To use this feature, follow these steps:
1. Enable the "Enable Url Params" option when creating an element short-code.
2. Append the override URL parameters to the page that includes the element.

The following parameters are currently supported to override element settings:
`
currency: Choose from usd, eur, aud, cad, cny, gbp, hkd, jpy, myr
amount: Enter any digital number.
quantity: Set the quantity for one-time type elements.
[name]: Set the product name for one-time type elements. Note that the brackets are required for this term.
metadata: Add metadata for the element.
price: Use only for price IDs created in the Stripe dashboard. Format the price as "price_xxx_xx".
`

Here are some examples of how to use these parameters:
`
https://example.com/checkout?currency=eur&amount=199

https://example.com/checkout?currency=eur&amount=199&quantity=2&[name]=myproduct&metadata.order=1234&metadata.note=xxx
`

#### Payment Links
With Payment Links, you can create a payment page and share a link to it with your customers. You can share the link as many times as you want on social media, in emails, or through any other channel. Also, you can use them as an image link button or even insert them into any pricing table. 

Payment Links supports over 20 payment methods—including credit and debit cards, Apple Pay, and Google Pay. The payment page is translated into over 30 languages and automatically matches your customer’s preferred browser language.

[Links Demo](https://itstripe.com/demo/payment-links/) | [Pricing Table Demo](https://itstripe.com/demo/pricing-table)

#### Customize email notifications
You can turn on/off three kinds of email notifications for each transfer: payment success, failed, customer invoice. You can design your email templates with built-in placeholder fields like amount, currency, customer email, address, etc...

[Documentation](https://docs.itstripe.com/tutorial/setup-email/)

#### China digital payment: Alipay & WeChat
Both Alipay & WeChat Pay are digital wallet in China that has more than a billion active users worldwide. If your business is in China, then good for you, from a simple payment button to a complex form, we provide multiple elements for your customer to finish the payment easily.

[Form Demo](https://itstripe.com/demo/payment-element-form/) | [Simple Button Demo](https://itstripe.com/demo/alipay-button/) | [Documentation](https://docs.itstripe.com/digital-wallet/create-wechat-pay/)

#### ACH via Plaid Link
Automated Clearing House (ACH) is currently supported only for Stripe businesses based in the U.S. ACH debits also provide **lower** transaction fees than cards. Comparing with 2.9% + 30¢ for Card & Wallet, ACH payments on Stripe cost 0.80%, capped at $5.

Plaid provides the quickest way to collect and verify your customer’s banking information. Using the Stripe + Plaid integration, you’re able to instantly receive a verified bank account, allowing for immediate charging.

[Online Demo](https://itstripe.com/demo/ach-pay/) | [Documentation](https://docs.itstripe.com/payment-methods/ach-debit-plaid-link-integration/)

== Frequently Asked Questions ==

= Who should use this plugin? =
You don’t need an entire eCommerce store to accept payments on your site and you have a product or service to offer and simply want to automate sales.

= Does this require an SSL certificate? =

Yes! In Live Mode, an SSL certificate must be installed on your site to use Stripe. In addition to SSL encryption, Stripe provides an extra JavaScript method to secure card data using [Stripe Elements](https://stripe.com/elements).

= Does this support both production mode and sandbox mode for testing? =

Yes, it does - production and Test (sandbox) mode is driven by the API keys you use with a checkbox in the admin settings to toggle between both.

= Can I disable WP REST API? =
No, this plugin is using WP REST API. So please make sure it is opening or just add stripe-express API into the whitelist by some plugins like [disable-json-api](https://wordpress.org/plugins/disable-json-api/).

== Screenshots ==
1. overview 
2. payment link
3. google pay
4. setting
5. element list
6. email notifications


== Changelog ==
= 1.11.0 =
* feat: add dynamic amount, currency, metadata, etc based on URL parameters.

= 1.10.7 =
* feat: add ACH, klarna, affirm, afterpay methods in checkout page.

= 1.10.6 =
* feat: add custom amount for payment element form.
* feat: change currency symbol as left side.
* feat: add multi payment methods support for subscription.

= 1.10.2 =
* fix: add auto payment methods for subscription.
* fix: theme color fix.

= 1.10.1 =
* feat: add element button preview.
* feat: add single element theme support.

= 1.10.0 =
* chore: banner & screenshot change.
* bug fix.

= 1.9.0 =
* feat: add thank you/receipt shortcode
* feat: add terms of service support..
* feat: elementor integration.
* bug fix.

= 1.8.0 =
* feat: one-click import demo.
* bug fix.

= 1.7.8 =
* feat: add payment links.

= 1.7.5 =
* feat: add stripe tax collect for one-time & subscription checkout.
* feat: add coupon codes support for one-time & subscription checkout.
* feat: add global events for advanced usages.
* fix: fix subscription submitType issues.

= 1.7.0 =
* feat: add multi-currencies support.
* feat: add WeChat pay support for checkout one-time pay.
* feat: enhance WeChat pay scan behavior.
* feat: support to use price/product created from stripe dashboard for one-time payments.
* feat: integrate stripe's self-design payment-element form (including multi pre-defined UI, more payment methods).
* refactor: permission enhancement.

= 1.6.2 =
* fix: fix components background color issue.
* fix: minor fix on ACH.

= 1.6.0 =
* feat: add ACH transfer with Plaid Link

= 1.5.6 =
* feat: add cf7 redirection plugin for free.

= 1.5.5 =
* feat: add more themes, sizes option for alipay&wechat pay.
* fix: minor bug fix.

= 1.5.0 =
* feat: Add recurring pay.
* feat: Add payment report page.
* fix: default button label missing.

= 1.4.1 =
* feat: Add custom amount field & phone field for both WeChat, Alipay, and checkout form elements.
* feat: Add more fields for email notification.
* feat: Add Ideal method for checkout form.


== Upgrade Notice ==
None.