<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="row border-bottom align-items-center">
    <div class="col-12 py-2 bg-secondary">
        <strong class="h5 text-light"><?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ?  __('Edit shipping method','extended-flat-rate-shipping-woocommerce') : __('Add new shipping method','extended-flat-rate-shipping-woocommerce'); ?></strong>
    </div>
</div>
<form method="post" id="pisol-efrs-new-method">
<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_status" class="h6"><?php echo __('Status','advanced-free-flat-shipping-woocommerce'); ?></label>
    </div>
    <div class="col-12 col-sm">
        <div class="custom-control custom-switch">
        <input type="checkbox" value="1" <?php echo $data['pi_status']; ?> class="custom-control-input" name="pi_status" id="pi_status">
        <label class="custom-control-label" for="pi_status"></label>
        </div>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_title" class="h6"><?php echo __('Shipping Method Name','advanced-free-flat-shipping-woocommerce'); ?> <span class="text-primary">*</span></label>
    </div>
    <div class="col-12 col-sm">
        <input type="text" required value="<?php echo $data['pi_title']; ?>" class="form-control" name="pi_title" id="pi_title">
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_cost" class="h6"><?php echo __('Shipping Charges','advanced-free-flat-shipping-woocommerce'); ?> <?php echo '(' . get_woocommerce_currency_symbol() . ')' ?> <span class="text-primary">*</span></label> <?php pisol_help::inline('shipping_charge_short_code_help','Creating complex shipping charges using short code'); ?>
    </div>
    <div class="col-12 col-sm">
        <input type="number" required value="<?php echo $data['pi_cost']; ?>" class="form-control" name="pi_cost" id="pi_cost" step="any" min="0">
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_desc" class="h6"><?php echo __('Description','advanced-free-flat-shipping-woocommerce'); ?></label> <?php pisol_help::tooltip('You can show this description below the shipping method name on the front end of the website by enabling the option present in the Extra settings tab'); ?>
    </div>
    <div class="col-12 col-sm">
        <textarea type="text"  class="form-control" name="pi_desc" id="pi_desc"><?php echo $data['pi_desc']; ?></textarea>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_is_taxable" class="h6"><?php echo __('Taxable','advanced-free-flat-shipping-woocommerce'); ?></label>
    </div>
    <div class="col-12 col-sm">
        <select class="form-control" name="pi_is_taxable" id="pi_is_taxable">
            <option value="no" <?php selected( $data['pi_is_taxable'], "no" ); ?>>No</option>
            <option value="yes" <?php selected( $data['pi_is_taxable'], "yes" ); ?>>Yes</option>
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_free_when_free_shipping_coupon" class="h6"><?php echo __('Make free when free shipping coupon is applied','extended-flat-rate-shipping-woocommerce'); ?></label>
        <p>Cost of this shipping method will become zero when user will apply Free shipping coupon</p>
    </div>
    <div class="col-12 col-sm">
        <div class="custom-control custom-switch">
        <input type="checkbox" value="1" <?php echo $data['pi_free_when_free_shipping_coupon']; ?> class="custom-control-input" name="pi_free_when_free_shipping_coupon" id="pi_free_when_free_shipping_coupon">
        <label class="custom-control-label" for="pi_free_when_free_shipping_coupon"></label>
        </div>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_currency" class="h6"><?php echo __('Apply for currency (useful for multi currency website only)','extended-flat-rate-shipping-woocommerce'); ?></label><br><strong>Leave empty if you want to apply for all currency OR you have single currency</strong><?php pisol_help::tooltip('Select the currency for which to apply the rule, if left blank it will apply for all the currency'); ?>
    </div>
    <div class="col-12 col-sm">
        <select name="pi_currency[]" id="pi_currency" multiple="multiple">
                <?php self::get_currency($data['pi_currency']); ?>
        </select>
    </div>
</div>

<div class="border-bottom">
<?php
$selection_rule_obj = new Pi_efrs_selection_rule_main(
    __('Below conditions determine when to show this shipping method','advanced-free-flat-shipping-woocommerce'),
    $data['pi_metabox'], $data
);
wp_nonce_field( 'add_shipping_method', 'pisol_efrs_nonce');
?>
</div>

