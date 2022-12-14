<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Render Time sale countdown
 * 
 * @param type $time_sale
 * @return type
 */
function nasa_time_sale($time_sale = false, $gmt = true, $wrap = false) {
    $result = '';
    
    if ($time_sale) {
        $time_sale = apply_filters('nasa_time_sale_countdown', $time_sale);
        $gmt_set = apply_filters('nasa_gmt', $gmt);
        
        $date_str = $gmt_set ?
            get_date_from_gmt(date('Y-m-d H:i:s', $time_sale), 'M j Y H:i:s O') :
            date('M j Y H:i:s O', $time_sale);
        
        $result .= $wrap ? '<div class="nasa-sc-pdeal-countdown">' : '';
        $result .= '<span class="countdown" data-countdown="' . esc_attr($date_str) . '"></span>';
        $result .= $wrap ? '</div>' : '';
    }
    
    return $result;
}

/**
 * Fix shortcode content
 * 
 * @param type $content
 * @return type
 */
function nasa_fix_shortcode($content = '') {
    $fix = array(
        '&nbsp;' => '',
        '<p>' => '',
        '</p>' => '',
        '<p></p>' => '',
    );
    $content = strtr($content, $fix);
    $content = wpautop(preg_replace('/<\/?p\>/', "\n", $content) . "\n");

    return do_shortcode(shortcode_unautop($content));
}

/**
 * Do shortcode for Ajax
 */
add_action('wp_ajax_get_shortcode', 'nasa_get_shortcode');
add_action('wp_ajax_nopriv_get_shortcode', 'nasa_get_shortcode');
function nasa_get_shortcode() {
    die(do_shortcode($_POST["content"]));
}

/**
 * Do Shortcode for widget text and the excerpt ...
 */
add_action('init', 'nasa_custom_do_sc');
function nasa_custom_do_sc() {
    add_filter('widget_text', 'do_shortcode');
    add_filter('the_excerpt', 'do_shortcode');
}

/**
 * Get Thumbnail
 * 
 * @param type $_id
 * @param type $image_pri
 * @param type $count_imgs
 * @param type $img_thumbs
 * @return string
 */
function nasa_getThumbs($_id, $image_pri, $count_imgs, $img_thumbs) {
    $thumbs = '<div class="nasa-sc-p-thumbs">';
    $thumbs .= '<div class="product-thumbnails-' . $_id . ' owl-carousel">';

    if ($image_pri) {
        $thumbs .= '<a href="javascript:void(0);" class="active-thumbnail nasa-thumb-a" rel="nofollow">';
        $thumbs .= '<img class="nasa-thumb-img" src="' . esc_attr($image_pri['thumb'][0]) . '" />';
        $thumbs .= '</a>';
    }

    if ($count_imgs) {
        foreach ($img_thumbs as $thumb) {
            $thumbs .= '<a href="javascript:void(0);" class="nasa-thumb-a" rel="nofollow">';
            $thumbs .= '<img class="nasa-thumb-img" src="' . esc_attr($thumb['src'][0]) . '" />';
            $thumbs .= '</a>';
        }
    } else {
        $thumbs .= sprintf('<a href="%s" class="active-thumbnail"><img src="%s" /></a>', wc_placeholder_img_src(), wc_placeholder_img_src());
    }

    $thumbs .= '</div>';
    $thumbs .= '</div>';
    
    return $thumbs;
}

/**
 * Vertical thumbnail
 * 
 * @param type $_id
 * @param type $image_pri
 * @param type $count_imgs
 * @param type $img_thumbs
 * @return type
 */
