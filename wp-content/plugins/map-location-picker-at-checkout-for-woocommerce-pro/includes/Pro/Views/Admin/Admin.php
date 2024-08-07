<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://uriahsvictor.com
 * @since      1.0.0
 *
 * @package    Lpac\Pro\Views
 */

namespace Lpac\Pro\Views\Admin;

use Lpac\Pro\Models\Plugin_Settings\Shipping_Settings;
use WC_Order;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Class Admin
 *
 * @package Lpac\Pro\Views
 */
class Admin {

	/**
	 * Format our distance for display on admin pages.
	 *
	 * @param float  $distance
	 * @param string $distance_unit
	 * @return string
	 */
	private function normalize_distance_display( float $distance, string $distance_unit ) {

		$rounding_km   = apply_filters( 'lpac_customer_distance_km_rounding', 2 );
		$rounding_mile = apply_filters( 'lpac_customer_distance_mile_rounding', 2 );

		$thousands_sep = get_option( 'woocommerce_price_thousand_sep' );
		$thousands_sep = $thousands_sep ?: ',';

		$decimal_sep = get_option( 'woocommerce_price_decimal_sep' );
		$decimal_sep = $decimal_sep ?: '.';

		$distance = ( $distance_unit === 'km' ) ?
			number_format( $distance, $rounding_km, $decimal_sep, $thousands_sep ) :
			number_format( $distance, $rounding_mile, $decimal_sep, $thousands_sep );

		return $distance;
	}

	/**
	 * Get a customer's detected region.
	 *
	 * @param object $order
	 * @return string
	 */
	private function getCustomerRegion( object $order ): string {

		$customer_region = sanitize_text_field( $order->get_meta( 'lpac_customer_region' ) );

		$saved_regions = get_option( 'lpac_shipping_regions', array() );

		$region_name = '';

		foreach ( $saved_regions as $key => $region ) {
			if ( $region['id'] === $customer_region ) {
				$region_name = $region['name'];
				break;
			}
		}

		return $region_name;
	}

	/**
	 * Displays custom meta in details.
	 *
	 * @since 1.6.6
	 * @since 1.6.8 Show customer region as well.
	 * @param object $order The order object.
	 */
	public function display_lpac_admin_order_meta( $order ) {

		$distance          = (float) $order->get_meta( 'lpac_customer_distance' );
		$distance_unit     = sanitize_text_field( $order->get_meta( 'lpac_customer_distance_unit' ) );
		$distance_duration = sanitize_text_field( $order->get_meta( 'lpac_customer_distance_duration' ) );

		$markup = '';

		if ( ! empty( $distance ) && ! empty( $distance_unit ) ) {

			$distance = $this->normalize_distance_display( $distance, $distance_unit );

			$distance_meta_text = esc_html__( 'Distance', 'map-location-picker-at-checkout-for-woocommerce' );

			$markup .= "<p><strong>{$distance_meta_text}:</strong> <span>$distance $distance_unit</span></p>";

			if ( ! empty( $distance_duration ) ) {
				$duration_meta_text = esc_html__( 'Duration', 'map-location-picker-at-checkout-for-woocommerce' );
				$markup            .= "<p><strong>{$duration_meta_text}:</strong> <span>$distance_duration</span></p>";
			}
		}

		// Cost by Region feature
		$region_name = $this->getCustomerRegion( $order );

		if ( ! empty( $region_name ) ) {

			$region_name_meta_text = esc_html__( 'Region', 'map-location-picker-at-checkout-for-woocommerce' );
			?>
			<p><strong><?php echo esc_html( $region_name_meta_text ); ?></strong>: <span style="color: green; text-decoration: underline;"><?php echo esc_html( $region_name ); ?></span></p>
			<?php

		}
	}

	/**
	 * Prepare region column content.
	 *
	 * @param WC_Order $order
	 * @return void
	 * @since 1.9.0
	 */
	private function prepareRegionColumnContent( WC_Order $order ) {

		$region_name = $this->getCustomerRegion( $order );

		if ( empty( $region_name ) ) {
			return;
		}

		echo esc_html( $region_name );
	}

	/**
	 * Prepare distance column content.
	 *
	 * @param WC_Order $order
	 * @return void
	 * @since 1.9.0
	 */
	private function prepareDistanceColumnContent( WC_Order $order ) {

		$distance          = (float) $order->get_meta( 'lpac_customer_distance' );
		$distance_unit     = $order->get_meta( 'lpac_customer_distance_unit' );
		$distance_duration = $order->get_meta( 'lpac_customer_distance_duration' );

		if ( empty( $distance ) || empty( $distance_unit ) ) {
			return;
		}

		$distance = $this->normalize_distance_display( $distance, $distance_unit );
		?>
		<p>
			<?php
			echo esc_html( $distance );
			echo ' ' . esc_html( $distance_unit );
			echo ( ! empty( $distance_duration ) ) ? "<br/><span style='color: #999'>(" . esc_html( $distance_duration ) . ')</span>' : ''
			?>
		</p>
		<?php

	}

	/**
	 * Add our custom columns to the list of columns.
	 *
	 * @param array $columns
	 * @return array
	 * @since 1.9.0
	 */
	public function addKikoteColumns( array $columns ): array {

		if ( Shipping_Settings::costByRegionEnabled() ) {
			$columns['lpac_customer_region'] = __( 'Region', 'map-location-picker-at-checkout-for-woocommerce' );
		}

		if ( Shipping_Settings::costByDistanceEnabled() ) {
			$columns['lpac_customer_distance'] = __( 'Distance', 'map-location-picker-at-checkout-for-woocommerce' );
		}

		return $columns;
	}

	/**
	 * Add our custom column content for PRO features.
	 *
	 * @param string $column
	 * @param mixed  $order
	 * @return void
	 * @since 1.9.0
	 */
	public function addKikoteColumnsContent( string $column, $order ): void {

		if ( is_int( $order ) === false && is_object( $order ) === false ) {
			return;
		}

		if ( is_int( $order ) ) { // When HPOS is on this would be an int
			$order = wc_get_order( $order );
		}

		if ( $column === 'lpac_customer_region' ) {
			$this->prepareRegionColumnContent( $order );
		}

		if ( $column === 'lpac_customer_distance' ) {
			$this->prepareDistanceColumnContent( $order );
		}
	}
}
