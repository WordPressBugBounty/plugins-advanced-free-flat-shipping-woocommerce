<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="row border-bottom align-items-center">
    <div class="col-12 py-2 bg-primary">
        <strong class="h5 text-light"><?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ?  __('Edit Virtual Category','extended-flat-rate-shipping-woocommerce') : __('Add New Virtual Category','extended-flat-rate-shipping-woocommerce'); ?></strong>
    </div>
</div>
<form method="post" id="pisol-efrs-new-method">
<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_title" class="h6"><?php echo __('Virtual category name','extended-flat-rate-shipping-woocommerce'); ?> <span class="text-primary">*</span></label><?php pisol_help::tooltip('You can club multiple categories and product to form a virtual category of products and latter on use that inside the Shipping method rules'); ?>
    </div>
    <div class="col-12 col-sm">
        <input type="text" required value="<?php echo $data['pi_title']; ?>" class="form-control" name="pi_title" id="pi_title">
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_desc" class="h6"><?php echo __('Description','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('This description is for your own reference'); ?>
    </div>
    <div class="col-12 col-sm">
        <textarea type="text"  class="form-control" name="pi_desc" id="pi_desc"><?php echo $data['pi_desc']; ?></textarea>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label class="h6"><?php echo __('Include','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('You can add all the product in this virtual category and then exclude product or you can only add selected product to the virtual category'); ?>
    </div>
    <div class="col-12 col-sm align-items-center">
        <div class="row align-items-center">
        <div class="col-6">
        <input type="radio" name="pi_match_type" value="all" id="match-type-all" <?php checked($data['pi_match_type'], 'all'); ?>> <label for="match-type-all" class="my-0">All Products</label>
        </div>
        <div class="col-6">
        <input type="radio" name="pi_match_type" value="selected" id="match-type-selected" <?php checked($data['pi_match_type'], 'selected'); ?>> <label for="match-type-selected"  class="my-0">Selected Products</label>
        </div>
        </div>
    </div>
</div>

<div id="pi-selection-columns">

<div id="pi-include-product-group">
<div class="row py-4 border-bottom align-items-center bg-secondary">
    <div class="col-12">
        <strong class="h6 text-light"><?php echo __("Include Products",'extended-flat-rate-shipping-woocommerce'); ?></strong><?php pisol_help::tooltip('Include product to this virtual group using below selectors'); ?>
    </div>
</div>
<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_categories" class="h6"><?php echo __('Categories to include','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Product directly belonging to this category will be part of virtual category, product belonging to the child category of the included category will not be part of virtual category.'); ?>
    </div>
    <div class="col-12 col-sm">
        <select type="text" class="pi_efrs_custom_group_search_category form-control" name="pi_categories[]" multiple="multiple">
            <?php echo self::savedCategories(  $data['pi_categories'] ); ?>
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_shipping_classes" class="h6"><?php echo __('Shipping class to include','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Products belonging to this shipping class will be part of this virtual category'); ?>
    </div>
    <div class="col-12 col-sm">
        <select type="text" class="pi-efrs-custom-group-simple-select form-control" name="pi_shipping_classes[]" multiple="multiple">
            <?php  
                $shipping_classes = self::allShippingClasses();
                $data['pi_shipping_classes'] = is_array($data['pi_shipping_classes']) ? $data['pi_shipping_classes'] : array();
                foreach($shipping_classes as $class_id => $class){
                    $select_status = in_array($class_id, $data['pi_shipping_classes']) ? ' selected="selected" ': '';
                    echo '<option value="'.esc_attr($class_id).'" '.$select_status.'>'.esc_html($class).'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center free-version">
    <div class="col-12 col-sm-5">
        <label for="pi_products" class="h6"><?php echo __('Products to include','extended-flat-rate-shipping-woocommerce'); ?></label><p>Product that you want to be part of this virtual category, you can even include a variation of a product</p>
    </div>
    <div class="col-12 col-sm">
        <select type="text" class="pi_efrs_custom_group_search_product form-control" name="pi_products[]" multiple="multiple">
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center free-version">
    <div class="col-12 col-sm-5">
        <label for="pi_stock_status" class="h6"><?php echo __('Include product with Stock status','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Product stock status will decide if product can be part of this virtual category or not'); ?>
    </div>
    <div class="col-12 col-sm">
        <select type="text" class="form-control" name="pi_stock_status" id="pi_stock_status">
            <?php  
                $stock_status = array(
                    'instock' => __('In stock','extended-flat-rate-shipping-woocommerce'),
                    'onbackorder' => __('On backorder','extended-flat-rate-shipping-woocommerce'),
                );
                
                echo '<option value="">'.__('Select product (In Stock / On Back Order)','extended-flat-rate-shipping-woocommerce').'</option>';
                foreach($stock_status as $status_id => $status){
                    $select_status = '';
                    echo '<option value="'.esc_attr($status_id).'" '.$select_status.'>'.esc_html($status).'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center free-version">
    <div class="col-12 col-sm-5">
        <label for="pi_product_subtotal" class="h6"><?php echo __('Include Product with subtotal','conditional-extra-fees-woocommerce'); ?></label><?php pisol_help::tooltip('Product with subtotal matching the logic will be excluded from the group'); ?>
    </div>
    <div class="col-12 col-sm-4">
        <select type="text" class="form-control" name="pi_product_subtotal_logic">
            <option value="">Don't consider this rule</option>
            <option value="equal_to">Equal to</option>
            <option value="less_equal_to">Less then equal to</option>
            <option value="less_then">Less then</option>
            <option value="greater_equal_to">Grater then equal to</option>
            <option value="greater_then">Grater then</option>
            <option value="not_equal_to">Not equal to</option>
        </select>
    </div>
    <div class="col-12 col-sm-3">
        <input type="number" class="form-control" step="0.01" min="0" name="pi_product_subtotal" placeholder="insert subtotal">
    </div>
</div>

</div>


<div id="pi-exclude-product-group">
<div class="row py-4 border-bottom align-items-center bg-danger">
    <div class="col-12">
        <strong class="h6 text-light"><?php echo __("Exclude Products",'extended-flat-rate-shipping-woocommerce'); ?></strong><?php pisol_help::tooltip('Exclude product from this virtual group using below selectors'); ?>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_excluded_categories" class="h6"><?php echo __('Categories to exclude','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Product directly belonging to this category will be excluded from virtual category'); ?>
    </div>
    <div class="col-12 col-sm">
        <select type="text" class="pi_efrs_custom_group_search_category form-control" name="pi_excluded_categories[]" multiple="multiple">
            <?php echo self::savedCategories(  $data['pi_excluded_categories'] ); ?>
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_excluded_shipping_classes" class="h6"><?php echo __('Shipping class to exclude','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Products belonging to this shipping class will not be part of virtual category'); ?>
    </div>
    <div class="col-12 col-sm">
        <select type="text" class="pi-efrs-custom-group-simple-select form-control" name="pi_excluded_shipping_classes[]" multiple="multiple">
            <?php  
                $data['pi_excluded_shipping_classes'] = is_array($data['pi_excluded_shipping_classes']) ? $data['pi_excluded_shipping_classes'] : array();
                foreach($shipping_classes as $class_id2 => $class2){
                    $select_status2 = in_array($class_id2, $data['pi_excluded_shipping_classes']) ? ' selected="selected" ': '';
                    echo '<option value="'.esc_attr($class_id2).'" '.$select_status2.'>'.esc_html($class2).'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center free-version">
    <div class="col-12 col-sm-5">
        <label for="pi_excluded_products" class="h6"><?php echo __('Products to exclude','extended-flat-rate-shipping-woocommerce'); ?></label><p>Product that you want to be excluded from this virtual category, you can even include a variation of a product</p>
    </div>
    <div class="col-12 col-sm">
        <select type="text" class="pi_efrs_custom_group_search_product form-control" name="pi_excluded_products[]" multiple="multiple">
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center free-version">
    <div class="col-12 col-sm-5">
        <label for="pi_excluded_stock_status" class="h6"><?php echo __('Exclude product with Stock status','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Product stock status will decide if product can be part of this virtual category or not'); ?>
    </div>
    <div class="col-12 col-sm">
        <select type="text" class="form-control" name="pi_excluded_stock_status" id="pi_excluded_stock_status">
            <?php  
                $stock_status = array(
                    'instock' => __('In stock','extended-flat-rate-shipping-woocommerce'),
                    'onbackorder' => __('On backorder','extended-flat-rate-shipping-woocommerce'),
                );
                
                echo '<option value="">'.__('Select product (In Stock / On Back Order)','extended-flat-rate-shipping-woocommerce').'</option>';
                foreach($stock_status as $status_id => $status){
                    $select_status =  '';
                    echo '<option value="'.esc_attr($status_id).'" '.$select_status.'>'.esc_html($status).'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center free-version">
    <div class="col-12 col-sm-5">
        <label for="pi_excluded_product_subtotal" class="h6"><?php echo __('Exclude Product with subtotal','conditional-extra-fees-woocommerce'); ?></label><?php pisol_help::tooltip('Product with subtotal matching the logic will be excluded from the group'); ?>
    </div>
    <div class="col-12 col-sm-4">
        <select type="text" class="form-control" name="pi_excluded_product_subtotal_logic">
            <option value="">Don't consider this rule</option>
            <option value="equal_to">Equal to</option>
            <option value="less_equal_to">Less then equal to</option>
            <option value="less_then">Less then</option>
            <option value="greater_equal_to">Grater then equal to</option>
            <option value="greater_then">Grater then</option>
            <option value="not_equal_to">Not equal to</option>
        </select>
    </div>
    <div class="col-12 col-sm-3">
        <input type="number" class="form-control" step="0.01" min="0" name="pi_excluded_product_subtotal" placeholder="insert subtotal">
    </div>
</div>

</div>

</div>


<?php wp_nonce_field( 'add_custom_group', 'pisol_efrs_nonce'); ?>
<input type="hidden" name="post_type" value="pi_efrs_custom_group">
<input type="hidden" name="post_id" value="<?php echo $data['post_id']; ?>">
<input type="hidden" name="action" value="pisol_efrs_save_custom_group">
<input type="submit" value="Save Package" name="submit" class="m-2 mt-5 btn btn-primary btn-lg" id="pi-efrs-new-shipping-method-form">
</form>
