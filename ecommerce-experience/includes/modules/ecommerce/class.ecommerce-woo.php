<?php

namespace TMA\ExperienceManager\Modules\ECommerce;

/**
 * Description of class
 *
 * @author marx
 */
class Ecommerce_Woo extends Ecommerce {

	private static $_instance = null;

	public static function instance() {

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		parent::__construct();
	}

	protected function _popular_products($count) {
		$args = array(
			'post_type' => array( 'product' ),
			'meta_key' => 'total_sales',
			'orderby' => 'meta_value_num',
			'order' => 'desc',
			'posts_per_page' => $count
		);

		$products = get_posts($args);

		return $products;
	}

	protected function _random_products($count) {
		$args = array(
			'posts_per_page' => $count,
			'orderby' => 'rand',
			'post_type' => 'product');

		$random_products = get_posts($args);

		return $random_products;
	}

	protected function _load_product($product_id) {
		$woo_product = wc_get_product($product_id);

		if ($woo_product == null || $woo_product === false) {
			return FALSE;
		}

		return $this->_map_product($woo_product);
	}
	
	protected function _map_product ($woo_product) {
		$product = [
			"id" => $woo_product->get_id(),
			"title" => $woo_product->get_title(),
			"sku" => $woo_product->get_sku("edit"),
			"price" => $woo_product->get_price_html(),
			"is_sale" => $woo_product->is_on_sale(),
			"image" => $woo_product->get_image("woocommerce_thumbnail", ['class' => 'image']),
			"url" => $woo_product->get_permalink()
		];
		
		return $product;
	}

}
