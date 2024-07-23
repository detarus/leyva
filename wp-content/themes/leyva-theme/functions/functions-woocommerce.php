<?php 
/**
 * Add support Woocommerce fot theme.
 */
add_theme_support('woocommerce');

/**
 * Edit default Woocommerece hooks.
 */

 /* Removes */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
add_filter('wc_product_sku_enabled', '__return_false');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);
 // remove_cation('woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10);
add_filter('woocommerce_enable_order_notes_field', '__return_false');

 /* Add */
add_action('woocommerce_after_shop_loop_item_title', 'show_desc_product_in_shop', 1);
add_action('woocommerce_before_single_product_summary', 'product_container_content_open', 1);
add_action('woocommerce_after_single_product_summary', 'product_container_content_close', 1);
add_action('woocommerce_after_single_product', 'product_category_slider', 1);
add_action('woocommerce_shop_loop_item_title', 'show_color_attr_product', 1);
add_action('woocommerce_before_single_product_summary', 'wc_show_product_images', 20);
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'color_radio_variations', 20, 2);
add_action('woocommerce_after_single_product_summary', 'wc_reviews_custom', 10);
add_action('woocommerce_before_add_to_cart_quantity', 'add_quantity_minus_sign');
add_action('woocommerce_after_add_to_cart_quantity', 'add_quantity_plus_sign');
add_action('woocommerce_after_add_to_cart_button', 'close_wrapper_cart_block');
add_action('wp_footer', 'wc_quantity_plus_minus_script');
add_action('woocommerce_single_product_summary', 'wc_display_single_product_attributes', 15);
add_action('woocommerce_single_product_summary', 'wc_new_variable_add_to_cart', 25);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20);
add_action('woocommerce_single_product_summary', 'wc_add_rating_single_title', 5 );
add_action('woocommerce_single_product_summary', 'wc_single_product_description', 55);
add_action('woocommerce_single_product_summary', 'wc_single_product_details', 60);
add_action('woocommerce_widget_shopping_cart_buttons', 'custom_widget_shopping_cart_button_view_cart', 10);
add_action('woocommerce_widget_shopping_cart_buttons', 'custom_widget_shopping_cart_proceed_to_checkout', 20);
add_filter('woocommerce_checkout_fields', 'remove_billing_checkout_fields');
add_filter('woocommerce_default_address_fields' , 'change_address_billing_checkout_fields');
add_filter('woocommerce_checkout_fields' , 'change_other_billing_checkout_fields', 20, 1);
add_filter( 'woocommerce_output_cart_shortcode_content', 'disable_cart_after_order', 25 );
add_filter( 'woocommerce_before_checkout_form', 'add_before_checkout_block');
add_filter( 'woocommerce_after_checkout_form', 'add_after_checkout_block');
// add_filter( 'woocommerce_get_checkout_url', 'change_viem_cart_url', 10, 2 );
add_filter( 'woocommerce_get_cart_url', 'change_viem_cart_url' );
add_action( 'template_redirect', 'redirect_empty_cart', 25 );

function redirect_empty_cart() {

	if((is_cart()) && (0 == WC()->cart->get_cart_contents_count()) && (!is_wc_endpoint_url('order-pay')) && (!is_wc_endpoint_url('order-received'))){
		wp_safe_redirect(get_page_link(194));
		exit;
	}
}

function change_viem_cart_url($url){
  if(!(is_cart() || is_checkout())){
    $url = wc_get_checkout_url();
  }
  return $url;
}

function add_before_checkout_block(){
	echo '<div class="wc-cart-checkout-block">';
}

function add_after_checkout_block(){
	echo '</div>';
}

function disable_cart_after_order($display_cart){
	if(is_wc_endpoint_url('order-received')){
		$display_cart = false;
	}
	return $display_cart;
}

function remove_billing_checkout_fields( $fields ) {
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_city']);
  unset($fields['billing']['billing_state']);
  // unset($fields['billing']['billing_address_1']);

  return $fields;
}

