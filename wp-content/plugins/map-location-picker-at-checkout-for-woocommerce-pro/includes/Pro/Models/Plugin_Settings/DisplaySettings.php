<?php
/**
 * Get Display plugin settings for PRO plugin.
 *
 * Author:          Uriahs Victor
 * Created on:      13/01/2024 (d/m/y)
 *
 * @link    https://uriahsvictor.com
 * @since   1.9.0
 * @package Models
 */
namespace Lpac\Pro\Models\Plugin_Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Lpac\Models\Base_Model;

class DisplaySettings extends Base_Model {

	/**
	 * Get the map id for the checkout page.
	 *
	 * @return string
	 * @since 1.9.0
	 */
	public static function getCheckoutPageMapId(): string {
		return get_option( 'lpac_checkout_page_map_id', '' );
	}

	/**
	 * Get the map id for view order page (in customer My Account area)
	 *
	 * @return string
	 * @since 1.9.0
	 */
	public static function getViewOrderPageMapId(): string {
		return get_option( 'lpac_view_order_page_map_id', '' );
	}

	/**
	 * Get the map id for the order received page.
	 *
	 * @return string
	 * @since 1.9.0
	 */
	public static function getOrderReceivedPageMapId(): string {
		return get_option( 'lpac_order_received_page_map_id', '' );
	}

	/**
	 * Get the map id for the view order edit screen map and Kikote export settings page map.
	 *
	 * @return string
	 * @since 1.9.0
	 */
	public static function getAdminViewOrderMapId(): string {
		return get_option( 'lpac_admin_view_order_map_id', '' );
	}

}
