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
		$this->options = get_option('exm-woocommerce-category');
	}

	public function add_settings() {
		add_filter('experience-manager/settings/fields', [$this, 'settings_fields']);
		add_filter('experience-manager/settings/sections', [$this, 'sections']);
	}

	function init() {

		add_action("parse_query", function () {
			if (is_product_category()) {
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
			$arguments["template"] = "category/" . ($this->get_feature("header_template") ? $this->get_feature("header_template") : "woocommerce-default");
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
			$arguments["template"] = "category/" . ($this->get_feature("footer_template") ? $this->get_feature("footer_template") : "woocommerce-default");
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

	private function get_recommendation_types() {
		return [
			"default" => __("None", "experience-manager"),
			"popular-products" => __("Popular products in category", "experience-manager"),
			"frequently-bought" => __("Frequently bought in category", "experience-manager"),
			"recently-viewed" => __("Recently viewed", "experience-manager")
		];
	}

	private function get_recommendation_templates() {
		return apply_filters("experience-manager/woocommerce/category/templates", [
			"woocommerce-default" => __("WooCommerce Default", "experience-manager")
		]);
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

	public function get_options() {
		return $this->options;
	}

}