function change_address_billing_checkout_fields( $fields ) {
  $fields['first_name']['placeholder'] = __('First name', 'woocommerce');
  $fields['last_name']['placeholder'] = __('Last name', 'woocommerce');

  return $fields;
}

function change_other_billing_checkout_fields( $fields ) {
  $fields['billing']['billing_phone']['placeholder'] = 'Number';
  $fields['billing']['billing_email']['placeholder'] = 'Mail';
  return $fields;
}




function wc_single_product_description(){
  global $product;
  $product_instance = wc_get_product($product->get_id());
  $description = $product_instance->get_description();
  if($description){
    echo '<div class="wc-single-prod-description-block"><h5 class="wc-single-prod-description-title active">Description <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M18 9L12 15L6 9" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></h5><div class="wc-single-prod-description-text">' . $description .'</div></div>';
  }
}

function wc_single_product_details(){
  if(get_the_excerpt()){
    echo '<div class="wc-single-prod-details-block"><h5 class="wc-single-prod-details-title">Details <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M18 9L12 15L6 9" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></h5><p class="wc-single-prod-details-text" style="display: none;">' . get_the_excerpt() .'</p></div>';
  }
}

function show_desc_product_in_shop() {
  if(get_the_excerpt()){
    echo '<span class="product-block-desc">' . get_the_excerpt() .'</span>';
  }
}

function product_container_content_open() {
  echo '<div class="wc-single-prod-body">';
}

function product_container_content_close() {
  echo '</div>';
}


function product_category_slider() {
  $args = array(
    'taxonomy'   => "product_cat",
    'number'     => $number,
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
    'include'    => $ids
  );

  $product_categories = get_terms($args);
  $prod_cat_slide = '';

  $arrow_rose = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#BE3155"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#BE3155" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 16L16 12L12 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
  $arrow_white = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 16L16 12L12 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

  foreach($product_categories as $cat){
    $image = '<img src="' . wp_get_attachment_url(get_term_meta($cat->term_id, 'thumbnail_id', true)) . '" alt="' . $slug . '" />';
    $name = $cat->name;
    $slug = $cat->slug;
    $link = get_term_link( $cat->term_id, 'product_cat' );

    $prod_cat_slide .= '<div class="swiper-slide home-single-cat-content">' . $image . '<a class="home-single-cat-link" href="' . $link . '">' . $name . $arrow_white . '</a></div>';
  }

  
  echo '<section class="s-cats-home">
          <h2 class="cats-home-title">Popular categories</h2>
          <div class="cats-home-swiper swiper">
            <div class="cats-home-wrapper swiper-wrapper">' . $prod_cat_slide . '</div>
            <div class="home-cats-arrows">
              <div class="home-cats-next">' . $arrow_rose . '</div>
              <div class="home-cats-prev">' . $arrow_rose . '</div>
            </div>
            <div class="home-cats-swiper-pagination"></div>
          </div>
        </section>';
}

function show_color_attr_product() {
  global $product;
  if ( $product->is_type('variable') || $product->is_type('simple') ) {
    $atrs = $product->get_attributes();
    $color_icons = '';

    foreach($atrs as $atr){
      if($atr->get_data()['name'] == 'pa_color') $colors = $atr->get_data();
    }

    foreach($colors['options'] as $color){
      $color_icons .= ' <img src="' . get_field('product_att_img', 'pa_color_' . $color) . '" alt="color-product">';
    }

    echo '<span class="wc-shop-product-color">Color:' . $color_icons . '</span>';
  }
}

