<?php

/**
 * Product Loop Start
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.3.0
 */

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

global $nasa_opt, $woocommerce_loop;

$data_columns_small = 1;
$data_columns_tablet = 2;

/**
 * Loop in Shop page
 */
if (!isset($woocommerce_loop['is_shortcode']) || !$woocommerce_loop['is_shortcode']) {
    $typeView = !isset($nasa_opt['products_type_view']) ? 'grid' : $nasa_opt['products_type_view'];
    
    $typeShow = $typeView == 'list' ? $typeView : 'grid';
    
    if (isset($_GET['view-layout']) && $_GET['view-layout'] == 'list') {
        $typeShow = 'list';
    }
    
    $nasa_change_view = !isset($nasa_opt['enable_change_view']) || $nasa_opt['enable_change_view'] ? true : false;
    $products_per_row = (isset($nasa_opt['products_type_view']) && $nasa_opt['products_type_view'] == 'list') ? 4 :
        (isset($nasa_opt['products_per_row']) && (int) $nasa_opt['products_per_row'] ? (int) $nasa_opt['products_per_row'] : 4);

    if (isset($_GET['view-layout']) && in_array($_GET['view-layout'], array('grid-2', 'grid-3', 'grid-4', 'grid-5', 'grid-6', 'list'))) :
        switch ($_GET['view-layout']) :
            case 'grid-2' :
                $products_per_row = 2;
                break;
            
            case 'grid-3' :
                $products_per_row = 3;
                break;

            case 'grid-5' :
                $products_per_row = 5;
                break;
            
            case 'grid-6' :
                $products_per_row = 6;
                break;

            case 'grid-4' :
            case 'list' :
            default:
                $products_per_row = 4;
                break;
        endswitch;
    endif;
}

/**
 * Loop in Short code
 */
else {
    $typeShow = 'grid';
    $products_per_row = isset($woocommerce_loop['columns']) ?
        $woocommerce_loop['columns'] : (isset($nasa_opt['products_per_row']) && (int) $nasa_opt['products_per_row'] ? (int) $nasa_opt['products_per_row'] : 4);
}

/**
 * Columns for desktop
 */
switch ($products_per_row):
    case 2:
        $typeShow .= ' large-block-grid-2';
        break;
    
    case 3:
        $typeShow .= ' large-block-grid-3';
        break;

    case 5:
        $typeShow .= ' large-block-grid-5';
        break;
    
    case 6:
        $typeShow .= ' large-block-grid-6';
        break;

    case 4:
    default:
        $typeShow .= ' large-block-grid-4';
        break;
endswitch;

/**
 * Columns for mobile
 */
$products_per_row_small = isset($nasa_opt['products_per_row_small']) && (int) $nasa_opt['products_per_row_small'] ? (int) $nasa_opt['products_per_row_small'] : 1;
switch ($products_per_row_small):
    case 2:
        $typeShow .= ' small-block-grid-2';
        $data_columns_small = 2;
        break;
    case 1:
    default:
        $typeShow .= ' small-block-grid-1';
        $data_columns_small = 1;
        break;
endswitch;

/**
 * Columns for tablet
 */
$products_per_row_tablet = isset($nasa_opt['products_per_row_tablet']) && (int) $nasa_opt['products_per_row_tablet'] ? (int) $nasa_opt['products_per_row_tablet'] : 2;
switch ($products_per_row_tablet):
    case 3:
        $typeShow .= ' medium-block-grid-3';
        $data_columns_tablet = 3;
        break;
    case 4:
        $typeShow .= ' medium-block-grid-4';
        $data_columns_tablet = 4;
        break;
    case 2:
    default:
        $typeShow .= ' medium-block-grid-2';
        $data_columns_tablet = 2;
        break;
endswitch;

$loop_start_class = apply_filters('nasa_loop_start_class', $typeShow);
?>

<div class="nasa-content-page-products">
    <ul class="products <?php echo esc_attr($loop_start_class); ?>" data-columns_small="<?php echo esc_attr($data_columns_small); ?>" data-columns_medium="<?php echo esc_attr($data_columns_tablet); ?>">