function nasa_getThumbsVertical($_id, $image_pri, $count_imgs, $img_thumbs) {
    $thumbs = '';
    $show = 3;
    $k = 0;
    
    if ($image_pri) {
        $thumbs .= '<a href="javascript:void(0);" class="nasa-thumb-a" rel="nofollow"><div class="row nasa-pos-relative">';
        $thumbs .= '<div class="large-4 medium-4 small-2 columns nasa-icon-current"><i class="pe-7s-angle-left"></i></div>';
        $thumbs .= '<div class="large-8 medium-8 small-10 columns"><img class="nasa-thumb-img" src="' . esc_attr($image_pri['thumb'][0]) . '" /></div>';
        $thumbs .= '</div></a>';
        $k++;
    }

    if ($count_imgs) {
        foreach ($img_thumbs as $thumb) {
            $k++;
            $thumbs .= '<a href="javascript:void(0);" class="nasa-thumb-a" rel="nofollow"><div class="row nasa-pos-relative">';
            $thumbs .= '<div class="large-4 medium-4 small-2 columns nasa-icon-current"><i class="pe-7s-angle-left"></i></div>';
            $thumbs .= '<div class="large-8 medium-8 small-10 columns"><img class="nasa-thumb-img" src="' . esc_attr($thumb['src'][0]) . '" /></div>';
            $thumbs .= '</div></a>';
        }
    } else {
        $k++;
        $imgSrc = wc_placeholder_img_src();
        $thumbs .=
            '<a href="' . $imgSrc . '" class="nasa-thumb-a">' .
                '<div class="nasa-pos-relative">' .
                    '<div class="large-4 medium-4 small-2 columns nasa-icon-current">' .
                        '<i class="pe-7s-angle-left"></i>' .
                    '</div>' .
                    '<div class="large-8 medium-8 small-10 columns">' .
                        '<img src="' . $imgSrc . '" />' .
                    '</div>' .
                '</div>' .
            '</a>';
    }

    $thumbs_begin = '<div class="nasa-sc-p-thumbs">';
    $attr_top = ($k <= $show) ? ' data-top="1"' : '';

    $thumbs_begin .= '<div class="y-thumb-images-' . $_id . ' images-popups-gallery" data-show="' . $show . '" data-autoplay="1"' . $attr_top . '>';

    $thumbs .= '</div>';
    $thumbs .= '</div>';

    return $thumbs_begin . $thumbs;
}

/**
 * Category thumbnail
 * 
 * @param type $category
 * @param type $type
 */
function nasa_category_thumbnail($category, $type) {
    $small_thumbnail_size = apply_filters('subcategory_archive_thumbnail_size', $type);
    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
    
    if ($thumbnail_id) {
        $image = wp_get_attachment_image_src($thumbnail_id, $small_thumbnail_size);
        if (isset($image[0])) {
            $image_src = $image[0];
            $image_width = $image[1];
            $image_height = $image[2];
        }
    } else {
        $image_src = wc_placeholder_img_src();
        $image_width = 100;
        $image_height = 100;
    }

    if ($image_src) {
        echo '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($category->name) . '" width="' . $image_width . '" height="' . $image_height . '" />';
    }
}

/**
 * Get Menu options Shortcode
 */
function nasa_get_menu_options() {
    global $nasa_menu_options;
    
    if (!isset($nasa_menu_options)) {
        $menus = wp_get_nav_menus(array('orderby' => 'name'));
        $nasa_menu_options = array(esc_html__("Select menu", 'nasa-core') => '');
        foreach ($menus as $menu_option) {
            $nasa_menu_options[$menu_option->name] = $menu_option->slug;
        }
        
        $GLOBALS['nasa_menu_options'] = $nasa_menu_options;
    }
    
    return $nasa_menu_options;
}

/**
 * Get Pins
 * 
 * @param type $type
 * @return type
 */
function nasa_get_pin_arrays($type = 'nasa_pin_pb') {
    global $nasa_pins;
    
    if (!isset($nasa_pins)) {
        $nasa_pins = array();
    }
    
    if (!isset($nasa_pins[$type])) {
        $nasa_pins[$type] = array(esc_html__('Select Item', 'nasa-core') => '');
        
        $pins = get_posts(array(
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'post_type'         => $type
        ));

        if ($pins) {
            foreach ($pins as $pin) {
                $nasa_pins[$type][$pin->post_title] = $pin->post_name;
            }
        }
        
        $GLOBALS['nasa_pins'] = $nasa_pins;
    }
    
    return $nasa_pins[$type];
}

/**
 * Get Revolution Sliders
 */
function nasa_get_revsliders_arrays() {
    global $nasa_revsliders;
    
    if (!isset($nasa_revsliders)) {
        $nasa_revsliders = array();
    }
    
    if (empty($nasa_revsliders)) {
        $nasa_revsliders = array(esc_html__('Select Rev Slider Item', 'nasa-core') => '');
        
        if (!class_exists('RevSlider')) {
            return $nasa_revsliders;
        }
        
        $slider = new RevSlider();
        $revs = $slider->get_sliders();

        if ($revs) {
            foreach ($revs as $rev) {
                $nasa_revsliders[$rev->title] = $rev->alias;
            }
        }
        
        $GLOBALS['nasa_revsliders'] = $nasa_revsliders;
    }
    
    return $nasa_revsliders;
}

/**
 * get Header by slug
 * 
 * @param type $slug
 */
