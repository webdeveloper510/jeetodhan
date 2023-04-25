<?php
/**
 * WCFM plugin view
 *
 * WCFM Products Manage Tabs view
 * This template can be overridden by copying it to yourtheme/wcfm/products-manager/
 *
 * @author 		WC Lovers
 * @package 	wcfm/views/products-manager
 * @version   1.0.0
 */
 
global $wp, $WCFM, $wc_product_attributes;

?>
				<?php 
				$wcfm_pm_block_class_stock = apply_filters( 'wcfm_pm_block_class_stock', 'simple variable grouped external non-job_package non-resume_package non-auction non-groupbuy non-accommodation-booking' );
				if( !apply_filters( 'wcfm_is_allow_inventory', true ) || !apply_filters( 'wcfm_is_allow_pm_inventory', true ) ) { 
					$wcfm_pm_block_class_stock = 'wcfm_block_hide';
				}
				?>


				
				<!-- collapsible 1 -->
				<div class="page_collapsible products_manage_inventory <?php echo esc_attr($wcfm_pm_block_class_stock) . ' ' . esc_attr($wcfm_wpml_edit_disable_element); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_stock', '' ); ?>" id="wcfm_products_manage_form_inventory_head"><label class="fas fa-database"></label><?php _e('Inventory', 'pomana'); ?><span></span></div>
				<div class="wcfm-container <?php echo esc_attr($wcfm_pm_block_class_stock) . ' ' . esc_attr($wcfm_wpml_edit_disable_element); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_stock', '' ); ?>">
					<div id="wcfm_products_manage_form_inventory_expander" class="wcfm-content">
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_fields_stock', array(
	"sku" => array('label' => __('SKU', 'pomana') , 'type' => 'text', 'class' => 'wcfm-text', 'label_class' => 'wcfm_title', 'value' => $sku, 'hints' => __( 'SKU refers to a Stock-keeping unit, a unique identifier for each distinct product and service that can be purchased.', 'pomana' )),
	"manage_stock" => array('label' => __('Manage Stock?', 'pomana') , 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele simple variable manage_stock_ele non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'value' => 'enable', 'label_class' => 'wcfm_title wcfm_ele checkbox_title simple variable non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'hints' => __('Enable stock management at product level', 'pomana'), 'dfvalue' => $manage_stock),
	"stock_qty" => array('label' => __('Stock Qty', 'pomana') , 'type' => 'number', 'class' => 'wcfm-text wcfm_ele simple variable non_manage_stock_ele non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking non-accommodation-booking', 'label_class' => 'wcfm_title wcfm_ele simple variable non_manage_stock_ele non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'value' => $stock_qty, 'hints' => __( 'Stock quantity. If this is a variable product this value will be used to control stock for all variations, unless you define stock at variation level.', 'pomana' ), 'attributes' => array( 'min' => '1', 'step'=> '1' ) ),
	"backorders" => array('label' => __('Allow Backorders?', 'pomana') , 'type' => 'select', 'options' => array('no' => __('Do not Allow', 'pomana'), 'notify' => __('Allow, but notify customer', 'pomana'), 'yes' => __('Allow', 'pomana')), 'class' => 'wcfm-select wcfm_ele simple variable non_manage_stock_ele non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'label_class' => 'wcfm_title wcfm_ele simple variable non_manage_stock_ele non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'value' => $backorders, 'hints' => __( 'If managing stock, this controls whether or not backorders are allowed. If enabled, stock quantity can go below 0.', 'pomana' )),
	"stock_status" => array('label' => __('Stock status', 'pomana') , 'type' => 'select', 'options' => array('instock' => __('In stock', 'pomana'), 'outofstock' => __('Out of stock', 'pomana'), 'onbackorder' => __( 'On backorder', 'pomana' ) ), 'class' => 'wcfm-select wcfm_ele stock_status_ele simple variable grouped non-variable-subscription non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'label_class' => 'wcfm_ele wcfm_title stock_status_ele simple variable grouped non-variable-subscription non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'value' => $stock_status, 'hints' => __( 'Controls whether or not the product is listed as "in stock" or "out of stock" on the frontend.', 'pomana' )),
	"sold_individually" => array('label' => __('Sold Individually', 'pomana') , 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele simple variable non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'hints' => __('Enable this to only allow one of this item to be bought in a single order', 'pomana'), 'label_class' => 'wcfm_title wcfm_ele simple variable checkbox_title non-job_package non-resume_package non-auction non-redq_rental non-appointment non-accommodation-booking', 'dfvalue' => $sold_individually)
				), $product_id, $product_type ) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
					
				<?php do_action( 'after_wcfm_products_manage_stock', $product_id, $product_type ); ?>
				
				<?php 
				$wcfm_pm_block_class_downlodable = apply_filters( 'wcfm_pm_block_class_downlodable', 'simple downlodable non-variable-subscription non-redq_rental non-appointment' );
				if( !apply_filters( 'wcfmu_is_allow_downloadable', true ) || !apply_filters( 'wcfmu_is_allow_pm_downloadable', true ) ) { 
					$wcfm_pm_block_class_downlodable = 'wcfm_block_hide';
				}
				?>
				<!-- collapsible 2 -->
				<div class="page_collapsible products_manage_downloadable <?php echo esc_attr($wcfm_pm_block_class_downlodable) . ' ' . $wcfm_wpml_edit_disable_element; ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_downlodable', '' ); ?>" id="wcfm_products_manage_form_downloadable_head"><label class="fas fa-cloud-download-alt"></label><?php _e('Downloadable', 'pomana'); ?><span></span></div>
				<div class="wcfm-container <?php echo esc_attr($wcfm_pm_block_class_downlodable) . ' ' . esc_attr($wcfm_wpml_edit_disable_element); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_downlodable', '' ); ?>">
					<div id="wcfm_products_manage_form_downloadable_expander" class="wcfm-content">
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_fields_downloadable', array(  
						"downloadable_files" => array('label' => __('Files', 'pomana') , 'type' => 'multiinput', 'class' => 'wcfm-text wcfm_ele simple downlodable', 'label_class' => 'wcfm_title', 'value' => $downloadable_files, 'options' => array(
				"name" => array('label' => __('Name', 'pomana'), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple downlodable', 'label_class' => 'wcfm_ele wcfm_title simple downlodable', 'custom_attributes' => array( 'required' => 1 ) ),
				"file" => array('label' => __('File', 'pomana'), 'type' => 'upload', 'mime' => 'Uploads', 'button_class' => 'downloadable_product', 'class' => 'wcfm-text wcfm_ele simple downlodable downlodable_file', 'label_class' => 'wcfm_ele wcfm_title simple downlodable', 'custom_attributes' => array( 'required' => 1 ) ),
				"previous_hash" => array( 'type' => 'hidden', 'name' => 'id' )
				)
),
				"download_limit" => array('label' => __('Download Limit', 'pomana'), 'type' => 'number', 'value' => $download_limit, 'placeholder' => __('Unlimited', 'pomana'), 'class' => 'wcfm-text wcfm_ele simple external', 'label_class' => 'wcfm_ele wcfm_title simple downlodable', 'attributes' => array( 'min' => '0', 'step' => '1' )),
				"download_expiry" => array('label' => __('Download Expiry', 'pomana'), 'type' => 'number', 'value' => $download_expiry, 'placeholder' => __('Never', 'pomana'), 'class' => 'wcfm-text wcfm_ele simple external', 'label_class' => 'wcfm_ele wcfm_title simple downlodable', 'attributes' => array( 'min' => '0', 'step' => '1' ))
						), $product_id, $product_type ) );
						
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				
				<?php do_action( 'after_wcfm_products_downloadable', $product_id, $product_type ); ?>
				
				<!-- collapsible 3 - Grouped Product -->
				<div class="page_collapsible products_manage_grouped grouped" id="wcfm_products_manage_form_grouped_head"><label class="fas fa-object-group"></label><?php _e('Grouped Products', 'pomana'); ?><span></span></div>
				<div class="wcfm-container grouped">
					<div id="wcfm_products_manage_form_grouped_expander" class="wcfm-content">
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_grouped', array(  
						"grouped_products" => array('label' => __('Grouped products', 'pomana') , 'type' => 'select', 'attributes' => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ), 'class' => 'wcfm-select wcfm_ele grouped', 'label_class' => 'wcfm_title wcfm_ele grouped', 'options' => $products_array, 'value' => $children, 'hints' => __( 'This lets you choose which products are part of this group.', 'pomana' ))
	)) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				
				<?php do_action( 'after_wcfm_products_manage_grouped', $product_id, $product_type ); ?>
				
				<?php 
				$wcfm_pm_block_class_shipping = apply_filters( 'wcfm_pm_block_class_shipping', 'simple variable nonvirtual booking non-accommodation-booking' );
				if( !apply_filters( 'wcfm_is_allow_shipping', true ) || !apply_filters( 'wcfm_is_allow_pm_shipping', true ) ) { 
				  $wcfm_pm_block_class_shipping = 'wcfm_block_hide';
				}
				?>
				<!-- collapsible 4 -->
				<div class="page_collapsible products_manage_shipping <?php echo esc_attr($wcfm_pm_block_class_shipping) . ' ' . $wcfm_wpml_edit_disable_element; ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_shipping', '' ); ?>" id="wcfm_products_manage_form_shipping_head"><label class="fas fa-truck"></label><?php _e('Shipping', 'pomana'); ?><span></span></div>
				<div class="wcfm-container <?php echo esc_attr($wcfm_pm_block_class_shipping) . ' ' . esc_attr($wcfm_wpml_edit_disable_element); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_shipping', '' ); ?>">
					<div id="wcfm_products_manage_form_shipping_expander" class="wcfm-content">
						<?php do_action( 'wcfm_product_manage_fields_shipping_before', $product_id ); ?>
						<div class="wcfm_clearfix"></div>
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_manage_fields_shipping', array(  "weight" => array( 'label' => __('Weight', 'pomana') . ' ('.get_option( 'woocommerce_weight_unit', 'kg' ).')' , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $weight),
"length" => array( 'label' => __('Dimensions', 'pomana') . ' ('.get_option( 'woocommerce_dimension_unit', 'cm' ).')', 'placeholder' => __('Length', 'pomana'), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $length),
"width" => array( 'placeholder' => __('Width', 'pomana'), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $width),
"height" => array( 'placeholder' => __('Height', 'pomana'), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $height),
"shipping_class" => array('label' => __('Shipping class', 'pomana') , 'type' => 'select', 'options' => $shipping_option_array, 'class' => 'wcfm-select wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $shipping_class)
		), $product_id ) );
						?>
						<div class="wcfm_clearfix"></div>
						<?php do_action( 'wcfm_product_manage_fields_shipping_after', $product_id ); ?>
					</div>
				</div>


				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				
				<?php do_action( 'after_wcfm_products_manage_shipping', $product_id, $product_type ); ?>
				
				<?php if ( wc_tax_enabled() ) { ?>
					<?php 
					$wcfm_pm_block_class_tax = apply_filters( 'wcfm_pm_block_class_tax', 'simple variable booking non-groupbuy' );
					if( !apply_filters( 'wcfm_is_allow_tax', true ) || !apply_filters( 'wcfm_is_allow_pm_tax', true ) ) { 
						$wcfm_pm_block_class_tax = 'wcfm_block_hide';
					}
					?>
					<!-- collapsible 5 -->
					<div class="page_collapsible products_manage_tax <?php echo esc_attr($wcfm_pm_block_class_tax) . ' ' . $wcfm_wpml_edit_disable_element; ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_tax', '' ); ?>" id="wcfm_products_manage_form_tax_head"><label class="fas fa-money fa-money-bill-alt"></label><?php _e('Tax', 'pomana'); ?><span></span></div>
					<div class="wcfm-container <?php echo esc_attr($wcfm_pm_block_class_tax) . ' ' . esc_attr($wcfm_wpml_edit_disable_element); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_tax', '' ); ?>">
						<div id="wcfm_products_manage_form_tax_expander" class="wcfm-content">
<?php
$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_simple_fields_tax', array(  
	"tax_status" => array('label' => __('Tax Status', 'pomana') , 'type' => 'select', 'options' => array( 'taxable' => __( 'Taxable', 'pomana' ), 'shipping' => __( 'Shipping only', 'pomana' ), 'none' => _x( 'None', 'Tax status', 'pomana' ) ), 'class' => 'wcfm-select wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $tax_status, 'hints' => __( 'Define whether or not the entire product is taxable, or just the cost of shipping it.', 'pomana' )),
	"tax_class" => array('label' => __('Tax Class', 'pomana') , 'type' => 'select', 'options' => $tax_classes_options, 'class' => 'wcfm-select wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $tax_class, 'hints' => __( 'Choose a tax class for this product. Tax classes are used to apply different tax rates specific to certain types of product.', 'pomana' ))
			)) );
