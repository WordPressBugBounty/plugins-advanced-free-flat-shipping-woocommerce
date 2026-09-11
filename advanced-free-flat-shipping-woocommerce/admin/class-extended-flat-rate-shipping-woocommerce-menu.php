<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Pi_Efrs_Menu{

    public $plugin_name;
    public $menu;
    public $version;
    function __construct($plugin_name , $version){
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action( 'admin_menu', array($this,'plugin_menu') );
        add_action($this->plugin_name.'_promotion', array($this,'promotion'));
    }

    function plugin_menu(){
        $main_menu = get_option('pisol_affsw_move_to_submenu', 0);
        if($main_menu){
            $this->menu = add_submenu_page(
                'woocommerce',
                __( 'Flat Rate Shipping'),
                __( 'Flat Rate Shipping'),
                'manage_options',
                'pisol-efrs-notification',
                array($this, 'menu_option_page')
            );
        }else{
            $this->menu = add_menu_page(
                __( 'Flat Rate Shipping','advanced-free-flat-shipping-woocommerce'),
                __( 'Flat Rate Shipping','advanced-free-flat-shipping-woocommerce'),
                'manage_options',
                'pisol-efrs-notification',
                array($this, 'menu_option_page'),
                plugin_dir_url( __FILE__ ).'img/pi.svg',
                6
            );
        }

        add_action("load-".$this->menu, array($this,"bootstrap_style"));
        
 
    }

    public function bootstrap_style() {

        wp_enqueue_script('thickbox', null, array('jquery'));

        wp_enqueue_style( $this->plugin_name."_toast", plugin_dir_url( __FILE__ ) . 'css/jquery-confirm.min.css', array(), $this->version, 'all' );

        wp_enqueue_script( $this->plugin_name."_toast", plugin_dir_url( __FILE__ ) . 'js/jquery-confirm.min.js', array('jquery'), $this->version);

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/extended-flat-rate-shipping-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name.'-additional-charges', plugin_dir_url( __FILE__ ) . 'js/extended-flat-rate-shipping-additional-charges.js', array( 'jquery' ), $this->version, false );

        // include the thickbox styles
        wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');

        wp_enqueue_style( $this->plugin_name."_admin", plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
        
        wp_enqueue_style( $this->plugin_name."_bootstrap", plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version, 'all' );

        //wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/extended-flat-rate-shipping-woocommerce-admin.css', array(), $this->version, 'all' );

		
	}

    static function  getCapability(){
        $capability = 'manage_options';

        return (string)apply_filters('pisol_efrs_settings_cap', $capability);
    }

    function menu_option_page(){
        ?>
        <div class="pisol-container bootstrap-wrapper">
            <div class="pisol-header">
                <div id="pisol-header-bar">
                    <a href="https://www.piwebsolution.com/" target="_blank"><img id="pi-logo" class="pisol-img-fluid" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>img/pi-web-solution.svg"></a>
                </div>
            </div>

            <div class="pisol-left-sidebar">
                <div id="pisol-side-menu" class="mb-4 rounded">
                    <?php do_action($this->plugin_name.'_tab'); ?>
                    <a class="  px-3 py-2 text-light d-flex align-items-center  border-left border-right  bg-secondary" href="https://www.piwebsolution.com/advance-flat-rate-shipping/" target="_blank">
                        <span class="dashicons dashicons-editor-help"></span> Help & Docs
                    </a>
                </div>
                <?php do_action($this->plugin_name.'_promotion'); ?>
            </div>

            <div class="pisol-content">
                <label for="pi-left-sidebar-controller" class="pi-left-sidebar-closing-circle"><input id="pi-left-sidebar-controller" type="checkbox"/></label>
                <div id="pisol-efrs-notices"></div>
                <?php do_action($this->plugin_name.'_tab_content'); ?>
            </div>
        </div>   
        <?php
        include_once 'help.php';
        $this->support();
    }

    function promotion(){
        ?>
        <div id="pi-efrs-sidebar-container">

            <aside id="pefrs-side-banner" class="pefrs-banner">
                <div class="pefrs-banner__orb pefrs-banner__orb--1"></div>
                <div class="pefrs-banner__orb pefrs-banner__orb--2"></div>
                <div class="pefrs-banner__grid"></div>

                <div class="pefrs-banner__inner">

                <!-- Trust Header -->
                <header class="pefrs-banner__head">
                    <div class="pefrs-banner__stars">
                    <svg class="pefrs-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <svg class="pefrs-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <svg class="pefrs-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <svg class="pefrs-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <svg class="pefrs-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <p class="pefrs-banner__trust-main">Trusted by <strong>3,000+</strong> WooCommerce Stores</p>
                    <p class="pefrs-banner__trust-sub">Rated 4.9/5 – Users love it</p>
                </header>

                <div class="pefrs-banner__divider"><span>Pro Features</span></div>

                <!-- Features -->
                <ul class="pefrs-banner__features">
                    <li class="pefrs-feature">
                    <span class="pefrs-feature__check">
                        <svg viewBox="0 0 20 20"><path d="M16.7 5.3a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 1 1 1.4-1.4L9 11.6l6.3-6.3a1 1 0 0 1 1.4 0z"/></svg>
                    </span>
                    <span class="pefrs-feature__body">
                        <span class="pefrs-feature__name">Location-based rules</span>
                        <span class="pefrs-feature__hint">State, Postcode, City, Zone, etc.</span>
                    </span>
                    </li>
                    <li class="pefrs-feature">
                    <span class="pefrs-feature__check">
                        <svg viewBox="0 0 20 20"><path d="M16.7 5.3a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 1 1 1.4-1.4L9 11.6l6.3-6.3a1 1 0 0 1 1.4 0z"/></svg>
                    </span>
                    <span class="pefrs-feature__body">
                        <span class="pefrs-feature__name">Product/cart conditions</span>
                        <span class="pefrs-feature__hint">Subtotal, Weight, Dimensions, Quantity, etc.</span>
                    </span>
                    </li>
                    <li class="pefrs-feature">
                    <span class="pefrs-feature__check">
                        <svg viewBox="0 0 20 20"><path d="M16.7 5.3a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 1 1 1.4-1.4L9 11.6l6.3-6.3a1 1 0 0 1 1.4 0z"/></svg>
                    </span>
                    <span class="pefrs-feature__body">
                        <span class="pefrs-feature__name">Customer-specific logic</span>
                        <span class="pefrs-feature__hint">User roles, Coupons, Payment methods, etc.</span>
                    </span>
                    </li>
                    <li class="pefrs-feature">
                    <span class="pefrs-feature__check">
                        <svg viewBox="0 0 20 20"><path d="M16.7 5.3a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 1 1 1.4-1.4L9 11.6l6.3-6.3a1 1 0 0 1 1.4 0z"/></svg>
                    </span>
                    <span class="pefrs-feature__body">
                        <span class="pefrs-feature__name">Shipping method control</span>
                        <span class="pefrs-feature__hint">Priorities, Remove other methods, Combine methods etc.</span>
                    </span>
                    </li>
                    <li class="pefrs-feature">
                    <span class="pefrs-feature__check">
                        <svg viewBox="0 0 20 20"><path d="M16.7 5.3a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 1 1 1.4-1.4L9 11.6l6.3-6.3a1 1 0 0 1 1.4 0z"/></svg>
                    </span>
                    <span class="pefrs-feature__body">
                        <span class="pefrs-feature__name">Adjust shipping charge</span>
                        <span class="pefrs-feature__hint">By product, Category, Shipping class etc.</span>
                    </span>
                    </li>
                    <li class="pefrs-feature">
                    <span class="pefrs-feature__check">
                        <svg viewBox="0 0 20 20"><path d="M16.7 5.3a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 1 1 1.4-1.4L9 11.6l6.3-6.3a1 1 0 0 1 1.4 0z"/></svg>
                    </span>
                    <span class="pefrs-feature__body">
                        <span class="pefrs-feature__name">Smart features</span>
                        <span class="pefrs-feature__hint">Virtual categories, day-based rules, unlimited combinations, etc.</span>
                    </span>
                    </li>
                </ul>

                <!-- Price -->
                <div class="pefrs-banner__price-row">
                    <div class="pefrs-banner__price">
                    <span class="pefrs-banner__price-symbol">$</span>
                    <span class="pefrs-banner__price-amount"><?php echo esc_html( PI_EFRS_PRICE ); ?></span>
                    <span class="pefrs-banner__price-suffix">only</span>
                    </div>
                </div>

                <!-- CTA -->
                <a href="<?php echo esc_url( PI_EFRS_PRODUCT_PAGE_URL ); ?>" class="pefrs-banner__cta" target="_blank">
                    <span class="pefrs-banner__cta-shine"></span>
                    <span class="pefrs-banner__cta-text">Unlock Pro Now</span>
                    <span class="pefrs-banner__cta-sub">Limited Time Price!</span>
                    <svg class="pefrs-banner__cta-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                </div>
            </aside>
            <!-- Banner HTML End -->

                <div class="bg-dark text-light text-center mt-3 rounded overflow-hidden">
                    <a href="<?php echo esc_url( PI_EFRS_PRODUCT_PAGE_URL ); ?>&utm_ref=discount_banner" target="_blank">
                    <?php  new pisol_promotion("pi_efrs_installation_date"); ?>
                    </a>
                </div>

        </div>
        <?php
    }

    function support(){
        $website_url = home_url();
        $plugin_name = $this->plugin_name;
        ?>
        <form action="https://www.piwebsolution.com/quick-support/" method="post" target="_blank" style="display:inline; position:fixed; bottom:30px; right:35px; z-index:9999;" >
            <input type="hidden" name="website_url" value="<?php echo esc_attr( $website_url ); ?>">
            <input type="hidden" name="plugin_name" value="<?php echo esc_attr( $plugin_name ); ?>">
            <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;">
                <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>img/chat.png" 
                    alt="Live Support" title="Quick Support" style="width:60px;height:60px;">
            </button>
        </form>
        <?php
    }
}