function nasa_get_header($slug) {
    if (!$slug) {
        return;
    }

    $args = array(
        'name' => $slug,
        'posts_per_page' => 1,
        'post_type' => 'header',
        'post_status' => 'publish'
    );

    $headers_type = get_posts($args);
    $header = isset($headers_type[0]) ? $headers_type[0] : null;
    $header_id = isset($header->ID) ? (int) $header->ID : null;

    if (function_exists('icl_object_id') && (int) $header_id) {
        $header_langID = icl_object_id($header_id, 'header', true);
        
        if ($header_langID && $header_langID != $header_id) {
            $headerLang = get_post($header_langID);
            
            $header = $headerLang && $headerLang->post_status == 'publish' ? $headerLang : $header;
            $header_id = $header_langID;
        }
    }

    $content = '';
    if ($header && isset($header->post_content)) {
        $content = nasa_get_custom_style($header_id);
        $content .= do_shortcode($header->post_content);
    }
    
    return $content;
}

/**
 * get Footer by slug
 * 
 * @param type $slug
 */
function nasa_get_footer($slug) {
    if (!$slug) {
        return;
    }

    $args = array(
        'posts_per_page' => 1,
        'post_type' => 'footer',
        'post_status' => 'publish',
        'name' => $slug
    );

    $footers_type = get_posts($args);
    $footer = isset($footers_type[0]) ? $footers_type[0] : null;
    $footer_id = isset($footer->ID) ? (int) $footer->ID : null;
    $footer_pageID = $footer_id;

    /**
     * Support Multi Languages
     */
    if (function_exists('icl_object_id') && (int) $footer_id) {
        $footer_langID = icl_object_id($footer_id, 'footer', true);
        
        if ($footer_langID && $footer_langID != $footer_id) {
            $footerLang = get_post($footer_langID);
            
            $footer = $footerLang && $footerLang->post_status == 'publish' ? $footerLang : $footer;
            $footer_pageID = $footer_langID;
        }
    }

    $content = '';
    if ($footer && isset($footer->post_content)) {
        $content .= nasa_get_custom_style($footer_pageID);
        $content .= do_shortcode($footer->post_content);
    }
    
    return $content;
}

/**
 * Get Block by slug
 * 
 * @param type $slug
 * @return type
 */
function nasa_get_block($slug) {
    $block = $slug && $slug !== 'default' ? get_posts(
        array(
            'name'              => $slug,
            'posts_per_page'    => 1,
            'post_type'         => 'nasa_block',
            'post_status'       => 'publish'
        )
    ) : null;
    
    $post = !empty($block) ? $block[0] : null;
    $real_id = $post ? $post->ID : 0;

    /**
     * With Multi Languages
     */
    if (function_exists('icl_object_id') && $real_id) {
        $postLangID = icl_object_id($real_id, 'nasa_block', true);

        if ($postLangID && $postLangID != $real_id) {
            $postLang = get_post($postLangID);
            $post = $postLang && $postLang->post_status == 'publish' ? $postLang : $post;
            $real_id = $postLangID;
        }
    }

    $content = '';
    if ($post && isset($post->post_content)) {
        $content .= nasa_get_custom_style($real_id);
        $content .= do_shortcode($post->post_content);
    }

    return $content;
}

/**
 * Get Block OBJ by slug
 * 
 * @param type $slug
 * @return type
 */
function nasa_get_block_obj($slug) {
    $block = $slug && $slug !== 'default' ? get_posts(
        array(
            'name'              => $slug,
            'posts_per_page'    => 1,
            'post_type'         => 'nasa_block',
            'post_status'       => 'publish'
        )
    ) : null;
    
    $post = !empty($block) ? $block[0] : null;
    $real_id = $post ? $post->ID : 0;

    /**
     * With Multi Languages
     */
    if (function_exists('icl_object_id') && $real_id) {
        $postLangID = icl_object_id($real_id, 'nasa_block', true);

        if ($postLangID && $postLangID != $real_id) {
            $postLang = get_post($postLangID);
            $post = $postLang && $postLang->post_status == 'publish' ? $postLang : $post;
            $real_id = $postLangID;
        }
    }

    if ($post) {
        $result = array(
            'title' => '',
            'content' => ''
        );
        
        $result['content'] .= nasa_get_custom_style($real_id);
        $result['content'] .= do_shortcode($post->post_content);
        
        $result['title'] .= $post->post_title;
        
        return $result;
    }

    return null;
}

/**
 * get custom css by post id
 */