function wc_show_product_images() {

  global $product;

  $images = '<div class="swiper-slide"><img class="wc-prod-swiper-img" src="' . wp_get_attachment_url($product->get_image_id()) . '" /></div>';
  $attachment_ids = $product->get_gallery_image_ids();

  foreach($attachment_ids as $key => $attachment_id) {
    $image_link = wp_get_attachment_url($attachment_id);
    if($key == 0) $first_class = 'wc-prod-swiper-img__first-img'; else $first_class = '';
    $images .= '<div class="swiper-slide"><img class="wc-prod-swiper-img ' . $first_class . '" src="' . $image_link . '" /></div>';
  }

  echo '
  <div class="wc-single-prod-gallery">
    <div class="swiper wc-swiper-gallery wc-swiper-gallery--main">
      <div class="swiper-wrapper">' . $images . '</div>
      <div class="wc-single-prod-pagination"></div>
    </div>
    <div thumbsSlider="" class="swiper wc-swiper-gallery wc-swiper-gallery--second">
      <div class="swiper-wrapper">' . $images . '</div>
    </div>
    <div class="wc-single-prod-btn-next">
      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><path d="M18.5 9.5L12.5 15.5L6.5 9.5" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </div>
    <div class="wc-single-prod-btn-prev">
      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none"><path d="M18.5 15.5L12.5 9.5L6.5 15.5" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </div>
  </div>';
}

function color_radio_variations( $html, $args ) {

  // in wc_dropdown_variation_attribute_options() they also extract all the array elements into variables
  $options   = $args[ 'options' ];
  $product   = $args[ 'product' ];
  $attribute = $args[ 'attribute' ];
  $name      = $args[ 'name' ] ? $args[ 'name' ] : 'attribute_' . sanitize_title( $attribute );
  $id        = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
  $class     = $args[ 'class' ];

  if((empty( $options ) || ! $product) && 'pa_color' !== $attribute) {
    return $html;
  }

  // HTML for our radio buttons
  $radios = '<div class="wc-product-variation-radios">';

   // taxonomy-based attributes
  if( taxonomy_exists( $attribute ) ) {

    $terms = wc_get_product_terms(
      $product->get_id(),
      $attribute,
      array(
        'fields' => 'all',
      )
    );

    foreach( $terms as $term ) {
      if( in_array( $term->slug, $options, true ) ) {
        // $color_img = get_field('product_att_img', 'pa_color_' . $term->term_id);
        $color_img = '<img src="' . get_field('product_att_img', 'pa_color_' . $term->term_id) . '" alt="color-product">';
        // $color_img = ;
        $radios .= "<input class=\"wc-input-var-atr wc-input-var-atr--{$name}-{$term->slug}\"type=\"radio\" id=\"{$name}-{$term->slug}\" name=\"{$name}\" value=\"{$term->slug}\"" . checked( $args[ 'selected' ], $term->slug, false ) . "><label class=\"wc-label-var-atr wc-label-var-atr--{$name}-{$term->slug}\" for=\"{$name}-{$term->slug}\">{$color_img}</label>";
      }
    }
  // individual product attributes
  } else {
    foreach( $options as $option ) {
      $checked = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? checked( $args[ 'selected' ], sanitize_title( $option ), false ) : checked( $args[ 'selected' ], $option, false );
      $radios .= "<input type=\"radio\" id=\"{$name}-{$option}\" name=\"{$name}\" value=\"{$option}\" id=\"{$option}\" {$checked}><label for=\"{$name}-{$option}\">{$option}</label>";
    }
  }
  
  $radios .= '</div>';

  return $html . $radios;
  
}

function wc_reviews_custom(){
  comments_template();
}

function add_quantity_minus_sign(){
  echo '<div class="wc-sing-prod-cart--block"><div class="wc-product-quantity-wrapper"><button type="button" class="wc-procut-quantity-minus" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><path d="M15 18.5L9 12.5L15 6.5" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>';
}

function add_quantity_plus_sign(){
  echo '<button type="button" class="wc-procut-quantity-plus" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><path d="M9 6.5L15 12.5L9 18.5" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button></div>';
}

function close_wrapper_cart_block(){
  echo '</div>';
}

