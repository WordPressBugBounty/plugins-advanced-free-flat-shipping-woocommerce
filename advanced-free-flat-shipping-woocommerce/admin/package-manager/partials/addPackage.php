<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="row border-bottom align-items-center">
    <div class="col-12 py-2 bg-primary">
        <strong class="h5 text-light"><?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ?  __('Edit Package','extended-flat-rate-shipping-woocommerce') : __('Add New Package','extended-flat-rate-shipping-woocommerce'); ?></strong>
    </div>
</div>
<form method="post" id="pisol-efrs-new-method">
<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_status" class="h6"><?php echo __('Status','extended-flat-rate-shipping-woocommerce'); ?></label>
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
        <label for="pi_priority" class="h6"><?php echo __('Package priority','extended-flat-rate-shipping-woocommerce'); ?></label>
    </div>
    <div class="col-12 col-sm">
        <input type="number" value="<?php echo $data['pi_priority']; ?>" step="1"  class="form-control" name="pi_priority" id="pi_priority">
    </div>
</div>

<div class="row py-4 border-bottom align-items-center">
    <div class="col-12 col-sm-5">
        <label for="pi_title" class="h6"><?php echo __('Package name','extended-flat-rate-shipping-woocommerce'); ?> <span class="text-primary">*</span></label><?php pisol_help::tooltip('You can club product in multiple shipping package withing one order and user can select different shipping method for each such package'); ?>
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
        <label for="pi_desc" class="h6"><?php echo __('Select Virtual category','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Product belonging to this virtual category will be grouped as one shipping package'); ?>
    </div>
    <div class="col-12 col-sm">
        <?php
            $groups = get_posts(array(
                'post_type'=>'pi_efrs_custom_group',
                'numberposts'      => -1
            ));

            if(empty($groups)){
                echo '<div class="alert alert-warning">'.__('Create a Virtual category first','extended-flat-rate-shipping-woocommerce').' <a class="btn btn-primary btn-sm mr-3" href="'.admin_url( 'admin.php?page=pisol-efrs-notification&tab=pi_efrs_add_custom_group' ).'"><span class="dashicons dashicons-plus"></span> Add virtual category</a></div>';
            }else{
        ?>
        <select name="pi_group" id="pi_group" class="form-control" required="required">
            <option value=""><?php echo __('Select Virtual Category','extended-flat-rate-shipping-woocommerce'); ?></option>
            <?php
            $groups = get_posts(array(
                'post_type'=>'pi_efrs_custom_group',
                'numberposts'      => -1
            ));
            foreach($groups as $group){
                $selected = $data['pi_group'] == $group->ID ? 'selected' : '';
                echo '<option '.$selected.' value="'.$group->ID.'">'.get_the_title( $group->ID ).'</option>';
            }
        ?>
        </select>
        <?php
            }
        ?>
    </div>
</div>

<div class="row py-4 border-bottom align-items-center free-version">
    <div class="col-12 col-sm-5">
        <label for="pi_subtotal_logic" class="h6"><?php echo __('When virtual category products total','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Create package when Virtual category product subtotal satisfies the selected logic'); ?>
    </div>
    <div class="col-12 col-sm-3">
        <select name="pi_subtotal_logic" id="pi_subtotal_logic" class="form-control">
            <option <?php echo empty($data['pi_subtotal_logic']) ? 'selected' : ''; ?> value=""><?php echo __('Select Logic','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_subtotal_logic'] == 'greater' ? 'selected' : ''; ?> value="greater"><?php echo __('Greater than','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_subtotal_logic'] == 'greater_equal' ? 'selected' : ''; ?> value="greater_equal"><?php echo __('Greater than equal to','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_subtotal_logic'] == 'less' ? 'selected' : ''; ?> value="less"><?php echo __('Less than','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_subtotal_logic'] == 'less_equal' ? 'selected' : ''; ?> value="less_equal"><?php echo __('Less than equal to','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_subtotal_logic'] == 'equal' ? 'selected' : ''; ?> value="equal"><?php echo __('Equal to','extended-flat-rate-shipping-woocommerce'); ?></option>
        </select>
    </div>
    <div class="col-12 col-sm-3">
        <input type="number" value="<?php echo $data['pi_subtotal']; ?>" step="0.001"  class="form-control" name="pi_subtotal" id="pi_subtotal" placeholder="Total">
    </div>
</div>

<div class="row py-4 border-bottom align-items-center  free-version">
    <div class="col-12 col-sm-5">
        <label for="pi_quantity_logic" class="h6"><?php echo __('When virtual category products quantity','extended-flat-rate-shipping-woocommerce'); ?></label><?php pisol_help::tooltip('Create package when Virtual category product quantity satisfies the selected logic'); ?>
    </div>
    <div class="col-12 col-sm-3">
        <select name="pi_quantity_logic" id="pi_quantity_logic" class="form-control">
            <option <?php echo empty($data['pi_quantity_logic']) ? 'selected' : ''; ?> value=""><?php echo __('Select Logic','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_quantity_logic'] == 'greater' ? 'selected' : ''; ?> value="greater"><?php echo __('Greater than','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_quantity_logic'] == 'greater_equal' ? 'selected' : ''; ?> value="greater_equal"><?php echo __('Greater than equal to','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_quantity_logic'] == 'less' ? 'selected' : ''; ?> value="less"><?php echo __('Less than','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_quantity_logic'] == 'less_equal' ? 'selected' : ''; ?> value="less_equal"><?php echo __('Less than equal to','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_quantity_logic'] == 'equal' ? 'selected' : ''; ?> value="equal"><?php echo __('Equal to','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_quantity_logic'] == 'multiple' ? 'selected' : ''; ?> value="multiple"><?php echo __('Multiple of','extended-flat-rate-shipping-woocommerce'); ?></option>
            <option <?php echo $data['pi_quantity_logic'] == 'not_multiple' ? 'selected' : ''; ?> value="not_multiple"><?php echo __('Not Multiple of','extended-flat-rate-shipping-woocommerce'); ?></option>
        </select>
    </div>
    <div class="col-12 col-sm-3">
        <input type="number" value="<?php echo $data['pi_quantity']; ?>" step="1"  class="form-control" name="pi_quantity" id="pi_quantity" placeholder="Quantity">
    </div>
</div>

<?php wp_nonce_field( 'add_package', 'pisol_efrs_nonce'); ?>
<input type="hidden" name="post_type" value="pi_efrs_package">
<input type="hidden" name="post_id" value="<?php echo $data['post_id']; ?>">
<input type="hidden" name="action" value="pisol_efrs_save_package">
<input type="submit" value="Save Method" name="submit" class="m-2 mt-5 btn btn-primary btn-lg" id="pi-efrs-new-shipping-method-form">
</form>