?>
						</div>
					</div>
					<!-- end collapsible -->
					<div class="wcfm_clearfix"></div>
				<?php } ?>
				
				<?php do_action( 'after_wcfm_products_manage_tax', $product_id, $product_type ); ?>
				
				<?php 
				$wcfm_pm_block_class_attributes = apply_filters( 'wcfm_pm_block_class_attributes', 'simple variable external grouped booking' );
				if( !apply_filters( 'wcfm_is_allow_attribute', true ) || !apply_filters( 'wcfm_is_allow_pm_attribute', true ) ) {
					$wcfm_pm_block_class_attributes = 'wcfm_block_hide';
				}	
				?>
				<!-- collapsible 6 -->
				<div class="page_collapsible products_manage_attribute <?php echo esc_attr($wcfm_pm_block_class_attributes); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_attributes', '' ); ?>" id="wcfm_products_manage_form_attribute_head"><label class="fas fa-server"></label><?php _e('Attributes', 'pomana'); ?><span></span></div>
				<div class="wcfm-container <?php echo esc_attr($wcfm_pm_block_class_attributes); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_attributes', '' ); ?>">
					<div id="wcfm_products_manage_form_attribute_expander" class="wcfm-content">
						<?php
						  do_action( 'wcfm_products_manage_attributes', $product_id );
						  