function nasa_get_custom_style($post_id) {
    $content = '';
    
    if (!$post_id) {
        return $content;
    }
    
    $shortcodes_custom_css = get_post_meta($post_id, '_wpb_shortcodes_custom_css', true);
    if (!empty($shortcodes_custom_css)) {
        $content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
        $content .= strip_tags($shortcodes_custom_css);
        $content .= '</style>';
    }
    
    return $content;
}

/**
 * Label empty select nasa custom taxonomies
 * 
 * @param type $level
 * @return type
 */
function nasa_render_select_nasa_cats_empty($level = '0') {
    switch ($level) :
        case '1':
            return esc_html__('Select Level 1', 'nasa-core');
        case '2':
            return esc_html__('Select Level 2', 'nasa-core');
        case '3':
            return esc_html__('Select Level 3', 'nasa-core');
        default:
            return esc_html__('Select Model', 'nasa-core');
    endswitch;
}

/**
 * get No-Image
 */
function nasa_no_image($only_src = false) {
    $src = apply_filters('nasa_src_no_image', NASA_CORE_PLUGIN_URL . 'assets/images/no_image.jpg');
    
    return $only_src ? esc_url($src) : '<img src="' . esc_url($src) . '" alt="' . esc_attr__('No Image', 'nasa-core') . '" />';
}

/**
 * Get relates post
 */
add_action('nasa_after_single_post', 'nasa_relate_posts');
if (!function_exists('nasa_relate_posts')) :
    function nasa_relate_posts() {
        global $nasa_opt, $post;
        
        if (isset($nasa_opt['relate_blogs']) && !$nasa_opt['relate_blogs']) {
            return;
        }
        
        $numberPost = isset($nasa_opt['relate_blogs_number']) && (int) $nasa_opt['relate_blogs_number'] ? (int) $nasa_opt['relate_blogs_number'] : 10;
        
        $relate = get_posts(
            array(
                'post_status' => 'publish',
                'post_type' => 'post',
                'category__in' => wp_get_post_categories($post->ID),
                'numberposts' => $numberPost,
                'post__not_in' => array($post->ID),
                'orderby' => 'date',
                'order' => 'DESC'
            )
        );
        
        if ($relate) {
            nasa_template('blogs/single/nasa-blog-relate.php', array('relate' => $relate));
        }
    }
endif;

/**
 * set nasa_opt - Header structure
 */
