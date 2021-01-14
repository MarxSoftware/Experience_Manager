<?php

namespace TMA\ExperienceManager;

/**
 * Description of Plugins
 *
 * @author marx
 */
class Plugins {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	protected function __clone() {
		
	}

	private $plugins;

	protected function __construct() {
		$this->plugins = apply_filters('active_plugins', get_option('active_plugins'));
	}

	public function woocommerce() {
		return in_array('woocommerce/woocommerce.php', $this->plugins);
	}
	public function easydigitaldownloads() {
		return in_array('easy-digital-downloads/easy-digital-downloads.php', $this->plugins);
	}

	public function elementor() {
		return in_array('elementor/elementor.php', $this->plugins);
	}
	public function divi() {
		return function_exists("et_setup_theme") || class_exists("ET_Builder_Plugin");
	}

	public function popup_maker() {
		return in_array('popup-maker/popup-maker.php', $this->plugins);
	}
	
	public function wp_popups() {
		return in_array('wp-popups-lite/wp-popups-lite.php', $this->plugins);
	}

	public function advanced_ads() {
		return in_array('advanced-ads/advanced-ads.php', $this->plugins);
	}
	
	public function beaver() {
		return class_exists('FLBuilder');
	}

	public function gutenberg() {
		//if (function_exists('is_gutenberg_page') && is_gutenberg_page()) {
		if (version_compare( get_bloginfo( 'version' ), '5.0', '>=' )) {
			return true;
		}
		return false;
		//return in_array('gutenberg/gutenberg.php', $this->plugins) || function_exists("the_gutenberg_project");
	}

}