$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_simple_fields_attributes', array(  
					"attributes" => array( 'label' => __( 'Attributes', 'pomana' ), 'type' => 'multiinput', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'has_dummy' => true, 'label_class' => 'wcfm_title', 'value' => $attributes, 'options' => array(
"term_name" => array('type' => 'hidden'),
"is_active" => array('label' => __('Active?', 'pomana'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele attribute_ele simple variable external grouped booking', 'label_class' => 'wcfm_title attribute_ele checkbox_title'),
"name" => array('label' => __('Name', 'pomana'), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele attribute_ele simple variable external grouped booking', 'label_class' => 'wcfm_title attribute_ele'),
"value" => array('label' => __('Value(s):', 'pomana'), 'type' => 'textarea', 'class' => 'wcfm-textarea wcfm_ele simple variable external grouped booking', 'placeholder' => sprintf( __('Enter some text, some attributes by "%s" separating values.', 'pomana'), WC_DELIMITER ), 'label_class' => 'wcfm_title'),
"is_visible" => array('label' => __('Visible on the product page', 'pomana'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title checkbox_title'),
"is_variation" => array('label' => __('Use as Variation', 'pomana'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele variable variable-subscription', 'label_class' => 'wcfm_title checkbox_title wcfm_ele variable variable-subscription'),
"tax_name" => array('type' => 'hidden'),
"is_taxonomy" => array('type' => 'hidden')
					))
)) );
						?>
						<div class="wcfm_clearfix"></div><br />
						<p>
<?php if( apply_filters( 'wcfm_is_allow_add_attribute', true ) ) { ?>
	<select name="wcfm_attribute_taxonomy" class="wcfm-select wcfm_attribute_taxonomy">
		<option value="add_attribute"><?php _e( 'Add attribute', 'pomana' ); ?></option>
	</select>
	<button type="button" class="button wcfm_add_attribute"><?php _e( 'Add', 'pomana' ); ?></button>
<?php } ?>
						</p>
						<div class="wcfm_clearfix"></div><br />
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				
				<?php do_action( 'after_wcfm_products_manage_attribute', $product_id, $product_type ); ?>
				
				<?php if( apply_filters( 'wcfm_is_allow_variable', true ) && apply_filters( 'wcfm_is_allow_pm_variable', true ) ) { ?>
				<!-- collapsible 7 -->
				<div class="page_collapsible products_manage_variations variable variations variable-subscription" id="wcfm_products_manage_form_variations_head"><label class="fas fa-tasks"></label><?php _e('Variations', 'pomana'); ?><span></span></div>
				<div class="wcfm-container variable variable-subscription">
				  <div id="wcfm_products_manage_form_variations_empty_expander" class="wcfm-content">
				    <?php printf( __( 'Before you can add a variation you need to add some variation attributes on the Attributes tab. %sLearn more%s', 'pomana' ), '<br /><h2><a class="wcfm_dashboard_item_title" target="_blank" href="' . apply_filters( 'wcfm_variations_help_link', 'https://docs.woocommerce.com/document/variable-product/' ) . '">', '</a></h2>' ); ?>
				  </div>
					<div id="wcfm_products_manage_form_variations_expander" class="wcfm-content">
					  <p>
<div class="default_attributes_holder">
  <p class="wcfm_title selectbox_title"><strong><?php _e( 'Default Form Values:', 'pomana' ); ?></strong></p>
	<input type="hidden" name="default_attributes_hidden" data-name="default_attributes_hidden" value="<?php echo esc_attr( $default_attributes ); ?>" />
</div>
						</p>
						<p>
						  <p class="variations_options wcfm_title"><strong><?php _e('Variations Bulk Options', 'pomana'); ?></strong></p>
						  <label class="screen-reader-text" for="variations_options"><?php _e('Variations Bulk Options', 'pomana'); ?></label>
						  <select id="variations_options" name="variations_options" class="wcfm-select wcfm_ele variable-subscription variable">
						    <option value="" selected="selected"><?php _e( 'Choose option', 'pomana' ); ?></option>
						    <optgroup label="<?php _e( 'Status', 'pomana' ); ?>">
	  <option value="on_enabled"><?php _e( 'Enable all Variations', 'pomana' ); ?></option>
	  <option value="off_enabled"><?php _e( 'Disable all Variations', 'pomana' ); ?></option>
	  <?php if( WCFM_Dependencies::wcfmu_plugin_active_check() && apply_filters( 'wcfmu_is_allow_downloadable', true ) && apply_filters( 'wcfmu_is_allow_pm_downloadable', true ) ) { ?>
			<option value="on_downloadable"><?php _e( 'Set variations "Downloadable"', 'pomana' ); ?></option>
			<option value="off_downloadable"><?php _e( 'Set variations "Non-Downloadable"', 'pomana' ); ?></option>
	  <?php } ?>
	  <?php if( apply_filters( 'wcfmu_is_allow_virtual', true ) && apply_filters( 'wcfmu_is_allow_pm_virtual', true ) ) { ?>
			<option value="on_virtual"><?php _e( 'Set variations "Virtual"', 'pomana' ); ?></option>
			<option value="off_virtual"><?php _e( 'Set variations "Non-Virtual"', 'pomana' ); ?></option>
		<?php } ?>
	</optgroup>
						    <optgroup label="<?php _e( 'Pricing', 'pomana' ); ?>">
		<option value="set_regular_price"><?php _e( 'Regular prices', 'pomana' ); ?></option>
		<option value="regular_price_increase"><?php _e( 'Regular price increase', 'pomana' ); ?></option>
		<option value="regular_price_decrease"><?php _e( 'Regular price decrease', 'pomana' ); ?></option>
		<option value="set_sale_price"><?php _e( 'Sale prices', 'pomana' ); ?></option>
		<option value="sale_price_increase"><?php _e( 'Sale price increase', 'pomana' ); ?></option>
		<option value="sale_price_decrease"><?php _e( 'Sale price decrease', 'pomana' ); ?></option>
	</optgroup>
	<?php if( apply_filters( 'wcfm_is_allow_inventory', true ) && apply_filters( 'wcfm_is_allow_pm_inventory', true ) ) { ?>
		<optgroup label="<?php _e( 'Inventory', 'pomana' ); ?>">
			<option value="on_manage_stock"><?php _e( 'ON "Manage stock"', 'pomana' ); ?></option>
			<option value="off_manage_stock"><?php _e( 'OFF "Manage stock"', 'pomana' ); ?></option>
			<option value="variable_stock"><?php _e( 'Stock', 'pomana' ); ?></option>
			<option value="variable_increase_stock"><?php _e( 'Increase Stock', 'pomana' ); ?></option>
			<option value="variable_stock_status_instock"><?php _e( 'Set Status - In stock', 'pomana' ); ?></option>
			<option value="variable_stock_status_outofstock"><?php _e( 'Set Status - Out of stock', 'pomana' ); ?></option>
			<option value="variable_stock_status_onbackorder"><?php _e( 'Set Status - On backorder', 'pomana' ); ?></option>
		</optgroup>
	<?php } ?>
	<?php if( apply_filters( 'wcfm_is_allow_shipping', true ) && apply_filters( 'wcfm_is_allow_pm_shipping', true ) ) { ?>
		<optgroup label="<?php _e( 'Shipping', 'pomana' ); ?>">
			<option value="set_length"><?php _e( 'Length', 'pomana' ); ?></option>
			<option value="set_width"><?php _e( 'Width', 'pomana' ); ?></option>
			<option value="set_height"><?php _e( 'Height', 'pomana' ); ?></option>
			<option value="set_weight"><?php _e( 'Weight', 'pomana' ); ?></option>
		</optgroup>
	<?php } ?>
	<?php if( WCFM_Dependencies::wcfmu_plugin_active_check() && apply_filters( 'wcfmu_is_allow_downloadable', true ) && apply_filters( 'wcfmu_is_allow_pm_downloadable', true ) ) { ?>
		<optgroup label="<?php _e( 'Downloadable products', 'pomana' ); ?>">
			<option value="variable_download_limit"><?php _e( 'Download limit', 'pomana' ); ?></option>
			<option value="variable_download_expiry"><?php _e( 'Download expiry', 'pomana' ); ?></option>
		</optgroup>
	<?php } ?>
						  </select>
						</p>
						<?php
						 $WCFM->wcfm_fields->wcfm_generate_form_field( array(  
					"variations" => array('type' => 'multiinput', 'class' => 'wcfm_ele variable variable-subscription', 'label_class' => 'wcfm_title', 'value' => $variations, 'options' => 
apply_filters( 'wcfm_product_manage_fields_variations', array(
"id" => array('type' => 'hidden', 'class' => 'variation_id'),
"enable" => array('label' => __('Enable', 'pomana'), 'type' => 'checkbox', 'value' => 'enable', 'dfvalue' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele variable variable-subscription', 'label_class' => 'wcfm_title checkbox_title'),
"is_virtual" => array('label' => __('Virtual', 'pomana'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele variable variable-subscription variation_is_virtual_ele', 'label_class' => 'wcfm_title checkbox_title'),
"manage_stock" => array('label' => __('Manage Stock', 'pomana'), 'type' => 'checkbox', 'value' => 'enable', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele variable variable-subscription variation_manage_stock_ele', 'label_class' => 'wcfm_title checkbox_title'),
"wcfm_element_breaker_variation_1" => array( 'type' => 'html', 'value' => '<div class="wcfm-cearfix"></div>'),
"image" => array('label' => __('Image', 'pomana'), 'type' => 'upload', 'class' => 'wcfm-text wcfm_ele variable variable-subscription', 'label_class' => 'wcfm_title wcfm_half_ele_upload_title'),
"wcfm_element_breaker_variation_2" => array( 'type' => 'html', 'value' => '<div class="wcfm-cearfix"></div>'),
"regular_price" => array('label' => __('Regular Price', 'pomana') . '(' . get_woocommerce_currency_symbol() . ')', 'type' => 'number', 'class' => 'wcfm-text wcfm_ele wcfm_non_negative_input wcfm_half_ele variable', 'label_class' => 'wcfm_title wcfm_ele wcfm_half_ele_title variable', 'attributes' => array( 'min' => '0.1', 'step'=> '0.1' ) ),
"sale_price" => array('label' => __('Sale Price', 'pomana') . '(' . get_woocommerce_currency_symbol() . ')', 'type' => 'number', 'class' => 'wcfm-text wcfm_ele wcfm_non_negative_input wcfm_half_ele variable variable-subscription', 'label_class' => 'wcfm_title wcfm_ele wcfm_half_ele_title variable variable-subscription', 'attributes' => array( 'min' => '0.1', 'step'=> '0.1' ) ),
"sale_price_dates_from" => array('label' => __('From', 'pomana'), 'type' => 'text', 'placeholder' => __( 'From', 'pomana' ) . ' ... YYYY-MM-DD', 'class' => 'wcfm-text wcfm_ele wcfm_half_ele var_sales_schedule_ele var_sale_date_from variable variable-subscription', 'label_class' => 'wcfm_ele wcfm_half_ele_title var_sales_schedule_ele variable variable-subscription'),
"sale_price_dates_to" => array('label' => __('Upto', 'pomana'), 'type' => 'text', 'placeholder' => __( 'To', 'pomana' ) . ' ... YYYY-MM-DD', 'class' => 'wcfm-text wcfm_ele wcfm_half_ele var_sales_schedule_ele var_sale_date_upto variable variable-subscription', 'label_class' => 'wcfm_ele wcfm_half_ele_title var_sales_schedule_ele wcfm_title variable variable-subscription'),
"stock_qty" => array('label' => __('Stock Qty', 'pomana') , 'type' => 'number', 'class' => 'wcfm-text wcfm_ele wcfm_half_ele variable variable-subscription variation_non_manage_stock_ele', 'label_class' => 'wcfm_title wcfm_half_ele_title variation_non_manage_stock_ele', 'attributes' => array( 'min' => '1', 'step'=> '1' ) ),
"backorders" => array('label' => __('Backorders?', 'pomana') , 'type' => 'select', 'options' => array('no' => __('Do not Allow', 'pomana'), 'notify' => __('Allow, but notify customer', 'pomana'), 'yes' => __('Allow', 'pomana')), 'class' => 'wcfm-select wcfm_ele wcfm_half_ele variable variable-subscription variation_non_manage_stock_ele', 'label_class' => 'wcfm_title wcfm_half_ele_title variation_non_manage_stock_ele'),
"sku" => array('label' => __('SKU', 'pomana'), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele wcfm_half_ele variable variable-subscription', 'label_class' => 'wcfm_title wcfm_half_ele_title'),
"stock_status" => array('label' => __('Stock status', 'pomana') , 'type' => 'select', 'options' => array('instock' => __('In stock', 'pomana'), 'outofstock' => __('Out of stock', 'pomana'), 'onbackorder' => __( 'On backorder', 'pomana' )), 'class' => 'wcfm-select wcfm_ele wcfm_half_ele variable variable-subscription variation_stock_status_ele', 'label_class' => 'wcfm_title wcfm_half_ele_title variation_stock_status_ele'), 
"attributes" => array('type' => 'hidden')
					), $variations, $variation_shipping_option_array, $variation_tax_classes_options, $products_array, $product_id, $product_type ) )
) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				<?php } ?>
				
				<?php do_action( 'after_wcfm_products_manage_variable', $product_id, $product_type ); ?>
				
				<?php 
				$wcfm_pm_block_class_linked = apply_filters( 'wcfm_pm_block_class_linked', 'simple variable external grouped' );
				if( !apply_filters( 'wcfm_is_allow_linked', true ) ) { 
				  $wcfm_pm_block_class_linked = 'wcfm_block_hide'; 
				}
				?>
				<!-- collapsible 8 - Linked Product -->
				<div class="page_collapsible products_manage_linked <?php echo esc_attr($wcfm_pm_block_class_linked) . ' ' . esc_attr($wcfm_wpml_edit_disable_element); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_linked', '' ); ?>" id="wcfm_products_manage_form_linked_head"><label class="fas fa-link"></label><?php _e('Linked', 'pomana'); ?><span></span></div>
				<div class="wcfm-container <?php echo esc_attr($wcfm_pm_block_class_linked) . ' ' . esc_attr($wcfm_wpml_edit_disable_element); ?> <?php echo apply_filters( 'wcfm_pm_block_custom_class_linked', '' ); ?>">
					<div id="wcfm_products_manage_form_linked_expander" class="wcfm-content">
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_manage_fields_linked', array(  
						"upsell_ids" => array('label' => __('Up-sells', 'pomana') , 'type' => 'select', 'attributes' => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ), 'class' => 'wcfm-select wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title', 'options' => $products_array, 'value' => $upsell_ids, 'hints' => __( 'Up-sells are products which you recommend instead of the currently viewed product, for example, products that are more profitable or better quality or more expensive.', 'pomana' )),
						"crosssell_ids" => array('label' => __('Cross-sells', 'pomana') , 'type' => 'select', 'attributes' => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ), 'class' => 'wcfm-select wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title', 'options' => $products_array, 'value' => $crosssell_ids, 'hints' => __( 'Cross-sells are products which you promote in the cart, based on the current product.', 'pomana' ))
	), $product_id, $products_array ) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				
				<?php do_action( 'after_wcfm_products_manage_linked', $product_id, $product_type ); ?>