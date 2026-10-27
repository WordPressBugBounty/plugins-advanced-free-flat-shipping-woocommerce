<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class pisol_efrs_disable_shipping_method_cache{
    
    static $instance = false;

    public static function get_instance(){
        if ( ! self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        //add_action('wp_loaded', array(__CLASS__, 'clear_wc_shipping_rates_cache'));
        add_filter( 'woocommerce_cart_shipping_packages', array( $this, 'bust_package_hash' ), 999 );
        add_filter( "option_woocommerce_shipping_cost_requires_address", array(__CLASS__, 'disableHideUntilAddress') );
    }

    /**
     * New cache busting for shipping package 
     */
    public function bust_package_hash( $packages ) {
        // Same token for the whole request, new token on the next request.
        static $token = null;
        if ( null === $token ) {
            $token = wp_generate_uuid4();
        }

        foreach ( $packages as $key => $package ) {
            $packages[ $key ]['pisol_cache_buster'] = $token;
        }
        return $packages;
    }

   static function disableHideUntilAddress($val){
       if(function_exists('is_admin') && is_admin()) return $val;

       return 'no';
   }
}

pisol_efrs_disable_shipping_method_cache::get_instance();