<div class="row py-4 border-bottom align-items-center bg-secondary">
<div class="col-12 col-md-5">
        <label for="pi_enable_other_method_modification" class="h6 text-light"><?php echo __('Modify other shipping methods when this method is applied','advanced-free-flat-shipping-woocommerce'); ?><?php pisol_help::tooltip('What happens to other shipping method when this shipping method becomes available for selection'); ?>
        <br>
        <span class="text-warning">(This is only available in pro)</span>
        </label>
    </div>
<div class="col-12 col-md">
<select name="pi_what_to_do_to_other_methods-pro" id="" class="form-control">
    <option value="" selected="selected" >Select an option</option>
    <option value="hide-all-other-methods" disabled>Hide all other methods (PRO)</option>
    <option value="hide-all-other-methods-exclude-local-pickup" disabled>Hide all other methods (excluding WC Local Pickup method) (PRO)</option>
    <option value="hide-all-non-plugin-methods-exclude-local-pickup" disabled>Hide all methods except the one added by this plugin and WC Local pickup (PRO)</option>
    <option value="hide-all-non-plugin-methods" disabled>Hide all methods except the one added by this plugin (PRO)</option>
    <option value="hide-all-plugin-method-with-lower-priority" disabled>Hide all plugin methods with lower priority (PRO)</option>
</select>
</div>
</div>

<div class="row py-4 border-bottom align-items-center bg-secondary">
    <div class="col-12">
        <strong class="h6 text-light"><?php echo __("Shipping Classes",'advanced-free-flat-shipping-woocommerce'); ?></strong><?php pisol_help::tooltip('These costs can optionally be added to shipping charge based on the product shipping class'); ?>
    </div>
</div>
<?php if(!empty($data['present_shipping_classes'])){ ?>
<?php foreach($data['present_shipping_classes'] as $shipping_class): 
    $shipping_extra_cost = isset( $data['shipping_extra_cost']["$shipping_class->term_id"] ) && ( $data['shipping_extra_cost']["$shipping_class->term_id"] !== '' ) ? $data['shipping_extra_cost']["$shipping_class->term_id"] : "";
    ?>
<div class="row py-2 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
    <label for="extra_cost_<?php echo esc_attr( $shipping_class->term_id ); ?>"><?php echo esc_html( $shipping_class->name ); ?></label> <?php pisol_help::inline('shipping_class_charge_short_code_help','Creating complex shipping charges for shipping class'); ?>
    </div>
    <div class="col-12 col-sm">
    <input type="text" name="shipping_extra_cost[<?php echo esc_attr( $shipping_class->term_id ); ?>]" class="text-class"
										       id="shipping_extra_cost_<?php echo esc_attr( $shipping_class->term_id ); ?>" value="<?php echo htmlentities( $shipping_extra_cost ); ?>"
										       placeholder="<?php echo get_woocommerce_currency_symbol(); ?>">
    </div>
</div>
<?php endforeach; ?>
<?php } ?>
<div class="row py-2 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
    <label for="pi_extra_cost_calc_type"><?php echo __('Calculation type','advanced-free-flat-shipping-woocommerce'); ?></label>
    </div>
    <div class="col-12 col-sm">
        <select class="form-control" name="pi_extra_cost_calc_type" id="pi_extra_cost_calc_type" >
			<option value="class" <?php selected( $data['pi_extra_cost_calc_type'], "class" ); ?>>Per class: Charge shipping for each shipping class individually</option>
			<option value="order" <?php selected( $data['pi_extra_cost_calc_type'], "order" ); ?>>Per order: Charge shipping for the most expensive shipping class</option>
		</select>
    </div>
</div>


<?php do_action('pi_efrs_extra_form_fields', $data); ?>

<input type="hidden" name="post_type" value="pi_shipping_method">
<input type="hidden" name="post_id" value="<?php echo $data['post_id']; ?>">
<input type="hidden" name="action" value="pisol_efrs_save_method">
<input type="submit" value="Save Method" name="submit" class="m-2 mt-5 btn btn-primary btn-lg">
</form>
