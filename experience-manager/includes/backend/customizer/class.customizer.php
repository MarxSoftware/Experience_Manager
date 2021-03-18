<?php

namespace TMA\ExperienceManager\Customizer;

class Customizer {

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

	public function init() {
		tma_exm_log("init customizer");
		add_action("customize_register", [$this, "register"]);
	}

	public function register(\WP_Customize_Manager $wp_customize) {
		tma_exm_log("register customizer");
		
		$wp_customize->add_panel('exm_recommendations', array(
			'title' => __('Recommendations'),
			'description' => "Config your product recommendations", // Include html tags such as <p>.
			'priority' => 160, // Mixed with top-level-section hierarchy.
		));
		
		//$this->do_shoppage($wp_customize);
	}
	protected function get_recommendation_types() {
		return [
			"default" => __("None", "experience-manager"),
			"popular-products" => __("Popular products", "experience-manager"),
			"frequently-bought" => __("Frequently bought", "experience-manager"),
			"recently-viewed" => __("Recently viewed", "experience-manager"),
			"most-viewed" => __("Most viewed", "experience-manager")
		];
	}
	private function get_shop_templates() {
		return apply_filters("experience-manager/woocommerce/shop/templates", [
			"default" => __("Default", "experience-manager"),
			"simple" => __("Simple", "experience-manager")
		]);
	}

	
	private function do_shoppage (\WP_Customize_Manager $wp_customize) {
		$wp_customize->add_section("exm_recom_shoppage", array(
			'title' => __("Shoppage", "experience-manager"),
			'panel' => 'exm_recommendations',
			'capability' => 'manage_options'
		));

		$wp_customize->add_setting('exm-woocommerce-shop[header_title]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => '',
		));

		$wp_customize->add_control('exm-recom-sp-h-title',
				array(
					'type' => 'text',
					'priority' => 10,
					'section' => 'exm_recom_shoppage',
					'label' => __("test", "ms-recently-viewed-products"),
					'description' => 'Text put here will be outputted in the footer',
					'settings' => 'exm-woocommerce-shop[header_title]'
				)
		);
		
		$wp_customize->add_setting('exm-woocommerce-shop[header_products]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => '',
		));

		$wp_customize->add_control('exm-recom-sp-h-products',
				array(
					'type' => 'select',
					'priority' => 10,
					'section' => 'exm_recom_shoppage',
					'label' => __("Type", "experience-manager"),
					'description' => 'The type for product recommendation',
					'settings' => 'exm-woocommerce-shop[header_products]',
					'choices' => $this->get_recommendation_types()
				)
		);
		$wp_customize->add_setting('exm-woocommerce-shop[header_template]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => '',
		));

		$wp_customize->add_control('exm-recom-sp-h-template',
				array(
					'type' => 'select',
					'priority' => 10,
					'section' => 'exm_recom_shoppage',
					'label' => __("Template", "experience-manager"),
					'description' => 'The template used for recommendations',
					'settings' => 'exm-woocommerce-shop[header_template]',
					'choices' => $this->get_shop_templates()
				)
		);
	}

}
