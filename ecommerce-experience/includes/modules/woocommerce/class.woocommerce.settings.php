<?php

namespace TMA\ExperienceManager\Modules\WooCommerce;

/**
 * Description of class
 *
 * @author marx
 */
class WooCommerce_Settings {

	public function __construct() {
		add_filter('experience-manager/settings/fields', [$this, 'settings_fields']);
		add_filter('experience-manager/settings/sections', [$this, 'sections']);
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
			],
			[
				'id' => 'exm-woocommerce-category',
				'title' => __('Category page', 'tma-webtools')
			]
		];
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

}