add_action('template_redirect', 'nasa_header_structure');
function nasa_header_structure() {
    global $nasa_opt, $post;
    
    $hstructure = isset($nasa_opt['header-type']) ? $nasa_opt['header-type'] : '1';
    $page_id = false;
    $header_override = false;
    $header_slug = isset($nasa_opt['header-custom']) && $nasa_opt['header-custom'] != 'default' ?
        $nasa_opt['header-custom'] : false;
    $header_slug_ovrride = false;
    $fixed_nav_header = '';
    
    /**
     * Top bar
     */
    $topbar_on = !isset($nasa_opt['topbar_on']) || $nasa_opt['topbar_on'] ? true : false;
    $topbar_on_ov = '';

    $is_shop = $pageShop = $is_product_taxonomy = $is_product = false;
    if (NASA_WOO_ACTIVED) {
        $is_shop = is_shop();
        $is_product = is_product();
        $is_product_taxonomy = is_product_taxonomy();
        $pageShop = wc_get_page_id('shop');
    }

    /**
     * Override Header
     */
    $root_term_id = nasa_root_term_id();
    if (!$root_term_id) {
        /**
         * Store Page
         */
        if (($is_shop || $is_product_taxonomy) && $pageShop > 0) {
            $page_id = $pageShop;
        }

        /**
         * Page
         */
        if (!$page_id && isset($post->post_type) && $post->post_type == 'page') {
            $page_id = $post->ID;
        }

        /**
         * Blog
         */
        if (!$page_id && nasa_check_blog_page()) {
            $page_id = get_option('page_for_posts');
        }

        /**
         * Swith header structure
         */
        if ($page_id) {
            $custom_header = get_post_meta($page_id, '_nasa_custom_header', true);
            if (!empty($custom_header)) {
                $hstructure = $custom_header;
                $header_slug_ovrride = get_post_meta($page_id, '_nasa_header_builder', true);
            }

            $fixed_nav_header = get_post_meta($page_id, '_nasa_fixed_nav', true);
            $fixed_nav_header = $fixed_nav_header == '-1' ? false : $fixed_nav_header;
            
            /**
             * Top bar
             */
            $topbar_on_ov = get_post_meta($page_id, '_nasa_topbar_on', true);
        }
    }

    else {
        /**
         * For Root category (parent = 0)
         */
        $header_override = get_term_meta($root_term_id, 'cat_header_type', true);

        if ($header_override == 'nasa-custom') {
            $hstructure = $header_override;
            $header_slug_ovrride = get_term_meta($root_term_id, 'cat_header_builder', true);
        } else {
            $hstructure = $header_override ? $header_override : $hstructure;
        }
        
        /**
         * Top bar
         */
        $topbar_on_ov = get_term_meta($root_term_id, 'cat_topbar_on', true);
    }
    
    if ($fixed_nav_header === '') {
        $fixed_nav_header = (!isset($nasa_opt['fixed_nav']) || $nasa_opt['fixed_nav']);
    }
    
    /**
     * Transparent header
     */
    $header_transparent = $page_id ? get_post_meta($page_id, '_nasa_header_transparent', true) : '';
    $header_transparent = $header_transparent == '-1' ? '0' : $header_transparent;
    $header_transparent = $header_transparent == '' ? ((!isset($nasa_opt['header_transparent']) || !$nasa_opt['header_transparent']) ? false : true) : (bool) $header_transparent;
    
    /**
     * Full width main menu
     */
    $full_rule_headers = array('2', '3');
    if (in_array($hstructure, $full_rule_headers)) {
        $fullwidth_main_menu = (isset($nasa_opt['fullwidth_main_menu']) && !$nasa_opt['fullwidth_main_menu']) ? false : true;
        $fullwidth_ovr = $page_id ? get_post_meta($page_id, '_nasa_fullwidth_main_menu', true) : $fullwidth_main_menu;
        if ($fullwidth_ovr !== '') {
            $fullwidth_main_menu = $fullwidth_ovr === '-1' ? false : $fullwidth_ovr;
        }
    } else {
        $fullwidth_main_menu = false;
    }
    
    /**
     * el_class for header
     */
    $el_class_header = $page_id ? get_post_meta($page_id, '_nasa_el_class_header', true) : '';
    
    /**
     * Re-Render
     */
    $nasa_opt['header-type'] = $hstructure;
    $nasa_opt['header-custom'] = $header_slug_ovrride ? $header_slug_ovrride : $header_slug;
    $nasa_opt['fixed_nav'] = $fixed_nav_header;
    $nasa_opt['header_transparent'] = $header_transparent;
    $nasa_opt['fullwidth_main_menu'] = $fullwidth_main_menu;
    if ($el_class_header) {
        $nasa_opt['el_class_header'] = $el_class_header;
    }
    
    /**
     * Top bar
     */
    if ($topbar_on_ov !== '') {
        if ($topbar_on_ov === '2') {
            $topbar_on = $topbar_on_ov === '2' ? false : true;
        }
        
        $nasa_opt['topbar_on'] = $topbar_on;
    }
    
    $GLOBALS['nasa_opt'] = $nasa_opt;
}

/**
 * Check Blog page
 * 
 * @global type $nasa_blog_page
 * @global type $post
 * @return type
 */
function nasa_check_blog_page() {
    global $nasa_blog_page;

    if (!isset($nasa_blog_page)) {
        global $post;

        $nasa_blog_page = (
            (isset($post->post_type) &&
            $post->post_type == 'post' &&
            (
                is_home() ||
                is_search() ||
                is_front_page() ||
                is_archive() ||
                is_category() ||
                is_tag() ||
                is_date() ||
                is_author() ||
                is_single()
            )) ||
            (is_search() && (!isset($_GET['post_type']) || !$_GET['post_type']))
        ) ? true : false;

        $GLOBALS['nasa_blog_page'] = $nasa_blog_page;
    }

    return $nasa_blog_page;
}

/**
 * Switch Tablet
 */
function nasa_switch_tablet() {
    return apply_filters('nasa_switch_tablet', '767');
}

/**
 * Switch Desktop
 */
function nasa_switch_desktop() {
    return apply_filters('nasa_switch_desktop', '1024');
}

/**
 * Filter hook remove smilies
 */
add_filter('smilies', 'nasa_filter_use_smilies');
function nasa_filter_use_smilies($wp_smiliessearch) {
    global $nasa_opt;
    
    return !isset($nasa_opt['enable_use_smilies']) || !$nasa_opt['enable_use_smilies'] ? array() : $wp_smiliessearch;
}
