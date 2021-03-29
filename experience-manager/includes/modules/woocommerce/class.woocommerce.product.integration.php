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
	 * @return WooCommerce_Product_Integration
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

		add_filter('experience-manager/settings/fields', [$this, 'settings_fields']);
		add_filter('experience-manager/settings/sections', [$this, 'sections']);
	}

	public function register_customizer(\WP_Customize_Manager $wp_customize) {
		$this->customizer_related_products($wp_customize);
	}

	function themeslug_sanitize_checkbox($checked) {
		// Boolean check.
		return ( ( isset($checked) && true == $checked ) ? "on" : "off");
	}

	function customizer_related_products(\WP_Customize_Manager $wp_customize) {
		$wp_customize->add_section("exm_recom_product", array(
			'title' => __("Product related products", "experience-manager"),
			'panel' => 'exm_recommendations',
			'capability' => 'manage_woocommerce',
			'description' => 'Configure the related products for the product page.'
		));

		$wp_customize->add_setting('exm-woocommerce-product[related_disable]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
			'default' => 'off',
			'sanitize_callback' => [$this, "themeslug_sanitize_checkbox"],
		));

		$wp_customize->add_control('exm-recom-product-related-disable',
				array(
					'type' => 'checkbox',
					'priority' => 10,
					'section' => 'exm_recom_product',
					'label' => __("Disable related prodcuts", "experience-manager"),
					'description' => 'Disable the default WooCommerce related products',
					'settings' => 'exm-woocommerce-product[related_disable]'
				)
		);

		// HEADER START
		$wp_customize->add_setting('exm-woocommerce-product[title]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
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
			'capability' => 'manage_woocommerce',
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
			'capability' => 'manage_woocommerce',
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
		if (!is_customize_preview()) {
			$this->update_product_detail_page();
		}

		// Prepare for customizer preview
		add_action('customize_preview_init', function () {
			$this->update_options();
			$this->update_product_detail_page();
		});
	}

	private function get_recommendation_templates() {
		return apply_filters("experience-manager/woocommerce/product/templates", [
			"default" => __("Default", "experience-manager"),
			"simple" => __("Simple", "experience-manager")
		]);
	}

	private function update_product_detail_page() {

		tma_exm_log("ymoptions: " . json_encode($this->get_options()));
		if ($this->get_feature("related_disable") && $this->get_feature("related_disable") === "on") {
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		}
		$product_detail = $this->get_feature("type");
		if ($product_detail && $product_detail !== "default") {
			add_action('woocommerce_after_single_product_summary', function () {
				global $product;
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

	function settings_fields($fields) {

		$settings_fields = [
			'exm-woocommerce-product' => [
				[
					'name' => 'related_disable',
					'label' => __("Disable related products", "experience-manager"),
					'desc' => __("Disable the default related products.", "experience-manager"),
					'type' => 'checkbox'
				],
				[
					'name' => 'product_detail_page',
					'label' => __("Product detail page", "experience-manager"),
					'desc' => __("Configure product recommendation on product defail page", "experience-manager"),
					'type' => 'subsection',
				],
				[
					'name' => 'type',
					'label' => __("Related products", "experience-manager"),
					'desc' => __("Replace the related products.", "experience-manager"),
					'type' => 'select',
					'options' => $this->get_recommendation_types()
				],
				[
					'name' => 'template',
					'label' => __("Template", "experience-manager"),
					'desc' => __("Template used to render recommendation.", "experience-manager"),
					'type' => 'select',
					'options' => $this->get_recommendation_templates()
				],
				[
					'name' => 'title',
					'label' => __("Title", "experience-manager"),
					'desc' => __("The title.", "experience-manager"),
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
				'title' => __('Product detail page', 'experience-manager')
			]
		];
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

}
