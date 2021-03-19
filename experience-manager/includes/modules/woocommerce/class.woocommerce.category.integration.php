<?php

namespace TMA\ExperienceManager\Modules\WooCommerce;

/**
 * Description of class
 *
 * @author marx
 */
class WooCommerce_Category_Integration extends Integration {

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
		parent::__construct('exm-woocommerce-category');
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
		$wp_customize->add_section("exm_recom_category_header", array(
			'title' => __("Category page header", "experience-manager"),
			'panel' => 'exm_recommendations',
			'capability' => 'manage_woocommerce',
			'description' => 'Configure the recommendation for the category page header area.'
		));
		// HEADER START
		$wp_customize->add_setting('exm-woocommerce-category[header_title]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
			'default' => '',
		));

		$wp_customize->add_control('exm-recom-cat-h-title',
				array(
					'type' => 'text',
					'priority' => 10,
					'section' => 'exm_recom_category_header',
					'label' => __("Headline", "ms-recently-viewed-products"),
					'description' => 'Headline for the recommendations in the header.',
					'settings' => 'exm-woocommerce-category[header_title]'
				)
		);

		$wp_customize->add_setting('exm-woocommerce-category[header_products]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-cat-h-products',
				array(
					'type' => 'select',
					'priority' => 10,
					'section' => 'exm_recom_category_header',
					'label' => __("Type", "experience-manager"),
					'description' => 'The type for product recommendation',
					'settings' => 'exm-woocommerce-category[header_products]',
					'default' => 'default',
					'choices' => $this->get_recommendation_types()
				)
		);
		$wp_customize->add_setting('exm-woocommerce-category[header_template]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-cat-h-template',
				array(
					'type' => 'select',
					'priority' => 10,
					'section' => 'exm_recom_category_header',
					'label' => __("Template", "experience-manager"),
					'description' => 'The template used for recommendations',
					'settings' => 'exm-woocommerce-category[header_template]',
					'default' => 'default',
					'choices' => $this->get_recommendation_templates()
				)
		);
		// HEADER ENDE
	}

	function customizer_footer(\WP_Customize_Manager $wp_customize) {
		$wp_customize->add_section("exm_recom_category_footer", array(
			'title' => __("Category page footer", "experience-manager"),
			'panel' => 'exm_recommendations',
			'capability' => 'manage_woocommerce',
			'description' => 'Configure the recommendation for the footer of the category page'
		));
		// FOOTER START
		$wp_customize->add_setting('exm-woocommerce-category[footer_title]', array(
			'type' => 'option',
			'capability' => 'manage_options',
			'default' => ''
		));

		$wp_customize->add_control('exm-recom-cat-f-title',
				array(
					'type' => 'text',
					'priority' => 20,
					'section' => 'exm_recom_category_footer',
					'label' => __("Headline", "experience-manager"),
					'description' => 'Headline of the footer recommendations',
					'settings' => 'exm-woocommerce-category[footer_title]'
				)
		);

		$wp_customize->add_setting('exm-woocommerce-category[footer_products]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-cat-f-products',
				array(
					'type' => 'select',
					'priority' => 20,
					'section' => 'exm_recom_category_footer',
					'label' => __("Type", "experience-manager"),
					'description' => 'The type for product recommendation',
					'settings' => 'exm-woocommerce-category[footer_products]',
					'default' => 'default',
					'choices' => $this->get_recommendation_types()
				)
		);
		$wp_customize->add_setting('exm-woocommerce-category[footer_template]', array(
			'type' => 'option',
			'capability' => 'manage_woocommerce',
			'default' => 'default',
		));

		$wp_customize->add_control('exm-recom-cat-f-template',
				array(
					'type' => 'select',
					'priority' => 20,
					'section' => 'exm_recom_category_footer',
					'label' => __("Template", "experience-manager"),
					'description' => 'The template used for recommendations',
					'settings' => 'exm-woocommerce-category[footer_template]',
					'default' => 'default',
					'choices' => $this->get_recommendation_templates()
				)
		);
		// FOOTER ENDE
	}

	private function get_recommendation_templates() {
		return apply_filters("experience-manager/woocommerce/category/templates", [
			"default" => __("Default", "experience-manager"),
			"simple" => __("Simple", "experience-manager")
		]);
	}

	function init() {

		add_action("parse_query", function () {
			if (is_product_category()) {
				$this->update_options();
				tma_exm_log("is product cat");
				tma_exm_log($this->get_feature("header_products"));
				$category_header = $this->get_feature("header_products");
				if ($category_header && $category_header !== "default") {
					$this->update_category_header();
				}

				$category_footer = $this->get_feature("footer_products");
				if ($category_footer && $category_footer !== "default") {
					$this->update_category_footer();
				}
			} else {
				tma_exm_log("is not product cat");
			}
		});
	}

	private function update_category_header() {
		add_action('woocommerce_archive_description', function () {
			$arguments = [];
			$arguments["category"] = get_queried_object_id();
			$arguments["size"] = 3;
			$arguments["type"] = $this->get_feature("header_products") ? $this->get_feature("header_products") : "recently-viewed";
			$arguments["template"] = "category/" . ($this->get_feature("header_template") ? $this->get_feature("header_template") : "default");
			$title = $this->get_feature("header_title");
			if ($title) {
				$arguments["title"] = $title;
			} else {
				$arguments["title"] = "";
			}
			exm_get_template("recommendation.category.html", $arguments);
		}, 20);
	}

	private function update_category_footer() {
		add_action('woocommerce_after_shop_loop', function () {
			$arguments = [];
			$arguments["category"] = get_queried_object_id();
			$arguments["size"] = 3;
			$arguments["type"] = $this->get_feature("footer_products") ? $this->get_feature("footer_products") : "recently-viewed";
			$arguments["template"] = "category/" . ($this->get_feature("footer_template") ? $this->get_feature("footer_template") : "default");
			$title = $this->get_feature("footer_title");
			if ($title) {
				$arguments["title"] = $title;
			} else {
				$arguments["title"] = "";
			}
			tma_exm_log("update_category_footer");
			exm_get_template("recommendation.category.html", $arguments);
		}, 20);
	}

	function settings_fields($fields) {

		$settings_fields = [
			'exm-woocommerce-category' => [
				[
					'name' => 'header',
					'label' => __("Category header", "experience-manager"),
					'desc' => __("Configure product recommendation on category overview header!", "experience-manager"),
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
					'desc' => __("Configure product recommendation on category overview footer!", "experience-manager"),
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
				'id' => 'exm-woocommerce-category',
				'title' => __('Category overview', 'tma-webtools')
			]
		];
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

}
