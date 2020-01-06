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
		
		
		wp_register_script('exm-d3-js', plugins_url('experience-manager/assets/dashboard/d3.min.js'));
		wp_enqueue_script('exm-d3-js');
		wp_register_script('exm-c3-js', plugins_url('experience-manager/assets/dashboard/c3.min.js'), ['exm-d3-js']);
		wp_enqueue_script('exm-c3-js');
		wp_register_style('ecm-c3-css', plugins_url('experience-manager/assets/dashboard/c3.min.css'));
		wp_enqueue_style('ecm-c3-css');
		
		
		
		wp_register_script('exm-dashboard-js', plugins_url('experience-manager/assets/dashboard/exm-dashboard.js'), ['exm-c3-js', 'tma-webtools-backend']);
		wp_enqueue_script('exm-dashboard-js');
		wp_register_style('exm-dashboard-css', plugins_url('experience-manager/assets/dashboard/exm-dashboard.css'));
		wp_enqueue_style('exm-dashboard-css');

		//set the settings
		$this->settings_api->set_sections($this->get_settings_sections());
		$this->settings_api->set_fields($this->get_settings_fields());
		//initialize settings
		$this->settings_api->admin_init();
	}

	function admin_menu() {
		add_menu_page(
				__("Experience Manager", "tma-webtools"), __("Experience Manager", "tma-webtools"), 'manage_options', 'experience-manager/pages/tma-webtools-admin.php', null, plugins_url( 'experience-manager/images/settings.png' ), 50);
		add_submenu_page('experience-manager/pages/tma-webtools-admin.php', __("Dashboard", "tma-webtools"), __("Dashboard", "tma-webtools"), 'manage_options', 'experience-manager/pages/tma-webtools-admin.php', null);
		add_submenu_page('experience-manager/pages/tma-webtools-admin.php', __("Settings", "tma-webtools"), __("Settings", "tma-webtools"), 'manage_options', 'tma-webtools-setting-admin', array($this, 'plugin_page'));
	}

	function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'tma_webtools_option',
				'title' => __('Basic Settings', 'wedevs')
			),
			array(
				'id' => 'tma_webtools_option_targeting',
				'title' => __('Targeting', 'wedevs')
			)
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
					'label' => __("Site id", "tma-webtools"),
					'desc' => __("The id should be unique and is used to filter in the Experience Platform.", "tma-webtools"),
					'placeholder' => __('Your site id', 'wedevs'),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'webtools_url',
					'label' => __("Url", "tma-webtools"),
					'desc' => __("The url where the Experience Platform is installed.", "tma-webtools"),
					'placeholder' => __('The webTools url', 'wedevs'),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'webtools_apikey',
					'label' => __("ApiKey", "tma-webtools"),
					'desc' => __("The apikey to use the Experience Platform.", "tma-webtools"),
					'placeholder' => __('The apikey', 'wedevs'),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'webtools_cookiedomain',
					'label' => __("Cookie domain", "tma-webtools"),
					'desc' => __("Share the Experience Platform cookie with subdomains. e.q. .your_domain.com", "tma-webtools"),
					'placeholder' => __('The cookiedomain', 'wedevs'),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'webtools_track',
					'label' => __("Enable Tracking?", "tma-webtools"),
					'desc' => __("Tracked events are: pageview", "tma-webtools"),
					'type' => 'toggle'
				),
				array(
					'name' => 'webtools_track_logged_in_users',
					'label' => __("Track logged in users?", "tma-webtools"),
					'desc' => __("Activate tracking of logged in users.", "tma-webtools"),
					'type' => 'toggle'
				),
				array(
					'name' => 'webtools_score',
					'label' => __("Enable Scoring?", "tma-webtools"),
					'desc' => __("If enabled, you can user the scoring metabox to set scorings for all your post types.", "tma-webtools"),
					'type' => 'toggle'
				)
			),
			'tma_webtools_option_targeting' => array(
				array(
					'name' => 'webtools_backend_mode',
					'label' => __("Backend mode?", "tma-webtools"),
					'desc' => __("Experimental: If enabled, the targeting is done in the backend.", "tma-webtools"),
					'type' => 'toggle'
				),
				array(
					'name' => 'webtools_shortcode_single_item_per_group',
					'label' => __("Single item per group?", "tma-webtools"),
					'desc' => __("If enabled, only the first matching group is delivered.", "tma-webtools"),
					'type' => 'toggle'
				)
			)
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
