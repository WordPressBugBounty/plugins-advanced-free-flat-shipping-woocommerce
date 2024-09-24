<div class="row mt-3">
    <div class="col-12 col-md-7">
        <div class="alert alert-info">
            Checkout this video to know more about Package manager <?php pisol_help::youtube('MVPPdukqLp0','Know more about the package manager'); ?>
        </div>
    </div>
    <div class="col-12 col-md-5 py-3 text-right"><a class="btn btn-primary btn-sm mr-3" href="<?php echo admin_url( 'admin.php?page=pisol-efrs-notification&tab=pi_efrs_add_package' ); ?>"><span class="dashicons dashicons-plus"></span> Add Package</a>
    </div>
</div>
<?php

$custom_groups = get_posts(array(
    'post_type'=>'pi_efrs_package',
    'numberposts'      => -1,
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key' => 'pi_priority', 
            'compare' => 'EXISTS'
        ),
        array(
            'key' => 'pi_priority', 
            'compare' => 'NOT EXISTS'
        )
    ),
    'orderby'=>'meta_value_num',
    'order'=>'DESC'
));

?>
<div id="pisol-efrs-shipping-method-list-view">
<table class="table text-center table-striped">
				<thead>
				<tr class="afrsm-head">
					<th class="text-left"><?php _e( 'Package name', 'extended-flat-rate-shipping-woocommerce'); ?><?php pisol_help::tooltip('you club product in one shipping package and ship them together and other product in different shipping package withing single order '); ?> </th>
					<th><?php _e( 'Description', 'extended-flat-rate-shipping-woocommerce'); ?></th>
                    <th><?php _e( 'Priority', 'extended-flat-rate-shipping-woocommerce'); ?></th>
					<th><?php _e( 'Status', 'extended-flat-rate-shipping-woocommerce'); ?></th>
					<th><?php _e( 'Actions', 'extended-flat-rate-shipping-woocommerce'); ?></th>
				</tr>
				</thead>
                <tbody >
                

<?php
if(count($custom_groups) > 0){
foreach($custom_groups as $method){
    $shipping_title  = get_the_title( $method->ID ) ? get_the_title( $method->ID ) : 'Package';
    $description = get_post_meta( $method->ID, 'pi_desc', true );
    $priority = get_post_meta( $method->ID, 'pi_priority', true );
    $status = get_post_meta( $method->ID, 'pi_status', true );
    echo '<tr id="pisol_tr_container_'.$method->ID.'">';
    echo '<td class="pisol-aafsw-td-name text-left"><a href="'.admin_url( '/admin.php?page=pisol-efrs-notification&tab=pi_efrs_add_package&action=edit&id='.$method->ID ).'">'.$shipping_title.' (ID: '.$method->ID.')</a></td>';
    
    echo '<td class="text-left">';
    echo esc_html($description);
    echo '</td>';
    echo '<td class="text-center">';
    echo esc_html($priority);
    echo '</td>';
    echo '<td class="text-center">';
    echo '<div class="custom-control custom-switch">
    <input type="checkbox" value="1" '.checked($status,'on', false).' class="custom-control-input pi-affsw-package-manager-status-change" name="pi_status" id="pi_status_'.$method->ID.'" data-id="'.esc_attr($method->ID).'">
    <label class="custom-control-label" for="pi_status_'.$method->ID.'"></label>
    </div>';
    echo '</td>';
    echo '<td>';
    echo '<a href="'.admin_url( '/admin.php?page=pisol-efrs-notification&tab=pi_efrs_add_package&action=edit&id='.$method->ID ).'" class="btn btn-primary btn-sm m-2" title="Edit package"><span class="dashicons dashicons-edit-page"></span></a>';
    echo '<form method="POST" class="d-inline"><input type="hidden" name="method_id" value="'.$method->ID.'"><input type="hidden" name="action" value="efrs_package_delete"><button class="btn btn-warning btn-sm m-2 pisol-confirm"  title="Delete package"><span class="dashicons dashicons-trash "></span> </button></form>';
    echo '</td>';
    echo '</tr>';
}
}else{
    echo '<tr>';
    echo '<td colspan="5" class="text-center">';
    echo __('There are no package created','extended-flat-rate-shipping-woocommerce' );
    echo '</td>';
    echo '</tr>';
}
?>
</tbody>
</table>
</div>