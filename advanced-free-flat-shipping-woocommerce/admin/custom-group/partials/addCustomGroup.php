<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="row border-bottom align-items-center">
    <div class="col-12 py-2 bg-dark2">
        <strong class="h5 text-light"><?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ?  esc_html__('Edit Virtual Category','advanced-free-flat-shipping-woocommerce') : esc_html__('Add New Virtual Category','advanced-free-flat-shipping-woocommerce'); ?></strong>
    </div>
</div>
<form method="post" id="pisol-efrs-new-method">
<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_title" class="h6"><?php echo esc_html__('Virtual category name','advanced-free-flat-shipping-woocommerce'); ?> <span class="text-primary">*</span></label><?php pisol_help::tooltip(esc_html__('You can club multiple categories and product to form a virtual category of products and latter on use that inside the Shipping method rules','advanced-free-flat-shipping-woocommerce')); ?>
    </div>
    <div class="col-12 col-sm">
        <input type="text" required value="<?php echo esc_attr( $data['pi_title'] ); ?>" class="form-control" name="pi_title" id="pi_title">
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_desc" class="h6"><?php echo esc_html__('Description','advanced-free-flat-shipping-woocommerce'); ?></label><?php pisol_help::tooltip(esc_html__('This description is for your own reference','advanced-free-flat-shipping-woocommerce')); ?>
    </div>
    <div class="col-12 col-sm">
        <textarea type="text"  class="form-control" name="pi_desc" id="pi_desc"><?php echo esc_html( $data['pi_desc'] ); ?></textarea>
    </div>
</div>



 <div class="pi-step-container">
        <div class="pi-step-content">
            <div class="pi-step-header bg-primary text-light">
                <div>
                <strong class="pi-step-title"><?php echo esc_html__('Step 1: Choose Product Scope','advanced-free-flat-shipping-woocommerce'); ?><small></small></strong>
                <p class="font-italic text-light mb-0">Use filters below to include or exclude products  <a href="https://www.piwebsolution.com/advance-flat-rate-shipping/#Step_1_Choose_Product_Scope" target="_blank" class="text-light">(Know more about this ?)</a></p>
                </div>
                <div>
                    <span class="dashicons dashicons-plus-alt2 mr-4"></span>
                    <span class="dashicons dashicons-minus mr-4"></span>
                </div>
            </div>
            <div class="pi-step-description">
                <!-- filtering type -->
                <div class="row py-4 border-bottom align-items-center">
                    <div class="col-12 col-sm-4">
                        <label class="h6"><?php echo esc_html__('Include','advanced-free-flat-shipping-woocommerce'); ?></label><?php pisol_help::tooltip(esc_html__('You can add all the product in this virtual category and then exclude product or you can only add selected product to the virtual category','advanced-free-flat-shipping-woocommerce')); ?>
                    </div>
                    <div class="col-12 col-sm align-items-center">
                        <div class="row align-items-center">
                        <div class="col-12">
                        <input type="radio" name="pi_match_type" value="all" id="match-type-all" <?php checked($data['pi_match_type'], 'all'); ?>> <label for="match-type-all" class="my-0"><?php esc_html_e('All Products','advanced-free-flat-shipping-woocommerce'); ?></label><br>
                        <div class="mt-1"><i>Start from all products, then exclude the product you dont want to be part of this virtual category</i></div>
                        </div>
                        <div class="col-12 mt-4">
                        <input type="radio" name="pi_match_type" value="selected" id="match-type-selected" <?php checked($data['pi_match_type'], 'selected'); ?>> <label for="match-type-selected"  class="my-0"><?php esc_html_e('Selected Products','advanced-free-flat-shipping-woocommerce'); ?></label><br>
                        <div class="mt-1"><i>Start with an empty category, then add products to it manually</i></div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- End filtering type -->
            </div>
        </div>
</div>

