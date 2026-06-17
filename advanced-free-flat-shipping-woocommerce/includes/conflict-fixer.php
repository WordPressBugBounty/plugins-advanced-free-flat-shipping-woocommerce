<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class pisol_efrs_pro_conflict_fixer{
    function __construct(){
        add_action( 'admin_enqueue_scripts', array($this,'removeConflictCausingScripts'), 1000 );

        /**
         * Woocommerce Role Based Shipping plugin uses the shipping method rate ID to determine which shipping method to apply. but it only has our pisol_extended_flat_shipping:0' method in shipping method list so we have to control general
         * https://woocommerce.com/products/role-based-payment-shipping-methods/
         */
        add_filter('wc_role_based_rate_id', array($this, 'fixRateId'));
    }

    function removeConflictCausingScripts(){
        if(isset($_GET['page']) && $_GET['page'] == 'pisol-efrs-notification'){
            wp_dequeue_style( 'bp3d_admin_custom_css' );
            wp_deregister_style( 'bp3d_admin_custom_css' );
        }
    }

    function fixRateId($rate_id){
        if (strpos($rate_id, 'pisol_extended_flat_shipping:') === 0 ) {
            return 'pisol_extended_flat_shipping:0';
        }

        if (strpos($rate_id, 'pisol_combine_method:') === 0 ) {
            return 'pisol_combine_method:0';
        }
        return $rate_id;
    }
}

new pisol_efrs_pro_conflict_fixer();