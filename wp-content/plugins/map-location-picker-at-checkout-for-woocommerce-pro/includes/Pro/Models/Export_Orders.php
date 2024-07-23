<?php

/**
 * Handles exporting of orders from the database.
 *
 * Author:          Uriahs Victor
 * Created on:      28/11/2021 (d/m/y)
 *
 * @link    https://uriahsvictor.com
 * @since   1.4.0
 * @package Lpac/Models
 */
namespace Lpac\Pro\Models;

use Lpac\Traits\Upload_Folders;
use Lpac\Helpers\Functions;
/**
 * Location_Details class.
 *
 * Handles saving of latitude and longitude.
 */
class Export_Orders {

	use Upload_Folders;

	/**
	 * The name of the export file.
	 *
	 * @var string
	 */
	private string $filename;

	/**
	 * The folder to store the exported orders.
	 *
	 * @var string
	 */
	private string $folder_name;

	/**
	 * Class constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->filename    = 'export_' . current_time( 'Y-m-d' ) . '_' . time() . '.csv';
		$this->folder_name = 'order-exports';
	}

	/**
	 * Get the CSV link after records have been retrieved and saved.
	 *
	 * @param array $date_range
	 * @return void|string
	 * @since 1.4.0
	 */
	public function getCsvLink( $date_range ) {

		$link = '';

		$records = $this->getRecords( $date_range );

		if ( empty( $records ) || ! is_array( $records ) ) {
			return null;
		}

		$saved = $this->saveRecordsToCsv( $records );

		if ( $saved ) {
			$link = $this->getOrderExportsUrl();
		}

		return $link;
	}

	/**
	 * Get our records from the Database.
	 *
	 * @param array $date_range
	 * @return array|object|null
	 * @since 1.4.0
	 */
	private function getRecords( $date_range ) {

		$from_date = sanitize_text_field( $date_range['from'] );
		$to_date   = sanitize_text_field( $date_range['to'] );

		$map_link = Functions::create_customer_directions_link();

		$status = apply_filters( 'lpac_exported_orders_statuses', array( 'wc-completed', 'processing' ) );

		$orders_object = wc_get_orders(
			array(
				'limit'        => -1,
				'type'         => 'shop_order',
				'status'       => $status,
				'date_created' => $from_date . '...' . $to_date,
			)
		);

		$normalized = array();
		$hold       = array();

		foreach ( $orders_object as $order ) {
			$hold['order_id']       = $order->get_id();
			$hold['user_id']        = $order->get_user_id();
			$hold['customer_name']  = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
			$hold['customer_email'] = $order->get_billing_email();
			$hold['phone_number']   = $order->get_billing_phone();
			$hold['location_link']  = $map_link . $order->get_meta( 'lpac_latitude' ) . ',' . $order->get_meta( 'lpac_longitude' );
			$order_date             = $order->get_date_created()->date( 'F j, Y @ h:i A' );
			$hold['order_date']     = $order_date;
			$normalized[]           = $hold;
		}

		return $normalized;
	}

	/**
	 * Get the URL for the export.
	 *
	 * @return string
	 */
	private function getOrderExportsUrl() {
		$upload_url = wp_upload_dir()['baseurl'];
		$link       = $upload_url . "/lpac/{$this->folder_name}/" . $this->filename;
		return $link;
	}

	/**
	 * Save the records from the DB to a CSV file.
	 *
	 * @param array $results
	 * @return void|true
	 * @since 1.4.0
	 */
	private function saveRecordsToCsv( array $results ) {

		if ( empty( $results ) || ! is_array( $results ) ) {
			return false;
		}

		clearstatcache();

		$path      = $this->create_upload_folder( $this->folder_name );
		$full_path = $path . $this->filename;

		$outstream = fopen( $full_path, 'w' );

		$headers = array(
			__( 'Order ID', 'map-location-picker-at-checkout-for-woocommerce' ),
			__( 'User ID', 'map-location-picker-at-checkout-for-woocommerce' ),
			__( 'Customer Name', 'map-location-picker-at-checkout-for-woocommerce' ),
			__( 'Customer Email', 'map-location-picker-at-checkout-for-woocommerce' ),
			__( 'Phone Number', 'map-location-picker-at-checkout-for-woocommerce' ),
			__( 'Order Date', 'map-location-picker-at-checkout-for-woocommerce' ),
			__( 'Location Link', 'map-location-picker-at-checkout-for-woocommerce' ),
		);

		 // Create our headings
		fputcsv( $outstream, $headers );

		foreach ( $results as $result_row ) {
			if ( empty( $result_row['user_id'] ) ) {
				$result_row['customer_name'] = __( 'Guest Customer', 'map-location-picker-at-checkout-for-woocommerce' );
			}
			fputcsv( $outstream, $result_row );
		}

		fclose( $outstream );

		if ( ! file_exists( $full_path ) || empty( @filesize( $full_path ) ) ) { // file doesn't exist or empty
			return false;
		}

		return true;
	}

	/**
	 * Get orders from the database by date range.
	 *
	 * @param array $range
	 * @return void
	 */
	public function getOrdersByRange( array $range ): array {

		$from = $range['from'];
		$to   = $range['to'];

		$status        = apply_filters( 'lpac_plotted_orders_statuses', array( 'wc-completed', 'processing' ) );
		$orders_object = wc_get_orders(
			array(
				'limit'        => -1,
				'type'         => 'shop_order',
				'status'       => $status,
				'date_created' => $from . '...' . $to,
			)
		);

		$orders_locations = array();

		foreach ( $orders_object as $order ) {
			$orders_locations[] = array(
				'orderID'   => $order->get_id(),
				'latitude'  => $order->get_meta( 'lpac_latitude' ),
				'longitude' => $order->get_meta( 'lpac_longitude' ),
				'region'    => $order->get_meta( 'lpac_customer_region' ),
			);
		}

		$orders_locations = array_values( array_unique( $orders_locations, SORT_REGULAR ) );

		return $orders_locations;
	}

}
