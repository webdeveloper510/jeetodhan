<?php

if (!defined('ABSPATH')) {
  exit;
}

class Stripe_Express_Addons_CF7
{
  public function __construct()
  {
    add_action('wpcf7_init', array($this, 'wpcf7_add_form_tag_stripe_express'), 10, 0);
    /* Tag generator */
    add_action('wpcf7_admin_init', array($this, 'wpcf7_add_tag_generator_stripe_express'), 56, 0);
  }

  function wpcf7_add_form_tag_stripe_express()
  {
    wpcf7_add_form_tag('stripe_express_element', array($this, 'wpcf7_stripe_express_form_tag_handler'));
  }

  function wpcf7_stripe_express_form_tag_handler($tag)
  {
    global $WP_STRIPE;
    global $wpdb;

    $validation_error = wpcf7_get_validation_error($tag->name);

    $class = wpcf7_form_controls_class($tag->type);

    $class .= ' wpcf7-validates-as-number';

    if ($validation_error) {
      $class .= ' wpcf7-not-valid';
    }

    $atts = array();
    $atts['id'] = $tag->get_option('elementId', 'int', true);
    $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}stripe_express_elements WHERE id = %d", $atts['id']));
    if (empty($item)) {
      return "<span>stripe element not found: {$atts['id']} </span>";
    }

    $uiConfig = array();
    $uiConfig['amountField'] = $tag->get_option('amountField', '', true);
    $uiConfig['quantityField'] = $tag->get_option('quantityField', '', true);
    $atts['uiConfig'] = json_encode($uiConfig);

    return $WP_STRIPE->stripe_express_shortcode($atts);
  }

  function wpcf7_add_tag_generator_stripe_express()
  {
    $tag_generator = WPCF7_TagGenerator::get_instance();
    $tag_generator->add(
      'stripe_express_element',
      // __('checkboxes', 'contact-form-7'),
      'stripe express element',
      array($this, 'wpcf7_tag_generator_stripe_express')
    );
  }


  function wpcf7_tag_generator_stripe_express($contact_form, $args = '')
  {
    global $wpdb;
    $results = $wpdb->get_results(
      "
        SELECT * 
        FROM {$wpdb->prefix}stripe_express_elements
        WHERE type='ONE_TIME_CF7_REDIRECT'
        ORDER BY id DESC
      ", ARRAY_A
    );
    $args = wp_parse_args($args, array());
    $type = 'stripe_express_element';

    $description = "Generate a form-tag for stripe express element section. For more details, see %s.";

    $desc_link = wpcf7_link('https://docs.itstripe.com/contact-form-7/', 'stripe-express for CF7');

?>
    <div class="control-box">
      <fieldset>
        <legend><?php echo sprintf(esc_html($description), $desc_link); ?></legend>

        <table class="form-table">
          <tbody>
	          <tr>
              <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-element-id' ); ?>">Element ID</label></th>
	            <td>
                <input type="text" name="elementId" class="oneline option" style="display:none" id="<?php echo esc_attr( $args['content'] . '-element-id' ); ?>" />
                <script type="text/javascript">
                  function handleElementSelected(target) {
                    var elementIdInput = document.getElementById('<?php echo esc_attr( $args['content'] . '-element-id' ); ?>');
                    elementIdInput.value = target.value;
                    elementIdInput.dispatchEvent(new Event('change'));
                  }
                </script>
                <select class="oneline option" onblur="handleElementSelected(this)" onchange="handleElementSelected(this)">
                  <option value="0">Select one</option>
                  <?php
                    foreach ($results as $item) {
                      $elementName = json_decode($item['paymentConfig'])->item->name;
                      ?>
                      <option value="<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $elementName ); ?></option>';
                      <?php
                    }
                  ?>
                </select>
                <?php if(count($results) == 0) {?>
                  <span style="color:red">No element found, please create them first in `Stripe Express` plugin.</span>
                <?php } ?>
              </td>
	          </tr>
            <tr>
              <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-element-amount-field' ); ?>">Amount Field</label></th>
	            <td><input type="text" name="amountField" class="oneline option" id="<?php echo esc_attr( $args['content'] . '-element-amount-field' ); ?>" />(The value will be collected from user.)</td>
	          </tr>
            <tr>
              <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-element-quantity-field' ); ?>">Quantity Field</label></th>
	            <td><input type="text" name="quantityField" class="oneline option" id="<?php echo esc_attr( $args['content'] . '-element-quantity-field' ); ?>" />(The value will be collected from user.)</td>
	          </tr>
            <!--
            <tr>
              <th scope="row"><label for="<?php echo esc_attr($args['content'] . '-id'); ?>"><?php echo esc_html(__('Id attribute', 'contact-form-7')); ?></label></th>
              <td><input type="text" name="id" required class="idvalue oneline option" id="<?php echo esc_attr($args['content'] . '-id'); ?>" /></td>
            </tr>

            <tr>
              <th scope="row"><label for="<?php echo esc_attr($args['content'] . '-class'); ?>"><?php echo esc_html(__('Class attribute', 'contact-form-7')); ?></label></th>
              <td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr($args['content'] . '-class'); ?>" /></td>
            </tr>
            -->
          </tbody>
        </table>
      </fieldset>
    </div>

    <div class="insert-box">
      <input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

      <div class="submitbox">
        <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr(__('Insert Tag', 'contact-form-7')); ?>" />
      </div>
      <br class="clear" />
    </div>
<?php
  }
}

new Stripe_Express_Addons_CF7();
