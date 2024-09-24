<div class="row py-3 border-bottom align-items-center bg-primary">
    <div class="col-12 col-md-4">
        <strong class="h6 text-light"><?php echo $this->title; ?> <span class="text-primary">*</span></strong><?php pisol_help::tooltip('When a customer satisfies this set of conditions, then only this shipping method will be available to them'); ?>
    </div>
    <div class="col-12 col-md-6">
        <select class="form-control" name="pi_condition_logic">
            <option value="and" <?php selected( $this->data['pi_condition_logic'], 'and' ); ?>>All the below rules should match</option>
            <option value="or" <?php selected( $this->data['pi_condition_logic'], 'or' ); ?>>Any one of the below rule should match</option>
        </select>
    </div>
    <div class="col-12 col-md-2 text-right">
        <a href="javascript:void(0);" class="btn btn-secondary btn-sm" id="pi-add-<?php echo $this->slug; ?>-rule" data-target="#pisol-rules-container-<?php echo $this->slug; ?>"><?php echo __('Add Condition','advanced-free-flat-shipping-woocommerce'); ?></a>
    </div>
</div>
<?php echo $this->conditionDropdownScript(); ?>
<?php $this->logicDropdownScript(); ?>
<?php echo $this->savedConditions($this->saved_conditions); ?>
<div id="pisol-rules-container-<?php echo $this->slug; ?>">
<?php echo $this->savedRows(); ?>
</div>