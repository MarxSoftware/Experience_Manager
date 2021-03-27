<?php

namespace TMA\ExperienceManager;

/**
 * Description of class
 *
 * @author marx
 */
class TMA_Settings {

	private $settings_api;

	function __construct() {
		$this->settings_api = new \TMA_Settings_API();
		add_action('admin_init', array($this, 'admin_init'));
		add_action('admin_menu', array($this, 'admin_menu'));
	}

	function admin_init() {

		wp_register_style('tma-settings', plugins_url('experience-manager/css/tma-settings.css'));
		wp_enqueue_style('tma-settings');


		//set the settings
		$this->settings_api->set_sections($this->get_settings_sections());
		$this->settings_api->set_fields($this->get_settings_fields());
		//initialize settings
		$this->settings_api->admin_init();
	}

	function admin_menu() {
		add_menu_page(
				__("Experience Manager", "experience-manager"), __("Experience Manager", "experience-manager"), 'manage_woocommerce', 'exm-settings', array($this, 'plugin_page'), plugins_url('experience-manager/images/settings_16.png'), 50);
		//add_submenu_page('experience-manager/pages/tma-webtools-admin.php', __("Dashboard", "experience-manager"), __("Dashboard", "experience-manager"), 'manage_options', 'experience-manager/pages/tma-webtools-admin.php', null);
		//add_submenu_page('experience-manager/pages/tma-webtools-admin.php', __("Settings", "experience-manager"), __("Settings", "experience-manager"), 'manage_options', 'tma-webtools-setting-admin', array($this, 'plugin_page'));
		
		
		add_submenu_page('exm-settings', __("Documentation", "experience-manager"), __("Documentation", "experience-manager"), 'manage_woocommerce', 'https://marx-software.de/documentation/experience-manager/', null);
	}

	function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'tma_webtools_option',
				'title' => __('Basic Settings', 'experience-manager')
			),
			[
				'id' => 'exm_options_recommendations',
				'title' => __("Recommendation Options", "experience-manager")
			]
//			array(
//				'id' => 'tma_webtools_option_targeting',
//				'title' => __('Targeting', 'wedevs')
//			)
		);

		$sections = apply_filters("experience-manager/settings/sections", $sections);
		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {
		$settings_fields = array(
			'tma_webtools_option' => array(
				array(
					'name' => 'webtools_siteid',
					'label' => __("Site id", "experience-manager"),
					'desc' => __("The id should be unique and is used to filter in the Experience Platform.", "experience-manager"),
					'placeholder' => __('Your site id', 'wedevs'),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'webtools_url',
					'label' => __("Url", "experience-manager"),
					'desc' => __("The url where the Experience Platform is installed.", "experience-manager"),
					'placeholder' => __('The webTools url', 'wedevs'),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'webtools_apikey',
					'label' => __("ApiKey", "experience-manager"),
					'desc' => __("The apikey to use the Experience Platform.", "experience-manager"),
					'placeholder' => __('The apikey', 'wedevs'),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'webtools_cookiedomain',
					'label' => __("Cookie domain", "experience-manager"),
					'desc' => __("Share the Experience Platform cookie with subdomains. e.q. .your_domain.com", "experience-manager"),
					'placeholder' => __('The cookiedomain', 'wedevs'),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'webtools_track',
					'label' => __("Enable Tracking?", "experience-manager"),
					'desc' => __("Tracked events are: pageview", "experience-manager"),
					'type' => 'toggle'
				),
				array(
					'name' => 'webtools_track_logged_in_users',
					'label' => __("Track logged in users?", "experience-manager"),
					'desc' => __("Activate tracking of logged in users.", "experience-manager"),
					'type' => 'toggle'
				),
				/*
				array(
					'name' => 'webtools_score',
					'label' => __("Enable Scoring?", "experience-manager"),
					'desc' => __("If enabled, you can user the scoring metabox to set scorings for all your post types.", "experience-manager"),
					'type' => 'toggle'
				)
				 */
			),
			"exm_options_recommendations" => [
				[
					'name' => 'add_random_products',
					'label' => __("Add popular/random products?", "experience-manager"),
					'desc' => __("Should missing recommendations be filled with popular/random products?", "experience-manager"),
					'type' => 'toggle'
				],
				[
					'name' => 'mode_intelligent',
					'label' => __("Enable intelligent mode?", "experience-manager"),
					'desc' => __("If the recommendation is dispayed on a category page, only products if that category are recommended!", "experience-manager"),
					'type' => 'toggle'
				]
			]
		);

		$settings_fields = apply_filters("experience-manager/settings/fields", $settings_fields);

		return $settings_fields;
	}

	function plugin_page() {
		echo '<div class="wrap">';
		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();
		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {
		$pages = get_pages();
		$pages_options = array();
		if ($pages) {
			foreach ($pages as $page) {
				$pages_options[$page->ID] = $page->post_title;
			}
		}
		return $pages_options;
	}

}

if (is_admin()) {
	new TMA_Settings();
}
