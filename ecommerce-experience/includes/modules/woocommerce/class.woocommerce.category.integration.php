<?php

namespace TMA\ExperienceManager\Modules\WooCommerce;

/**
 * Description of class
 *
 * @author marx
 */
class WooCommerce_Category_Integration {

	private $options;

	public function __construct() {
		$this->options = get_option('exm-woocommerce-category');

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

		$category_header = $this->get_feature("header_products");
		if ($category_header && $category_header !== "none") {
			$this->update_category_header();
		}
		
		$category_footer = $this->get_feature("footer_products");
		if ($category_footer && $category_footer !== "none") {
			$this->update_category_footer();
		}
	}

	private function update_category_header() {
		add_action('woocommerce_archive_description', function () {
			$arguments = [];
			$arguments["category"] = get_queried_object()->term_id;
			$arguments["size"] = 3;
			$arguments["type"] = "bought-together";
			$arguments["template"] = "category-overview";
			$title = $this->get_feature("header_title");
			if ($title) {
				$arguments["title"] = $title;
			} else {
				$arguments["title"] = "";
			}
			tma_exm_log("update_category_header");
			exm_get_template("recommendation.category.html", $arguments);
		}, 20);
	}
	private function update_category_footer() {
		add_action('woocommerce_after_shop_loop', function () {
			$arguments = [];
			$arguments["category"] = get_queried_object()->term_id;
			$arguments["size"] = 3;
			$arguments["type"] = "bought-together";
			$arguments["template"] = "category-overview";
			$title = $this->get_feature("footer_title");
			if ($title) {
				$arguments["title"] = $title;
			} else {
				$arguments["title"] = "";
			}
			tma_exm_log("update_category_header");
			exm_get_template("recommendation.category.html", $arguments);
		}, 20);
	}

	private function get_recommendation_types() {
		return [
			"none" => __("None", "experience-manager"),
			"popular_products" => __("Popular products in category", "experience-manager"),
			"frequently_bought" => __("Frequently bought in category", "experience-manager")
		];
	}

	function settings_fields($fields) {

		$settings_fields = [
			'exm-woocommerce-category' => [
				[
					'name' => 'header',
					'label' => __("Category header", "tma-webtools"),
					'desc' => __("Configure product recommendation on category overview header!", "tma-webtools"),
					'type' => 'subsection',
				],
				[
					'name' => 'header_products',
					'label' => __("Recommendation type", "tma-webtools"),
					'desc' => __("What kind of recommendation to display.", "tma-webtools"),
					'type' => 'select',
					'options' => $this->get_recommendation_types()
				],
				[
					'name' => 'header_title',
					'label' => __("Title", "tma-webtools"),
					'desc' => __("The title.", "tma-webtools"),
					'type' => 'text'
				],
				/* Footer */
				[
					'name' => 'footer',
					'label' => __("Category footer", "tma-webtools"),
					'desc' => __("Configure product recommendation on category overview footer!", "tma-webtools"),
					'type' => 'subsection',
				],
				[
					'name' => 'footer_products',
					'label' => __("Recommendation type", "tma-webtools"),
					'desc' => __("What kind of recommendation to display.", "tma-webtools"),
					'type' => 'select',
					'options' => $this->get_recommendation_types()
				],
				[
					'name' => 'footer_title',
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
				'id' => 'exm-woocommerce-category',
				'title' => __('Category overview', 'tma-webtools')
			]
		];
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

}
