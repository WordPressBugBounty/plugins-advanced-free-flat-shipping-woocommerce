<div class="row py-3 border-bottom align-items-center bg-dark2">
    <div class="col-12 col-md-5">
        <strong class="h6 text-light"><?php echo esc_html( $this->title ); ?> <span class="text-primary">*</span></strong><p class="font-italic mb-0 text-light"><?php echo __('When a customer satisfies this set of conditions, then only this shipping method will be available to them','extended-flat-rate-shipping-woocommerce'); ?></p>
    </div>
    <div class="col-12 col-md-5">
        <select class="form-control" name="pi_condition_logic">
            <option value="and" <?php selected( $this->data['pi_condition_logic'], 'and' ); ?>><?php echo esc_html__('All the below rules should match','advanced-free-flat-shipping-woocommerce'); ?></option>
            <option value="or" <?php selected( $this->data['pi_condition_logic'], 'or' ); ?>><?php echo esc_html__('Any one of the below rule should match','advanced-free-flat-shipping-woocommerce'); ?></option>
        </select>
    </div>
    <div class="col-12 col-md-2 text-right">
        <a href="javascript:void(0);" class="btn btn-primary btn-sm" id="pi-add-<?php echo esc_attr($this->slug); ?>-rule" data-target="#pisol-rules-container-<?php echo esc_attr($this->slug); ?>"><?php echo esc_html__('Add Condition','advanced-free-flat-shipping-woocommerce'); ?></a>
    </div>
</div>
<?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $this->conditionDropdownScript(); ?>
<?php $this->logicDropdownScript(); ?>
<?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $this->savedConditions($this->saved_conditions); ?>
<div id="pisol-rules-container-<?php echo esc_attr($this->slug); ?>">
<?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $this->savedRows(); ?>
</div>
<div class="row">
    <div class="col-12 text-right py-3">
        <a href="javascript:void(0);" class="btn btn-primary btn-sm pi-add-<?php echo esc_attr($this->slug); ?>-rule" data-target="#pisol-rules-container-<?php echo esc_attr($this->slug); ?>"><?php echo esc_html__('Add Condition','advanced-free-flat-shipping-woocommerce'); ?></a>
    </div>
</div>