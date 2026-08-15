<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class pisol_efrs_sample_shipping {

    static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function default_shipping() {
        $created = get_option( 'pisol_efrs_sample_shipping_created', 0 );
        if ( empty( $created ) ) {
            self::create_default_shipping();
            update_option( 'pisol_efrs_sample_shipping_created', 1 );
        }
    }

    public static function create_default_shipping() {
        $shipping = array();

        // Never seed if the user already has any fee rules — covers reactivation,
        // migration from another site, or manual creation before this runs.
        if ( self::get_shipping_count() > 0 ) {
            return $shipping;
        }

        $shipping[] = self::small_order_shipping();
        $shipping[] = self::international_large_order_shipping();
        $shipping[] = self::bulk_order_shipping();
        $shipping[] = self::free_shipping();
        

        foreach ( $shipping as $ship ) {
            self::create_shipping( $ship );
        }

        return $shipping;
    }

    public static function get_shipping_count() {
        $existing = get_posts([
            'post_type'   => 'pi_shipping_method',
            'post_status' => ['publish'],
            'numberposts' => 1
        ]);
        return $existing ? count( $existing ) : 0;
    }

    
    static function small_order_shipping() {
        $metabox = [];
        $metabox[] = array(
            'pi_condition' => 'cart_subtotal_before_discount',
            'pi_logic'     => 'less_equal_to',
            'pi_value'     => [500],
        );

        return array(
            'pi_title'            => 'Sample: Small Order Shipping',
            'pi_cost'             => 49,
            'pi_condition_logic'  => 'and',
            'pi_metabox'          => $metabox,
        );
    }

    static function free_shipping() {
        $metabox = [];
        $metabox[] = array(
            'pi_condition' => 'cart_subtotal_before_discount',
            'pi_logic'     => 'greater_equal_to',
            'pi_value'     => [500],
        );

        return array(
            'pi_title'            => 'Sample: Free Shipping',
            'pi_cost'             => 0,
            'pi_condition_logic'  => 'and',
            'pi_metabox'          => $metabox,
        );
    }


    static function bulk_order_shipping() {
        $metabox = [];
        $metabox[] = array(
            'pi_condition' => 'quantity',
            'pi_logic'     => 'greater_equal_to',
            'pi_value'     => [100],
        );

        return array(
            'pi_title'            => 'Sample: Bulk Order Shipping',
            'pi_cost'             => 29,
            'pi_condition_logic'  => 'and',
            'pi_metabox'          => $metabox,
        );
    }

    static function international_large_order_shipping() {
        $metabox = [];

        $shop_country = get_option( 'woocommerce_store_country' );
        if ( ! $shop_country ) {
            $shop_country = 'US'; // Default to US if no country is set
        }

        $metabox[] = array(
            'pi_condition' => 'country',
            'pi_logic'     => 'not_equal_to',
            'pi_value'     => [ $shop_country ], // reuse the get_option('woocommerce_store_country') trick from HSMCW
        );

        $metabox[] = array(
            'pi_condition' => 'cart_subtotal_before_discount',
            'pi_logic'     => 'greater_then',
            'pi_value'     => [1000],
        );

        return array(
            'pi_title'            => 'Sample: International Large Order Shipping',
            'pi_cost'             => 49,
            'pi_condition_logic'  => 'and',
            'pi_metabox'          => $metabox,
        );
    }


    static function create_shipping( $ship ) {
        $post_data = [
            'post_title'  => $ship['pi_title'],
            'post_status' => 'publish',
            'post_type'   => 'pi_shipping_method',
        ];

        $post_id = wp_insert_post( $post_data );

        if ( is_wp_error( $post_id ) ) {
            return false;
        }

        // Explicit 'off' — do NOT rely on empty/unset, since formDate() in
        // Class_Pi_Efrs_Add_Edit treats empty pi_status as checked/on.
        update_post_meta( $post_id, 'pi_status', 'off' );

        update_post_meta( $post_id, 'pi_cost', $ship['pi_cost'] );
        update_post_meta( $post_id, 'pi_priority', 1 );
        update_post_meta( $post_id, 'pi_desc', isset( $ship['pi_desc'] ) ? $ship['pi_desc'] : '' );
        update_post_meta( $post_id, 'pi_is_taxable', isset( $ship['pi_is_taxable'] ) ? $ship['pi_is_taxable'] : '' );
        update_post_meta( $post_id, 'shipping_extra_cost', isset( $ship['shipping_extra_cost'] ) ? $ship['shipping_extra_cost'] : array() );
        update_post_meta( $post_id, 'pi_extra_cost_calc_type', isset( $ship['pi_extra_cost_calc_type'] ) ? $ship['pi_extra_cost_calc_type'] : '' );
        update_post_meta( $post_id, 'min_days', isset( $ship['min_days'] ) ? $ship['min_days'] : '' );
        update_post_meta( $post_id, 'max_days', isset( $ship['max_days'] ) ? $ship['max_days'] : '' );
        update_post_meta( $post_id, 'pi_condition_logic', $ship['pi_condition_logic'] );
        update_post_meta( $post_id, 'pi_free_when_free_shipping_coupon', 'off' );
        update_post_meta( $post_id, 'pi_currency', array() );
        update_post_meta( $post_id, 'pi_metabox', $ship['pi_metabox'] );

        do_action( 'pisol_efrs_save_shipping_method', $post_id ); // matches the real hook name in this file

        return $post_id;
    }
}

/* Testing the rule creation on plugin activation */
//add_action('wp_loaded', array('pisol_efrs_sample_shipping', 'create_default_shipping'));
