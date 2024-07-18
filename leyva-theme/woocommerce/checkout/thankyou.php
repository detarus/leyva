<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="s-thanks-hero">
	<div class="container container-thanks-hero">
		<img class="thanks-bg" src="<?php echo get_template_directory_uri() . '/assets/img/thanks-background.png'; ?>" alt="thanks-background">
		<div class="hero-thanks-wrapper">
			<svg	svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" fill="none"><path d="M59.9992 100.8C37.4392 100.8 19.1992 82.5602 19.1992 60.0002C19.1992 37.4402 37.4392 19.2002 59.9992 19.2002C82.5592 19.2002 100.799 37.4402 100.799 60.0002C100.799 82.5602 82.5592 100.8 59.9992 100.8ZM59.9992 24.0002C40.0792 24.0002 23.9992 40.0802 23.9992 60.0002C23.9992 79.9202 40.0792 96.0002 59.9992 96.0002C79.9192 96.0002 95.9992 79.9202 95.9992 60.0002C95.9992 40.0802 79.9192 24.0002 59.9992 24.0002Z" fill="white"/><path d="M55.2003 77.7599L34.3203 56.8799L37.6803 53.5199L55.2003 71.0399L82.3203 43.9199L85.6803 47.2799L55.2003 77.7599Z" fill="white"/></svg>
			<h1 class="thanks-hero__title">thank you for order!</h1>
			<p class="hero-thanks-paragraph">Your order has been successfully placed</p>
		</div>
	</div>
</section>



	<section class="s-order-info">
		<div class="container container-order-info">
			<h2 class="order-info-title">Information about your order</h2>
			<div class="order-info-left">
				<?php foreach ($order->get_items() as $item_id => $item ): ?>
					<?php 
						$product = $item->get_product(); 
						$total_items = $item->get_quantity() + $total_items;
						$total_item_price = $item->get_total() + $total_item_price;
					?>
					<div class="order-info-left__item">
						<div class="order-info-left__img-block">
							<img src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" alt="img-product-<?php echo $product->get_slug()?>">
						</div>
						<div class="order-info-left__info-item">
							<h3 class="order-info__product-name"><?php echo $item->get_name(); ?></h3>
							<span class="order-info__product-details"><?php echo get_the_excerpt($product->get_id()); ?></span>
							<div class="order-info__price-wrapper">
								<span class="order-info__quantity"><?php echo $item->get_quantity(); if($item->get_quantity() > 1) echo ' items'; else echo ' item';?></span>
								<span class="order-info__price"><?php echo number_format($item->get_total(), 2) . ' ' . get_woocommerce_currency_symbol(); ?></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="order-info-left__right">
				<h4 class="order-info-left__title">Order №<?php echo $order->get_order_number();?></h4>
				<div class="order-info-left__price-block">
					<div class="order-info-left__total-items">
						<span class="order-info-left__price-title">Total items:</span>
						<span class="order-info-left__price-subtitle"><?php echo $total_items; ?></span>
					</div>
					<div class="order-info-left__total-delivery">
						<span class="order-info-left__price-title">Delivery:</span>
						<?php
							foreach ( $order->get_order_item_totals() as $key => $total ) {
								if($key == 'shipping'){
									if($total['value'] == 'Delivery'){
										echo '<span class="order-info-left__price-subtitle">0.00 ' . get_woocommerce_currency_symbol() .'</span>';
									} else {
										echo '<span class="order-info-left__price-subtitle">' . $total['value'] . '</span>';
									}
								} 
							}
						?>
					</div>
					<div class="order-info-left__total-items-price">
						<span class="order-info-left__price-title">Total items price:</span>
						<span class="order-info-left__price-subtitle"><?php echo number_format($total_item_price, 2) . ' ' . get_woocommerce_currency_symbol(); ?></span>
					</div>
					<div class="order-info-left__final-price">
						<span class="order-info-left__price-title">Final price:</span>
						<?php
							foreach ( $order->get_order_item_totals() as $key => $total ) {
								if($key == 'order_total') echo '<span class="order-info-left__price-subtitle">' . $total['value'] . '</span>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>


<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
