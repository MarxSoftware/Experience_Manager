<?php

namespace TMA\ExperienceManager\Modules\WooCommerce;

/**
 * Description of class
 *
 * @author marx
 */
class WooCommerce_Shop_Integration extends Integration {

	protected static $_instance = null;

	/**
	 * 
	 * @return WooCommerce_Shop_Integration
	 */
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	private $options;

	public function __construct() {
		parent::__construct('exm-woocommerce-shop');
	}

	public function add_settings() {
		add_filter("customize_register", [$this, "register_customizer"]);
	}

	public function register_customizer(\WP_Customize_Manager $wp_customize) {
		$this->customizer_header($wp_customize);
		$this->customizer_footer($wp_customize);
	}

	function customizer_header(\WP_Customize_Manager $wp_customize) {
		$wp_customize->add_section("exm_recom_shoppage_header", array(
			'title' => __("Shoppage header", "experience-manager"),
			'panel' => 'exm_recommendations',
			'capability' => 'manage_options',
			'description' => 'Configure the recommendation for the shop page header area.'
		));
		// HEADER START
		$wp_customize->add_setting('exm-woocommerce-shop[header_title]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => '',
		));

		$wp_customize->add_control('exm-recom-sp-h-title',
				array(
					'type' => 'text',
					'priority' => 10,
					'section' => 'exm_recom_shoppage_header',
					'label' => __("Headline", "ms-recently-viewed-products"),
					'description' => 'Headline for the recommendations in the header.',
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
					'section' => 'exm_recom_shoppage_header',
					'label' => __("Type", "experience-manager"),
					'description' => 'The type for product recommendation',
					'settings' => 'exm-woocommerce-shop[header_products]',
					'choices' => $this->get_recommendation_types()
				)
		);
		$wp_customize->add_setting('exm-woocommerce-shop[header_template]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-sp-h-template',
				array(
					'type' => 'select',
					'priority' => 10,
					'section' => 'exm_recom_shoppage_header',
					'label' => __("Template", "experience-manager"),
					'description' => 'The template used for recommendations',
					'settings' => 'exm-woocommerce-shop[header_template]',
					'default' => 'default',
					'choices' => $this->get_recommendation_templates()
				)
		);
		// HEADER ENDE
	}

	function customizer_footer(\WP_Customize_Manager $wp_customize) {
		$wp_customize->add_section("exm_recom_shoppage_footer", array(
			'title' => __("Shoppage footer", "experience-manager"),
			'panel' => 'exm_recommendations',
			'capability' => 'manage_options',
			'description' => 'Configure the recommendation for the footer of the shop page'
		));
		// FOOTER START
		$wp_customize->add_setting('exm-woocommerce-shop[footer_title]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-sp-f-title',
				array(
					'type' => 'text',
					'priority' => 20,
					'section' => 'exm_recom_shoppage_footer',
					'label' => __("Headline", "experience-manager"),
					'description' => 'Headline of the footer recommendations',
					'settings' => 'exm-woocommerce-shop[footer_title]'
				)
		);

		$wp_customize->add_setting('exm-woocommerce-shop[footer_products]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-sp-f-products',
				array(
					'type' => 'select',
					'priority' => 20,
					'section' => 'exm_recom_shoppage_footer',
					'label' => __("Type", "experience-manager"),
					'description' => 'The type for product recommendation',
					'settings' => 'exm-woocommerce-shop[footer_products]',
					'choices' => $this->get_recommendation_types()
				)
		);
		$wp_customize->add_setting('exm-woocommerce-shop[footer_template]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => '',
		));

		$wp_customize->add_control('exm-recom-sp-f-template',
				array(
					'type' => 'select',
					'priority' => 20,
					'section' => 'exm_recom_shoppage_footer',
					'label' => __("Template", "experience-manager"),
					'description' => 'The template used for recommendations',
					'settings' => 'exm-woocommerce-shop[footer_template]',
					'choices' => $this->get_recommendation_templates()
				)
		);
		// FOOTER ENDE
	}

	function init() {

		add_action("parse_query", function () {
			$this->update_options();
			if (is_shop()) {
				tma_exm_log("options: " . json_encode($this->options));
				tma_exm_log("is shop");
				tma_exm_log($this->get_feature("header_products"));
				$shop_header = $this->get_feature("header_products");
				if ($shop_header && $shop_header !== "default") {
					$this->update_shop_header();
				}

				$shop_footer = $this->get_feature("footer_products");
				if ($shop_footer && $shop_footer !== "default") {
					$this->update_shop_footer();
				}
			} else {
				tma_exm_log("is not shop");
			}
		});
	}

	private function update_shop_header() {
		add_action('woocommerce_archive_description', function () {
			$arguments = [];
			$arguments["size"] = 3;
			$arguments["type"] = $this->get_feature("header_products") ? $this->get_feature("header_products") : "recently-viewed";
			$arguments["template"] = "shop/" . ($this->get_feature("header_template") ? $this->get_feature("header_template") : "default");
			$title = $this->get_feature("header_title");
			if ($title) {
				$arguments["title"] = $title;
			} else {
				$arguments["title"] = "";
			}
			exm_get_template("recommendation.shop.html", $arguments);
		}, 20);
	}

	private function update_shop_footer() {
		add_action('woocommerce_after_shop_loop', function () {
			$arguments = [];
			$arguments["size"] = 3;
			$arguments["type"] = $this->get_feature("footer_products") ? $this->get_feature("footer_products") : "recently-viewed";
			$arguments["template"] = "shop/" . ($this->get_feature("footer_template") ? $this->get_feature("footer_template") : "default");
			$title = $this->get_feature("footer_title");
			if ($title) {
				$arguments["title"] = $title;
			} else {
				$arguments["title"] = "";
			}
			tma_exm_log("update_category_footer");
			exm_get_template("recommendation.shop.html", $arguments);
		}, 20);
	}

	private function get_recommendation_templates() {
		return apply_filters("experience-manager/woocommerce/shop/templates", [
			"default" => __("Default", "experience-manager"),
			"simple" => __("Simple", "experience-manager")
		]);
	}
}
