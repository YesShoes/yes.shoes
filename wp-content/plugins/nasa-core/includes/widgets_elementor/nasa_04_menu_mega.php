<?php
/**
 * Widget for Elementor
 */
class Nasa_Mega_Menu_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_mega_menu';
        $this->widget_cssclass = 'nasa_mega_menu_wgsc';
        $this->widget_description = esc_html__('Displays Mega Menu', 'nasa-core');
        $this->widget_id = 'nasa_mega_menu_sc';
        $this->widget_name = esc_html__('Nasa Mega Menu', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'menu' => array(
                'type' => 'menu_list',
                'std' => '',
                'label' => esc_html__('Select Menu (Use slug of Menu)', 'nasa-core')
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );

        parent::__construct();
    }
}
