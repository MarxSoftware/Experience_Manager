<?php

namespace TMA\ExperienceManager\Modules\WooCommerce;

/**
 * Description of class
 *
 * @author marx
 */
class WooCommerce_Product_Integration {

	protected static $_instance = null;

	/**
	 * 
	 * @return WooCommerce_Category_Integration
	 */
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	private $options;

	public function __construct() {
		$this->options = get_option('exm-woocommerce-product');
	}
	
	public function add_settings () {
		add_filter('experience-manager/settings/fields', [$this, 'settings_fields']);
		add_filter('experience-manager/settings/sections', [$this, 'sections']);
	}

	private function get_feature($feature) {
		if (isset($this->options[$feature])) {
			return $this->options[$feature];
		}
		return FALSE;
	}

	function init() {

		$product_detail = $this->get_feature("product_defailt_page_related");
		if ($product_detail && $product_detail !== "default") {
			$this->update_product_detail_page();
		}
	}

	private function update_product_detail_page() {
		remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		add_action('woocommerce_after_single_product_summary', function () {
			global $product;
			$arguments = [];
			$arguments["product"] = $product->get_id();
			$arguments["size"] = 3;
			$arguments["type"] = "bought-together";
			$arguments["template"] = "product-detail-page";
			$title = $this->get_feature("product_default_page_related_title");
			if ($title) {
				$arguments["title"] = $title;
			} else {
				$arguments["title"] = "";
			}
			tma_exm_log("update_product_detail_page");
			exm_get_template("recommendation.product.html", $arguments);
		}, 20);
	}

	function settings_fields($fields) {

		$settings_fields = [
			'exm-woocommerce-product' => [
				[
					'name' => 'product_detail_page',
					'label' => __("Product detail page", "tma-webtools"),
					'desc' => __("Configure product recommendation on product defail page", "tma-webtools"),
					'type' => 'subsection',
				],
				[
					'name' => 'product_defailt_page_related',
					'label' => __("Related products", "tma-webtools"),
					'desc' => __("Replace the related products.", "tma-webtools"),
					'type' => 'select',
					'options' => [
						"default" => "Default",
						"bought_together" => "Bought together",
						"frequently_bought" => "Frequently bought"
					]
				],
				[
					'name' => 'product_default_page_related_title',
					'label' => __("Title", "tma-webtools"),
					'desc' => __("The title.", "tma-webtools"),
					'type' => 'text'
				]
			]
		];
		$fields = array_merge_recursive($fields, $settings_fields);
		return $fields;
	}

	function sections($sections) {
		$custom_sections = [
			[
				'id' => 'exm-woocommerce-product',
				'title' => __('Product detail page', 'tma-webtools')
			]
		];
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

}
