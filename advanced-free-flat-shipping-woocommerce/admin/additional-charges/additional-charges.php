<?php

class pisol_efrs_additional_charges_form{
    function __construct(){
        add_action('pi_efrs_extra_form_fields', array($this, 'mainForm'), 10, 1);
        add_filter('pi_efrs_shipping_method_form_data',array($this, 'formData'), 10, 1);
        add_action('pisol_efrs_save_shipping_method', array($this, 'saveForm'),10,1);

        add_action('wp_ajax_pi_extra_charge_dynamic_value_product', array($this, 'search_product'));

		add_action('wp_ajax_pi_extra_charge_dynamic_value_category', array($this, 'search_category'));
    }

    function mainForm($data){
        include 'template/additional-charges.php';
    }

    function formData($data){
        $action_value = sanitize_text_field(filter_input( INPUT_GET, 'action'));
        $id_value     = sanitize_text_field(filter_input( INPUT_GET, 'id') );
        if ( isset( $action_value ) && 'edit' === $action_value ) {
            $data['pi_enable_additional_charges'] = get_post_meta( $data['post_id'], 'pi_enable_additional_charges', true );
            $data['pi_enable_additional_charges']       = isset($data['pi_enable_additional_charges']) && 'on' === $data['pi_enable_additional_charges'] ? 'checked' : '';
        }else{
            $data['pi_enable_additional_charges']               = 'checked';
        }
        return $data;
    }

    function saveForm($post_id){
        if ( isset( $_POST['pi_enable_additional_charges'] ) ) {
            update_post_meta( $post_id, 'pi_enable_additional_charges', "on" );
        } else {
            update_post_meta( $post_id, 'pi_enable_additional_charges', "off");
        }
    }

    static function tabName($name, $slug, $active = ""){
        echo "<a href=\"javascript:void(0)\" class=\"bg-dark2 py-3 px-2 d-block text-left text-light additional-charges-tab border-bottom ".esc_attr($active)." \" id=\"add-charges-tab-".esc_attr($slug)."\" data-target=\"#add-charges-tab-content-".esc_attr($slug)."\">".wp_kses_post($name)."</a>";
    }

    static function additionalChargesEnabled($post_id){
        $add_charges_enabled = get_post_meta( $post_id, 'pi_enable_additional_charges', true );

        return $add_charges_enabled == 'on' ? true : false;
    }

    static function sumOfCharges($name, $data){
        $val = isset($data[$name]) ? $data[$name] : '';
        ?>
        <select name="<?php echo esc_attr($name); ?>" class="form-control">
            <option value="all" <?php selected($val, 'all'); ?>><?php esc_html_e( 'Sum of all matched charges', 'advanced-free-flat-shipping-woocommerce'); ?></option>
            <option value="largest" <?php selected($val, 'largest'); ?>><?php esc_html_e( 'Largest of the matched charges', 'advanced-free-flat-shipping-woocommerce'); ?></option>
            <option value="smallest" <?php selected($val, 'smallest'); ?>><?php esc_html_e( 'Smallest of the matched charges', 'advanced-free-flat-shipping-woocommerce'); ?></option>
        </select>
        <?php
    }

	static function productOption($product_ids){
		if(empty($product_ids)) return ;

		$html = '';
		if(!is_array($product_ids)){
			$product_ids = array($product_ids);
		}
		foreach($product_ids as $product_id){
			
			$title = str_replace("&#8211;",">",get_the_title( $product_id ));
			$html .= sprintf('<option value="%s">%s</option>', esc_attr($product_id), esc_html($title).' (#'.$product_id.')');
			
		}
		return $html;
	}

	static function categoryOption($category_ids){
		if(empty($category_ids)) return ;

		$html = '';
		if(!is_array($category_ids)){
			$category_ids = array($category_ids);
		}
		foreach($category_ids as $category_id){

			$cat = get_term($category_id, 'product_cat');
			
			if(is_wp_error($cat)) continue;
			
			$html .= sprintf('<option value="%s">%s</option>', esc_attr($category_id), esc_html($cat->name).' (#'.$category_id.')');
			
		}
		return $html;
	}

    public function search_product( $x = '', $post_types = array( 'product' ) ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

        ob_start();
        
        if(!isset($_GET['keyword'])) die;

		$keyword = isset($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : "";

		if ( empty( $keyword ) ) {
			die();
		}
		$arg            = array(
			'post_status'    => 'publish',
			'post_type'      => $post_types,
			'posts_per_page' => 50,
			's'              => $keyword

		);
		$the_query      = new WP_Query( $arg );
		$found_products = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$prd = wc_get_product( get_the_ID() );
				$cat_ids  = wp_get_post_terms( get_the_ID(), 'product_cat', array( 'fields' => 'ids' ) );

				/* remove grouped product or external product */
				if($prd->is_type('grouped') || $prd->is_type('external')){
					continue;
				}
				

				$product_id    = get_the_ID();
				$product_title = get_the_title().' (#'.$product_id.')';
				$the_product   = new WC_Product( $product_id );
				if ( ! $the_product->is_in_stock() ) {
					$product_title .= ' (Out of stock)';
				}
				$product          = array( 'id' => $product_id, 'text' => $product_title );
				$found_products[] = $product;

				if ( $prd->has_child() && $prd->is_type( 'variable' ) ) {
					$product_children = $prd->get_children();
					if ( count( $product_children ) ) {
						foreach ( $product_children as $product_child ) {
							if ( self::wc_version_check() ) {
								$product = array(
									'id'   => $product_child,
									'text' => str_replace("&#8211;",">",get_the_title( $product_child )).' (#'.$product_child.')'
								);

							} else {
								$child_wc  = wc_get_product( $product_child );
								$get_atts  = $child_wc->get_variation_attributes();
								$attr_name = array_values( $get_atts )[0];
								$product   = array(
									'id'   => $product_child,
									'text' => get_the_title() . ' - ' . $attr_name
								);

							}
							$found_products[] = $product;
						}

					}
				} 			
			}
        }
		wp_send_json( $found_products );
		die;
    }

	public function search_category() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		ob_start();

		$keyword = sanitize_text_field(filter_input( INPUT_GET, 'keyword'));

		if ( empty( $keyword ) ) {
			die();
		}
		$categories = get_terms(
			array(
				'taxonomy' => 'product_cat',
				'orderby'  => 'name',
				'order'    => 'ASC',
				'search'   => $keyword,
				'number'   => 100
			)
		);
		$items      = array();
		if ( count( $categories ) ) {
			foreach ( $categories as $category ) {
				$item    = array(
					'id'   => $category->term_id,
					'text' => $category->name
				);
				$items[] = $item;
			}
		}
		wp_send_json( $items );
		die;
    }

    
    static function wc_version_check( $version = '3.0' ) {
            if ( class_exists( 'WooCommerce' ) ) {
                global $woocommerce;
                if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
                    return true;
                }
            }
            return false;
    }

	static function packageSupport($name, $data){
		$val = isset($data[$name]) ? $data[$name] : '';
		$html = "";
        $html .= '<select class="form-control" name="'.$name.'">';
        $html .= '<option value="package" '.selected($val, "package", false).' title="Package is useful when you are using some 3rd party plugin to split ordered item in different shipping packages">'.__('In Package').'</option>';
        $html .= '<option value="cart" '.selected($val, "cart", false).'>'.__('In Cart').'</option>';
        $html .= '</select>';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $html;
	}
    
}
new pisol_efrs_additional_charges_form();