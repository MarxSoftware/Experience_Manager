<?php

namespace TMA\ExperienceManager\Modules;

/**
 * Tracking of WooCommerce events.
 */
class Integrations {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	protected function __construct() {
		$this->options = get_option('tma-webtools-Integrations');
	}
	
	public function theme_init () {
		add_filter('experience-manager/settings/fields', [$this, 'intregrations_settings']);
		add_filter('experience-manager/settings/sections', [$this, 'integrations_sections']);
	}
	
	public function init() {
		if (\TMA\ExperienceManager\Plugins::getInstance()->elementor() && $this->shouldInit("editors_elementor")) {
			\TMA\ExperienceManager\Elementor_Integration::getInstance();
			\TMA\ExperienceManager\Elementor_Preview::getInstance();
			//		\TMA\ExperienceManager\ElementorPopupIntegration::getInstance()->init();
		}
		if (\TMA\ExperienceManager\Plugins::getInstance()->gutenberg() && $this->shouldInit("editors_gutenberg")) {
			new \TMA\ExperienceManager\Gutenberg_Integration();
		}
		if (\TMA\ExperienceManager\Plugins::getInstance()->divi() && $this->shouldInit("editors_divi")) {
			\TMA\ExperienceManager\Modules\Editors\Divi\DiviBuilder_Integration::getInstance()->init();
		}

		if (\TMA\ExperienceManager\Plugins::getInstance()->beaver() && $this->shouldInit("editors_beaver")) {
			new \TMA\ExperienceManager\Beaver\BeaverBuilder_Integration();
			//\TMA\ExperienceManager\Beaver\BeaverBuilder_Preview::getInstance()->init();
		}


		if (\TMA\ExperienceManager\Plugins::getInstance()->popup_maker() && $this->shouldInit("messaging_popupmaker")) {
			\TMA\ExperienceManager\TMA_PopupMakerIntegration::getInstance()->init();
		}
		if (\TMA\ExperienceManager\Plugins::getInstance()->advanced_ads() && $this->shouldInit("messaging_advancedads")) {
			\TMA\ExperienceManager\TMA_AdvancedAdsIntegration::getInstance()->init();
		}

		if (\TMA\ExperienceManager\Plugins::getInstance()->woocommerce() && $this->shouldInit("ecommerce_woocommerce")) {
			$tracker = new \TMA\ExperienceManager\Events\WC_TRACKER();
			$tracker->init();
		}
		if (\TMA\ExperienceManager\Plugins::getInstance()->easydigitaldownloads() && $this->shouldInit("ecommerce_edd")) {
			$edd_tracker = \TMA\ExperienceManager\Events\EDD_TRACKER::getInstance();
			$edd_tracker->init();
		}
	}

	public function intregrations_settings($fields) {

		$integrations = array(
			array(
				'name' => 'editors',
				'label' => __("Editor integrations", "tma-webtools"),
				'desc' => __("Configure the editor targeting", "tma-webtools"),
				'type' => 'subsection',
			),
			array(
				'name' => 'editors_gutenberg',
				'label' => __("Enable gutenberg integration?", "tma-webtools"),
				'desc' => __("Enable targeting in the gutenberg editor", "tma-webtools"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->gutenberg(),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'editors_elementor',
				'label' => __("Enable elementor integration?", "tma-webtools"),
				'desc' => __("Enable targeting in the elementor page builder", "tma-webtools"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->elementor(),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'editors_divi',
				'label' => __("Enable DIVI integration?", "tma-webtools"),
				'desc' => __("Enable targeting in the DIVI page builder", "tma-webtools"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->divi(),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'editors_beaver',
				'label' => __("Enable Beaver integration?", "tma-webtools"),
				'desc' => __("Enable targeting in the Beaver page builder", "tma-webtools"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->beaver(),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'messaging',
				'label' => __("Messaging integrations", "tma-webtools"),
				'desc' => __("Configure the targeting for plugins related to messaging", "tma-webtools"),
				'type' => 'subsection',
			),
			array(
				'name' => 'messaging_popupmaker',
				'label' => __("Enable popup maker integration?", "tma-webtools"),
				'desc' => __("Enable targeting in the popup maker", "tma-webtools"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->popup_maker(),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'messaging_advancedads',
				'label' => __("Enable Advanced Ads integration?", "tma-webtools"),
				'desc' => __("Enable targeting into Advanced Ads", "tma-webtools"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->advanced_ads(),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'ecommerce',
				'label' => __("eCommerce integrations", "tma-webtools"),
				'desc' => __("Configure the integration in ecommerce systems", "tma-webtools"),
				'type' => 'subsection',
			),
			array(
				'name' => 'ecommerce_woocommerce',
				'label' => __("Enable WooCommerce integration?", "tma-webtools"),
				'desc' => __("Enable integration into WooCommerce", "tma-webtools"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->woocommerce(),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'ecommerce_edd',
				'label' => __("Enable EasyDigitalDownloads integration?", "tma-webtools"),
				'desc' => __("Enable integration into EasyDigitalDownload", "tma-webtools"),
				'type' => 'toggle',
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->easydigitaldownloads(),
				'default' => ''
			)
		);

		apply_filters('experience-manager/settings/sections/integrations', $integrations);

		$settings_fields = array(
			'tma-webtools-Integrations' => $integrations
		);
		$fields = array_merge_recursive($fields, $settings_fields);
		return $fields;
	}

	public function integrations_sections($sections) {
		$custom_sections = array(
			array(
				'id' => 'tma-webtools-Integrations',
				'title' => __('Integrations', 'tma-webtools')
			)
		);
		$sections = array_merge_recursive($sections, $custom_sections);
		return $sections;
	}

	function shouldInit($setting_name) {
		return isset($this->options[$setting_name]) && $this->options[$setting_name] === "on";
	}

}
