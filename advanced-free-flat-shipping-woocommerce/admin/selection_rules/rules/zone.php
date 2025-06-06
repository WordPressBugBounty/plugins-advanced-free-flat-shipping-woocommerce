<?php

class Pi_efrs_selection_rule_zones{
    
    public $slug;
    public $condition;

    function __construct($slug){
        $this->slug = $slug;
        $this->condition = 'zones';
        /* this adds the condition in set of rules dropdown */
        add_filter("pi_".$this->slug."_condition", array($this, 'addRule'));
        
        /* this gives value field to store condition value either select or text box */
        add_action( 'wp_ajax_pi_'.$this->slug.'_value_field_'.$this->condition, array( $this, 'ajaxCall' ) );

        /* This gives our field with saved value */
        add_filter('pi_'.$this->slug.'_saved_values_'.$this->condition, array($this, 'savedDropdown'), 10, 3);

        /* This perform condition check */
        add_filter('pi_'.$this->slug.'_condition_check_'.$this->condition, array($this,'conditionCheck'),10,4);

        /* This gives out logic dropdown */
        add_action('pi_'.$this->slug.'_logic_'.$this->condition, array($this, 'logicDropdown'));

        /* This give saved logic dropdown */
        add_filter('pi_'.$this->slug.'_saved_logic_'.$this->condition, array($this, 'savedLogic'),10,3);
    }

    function addRule($rules){
        $rules[$this->condition] = array(
            'name'=>__('WooCommerce Assigned Zone', 'extended-flat-rate-shipping-woocommerce'),
            'group'=>'location_related',
            'condition'=>$this->condition
        );
        return $rules;
    }

    function logicDropdown(){
        $html = "";
        $html .= 'var pi_logic_'.$this->condition.'= "<select class=\'form-control\' name=\'pi_selection[{count}][pi_'.$this->slug.'_logic]\'>';
        
            $html .= '<option value=\'equal_to\'>Equal to (=)</option>';
            $html .= '<option value=\'not_equal_to\'>Not Equal to (!=)</option>';
           
        
        $html .= '</select>";';
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $html;
    }

    function savedLogic($html_in, $saved_logic, $count){
        $html = "";
        $html .= '<select class="form-control" name="pi_selection['.$count.'][pi_'.$this->slug.'_logic]">';
        
            $html .= '<option value="equal_to" '.selected($saved_logic , "equal_to",false ).'>Equal to (=)</option>';
            $html .= '<option value="not_equal_to" '.selected($saved_logic , "not_equal_to",false ).'>Not Equal to (!=)</option>';
           
        
        $html .= '</select>';
        return $html;
    }

    function ajaxCall(){
        $cap = Pi_Efrs_Menu::getCapability();
        if(!current_user_can( $cap )) {
            return;
            die;
        }
        $count = sanitize_text_field(filter_input(INPUT_POST,'count'));
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo Pi_efrs_selection_rule_main::createSelect($this->allZones(), $count,$this->condition,  "multiple",null,'static');
        echo '<p>When WooCommerce assigned shipping zone matches any of this zone</p>';
        die;
    }

    function savedDropdown($html, $values, $count){
        $html = Pi_efrs_selection_rule_main::createSelect($this->allZones(), $count,$this->condition,  "multiple", $values,'static');
        $html .=  '<p>When WooCommerce assigned shipping zone matches any of this zone</p>';
        return $html;
    }

    function allZones(){
       $zones =  WC_Shipping_Zones::get_zones();
       $all_zones = array();
       foreach ((array) $zones as $key => $zone ) {
        $all_zones[$key] = $zone['zone_name'];
      }
       $non_covered_zone =  WC_Shipping_Zones::get_zone_by("zone_id",0);
       if(is_object($non_covered_zone)){
            $all_zones[0] = $non_covered_zone->get_zone_name();
       }
       return $all_zones;
    }

    public static function getUserSelectedZone($package){
        global $woocommerce;
        if(isset(WC()->cart)){
        
            $shipping_zone = wc_get_shipping_zone( $package );

            if(is_object($shipping_zone)){
                return $shipping_zone;
            }
        }
        return null;
    }

    function conditionCheck($result, $package, $logic, $values){
        
                    $or_result = false;
                    $shipping_zone = self::getUserSelectedZone($package);
                    if(is_object($shipping_zone)){
                        $user_zone = $shipping_zone->get_id();
                        $rule_zone = $values;
                        if($logic == 'equal_to'){
                            if(in_array($user_zone, $rule_zone)){
                                $or_result = true;
                            }else{
                                $or_result = false;
                            }
                        }else{
                            if(in_array($user_zone, $rule_zone)){
                                $or_result = false;
                            }else{
                                $or_result = true;
                            }
                        }
                    }
               
        return  $or_result;
    }
}

new Pi_efrs_selection_rule_zones(PI_EFRS_SELECTION_RULE_SLUG);