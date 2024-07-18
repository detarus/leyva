<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<h2 class="wc-shop-table__title">Order Summary</h2>
<div class="shop_table wc-cart-total__order-summary-block">
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		$cart = WC()->instance()->cart;
		$cart_count = $cart->get_cart_contents_count();

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<div style="display: none;" class="wc-cart-total__product <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<span class="wc-cart-total__title">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
					<span class="wc-cart-total__subtitle">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
			</div>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>

		<div class="wc-cart-total__items-quantity">
			<span class="wc-cart-total__title"><?php esc_html_e( 'Total items:', 'woocommerce' ); ?></span>
			<span class="wc-cart-total__subtitle"><?php echo $cart_count; ?></span>
		</div>

		<div class="wc-cart-total__price-items">
			<span class="wc-cart-total__title"><?php esc_html_e( 'Total items price:', 'woocommerce' ); ?></span>
			<span class="wc-cart-total__subtitle"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="wc-cart-total__discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<span class="wc-cart-total__title"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				<span class="wc-cart-total__subtitle"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php 
		
				$packages = WC()->shipping()->get_packages();
				$first    = true;

				foreach ( $packages as $i => $package ) {
					$chosen_method = isset( WC()->session->chosen_shipping_methods[ $i ] ) ? WC()->session->chosen_shipping_methods[ $i ] : '';
					$product_names = array();

					if ( count( $packages ) > 1 ) {
						foreach ( $package['contents'] as $item_id => $values ) {
							$product_names[ $item_id ] = $values['data']->get_name() . ' &times;' . $values['quantity'];
						}
						$product_names = apply_filters( 'woocommerce_shipping_package_details_array', $product_names, $package );
					}

					wc_get_template(
						'cart/cart-shipping.php',
						array(
							'package'                  => $package,
							'available_methods'        => $package['rates'],
							'show_package_details'     => count( $packages ) > 1,
							'show_shipping_calculator' => is_cart() && apply_filters( 'woocommerce_shipping_show_shipping_calculator', $first, $i, $package ),
							'package_details'          => implode( ', ', $product_names ),
							/* translators: %d: shipping package number */
							'package_name'             => apply_filters( 'woocommerce_shipping_package_name', ( ( $i + 1 ) > 1 ) ? sprintf( _x( 'Select a shipping method %d', 'shipping packages', 'woocommerce' ), ( $i + 1 ) ) : _x( 'Select a shipping method', 'shipping packages', 'woocommerce' ), $i, $package ),
							'index'                    => $i,
							'chosen_method'            => $chosen_method,
							'formatted_destination'    => WC()->countries->get_formatted_address( $package['destination'], ', ' ),
							'has_calculated_shipping'  => WC()->customer->has_calculated_shipping(),
						)
					);

					$first = false;
				}
			
			?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="wc-cart-total__fee">
				<span class="wc-cart-total__title"><?php echo esc_html( $fee->name ); ?></span>
				<span class="wc-cart-total__subtitle"><?php wc_cart_totals_fee_html( $fee ); ?></span>
			</div>
		<?php endforeach; ?>

		<div class="wc-cart-total__order-delivery">
			<span class="wc-cart-total__title">Delivery:</span>
			<span class="wc-cart-total__subtitle wc-cart-total__subtitle--delivery">0.00 <?php echo get_woocommerce_currency_symbol();?></span>
		</div>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="wc-cart-total__order-total">
			<span class="wc-cart-total__title"><?php esc_html_e( 'Final price:', 'woocommerce' ); ?></span>
			<span class="wc-cart-total__subtitle"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</div>
