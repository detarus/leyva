<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
?>
<div class="woocommerce-shipping-totals shipping">
	<?php echo '<h2 class="wc-shipping-totals__title">' .wp_kses_post( $package_name ) . '</h2>'; ?>
		<?php if ( ! empty( $available_methods ) && is_array( $available_methods ) ) : ?>
			<div id="shipping_method" class="woocommerce-shipping-methods">
				<?php foreach ( $available_methods as $method ) : ?>
						<?php
						if(explode(':', $method->id)[0] == 'free_shipping'){
							$input_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M20 4C16.8174 4 13.7652 5.34856 11.5147 7.74902C9.26428 10.1495 8 13.4052 8 16.8C8 25.4399 18.575 35.1999 19.025 35.6159C19.2967 35.8638 19.6425 36 20 36C20.3575 36 20.7033 35.8638 20.975 35.6159C21.5 35.1999 32 25.4399 32 16.8C32 13.4052 30.7357 10.1495 28.4853 7.74902C26.2348 5.34856 23.1826 4 20 4ZM20 32.2399C16.805 29.0399 11 22.1439 11 16.8C11 14.2539 11.9482 11.8121 13.636 10.0118C15.3239 8.21141 17.6131 7.19999 20 7.19999C22.3869 7.19999 24.6761 8.21141 26.364 10.0118C28.0518 11.8121 29 14.2539 29 16.8C29 22.1439 23.195 29.0559 20 32.2399ZM20 10.4C18.8133 10.4 17.6533 10.7753 16.6666 11.4786C15.6799 12.1818 14.9108 13.1813 14.4567 14.3508C14.0026 15.5202 13.8838 16.8071 14.1153 18.0485C14.3468 19.29 14.9182 20.4304 15.7574 21.3254C16.5965 22.2205 17.6656 22.83 18.8295 23.077C19.9933 23.3239 21.1997 23.1972 22.2961 22.7128C23.3925 22.2284 24.3295 21.4081 24.9888 20.3556C25.6481 19.3031 26 18.0658 26 16.8C26 15.1026 25.3679 13.4747 24.2426 12.2745C23.1174 11.0743 21.5913 10.4 20 10.4ZM20 19.9999C19.4067 19.9999 18.8266 19.8123 18.3333 19.4607C17.8399 19.109 17.4554 18.6093 17.2284 18.0245C17.0013 17.4398 16.9419 16.7964 17.0576 16.1757C17.1734 15.5549 17.4591 14.9848 17.8787 14.5372C18.2982 14.0897 18.8328 13.7849 19.4147 13.6615C19.9967 13.538 20.5999 13.6014 21.1481 13.8436C21.6962 14.0858 22.1648 14.4959 22.4944 15.0221C22.8241 15.5484 23 16.1671 23 16.8C23 17.6486 22.6839 18.4626 22.1213 19.0627C21.5587 19.6628 20.7956 19.9999 20 19.9999Z" fill="#101010"/></svg>';
						} else if (explode(':', $method->id)[0] == 'local_pickup'){
							$input_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M5 20H20V22.5H5V20ZM2.5 13.75H15V16.25H2.5V13.75Z" fill="#101010"/><path d="M37.3989 20.7575L33.6489 12.0075C33.5526 11.7827 33.3923 11.5911 33.1882 11.4565C32.984 11.3218 32.7448 11.25 32.5002 11.25H28.7502V8.75C28.7502 8.41848 28.6185 8.10054 28.3841 7.86612C28.1496 7.6317 27.8317 7.5 27.5002 7.5H7.50017V10H26.2502V25.695C25.6809 26.0262 25.1827 26.4665 24.7842 26.9908C24.3856 27.5151 24.0945 28.1129 23.9277 28.75H16.0727C15.7684 27.5717 15.0449 26.5448 14.0377 25.8617C13.0304 25.1787 11.8087 24.8865 10.6014 25.0399C9.39416 25.1932 8.28426 25.7816 7.47977 26.6947C6.67529 27.6078 6.23145 28.783 6.23145 30C6.23145 31.217 6.67529 32.3922 7.47977 33.3053C8.28426 34.2184 9.39416 34.8068 10.6014 34.9601C11.8087 35.1135 13.0304 34.8213 14.0377 34.1383C15.0449 33.4552 15.7684 32.4283 16.0727 31.25H23.9277C24.1996 32.3228 24.8215 33.2743 25.6949 33.954C26.5683 34.6336 27.6435 35.0027 28.7502 35.0027C29.8569 35.0027 30.932 34.6336 31.8055 33.954C32.6789 33.2743 33.3008 32.3228 33.5727 31.25H36.2502C36.5817 31.25 36.8996 31.1183 37.1341 30.8839C37.3685 30.6495 37.5002 30.3315 37.5002 30V21.25C37.5001 21.0807 37.4657 20.9131 37.3989 20.7575ZM11.2502 32.5C10.7557 32.5 10.2724 32.3534 9.86125 32.0787C9.45013 31.804 9.12969 31.4135 8.94047 30.9567C8.75126 30.4999 8.70175 29.9972 8.79821 29.5123C8.89467 29.0273 9.13278 28.5819 9.48241 28.2322C9.83204 27.8826 10.2775 27.6445 10.7624 27.548C11.2474 27.4516 11.7501 27.5011 12.2069 27.6903C12.6637 27.8795 13.0541 28.1999 13.3288 28.6111C13.6036 29.0222 13.7502 29.5055 13.7502 30C13.7502 30.663 13.4868 31.2989 13.0179 31.7678C12.5491 32.2366 11.9132 32.5 11.2502 32.5ZM28.7502 13.75H31.6752L34.3552 20H28.7502V13.75ZM28.7502 32.5C28.2557 32.5 27.7724 32.3534 27.3612 32.0787C26.9501 31.804 26.6297 31.4135 26.4405 30.9567C26.2513 30.4999 26.2017 29.9972 26.2982 29.5123C26.3947 29.0273 26.6328 28.5819 26.9824 28.2322C27.332 27.8826 27.7775 27.6445 28.2624 27.548C28.7474 27.4516 29.2501 27.5011 29.7069 27.6903C30.1637 27.8795 30.5541 28.1999 30.8288 28.6111C31.1035 29.0222 31.2502 29.5055 31.2502 30C31.2502 30.663 30.9868 31.2989 30.5179 31.7678C30.0491 32.2366 29.4132 32.5 28.7502 32.5ZM35.0002 28.75H33.5727C33.2973 27.6793 32.6745 26.7302 31.8017 26.0516C30.929 25.3729 29.8557 25.0031 28.7502 25V22.5H35.0002V28.75Z" fill="#101010"/></svg>';
						} else {
							$input_icon = '';
						}
						if ( 1 < count( $available_methods ) ) {
							printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
						} else {
							printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
						}
						if($method->cost != '0.00'){
							$cost = '<span class="shipping-method-cost">' . $method->cost . ' ' . get_woocommerce_currency_symbol() . '</span>';
						} else {
							$cost = '<span class="shipping-method-cost">Free</span>';
						}
						printf( '<label class="shipping-method-label" for="shipping_method_%1$s_%2$s">' . $input_icon . '%3$s' . $cost . '</label>', $index, esc_attr(sanitize_title($method->id)), $method->label); // WPCS: XSS ok.
						// print_r($method);
						do_action( 'woocommerce_after_shipping_rate', $method, $index );
						?>
				<?php endforeach; ?>
			</div>
			<?php if ( is_cart() ) : ?>
				<p class="woocommerce-shipping-destination">
					<?php
					if ( $formatted_destination ) {
						// Translators: $s shipping destination.
						printf( esc_html__( 'Shipping to %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
						$calculator_text = esc_html__( 'Change address', 'woocommerce' );
					} else {
						echo wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'woocommerce' ) ) );
					}
					?>
				</p>
			<?php endif; ?>
			<?php
		elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
			if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) );
			} else {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) );
			}
		elseif ( ! is_cart() ) :
			echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
		else :
			echo wp_kses_post(
				/**
				 * Provides a means of overriding the default 'no shipping available' HTML string.
				 *
				 * @since 3.0.0
				 *
				 * @param string $html                  HTML message.
				 * @param string $formatted_destination The formatted shipping destination.
				 */
				apply_filters(
					'woocommerce_cart_no_shipping_available_html',
					// Translators: $s shipping destination.
					sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ),
					$formatted_destination
				)
			);
			$calculator_text = esc_html__( 'Enter a different address', 'woocommerce' );
		endif;
		?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>
			<?php woocommerce_shipping_calculator( $calculator_text ); ?>
		<?php endif; ?>
</div>
