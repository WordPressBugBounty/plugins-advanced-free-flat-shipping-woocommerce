<?php

class Pi_efrs_selection_rule_selected_delivery_day{
    public $slug;
    public $condition;
    
    function __construct($slug){
        $this->slug = $slug;
        $this->condition = 'selected_delivery_day';
        /* this adds the condition in set of rules dropdown */
        add_filter("pi_".$this->slug."_condition", array($this, 'addRule'));
        
        /* this gives value field to store condition value either select or text box */
        add_action( 'wp_ajax_pi_'.$this->slug.'_value_field_'.$this->condition, array( $this, 'ajaxCall' ) );

        /* This gives our field with saved value */
        add_filter('pi_'.$this->slug.'_saved_values_'.$this->condition, array($this, 'savedDropdown'), 10, 3);

        /* This perform condition check */
        add_filter('pi_'.$this->slug.'_condition_check_'.$this->condition,array($this,'conditionCheck'),10,4);

        /* This gives out logic dropdown */
        add_action('pi_'.$this->slug.'_logic_'.$this->condition, array($this, 'logicDropdown'));

        /* This give saved logic dropdown */
        add_filter('pi_'.$this->slug.'_saved_logic_'.$this->condition, array($this, 'savedLogic'),10,3);
    }

    static function datePluginInstalled(){
        if(is_plugin_active( 'pi-woocommerce-order-date-time-and-type-pro/pi-woocommerce-order-date-time-and-type-pro.php') || is_plugin_active( 'pi-woocommerce-order-date-time-and-type/pi-woocommerce-order-date-time-and-type.php')) return true;

        return false;
    }

    function addRule($rules){
        $rules[$this->condition] = array(
            'name'=>__('Selected delivery day'),
            'group'=>'order_date_time_plugin',
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
        if(!current_user_can( 'manage_options' )) {
            return;
            die;
        }
        if(self::datePluginInstalled()){
            $count = sanitize_text_field(filter_input(INPUT_POST,'count'));
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo Pi_efrs_selection_rule_main::createSelect($this->days(), $count,$this->condition,  "multiple",null,'static');
        }else{
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo self::msgNoDateTimePlugin();
        }
        die;
    }

    function savedDropdown($html, $values, $count){
        if(self::datePluginInstalled()){
            $html = Pi_efrs_selection_rule_main::createSelect($this->days(), $count, $this->condition,  "multiple", $values,'static');
            return $html;
        }

        return self::msgNoDateTimePlugin();
    }

    static function msgNoDateTimePlugin(){
        $url = self::installPluginUrl();
        $plugin_page = 'https://wordpress.org/plugins/pi-woocommerce-order-date-time-and-type/';
        return sprintf('<div class="alert alert-danger">This feature requires <a href="%s" target="_blank">Delivery date and time plugin</a> installed in your website so user can select a desired delivery date, <a href="%s">Click to install</a></div>',$plugin_page, $url);
    }

    static function installPluginUrl(){
        $action = 'install-plugin';
        $slug = 'pi-woocommerce-order-date-time-and-type';
        return wp_nonce_url(
            add_query_arg(
                array(
                    'action' => $action,
                    'plugin' => $slug
                ),
                admin_url( 'update.php' )
            ),
            $action.'_'.$slug
        );
    }

    function days(){
        $days = array(0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3=> 'Wednesday', 4=> 'Thursday', 5=>'Friday', 6=> 'Saturday');

        return $days;
    }

    function selectedDayOfTheWeek(){
        if(!isset($_POST['post_data']) && !isset($_POST['pi_system_delivery_date'])) return false;
        
        if(isset($_POST['pi_system_delivery_date'])){
            $values['pi_system_delivery_date'] = $_POST['pi_system_delivery_date'];
        }else{
            parse_str($_POST['post_data'], $values);
        }
        
        if(!empty($values['pi_system_delivery_date'])){
            $selected_day = date("w", strtotime($values['pi_system_delivery_date']));
            return $selected_day;
        }
        return false;
    }

    function conditionCheck($result, $package, $logic, $values){
        
                    $or_result = false;
                    $selected_day = $this->selectedDayOfTheWeek();

                    if($selected_day === false) return $or_result;

                    $rule_days = $values;
                    if($logic == 'equal_to'){
                        if(in_array($selected_day, $rule_days)){
                            $or_result = true;
                        }else{
                            $or_result = false;
                        }
                    }else{
                        if(in_array($selected_day, $rule_days)){
                            $or_result = false;
                        }else{
                            $or_result = true;
                        }
                    }
               
        return  apply_filters('pisol_efrs_selected_day_filter', $or_result, $values);
    }
}

new Pi_efrs_selection_rule_selected_delivery_day(PI_EFRS_SELECTION_RULE_SLUG);