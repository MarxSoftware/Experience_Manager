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
		$this->options = get_option('exm-woocommerce-shop');
	}

	public function add_settings() {
		add_filter('experience-manager/settings/fields', [$this, 'settings_fields']);
		add_filter('experience-manager/settings/sections', [$this, 'sections']);
	}

	function init() {

		add_action("parse_query", function () {
			if (is_shop()) {
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
				'title' => __('Shop page', 'tma-webtools')
			]
		];
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

	public function get_options() {
		return $this->options;
	}

}