function wc_quantity_plus_minus_script() {

  if (!is_product()) return;
  ?>
    <script type="text/javascript">
      jQuery(document).ready(function($){
        $('.wc-product-quantity-wrapper').on('click', '.wc-procut-quantity-plus, .wc-procut-quantity-minus', function(){
          $qty = $(this).closest('.wc-product-quantity-wrapper').find('.qty');
          $val = parseFloat($qty.val());
          $max = parseFloat($qty.attr('max'));
          $min = parseFloat($qty.attr('min'));
          $step = parseFloat($qty.attr('step'));

          if ($(this).is( '.wc-procut-quantity-plus')){
            if ($max && ($max <= $val)){
              $qty.val($max);
            }	else {
              $qty.val($val + $step);
            }
          }	else {
            if ($min && ($min >= $val)){
              qty.val(min);
            }	else if ($val > 1){
              $qty.val($val - $step);
            }
          }
        });
      });
    </script>
  <?php
}

function wc_display_single_product_attributes(){
  global $product;
  if($product->is_type('simple')){
    $product_attributes = array();

    // Display weight and dimensions before attribute list.
    $display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() );

    if ( $display_dimensions && $product->has_weight() ) {
      $product_attributes['weight'] = array(
        'label' => __( 'Weight', 'woocommerce' ),
        'value' => wc_format_weight( $product->get_weight() ),
      );
    }

    if ( $display_dimensions && $product->has_dimensions() ) {
      $product_attributes['dimensions'] = array(
        'label' => __( 'Dimensions', 'woocommerce' ),
        'value' => wc_format_dimensions( $product->get_dimensions( false ) ),
      );
    }

    // Add product attributes to list.
    $attributes = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );

    foreach ( $attributes as $attribute ) {
      $values = array();

      if ( $attribute->is_taxonomy() ) {
        $attribute_taxonomy = $attribute->get_taxonomy_object();
        $attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

        foreach ( $attribute_values as $attribute_value ) {
          $value_name = esc_html( $attribute_value->name );

          
          if ( $attribute_taxonomy->attribute_public ) {
            $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
          } else {
            $values[] = $value_name;
          }
        }
      } else {
        $values = $attribute->get_options();

        foreach ( $values as &$value ) {
          $value = make_clickable( esc_html( $value ) );
        }
      }

      if($attribute->get_name() == 'pa_color'){
        $terms = wc_get_product_terms($product->get_id(), $attribute->get_name());
        $color_imgs = '';
        foreach( $terms as $term ) {
          $color_imgs .= '<img src="' . get_field('product_att_img', 'pa_color_' . $term->term_id) . '" alt="color-product">';
        }
        $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
          'label' => wc_attribute_label( $attribute->get_name() ),
          'value' => $color_imgs,
        );
      } else if($attribute->get_name() == 'pa_features'){
        $terms = wc_get_product_terms($product->get_id(), $attribute->get_name());
        $feat_imgs = '';
        foreach( $terms as $term ) {
          $feat_imgs .= '<img src="' . get_field('product_att_img', 'pa_features_' . $term->term_id) . '" alt="color-product">';
        }
        $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
          'label' => wc_attribute_label( $attribute->get_name() ),
          'value' => $feat_imgs,
        );
      } else {
        $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
          'label' => wc_attribute_label( $attribute->get_name() ),
          'value' => apply_filters( 'woocommerce_attribute',  wptexturize( implode( ', ', $values ) ) , $attribute, $values ),
        );
      }

    }

    /**
    * Hook: woocommerce_display_product_attributes.
    *
    * @since 3.6.0.
    * @param array $product_attributes Array of attributes to display; label, value.
    * @param WC_Product $product Showing attributes for this product.
    */
    $product_attributes = apply_filters( 'woocommerce_display_product_attributes', $product_attributes, $product );

    wc_get_template(
      'single-product/product-attributes.php',
      array(
        'product_attributes' => $product_attributes,
        'product'            => $product,
        'attributes'         => $attributes,
        'display_dimensions' => $display_dimensions,
      )
    );
  }
}

