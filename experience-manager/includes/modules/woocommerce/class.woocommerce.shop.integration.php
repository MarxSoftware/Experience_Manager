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

		add_filter('experience-manager/settings/fields', [$this, 'settings_fields']);
		add_filter('experience-manager/settings/sections', [$this, 'sections']);
	}

	public function register_customizer(\WP_Customize_Manager $wp_customize) {
		$this->customizer_header($wp_customize);
		$this->customizer_footer($wp_customize);
	}

	function customizer_header(\WP_Customize_Manager $wp_customize) {
		$wp_customize->add_section("exm_recom_shoppage_header", array(
			'title' => __("Shoppage header", "experience-manager"),
			'panel' => 'exm_recommendations',
			'capability' => 'manage_woocommerce',
			'description' => 'Configure the recommendation for the shop page header area.'
		));
		// HEADER START
		$wp_customize->add_setting('exm-woocommerce-shop[header_title]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
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
			'capability' => 'manage_woocommerce',
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
			'capability' => 'manage_woocommerce',
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
			'capability' => 'manage_woocommerce',
			'description' => 'Configure the recommendation for the footer of the shop page'
		));
		// FOOTER START
		$wp_customize->add_setting('exm-woocommerce-shop[footer_title]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
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
			'capability' => 'manage_woocommerce',
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
			'capability' => 'manage_woocommerce',
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
		if (!is_customize_preview()) {
			$this->update_shop_page();
		}

		// Prepare for customizer preview
		add_action('customize_preview_init', function () {
			$this->update_options();
			$this->update_shop_page();
		});
	}

	private function update_shop_page() {
		$shop_header = $this->get_feature("header_products");
		if ($shop_header && $shop_header !== "default") {
			$this->update_shop_header();
		}

		$shop_footer = $this->get_feature("footer_products");
		if ($shop_footer && $shop_footer !== "default") {
			$this->update_shop_footer();
		}
	}

	private function update_shop_header() {
		add_action('woocommerce_archive_description', function () {
			if (!is_shop()) {
				return;
			}
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
			if (!is_shop()) {
				return;
			}
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
			exm_get_template("recommendation.shop.html", $arguments);
		}, 20);
	}

	private function get_recommendation_templates() {
		return apply_filters("experience-manager/woocommerce/shop/templates", [
			"default" => __("Default", "experience-manager"),
			"simple" => __("Simple", "experience-manager")
		]);
	}

	function settings_fields($fields) {

		$settings_fields = [
			'exm-woocommerce-shop' => [
				[
					'name' => 'header',
					'label' => __("Shop header", "experience-manager"),
					'desc' => __("Configure product recommendation on shop page header!", "experience-manager"),
					'type' => 'subsection',
				],
				[
					'name' => 'header_products',
					'label' => __("Recommendation type", "experience-manager"),
					'desc' => __("What kind of recommendation to display.", "experience-manager"),
					'type' => 'select',
					'options' => $this->get_recommendation_types()
				],
				[
					'name' => 'header_template',
					'label' => __("Template", "experience-manager"),
					'desc' => __("The template used to display the products.", "experience-manager"),
					'type' => 'select',
					'options' => $this->get_recommendation_templates()
				],
				[
					'name' => 'header_title',
					'label' => __("Title", "experience-manager"),
					'desc' => __("The title.", "experience-manager"),
					'type' => 'text'
				],
				/* Footer */
				[
					'name' => 'footer',
					'label' => __("Category footer", "experience-manager"),
					'desc' => __("Configure product recommendation on shop page footer!", "experience-manager"),
					'type' => 'subsection',
				],
				[
					'name' => 'footer_products',
					'label' => __("Recommendation type", "experience-manager"),
					'desc' => __("What kind of recommendation to display.", "experience-manager"),
					'type' => 'select',
					'options' => $this->get_recommendation_types()
				],
				[
					'name' => 'footer_template',
					'label' => __("Template", "experience-manager"),
					'desc' => __("The template used to display the products.", "experience-manager"),
					'type' => 'select',
					'options' => $this->get_recommendation_templates()
				],
				[
					'name' => 'footer_title',
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
				'id' => 'exm-woocommerce-shop',
				'title' => __('Shop page', 'experience-manager')
			]
		];
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

}
