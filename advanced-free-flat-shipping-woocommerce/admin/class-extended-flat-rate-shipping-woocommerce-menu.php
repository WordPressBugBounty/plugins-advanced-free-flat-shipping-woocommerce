<?php

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
        
        $this->menu = add_menu_page(
            __( 'Flat Rate Shipping'),
            __( 'Flat Rate Shipping'),
            'manage_options',
            'pisol-efrs-notification',
            array($this, 'menu_option_page'),
            plugin_dir_url( __FILE__ ).'img/pi.svg',
            6
        );

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
        
        wp_enqueue_style( $this->plugin_name."_bootstrap", plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version, 'all' );

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/extended-flat-rate-shipping-woocommerce-admin.css', array(), $this->version, 'all' );
		
	}

    static function  getCapability(){
        $capability = 'manage_options';

        return (string)apply_filters('pisol_efrs_settings_cap', $capability);
    }

    function menu_option_page(){
        ?>
        <div class="bootstrap-wrapper">
        <div class="pisol-container-fluid mt-2">
            <div class="pisol-row">
                    <div class="col-12">
                        <div class='bg-dark'>
                        <div class="pisol-row">
                            <div class="col-12 col-sm-2 py-3 d-flex align-items-center justify-content-center">
                                    <a href="https://www.piwebsolution.com/" target="_blank"><img id="pi-logo" class="img-fluid ml-2" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>img/pi-web-solution.png"></a>
                            </div>
                            <div class="col-12 col-sm-10 d-flex text-center small">
                                <nav id="pisol-navbar" class="navbar navbar-expand-lg navbar-light mr-0 ml-auto">
                                    <div>
                                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                            <?php do_action($this->plugin_name.'_tab'); ?>
                                            <a class=" px-3 text-light d-flex align-items-center  border-left border-right  ml-auto mr-0" href="https://www.piwebsolution.com/advance-flat-rate-shipping/" target="_blank">
                                            <span class="dashicons dashicons-editor-help"></span> Help & Docs
                                            </a>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="pisol-row">
                <div class="col-12">
                <div id="pisol-efrs-notices"></div>
                <div class="bg-light border pl-3 pr-3 pt-0">
                    <div class="row">
                        <div class="col">
                            <div class="pi-efrs-arrow-circle closed" title="Open / Close sidebar">
                                <svg class="pi-efrs-arrow-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <!-- First arrow -->
                                    <path d="M13 6l-6 6 6 6" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <!-- Second arrow (slightly right-shifted) -->
                                    <path d="M17 6l-6 6 6 6" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <?php do_action($this->plugin_name.'_tab_content'); ?>
                        </div>
                        <?php do_action($this->plugin_name.'_promotion'); ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
        <?php
        include_once 'help.php';
        $this->support();
    }

    function promotion(){
        ?>
        <div class="col-12 col-sm-12 col-md-4 pt-3 pb-3 border-left" id="pi-efrs-sidebar-container">

                <div class="pi-shadow rounded px-2 py-3">
                    <h2 id="pi-banner-tagline" class="mb-0" style="color:#ccc !important;">
                        <span class="d-block mb-4">⭐️⭐️⭐️⭐️⭐️</span>
                        <span class="d-block mb-2">🚀 Trusted by <span style="color:#fff;">3,000+</span> WooCommerce Stores</span>
                        <span class="d-block mb-2">Rated <span style="color:#fff;">4.9/5</span> – Users love it</span>
                    </h2>
                    <div class="inside">
                        <ul class="text-left pisol-pro-feature-list">
                            <li><b><span style="color:white;">&#10003;</span> Location-based rules</b><br>
                            <i>State, postcode, city, or zone</i></li>

                            <li><b><span style="color:white;">&#10003;</span> Product/cart conditions</b><br>
                            <i>Subtotal, weight, dimensions, quantity</i></li>

                            <li><b><span style="color:white;">&#10003;</span> Customer-specific logic</b><br>
                            <i>User roles, coupons, payment methods</i></li>

                            <li><b><span style="color:white;">&#10003;</span> Shipping method control</b><br>
                            <i>Priorities, remove other methods, combine methods</i></li>

                            <li><b><span style="color:white;">&#10003;</span> Adjust shipping charge</b><br>
                            <i>By product, category, or shipping class</i></li>

                            <li><b><span style="color:white;">&#10003;</span> Smart features</b><br>
                            <i>Virtual categories, day-based rules, unlimited combinations</i></li>
                        </ul>
                        <h4 class="pi-bottom-banner">💰 Just <?php echo esc_html(PI_EFRS_PRICE); ?></h4>
                        <h4 class="pi-bottom-banner">🔥 Unlock all 50+ features and grow your sales!</h4>
                        <div class="text-center pb-3 pt-2">
                            <a class="btn btn-primary btn-md" href="<?php echo esc_url( PI_EFRS_BUY_URL ); ?>&utm_ref=bottom_link" target="_blank">🔓 Unlock Pro Now – Limited Time Price!</a>
                        </div>
                    </div>
                </div>

                <div class="bg-dark text-light text-center mt-3 rounded overflow-hidden">
                    <a href="<?php echo esc_url( PI_EFRS_BUY_URL ); ?>&utm_ref=discount_banner" target="_blank">
                    <?php  new pisol_promotion("pi_efrs_installation_date"); ?>
                    </a>
                </div>

        </div>
        <?php
    }

    function isWeekend() {
        return (date('N', strtotime(date('Y/m/d'))) >= 6);
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