function wc_display_single_product_attributes_variation(){
  global $product;
  $product_attributes = array();

  // Display weight and dimensions before attribute list.
  $display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() );

  if ( $display_dimensions && $product->has_weight() ) {
    $product_attributes['weight'] = array(
      'label' => __( 'Weight', 'woocommerce' ),
      'value' => wc_format_weight( $product->get_weight() ),
    );
  }

  if ( $display_dimensions && $product->has_dimensions() ) {
    $product_attributes['dimensions'] = array(
      'label' => __( 'Dimensions', 'woocommerce' ),
      'value' => wc_format_dimensions( $product->get_dimensions( false ) ),
    );
  }

  // Add product attributes to list.
  $attributes = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );

  foreach ( $attributes as $attribute ) {
    $values = array();

    if ( $attribute->is_taxonomy() ) {
      $attribute_taxonomy = $attribute->get_taxonomy_object();
      $attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

      foreach ( $attribute_values as $attribute_value ) {
        $value_name = esc_html( $attribute_value->name );

        
        if ( $attribute_taxonomy->attribute_public ) {
          $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
        } else {
          $values[] = $value_name;
        }
      }
    } else {
      $values = $attribute->get_options();

      foreach ( $values as &$value ) {
        $value = make_clickable( esc_html( $value ) );
      }
    }
    if ($attribute->get_name() != 'pa_color') {
      if($attribute->get_name() == 'pa_features'){
        $terms = wc_get_product_terms($product->get_id(), $attribute->get_name());
        $features_imgs = '';
        foreach( $terms as $term ) {
          $features_imgs .= '<img src="' . get_field('product_att_img', 'pa_features_' . $term->term_id) . '" alt="features-product">';
        }
        $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
          'label' => wc_attribute_label( $attribute->get_name() ),
          'value' => $features_imgs,
        );
      } else {
        $product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
          'label' => wc_attribute_label( $attribute->get_name() ),
          'value' => apply_filters( 'woocommerce_attribute',  wptexturize( implode( ', ', $values ) ) , $attribute, $values ),
        );
      }
      
    }
  }

  /**
  * Hook: woocommerce_display_product_attributes.
  *
  * @since 3.6.0.
  * @param array $product_attributes Array of attributes to display; label, value.
  * @param WC_Product $product Showing attributes for this product.
  */
  $product_attributes = apply_filters( 'woocommerce_display_product_attributes', $product_attributes, $product );

  wc_get_template(
    'single-product/product-attributes.php',
    array(
      'product_attributes' => $product_attributes,
      'product'            => $product,
      'attributes'         => $attributes,
      'display_dimensions' => $display_dimensions,
    )
  );
}

function wc_new_variable_add_to_cart(){
  global $product;

  if ( $product->is_type('variable')) {
    // Enqueue variation scripts.
    wp_enqueue_script( 'wc-add-to-cart-variation' );

    // Get Available variations?
    $get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

    // Load the template.
    wc_get_template(
      'single-product/add-to-cart/variable.php',
      array(
        'available_variations' => $get_variations ? $product->get_available_variations() : false,
        'attributes'           => $product->get_variation_attributes(),
        'selected_attributes'  => $product->get_default_attributes(),
      )
    );
  }
}

function wc_add_rating_single_title(){
  global $product;

  $average = $product->get_average_rating();
  echo '<div class="wc-single-star-rating-top"><div class="star-rating"><span style="width:' . (($average/5) * 100) . '%" title="' . $average . '"></span></div></div>';
}

function custom_widget_shopping_cart_button_view_cart() {
  $original_link = wc_get_cart_url();
  $custom_link = home_url( '/cart/?id=1' );
  echo '<a href="' . esc_url( $custom_link ) . '" class="wc-cart-link-btn button wc-forward">' . esc_html__( 'Order', 'woocommerce' ) . '</a>';
}

function custom_widget_shopping_cart_proceed_to_checkout() {
  $original_link = wc_get_checkout_url();
  $custom_link = home_url( '/checkout/?id=1' );
  echo '<a href="' . esc_url( $custom_link ) . '" class="button checkout wc-forward">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
}

function woocommerce_widget_shopping_cart_subtotal() {
  echo '<div class="wc-mini-cart-total__main-price"><span class="wc-cart-final-price">' . esc_html__( 'Final price:', 'woocommerce' ) . '</span><div class="wc-cart-min--final-price">' . WC()->cart->get_cart_subtotal() . '</div></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

?>