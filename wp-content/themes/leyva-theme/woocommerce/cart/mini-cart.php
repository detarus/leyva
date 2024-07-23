<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<div class="wc-mini-cart-wrapper woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			// print_r($cart_item['variation']);
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			// print_r($_product);
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			$product_main = wc_get_product($product_id);

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				/**
				 * This filter is documented in woocommerce/templates/cart/cart.php.
				 *
				 * @since 2.1.0
				 */
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
				$product_title = $product_main->get_title();
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
				$product_details = '';
				?>
				<div id="wc-min-cart__item--<?php echo $product_id; if($cart_item['variation']) echo '--' . $cart_item['variation']['attribute_pa_color']; ?>" class="wc-mini-cart-wrapp-item woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
					
					<div class="wc-min-cart__img-block">
						<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="wc-min-cart__info-block">
						<h3 class="wc-min-cart__product-name"><?php echo wp_kses_post($product_title); ?></h3>
						
							<?php
								if($cart_item['variation']){
									$product_details = $cart_item['variation']['attribute_pa_color']; 
								} else if(get_the_excerpt($product_id)){
									$product_details = get_the_excerpt($product_id);
								}
							?>
						<?php if($product_details):?>
							<span class="wc-min-cart__product-details"><?php echo $product_details; ?></span>
						<?php endif; ?>
						<div class="wc-min-cart__links-wrapper">
							<?php if($product_permalink):?>
								<a class="wc-cart-min__link" href="<?php echo $product_permalink; ?>">Edit data</a>
							<?php endif; ?>
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="wc-cart-min__link remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">Delete</a>',
										esc_url(wc_get_cart_remove_url($cart_item_key)),
										/* translators: %s is the product name */
										esc_attr(sprintf( __('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
										esc_attr($product_id),
										esc_attr($cart_item_key),
										esc_attr($_product->get_sku())
									),
									$cart_item_key
								);
							?>
						</div>
						<?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<div class="wc-min-cart__price-wrapper">
							<div class="wc-min-cart__quantity-block">
								<button class="wc-min-cart__quantity-minus"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><path d="M15 18.5L9 12.5L15 6.5" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
								<input for-product="wc-min-cart__item--<?php echo $product_id; if($cart_item['variation']) echo '--' . $cart_item['variation']['attribute_pa_color']; ?>" id="min-cart-quantity__product--<?php echo $product_id; if($cart_item['variation']) echo '--' . $cart_item['variation']['attribute_pa_color']; ?>" class="wc-min-cart__quantity-input" name="min-cart-quantity" value="<?php echo $cart_item['quantity']; ?>" type="number" size="4" min="1" max="" step="1" placeholder="" inputmode="numeric" autocomplete="off" cart-key="<?php echo $cart_item_key;?>">
								<button class="wc-min-cart__quantity-plus"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><path d="M9 6.5L15 12.5L9 18.5" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
							</div>
							<span class="min-cart-price"><?php echo str_replace(',', '', number_format(($_product->get_price() * $cart_item['quantity']), 2)) . ' ' . get_woocommerce_currency_symbol(); ?></span>
						</div>
					</div>
				</div>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</div>

	<div class="wc-mini-cart-total-price-block woocommerce-mini-cart__total total">
		<div class="wc-mini-cart-total__items"><span class="wc-mini-cart-total__title">Total items:</span><span class="wc-mini-cart-total__subtitle wc-mini-cart-total--count"><?php echo WC()->cart->get_cart_contents_count(); ?></span></div>
		<div class="wc-mini-cart-total__price-items"><span class="wc-mini-cart-total__title">Total items price:</span><span class="wc-mini-cart-total__subtitle wc-mini-cart-total--subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></span></div>
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</div>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<div class="wc-mini-cart__buttons-block"><a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="wc-cart-link-btn button wc-forward">Order</a></div>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
