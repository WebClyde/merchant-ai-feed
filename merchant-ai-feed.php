<?php
/**
 * Plugin Name: Merchant AI Feed
 * Plugin URI:  https://webclyde.com/plugins/merchant-ai-feed/
 * Description: Generates a WooCommerce product feed following the Agentic Commerce Protocol standard for OpenAI.
 * Version:     1.0.0
 * Author:      Trae AI
 * Author URI:  https://trae.ai
 * License:     GPL-2.0+
 * Text Domain: merchant-ai-feed
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Merchant_AI_Feed {

	/**
	 * Instance of the class.
	 *
	 * @var Merchant_AI_Feed
	 */
	private static $instance = null;

	/**
	 * Get the instance of the class.
	 *
	 * @return Merchant_AI_Feed
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register REST API routes.
	 */
	public function register_routes() {
		register_rest_route( 'merchant-ai/v1', '/feed', array(
			'methods'             => 'GET',
			'callback'            => array( $this, 'generate_feed' ),
			'permission_callback' => '__return_true', // Public feed, but maybe secure it later
		) );
	}

	/**
	 * Generate the feed.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function generate_feed( $request ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return new WP_Error( 'woocommerce_missing', 'WooCommerce is not installed or active.', array( 'status' => 500 ) );
		}

		// Set headers for JSONL download
		header( 'Content-Type: application/json' );
		// header( 'Content-Disposition: attachment; filename="products.jsonl"' );

		// Query products
		$args = array(
			'status' => 'publish',
			'limit'  => -1,
			'paginate' => true,
		);

		$products = wc_get_products( $args );
		
		// If we are in a REST context, we might want to just return the data or stream it. 
		// For large catalogs, streaming is better.
		// However, WP REST API buffers the response. 
		// To stream properly, we might need to bypass REST API or just echo and exit.
		
		// Let's try to echo and exit to support streaming large feeds.
        $data = [];

		foreach ( $products->products as $product ) {
			$data[] = $this->map_product_data( $product );
		}

        echo json_encode( $data );
		
		exit;
	}

	/**
	 * Map WooCommerce product to Agentic Commerce Protocol schema.
	 *
	 * @param WC_Product $product
	 * @return array
	 */
	private function map_product_data( $product ) {
		$data = array();

		// Basic Product Data
		$data['id'] = (string) $product->get_id();
		$data['title'] = $product->get_name();
		$data['description'] = wp_strip_all_tags( $product->get_description() ? $product->get_description() : $product->get_short_description() );
		$data['link'] = $product->get_permalink();
		
		// Identifiers
		$sku = $product->get_sku();
		$gtin = $product->get_meta( '_gtin' ); // Assuming a common meta key, or leave empty
		
		if ( ! empty( $gtin ) ) {
			$data['gtin'] = $gtin;
		}
		
		// MPN is required if GTIN is missing. Use SKU as MPN if available.
		if ( ! empty( $sku ) ) {
			$data['mpn'] = $sku;
		} elseif ( empty( $gtin ) ) {
			// Fallback if both are missing? The spec says MPN required if GTIN missing.
			// We'll use ID as fallback for MPN to satisfy schema if SKU is missing.
			$data['mpn'] = (string) $product->get_id();
		}

		// OpenAI Flags
		// Defaulting to true for now, logic can be added to control this via meta fields.
		$data['enable_search'] = true;
		$data['enable_checkout'] = true;

		// Pricing (Assuming standard structure, though not fully detailed in snippet)
		// Usually: price: { value: "10.00", currency: "USD" }
		$data['price'] = array(
			'value' => $product->get_price(),
			'currency' => get_woocommerce_currency(),
		);

		// Availability
		$data['availability'] = $product->is_in_stock() ? 'in_stock' : 'out_of_stock';

		// Image
		$image_id = $product->get_image_id();
		if ( $image_id ) {
			$data['image_link'] = wp_get_attachment_url( $image_id );
		}
		
		// Brand - check for common brand plugins or attributes
		$brand = $product->get_attribute( 'brand' ); // 'pa_brand' usually
		if ( $brand ) {
			$data['brand'] = $brand;
		}

		// Item Information (Category, etc.)
		$cats = wc_get_product_category_list( $product->get_id() );
		if ( $cats ) {
			// Strip tags because wc_get_product_category_list returns HTML
			$data['product_type'] = wp_strip_all_tags( $cats );
		}

		return $data;
	}
}

// Initialize the plugin
Merchant_AI_Feed::get_instance();
