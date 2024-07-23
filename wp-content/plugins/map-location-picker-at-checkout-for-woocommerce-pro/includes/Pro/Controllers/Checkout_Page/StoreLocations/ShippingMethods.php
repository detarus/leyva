<?php
/**
 * File responsible for defining methods that handle Store Locations shipping methods functionality.
 *
 * Author:          Uriahs Victor
 * Created on:      12/12/2023 (d/m/y)
 *
 * @link    https://uriahsvictor.com
 * @since   1.9.0
 * @package Controllers
 */

namespace Lpac\Pro\Controllers\Checkout_Page\StoreLocations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Lpac\Models\Plugin_Settings\Store_Locations as StoreLocationsModel;

/**
 * Class responsible for defining methods that handle and manipulate shipping methods in relation to Store Locations.
 *
 * @package Lpac\Pro\Controllers\Checkout_Page\StoreLocations
 * @since 1.9.0
 */
class ShippingMethods {

	/**
	 * Filter the shipping methods shown based on the store location selected.
	 *
	 * @param array $rates
	 * @return array
	 * @since 1.9.0
	 */
	public function filterShippingMethods( array $rates ): array {

		$store_locations   = StoreLocationsModel::getStoreLocations();
		$selected_store_id = WC()->session->get( 'lpac_order__origin_store' );

		$supported_shipping_methods = array();
		foreach ( $store_locations as $key => $store_location ) {
			if ( $selected_store_id === $store_location['store_location_id'] ) {
				$supported_shipping_methods = $store_location['store_locations_shipping_method_select'] ?? '';
				break;
			}
		}

		if ( empty( $supported_shipping_methods ) ) {
			return $rates;
		}

		foreach ( $supported_shipping_methods as $supported_shipping_method ) {

			/**
			 * @var \WC_Shipping_Rate $rate_class
			 */
			foreach ( $rates as $rate_key => $rate_class ) {
				$instance_id = (int) $rate_class->get_instance_id();
				if ( ! in_array( $instance_id, $supported_shipping_methods, true ) ) {
					unset( $rates[ $rate_key ] );
				}
			}
		}

		return $rates;
	}

}
