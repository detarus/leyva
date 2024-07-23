<?php
/* Change quantity Woocommerce mini cart */
add_action('wp_ajax_change_mini_cart_quantity', 'change_mini_cart_quantity_func');
add_action('wp_ajax_nopriv_change_mini_cart_quantity', 'change_mini_cart_quantity_func');
/* Async Load Posts*/
add_action( 'wp_ajax_load_posts', 'leyve_load_posts_func');
add_action( 'wp_ajax_nopriv_load_posts', 'leyve_load_posts_func');

/**
 * Change quantity with AJAX-post for Woocommerce mini cart.
 *
 * @return void
 */
function change_mini_cart_quantity_func() {

    global $woocommerce;

    $product_id = $_POST['product_id'];
    $cart_key = $_POST['key'];
    $val = $_POST['value'];
    $block_id = $_POST['block_id'];
    $product = wc_get_product($product_id);
    $product_price = str_replace(',', '', number_format(($product->get_price() * $val), 2)) . ' ' . get_woocommerce_currency_symbol();
    $cart = WC()->instance()->cart;
    $cart_count = $cart->get_cart_contents_count();
    $cart_total = $cart->get_cart_subtotal();
    
    if($cart_key){
        $cart->set_quantity($cart_key, $val);
        $cart = WC()->instance()->cart;
        $cart_count = $cart->get_cart_contents_count();
        $cart_total = $cart->get_cart_subtotal();

        $ajax_answer = array(
            'product_id'    => $_POST['block_id'],
            'product_price' => $product_price,
            'total_items'   => $cart_count,
            'total_price'   => $cart_total,
        );

        echo wp_send_json_success($ajax_answer);
        wp_die();
    } 
    echo "It didn't work out. No change in quantity.";

    wp_die();
}

function leyve_load_posts_func() {

    $post_status = 'publish';
    $post_type = 'product';
    $orderby = 'menu_order';
    $category = '';
    $amount = '';
    $post_num = 12;
    $paged = 1;

    if($_POST['post_type']) $post_type = $_POST['post_type'];
    if($_POST['post_status']) $post_status = $_POST['post_status'];
    if($_POST['paged'])  $paged = $_POST['paged'];
    if($_POST['post_num']) $post_num = $_POST['post_num'];
    if($_POST['orderby']) $orderby = $_POST['orderby'];
    if($_POST['category']) $category = $_POST['category'];
    if($_POST['amount']) $amount = $_POST['amount'];

    if (isset($_POST['taxonomy']) && is_array($_POST['taxonomy']) && !empty($_POST['taxonomy'])) {
        $taxonomy = $_POST['taxonomy'];
        $tax_query = array('relation' => 'AND'); 
    
        foreach ($taxonomy as $key => $terms) {
            $tax_query[] = array(
                'taxonomy' => $key,
                'field'    => 'slug',
                'terms'    => $terms,
            );
        }    
    }

    $args = [
        'post_status'    => $post_status,
        'posts_per_page' => $post_num,
        'post_type'      => $post_type, 
        'paged'          => $paged,
    ];

    if($amount) $args['meta_query'] = [['relation' => 'AND'], ['key' => '_price', 'value' => array($amount[0], $amount[1]), 'compare' => 'BETWEEN']];

    if($category){
        $args['tax_query'] = [['taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $category], $tax_query];
    } else {
        $args['tax_query'] = $tax_query;
    }
        
    switch ($orderby){
        case 'popularity':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'total_sales';
            $args['order'] = 'DESC';
            break;

        case 'rating':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_wc_average_rating';
            $args['order'] = 'DESC';
            break;

        case 'date':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;

        case 'price':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'ASC';
            break;

        case 'price-desc':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'DESC';
            break;

        case 'menu_order':
            $args['orderby'] = 'menu_order';
            break;
    }

    $postslist = new WP_Query($args);
    $found = $postslist->found_posts;
    if ( $postslist->have_posts() ) {
        while ( $postslist->have_posts() ) : $postslist->the_post();
            wc_get_template_part( 'content', 'product' );
        endwhile;

        if ($found <= $paged * $post_num) echo 'end';

    } else {
        echo '<div id="noresults" class="noresults">Nothing Found</div>';
    }

    wp_die();
}

?>