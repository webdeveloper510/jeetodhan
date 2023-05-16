<style>
  .stripe-express-confirmation {
    max-width: 800px;
  }

  .stripe-express-confirmation__thank-you {
    font-size: 18px;
    margin-bottom: 30px;
  }

  .stripe-express-confirmation__section {
    background-color: #f6f9fc;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 30px;
  }

  .payment-detail {
    display: flex;
  }

  .payment-detail>div {
    margin-right: 2em;
    text-transform: uppercase;
    font-size: .715em;
    line-height: 1;
    border-right: 1px dashed #d3ced2;
    padding-right: 2em;
    margin-left: 0;
    padding-left: 0;
    list-style-type: none;
  }

  .payment-detail>div:last-of-type {
    border: none;
  }

  .payment-detail>div strong {
    display: block;
    font-size: 1.4em;
    text-transform: none;
    line-height: 1.5;
  }
</style>
<section class="stripe-express-confirmation">
  <?php if(!$hideThankYou) echo '<h4 class="stripe-express-confirmation__thank-you">Thank you. Your payment has been received.</h4> ' ?>

  <?php if(!$hidePaymentDetail) {?>
  <h4>Payment details</h4>
  <div class="stripe-express-confirmation__section payment-detail">
    <div>DATE: <strong><?php echo $placeholder['date'] ?></strong></div>
    <div>EMAIL: <strong><?php echo $placeholder['customer.email'] ?></strong></div>
    <div>TOTAL: <strong><?php echo $placeholder['amount_currency'] ?></strong></div>
    <div>PAYMENT METHOD: 
      <strong>
        <?php if($placeholder['payment_method'] == 'card') {
          echo $placeholder['payment_method.card.brand'] . ' - ' . $placeholder['payment_method.card.last4'];
        } else {
          echo $placeholder['payment_method'];
        } ?>
      </strong>
    </div>
  </div>
  <?php } ?>

  <?php if(!$hideBillingDetail) {?>
  <h4>Billing details</h4>
  <div class="stripe-express-confirmation__section">
    <div><?php echo $placeholder['billing_detail.name'] ?></div>
    <div><?php echo "
    {$placeholder['billing_detail.address.line1']}\n
    {$placeholder['billing_detail.address.line2']}\n
    {$placeholder['billing_detail.address.city']}, {$placeholder['billing_detail.address.state']} {$placeholder['billing_detail.address.postal_code']}\n
    {$placeholder['billing_detail.address.country']}
    " ?></div>
    <div><?php echo $placeholder['billing_detail.email'] ?></div>
    <div><?php echo $placeholder['billing_detail.phone'] ?></div>
  </div>
  <?php } ?>
  <p></p>
  <?php if(!$hideReceiptLink) {?>
  <p><span>You can download the </span><a href="<?php echo $placeholder['receipt.url'] ?>" target="_self"><span>receipt</span></a> here.</p>
  <?php } ?>
</section>