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
			'exm-woocommerce-settings' => [
				[
					'name' => 'exm_wc_sync_products',
					'label' => __("Sync Products", "experience-manager"),
					'desc' => __("Sync your products with the ecommerce engine.", "experience-manager"),
					'type' => 'button',
					'button_label' => 'Start Sync',
					'onclick' => 'exm_wc_sync_products(this)'
				]
			]
		];
		$fields = array_merge_recursive($fields, $settings_fields);
		return $fields;
	}

	function sections($sections) {
		$custom_sections = [
			[
				'id' => 'exm-woocommerce-settings',
				'title' => __('WooCommerce Settings', 'tma-webtools')
			]
		];
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

}