<div id="pi-selection-columns">

    <div class="pi-step-container" id="pi-include-product-group">
        <div class="pi-step-content">
            <div class="pi-step-header bg-dark text-light">
                <div>
                <strong class="pi-step-title">Step <span id="pi-include-step-no">2</span>: <?php echo esc_html__('Add Products to This Virtual Category','advanced-free-flat-shipping-woocommerce'); ?><small></small></strong>
                <p class="font-italic text-light mb-0">Include product to this virtual category using the given conditions  <a href="https://www.piwebsolution.com/advance-flat-rate-shipping/#Step_2_Add_Products_to_This_Virtual_Category" target="_blank" class="text-light">(Know more about this ?)</a></p>
                </div>
                <div>
                    <span class="dashicons dashicons-plus-alt2 mr-4"></span>
                    <span class="dashicons dashicons-minus mr-4"></span>
                </div>
            </div>
            <div class="pi-step-description">
                <!-- include rule -->
                    <div class="row py-4 border-bottom align-items-center">
                        <div class="col-12 col-sm-5">
                            <label for="pi_categories" class="h6"><?php echo esc_html__('Categories to include','advanced-free-flat-shipping-woocommerce'); ?></label><?php pisol_help::tooltip(esc_html__('Product directly belonging to this category will be part of virtual category, product belonging to the child category of the included category will not be part of virtual category.','advanced-free-flat-shipping-woocommerce')); ?>
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="pi_efrs_custom_group_search_category form-control" name="pi_categories[]" multiple="multiple">
                                <?php echo wp_kses( self::savedCategories(  $data['pi_categories'] ), [
                                    'option' => [
                                        'value' => [],
                                        'selected' => [],
                                    ],
                                ]); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center">
                        <div class="col-12 col-sm-5">
                            <label for="pi_shipping_classes" class="h6"><?php echo esc_html__('Shipping class to include','advanced-free-flat-shipping-woocommerce'); ?></label><?php pisol_help::tooltip(esc_html__('Products belonging to this shipping class will be part of this virtual category','advanced-free-flat-shipping-woocommerce')); ?>
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="pi-efrs-custom-group-simple-select form-control" name="pi_shipping_classes[]" multiple="multiple">
                                <?php  
                                    $shipping_classes = self::allShippingClasses();
                                    $data['pi_shipping_classes'] = is_array($data['pi_shipping_classes']) ? $data['pi_shipping_classes'] : array();
                                    foreach($shipping_classes as $class_id => $class){
                                        echo '<option value="'.esc_attr($class_id).'" '.(in_array($class_id, $data['pi_shipping_classes']) ? ' selected="selected" ': '').'>'.esc_html($class).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_products" class="h6"><?php echo esc_html__('Products to include','advanced-free-flat-shipping-woocommerce'); ?></label><p class="font-italic"><?php esc_html_e('Product that you want to be part of this virtual category, you can even include a variation of a product','advanced-free-flat-shipping-woocommerce'); ?></p>
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="pi_efrs_custom_group_search_product form-control" name="pi_products[]" multiple="multiple">
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_product_tags" class="h6"><?php echo esc_html__('Product tags to include','advanced-free-flat-shipping-woocommerce'); ?></label><p class="font-italic"><?php esc_html_e('Product with this tags will be part of this virtual category','advanced-free-flat-shipping-woocommerce'); ?></p>
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="pi_efrs_custom_group_search_tag form-control" name="pi_product_tags[]" multiple="multiple">
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_product_dimension" class="h6">Product dimension</label>
                            <p class="font-italic"><?php esc_html_e('Product with this similar dimension will be considered','advanced-free-flat-shipping-woocommerce'); ?></p>
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_product_length" placeholder="Length" value="">
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_product_width" placeholder="Width" value="">
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_product_height" placeholder="Height" value="">
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_product_volume" class="h6">Product with volume</label>
                            <p class="font-italic"><?php esc_html_e('Product with volume matching the logic will be selected, volume of a product is length x width x height','advanced-free-flat-shipping-woocommerce'); ?></p>                    
                        </div>
                        <div class="col-12 col-sm-4">
                            <select type="text" class="form-control" name="pi_product_volume_logic">
                                <option value="" selected="selected">Don't consider this rule</option>
                                <option value="equal_to">Equal to</option>
                                <option value="less_equal_to">Less then equal to</option>
                                <option value="less_then">Less then</option>
                                <option value="greater_equal_to">Grater then equal to</option>
                                <option value="greater_then">Grater then</option>
                                <option value="not_equal_to">Not equal to</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_product_volume" placeholder="Volume" value="">
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-4">
                            <label class="h6">Product attribute to include</label>
                            <p class="font-italic"><?php esc_html_e('Products having this attribute will be part of this virtual category','advanced-free-flat-shipping-woocommerce'); ?></p>                    
                        </div>
                        <div class="col-12 col-sm">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="javascript:void(0)" id="pi_product_attributes_add_attribute" class=" btn btn-md btn-dark" data-type="pi_product_attributes">Add Attribute</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_stock_status" class="h6"><?php echo esc_html__('Include product with Stock status','advanced-free-flat-shipping-woocommerce'); ?></label>
                            <p class="font-italic"><?php esc_html_e('Product stock status will decide if product can be part of this virtual category or not','advanced-free-flat-shipping-woocommerce'); ?></p>
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="form-control" name="pi_stock_status" id="pi_stock_status">
                                <?php  
                                    $stock_status = array(
                                        'instock' => __('In stock','advanced-free-flat-shipping-woocommerce'),
                                        'onbackorder' => __('On backorder','advanced-free-flat-shipping-woocommerce'),
                                    );
                                    
                                    echo '<option value="">'.esc_html__('Select product (In Stock / On Back Order)','advanced-free-flat-shipping-woocommerce').'</option>';
                                    foreach($stock_status as $status_id => $status){
                                        $select_status = '';
                                        echo '<option value="'.esc_attr($status_id).'" >'.esc_html($status).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_product_subtotal" class="h6"><?php echo esc_html__('Include Product with subtotal','advanced-free-flat-shipping-woocommerce'); ?></label>
                            <p class="font-italic"><?php esc_html_e('Product with subtotal matching the logic will be excluded from the group','advanced-free-flat-shipping-woocommerce'); ?></p>
                        </div>
                        <div class="col-12 col-sm-4">
                            <select type="text" class="form-control" name="pi_product_subtotal_logic">
                                <option value=""><?php echo esc_html_e('Don\'t consider this rule','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="equal_to"><?php echo esc_html_e('Equal to','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="less_equal_to"><?php echo esc_html_e('Less then equal to','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="less_then"><?php echo esc_html_e('Less then','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="greater_equal_to"><?php echo esc_html_e('Grater then equal to','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="greater_then"><?php echo esc_html_e('Grater then','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="not_equal_to"><?php echo esc_html_e('Not equal to','advanced-free-flat-shipping-woocommerce'); ?></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_product_subtotal" placeholder="<?php esc_attr_e('Insert subtotal','advanced-free-flat-shipping-woocommerce'); ?>">
                        </div>
                    </div>
                <!-- end include rule -->
            </div>
        </div>
    </div>

    <div class="pi-step-container" id="pi-exclude-product-group">
        <div class="pi-step-content">
            <div class="pi-step-header bg-dark text-light">
                <div>
                <strong class="pi-step-title">Step <span id="pi-exclude-step-no">3</span>: <?php echo esc_html__('Exclude Products from This Category','advanced-free-flat-shipping-woocommerce'); ?><small></small></strong>
                <p class="font-italic text-light mb-0">Exclude product from this virtual category using the given conditions  <a href="https://www.piwebsolution.com/advance-flat-rate-shipping/#Step_3_Exclude_Products_from_This_Category" target="_blank" class="text-light">(Know more about this ?)</a></p>
                </div>
                <div>
                    <span class="dashicons dashicons-plus-alt2 mr-4"></span>
                    <span class="dashicons dashicons-minus mr-4"></span>
                </div>
            </div>
            <div class="pi-step-description">
                <!-- include rule -->
                    <div class="row py-4 border-bottom align-items-center">
                        <div class="col-12 col-sm-5">
                            <label for="pi_excluded_categories" class="h6"><?php echo esc_html__('Categories to exclude','advanced-free-flat-shipping-woocommerce'); ?></label><?php pisol_help::tooltip(esc_html__('Product directly belonging to this category will be excluded from virtual category','advanced-free-flat-shipping-woocommerce')); ?>
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="pi_efrs_custom_group_search_category form-control" name="pi_excluded_categories[]" multiple="multiple">
                                <?php echo wp_kses( self::savedCategories(  $data['pi_excluded_categories'] ) , [
                                    'option' => [
                                        'value' => [],
                                        'selected' => [],
                                    ],
                                ]); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center">
                        <div class="col-12 col-sm-5">
                            <label for="pi_excluded_shipping_classes" class="h6"><?php echo esc_html__('Shipping class to exclude','advanced-free-flat-shipping-woocommerce'); ?></label><?php pisol_help::tooltip(esc_html__('Products belonging to this shipping class will not be part of virtual category','advanced-free-flat-shipping-woocommerce')); ?>
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="pi-efrs-custom-group-simple-select form-control" name="pi_excluded_shipping_classes[]" multiple="multiple">
                                <?php  
                                    $data['pi_excluded_shipping_classes'] = is_array($data['pi_excluded_shipping_classes']) ? $data['pi_excluded_shipping_classes'] : array();
                                    foreach($shipping_classes as $class_id2 => $class2){
                                        echo '<option value="'.esc_attr($class_id2).'" '.(in_array($class_id2, $data['pi_excluded_shipping_classes']) ? ' selected="selected" ': '').'>'.esc_html($class2).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_excluded_products" class="h6"><?php echo esc_html__('Products to exclude','advanced-free-flat-shipping-woocommerce'); ?></label>
                            <p class="font-italic"><?php esc_html_e('Product that you want to be excluded from this virtual category, you can even include a variation of a product','advanced-free-flat-shipping-woocommerce'); ?></p>
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="pi_efrs_custom_group_search_product form-control" name="pi_excluded_products[]" multiple="multiple">
                            </select>
                        </div>
                    </div>
                    
                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_excluded_product_vir_down" class="h6">Downloadable product to exclude</label>
                            <p class="font-italic"><?php esc_html_e('Downloadable product not be part of this virtual category','advanced-free-flat-shipping-woocommerce'); ?></p>                 
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="pi-efrs-custom-group-simple-select form-control select2-hidden-accessible" name="pi_excluded_product_vir_down[]" multiple="" tabindex="-1" aria-hidden="true">
                                <option value="downloadable">Downloadable</option>                        
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_excluded_product_dimension" class="h6">Product dimension</label>
                            <p class="font-italic"><?php esc_html_e('Product with this similar dimension will be considered','advanced-free-flat-shipping-woocommerce'); ?></p>                     
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_excluded_product_length" placeholder="Length" value="">
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_excluded_product_width" placeholder="Width" value="">
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_excluded_product_height" placeholder="Height" value="">
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_product_excluded_volume" class="h6">Product with volume</label>
                            <p class="font-italic"><?php esc_html_e('Product with volume matching the logic will be selected, volume of a product is length x width x height','advanced-free-flat-shipping-woocommerce'); ?></p>                     
                        </div>
                        <div class="col-12 col-sm-4">
                            <select type="text" class="form-control" name="pi_excluded_product_volume_logic">
                                <option value="" selected="selected">Don't consider this rule</option>
                                <option value="equal_to">Equal to</option>
                                <option value="less_equal_to">Less then equal to</option>
                                <option value="less_then">Less then</option>
                                <option value="greater_equal_to">Grater then equal to</option>
                                <option value="greater_then">Grater then</option>
                                <option value="not_equal_to">Not equal to</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_excluded_product_volume" placeholder="Volume" value="">
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-4">
                            <label class="h6">Product attribute to exclude</label> 
                            <p class="font-italic"><?php esc_html_e('Products having this attribute will be excluded from virtual category','advanced-free-flat-shipping-woocommerce'); ?></p>                    
                        </div>
                        <div class="col-12 col-sm">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="javascript:void(0)" id="pi_excluded_product_attributes_add_attribute" class=" btn btn-md btn-dark" data-type="pi_excluded_product_attributes">Add Attribute</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_excluded_stock_status" class="h6"><?php echo esc_html__('Exclude product with Stock status','advanced-free-flat-shipping-woocommerce'); ?></label>
                            <p class="font-italic"><?php esc_html_e('Product stock status will decide if product can be part of this virtual category or not','advanced-free-flat-shipping-woocommerce'); ?></p> 
                        </div>
                        <div class="col-12 col-sm">
                            <select type="text" class="form-control" name="pi_excluded_stock_status" id="pi_excluded_stock_status">
                                <?php  
                                    $stock_status = array(
                                        'instock' => __('In stock','advanced-free-flat-shipping-woocommerce'),
                                        'onbackorder' => __('On backorder','advanced-free-flat-shipping-woocommerce'),
                                    );
                                    
                                    echo '<option value="">'.esc_html__('Select product (In Stock / On Back Order)','advanced-free-flat-shipping-woocommerce').'</option>';
                                    foreach($stock_status as $status_id => $status){
                                        $select_status =  '';
                                        echo '<option value="'.esc_attr($status_id).'" >'.esc_html($status).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row py-4 border-bottom align-items-center free-version">
                        <div class="col-12 col-sm-5">
                            <label for="pi_excluded_product_subtotal" class="h6"><?php echo esc_html__('Exclude Product with subtotal','advanced-free-flat-shipping-woocommerce'); ?></label>
                            <p class="font-italic"><?php esc_html_e('Product with subtotal matching the logic will be excluded from the group','advanced-free-flat-shipping-woocommerce'); ?></p> 
                        </div>
                        <div class="col-12 col-sm-4">
                            <select type="text" class="form-control" name="pi_excluded_product_subtotal_logic">
                                <option value=""><?php echo esc_html__('Don\'t consider this rule','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="equal_to"><?php echo esc_html__('Equal to','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="less_equal_to"><?php echo esc_html__('Less then equal to','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="less_then"><?php echo esc_html__('Less then','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="greater_equal_to"><?php echo esc_html__('Grater then equal to','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="greater_then"><?php echo esc_html__('Grater then','advanced-free-flat-shipping-woocommerce'); ?></option>
                                <option value="not_equal_to"><?php echo esc_html__('Not equal to','advanced-free-flat-shipping-woocommerce'); ?></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <input type="number" class="form-control" step="0.01" min="0" name="pi_excluded_product_subtotal" placeholder="<?php echo esc_attr__('Insert subtotal','advanced-free-flat-shipping-woocommerce'); ?>">
                        </div>
                    </div>
                <!-- end include rule -->
            </div>
        </div>
    </div>

</div>


<?php wp_nonce_field( 'add_custom_group', 'pisol_efrs_nonce'); ?>
<input type="hidden" name="post_type" value="pi_efrs_custom_group">
<input type="hidden" name="post_id" value="<?php echo esc_attr( $data['post_id'] ); ?>">
<input type="hidden" name="action" value="pisol_efrs_save_custom_group">
<input type="submit" value="<?php esc_attr_e('Save Virtual Category','advanced-free-flat-shipping-woocommerce'); ?>" name="submit" class="my-3 btn btn-primary btn-md" id="pi-efrs-new-shipping-method-form">
</form>
