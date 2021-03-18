<?php

namespace TMA\ExperienceManager\Modules\WooCommerce;

/**
 * Description of class
 *
 * @author marx
 */
class WooCommerce_Product_Integration extends Integration {

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
		parent::__construct('exm-woocommerce-product');
	}

	public function add_settings() {
		add_filter("customize_register", [$this, "register_customizer"]);
	}

	public function register_customizer(\WP_Customize_Manager $wp_customize) {
		$this->customizer_related_products($wp_customize);
	}

	function customizer_related_products(\WP_Customize_Manager $wp_customize) {
		$wp_customize->add_section("exm_recom_product", array(
			'title' => __("Product related products", "experience-manager"),
			'panel' => 'exm_recommendations',
			'capability' => 'manage_options',
			'description' => 'Configure the related products for the product page.'
		));
		// HEADER START
		$wp_customize->add_setting('exm-woocommerce-product[title]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => '',
		));

		$wp_customize->add_control('exm-recom-product-title',
				array(
					'type' => 'text',
					'priority' => 10,
					'section' => 'exm_recom_product',
					'label' => __("Headline", "experience-manager"),
					'description' => 'Headline for the recommendations in the header.',
					'settings' => 'exm-woocommerce-product[title]'
				)
		);

		$wp_customize->add_setting('exm-woocommerce-product[type]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-product-type',
				array(
					'type' => 'select',
					'priority' => 10,
					'section' => 'exm_recom_product',
					'label' => __("Type", "experience-manager"),
					'description' => 'The type for product recommendation',
					'settings' => 'exm-woocommerce-product[type]',
					'default' => 'default',
					'choices' => $this->get_recommendation_types()
				)
		);
		$wp_customize->add_setting('exm-woocommerce-product[template]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-product-template',
				array(
					'type' => 'select',
					'priority' => 10,
					'section' => 'exm_recom_product',
					'label' => __("Template", "experience-manager"),
					'description' => 'The template used for recommendations',
					'settings' => 'exm-woocommerce-product[template]',
					'default' => 'default',
					'choices' => $this->get_recommendation_templates()
				)
		);
		// HEADER ENDE
	}

	function init() {
		$product_detail = $this->get_feature("type");
		if ($product_detail && $product_detail !== "default") {
			$this->update_product_detail_page();
		}
	}

	private function get_recommendation_templates() {
		return apply_filters("experience-manager/woocommerce/product/templates", [
			"default" => __("Default", "experience-manager"),
			"simple" => __("Simple", "experience-manager")
		]);
	}

	private function update_product_detail_page() {
		//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		add_action('woocommerce_after_single_product_summary', function () {
			global $product;
			$this->update_options();
			$arguments = [];
			$arguments["product"] = $product->get_id();
			$arguments["size"] = 3;
			$arguments["type"] = $this->get_feature("type") ? $this->get_feature("type") : "recently-viewed";
			$arguments["template"] = "product/" . ($this->get_feature("template") ? $this->get_feature("template") : "default");
			$title = $this->get_feature("title");
			if ($title) {
				$arguments["title"] = $title;
			} else {
				$arguments["title"] = "";
			}
			tma_exm_log("update_product_detail_page: " . json_encode($arguments));
			exm_get_template("recommendation.product.html", $arguments);
		}, 20);
	}
}
