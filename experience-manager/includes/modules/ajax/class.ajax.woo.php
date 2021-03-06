<?php

namespace TMA\ExperienceManager\Modules\Ajax;

/**
 * Description of class
 *
 * @author marx
 */
class Ajax_Woo extends Ajax_Base {

	private static $_instance = null;

	/**
	 * 
	 * @return Ajax_Woo
	 */
	public static function instance() {

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {
		parent::__construct();
	}

	protected function _popular_products($count, $category = "none") {
		$args = array(
			'post_type' => array('product'),
			'meta_key' => 'total_sales',
			'orderby' => 'meta_value_num',
			'order' => 'desc',
			'posts_per_page' => $count
		);
		
		if (strcasecmp($category, "none") === 0) {
			$args['tax_query'] = [
				'relation' => 'AND',
				[
					'taxonomy' => 'product_cat',
					'field' => 'id',
					'terms' => $category,
					'operator' => 'IN'
				]
			];
		}

		$products = get_posts($args);

		return $products;
	}

	protected function _random_products($count, $category = "none") {
		$args = array(
			'posts_per_page' => $count,
			'orderby' => 'rand',
			'post_type' => 'product');

		if (strcasecmp($category, "none") === 0) {
			$args['tax_query'] = [
				'relation' => 'AND',
				[
					'taxonomy' => 'product_cat',
					'field' => 'id',
					'terms' => $category,
					'operator' => 'IN'
				]
			];
		}

		$random_products = get_posts($args);

		return $random_products;
	}

	protected function _load_product($product_id) {
		$woo_product = wc_get_product($product_id);

		if ($woo_product == null || $woo_product === false) {
			return FALSE;
		}

		return new Product($woo_product->get_id());
	}

	protected function _map_product($woo_product) {
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
