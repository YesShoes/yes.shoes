<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Add action dokan
 */
add_action('init', 'elessi_add_action_dokan');
if (!function_exists('elessi_add_action_dokan')) :
    function elessi_add_action_dokan() {
        global $nasa_opt;
        
        add_action('woocommerce_after_shop_loop_item_title', 'elessi_dokan_loop_sold_by');
            
        // Hide Uncategorized
        if (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized']) {
            add_filter('dokan_category_widget', 'elessi_hide_uncategorized');
        }
    }
endif;

/**
 * Compatible with DOKAN plugin
 * 
 * sold-by in loop
 */
if (!function_exists('elessi_dokan_loop_sold_by')) :
    function elessi_dokan_loop_sold_by() {
        global $post, $nasa_dokan_vendors;
        
        if (!$post) {
            return;
        }
        
        if (!isset($nasa_dokan_vendors[$post->post_author])) {
            $author = get_user_by('id', $post->post_author);
            $store_info = dokan_get_store_info($author->ID);
            
            if (!empty($store_info['store_name'])) {
                $nasa_dokan_vendors[$post->post_author]['name'] = $store_info['store_name'];
                $nasa_dokan_vendors[$post->post_author]['url'] = dokan_get_store_url($author->ID);
            } else {
                $nasa_dokan_vendors[$post->post_author] = null;
            }
            
            $GLOBALS['nasa_dokan_vendors'] = $nasa_dokan_vendors;
        }
        
        if (isset($nasa_dokan_vendors[$post->post_author]) && $nasa_dokan_vendors[$post->post_author]) {
            echo '<small class="nasa-dokan-sold_by_in_loop">' .
                esc_html__('Sold By: ', 'elessi-theme') .
                '<a ' .
                    'href="' . esc_url($nasa_dokan_vendors[$post->post_author]['url']) . '" ' .
                    'class="nasa-dokan-sold_by_href" ' .
                    'title="' . esc_attr($nasa_dokan_vendors[$post->post_author]['name']) . '">' .
                    $nasa_dokan_vendors[$post->post_author]['name'] .
                '</a>' .
            '</small>';
        }
    }
endif;

/**
 * dokan_enqueue_style
 */
add_action('nasa_before_store_dokan', 'elessi_dokan_enqueue_style');
if (!function_exists('elessi_dokan_enqueue_style')) :
    function elessi_dokan_enqueue_style() {
        global $nasa_opt;

        $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        $themeVersion = isset($nasa_opt['css_theme_version']) && $nasa_opt['css_theme_version'] ? NASA_VERSION : null;
        
        $prefix = elessi_prefix_theme();

        if (!$inMobile) {
            wp_enqueue_style($prefix . '-style-products-list', ELESSI_THEME_URI . '/assets/css/style-products-list.css', array(), $themeVersion);
        }
    }
endif;

/**
 * Change view layout
 */
add_action('dokan_store_profile_frame_after', 'elessi_dokan_change_view_store', 15);
if (!function_exists('elessi_dokan_change_view_store')) :
    function elessi_dokan_change_view_store() {
        elessi_nasa_change_view('no');
    }
endif;