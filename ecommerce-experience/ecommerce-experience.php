<?php
/*
  Plugin Name: Ecommerce-Experience
  Plugin URI: https://marx-software.de/ecommerce-experience/
  Description: The integration for the experience platform.
  Author: Marx-Software - Thorsten Marx
  Version: 4.5.0
  Author URI: https://marx-software.de/
  Text Domain: ecommerce-experience
  Domain Path: /languages
 */
if (!defined('ABSPATH')) {
	exit;
}

define("TMA_EXPERIENCE_MANAGER_VERSION", "4.5.0");

define("TMA_EXPERIENCE_MANAGER_DIR", plugin_dir_path(__FILE__));
define("TMA_EXPERIENCE_MANAGER_URL", plugins_url('/', __FILE__));

define('TMA_EXPERIENCE__FILE__', __FILE__);
define('TMA_EXPERIENCE_PLUGIN_BASE', plugin_basename(TMA_EXPERIENCE__FILE__));

require_once 'tma-autoload.php';
require 'dependencies/Mustache/Autoloader.php';
\Mustache_Autoloader::register();
require_once 'includes/tma_functions.php';
require_once 'tma-scripts.php';

require_once 'includes/modules/events/ecommerce_events.php';


add_action("init", "exm_init");
add_action("rest_api_init", "exm_rest_init");
require_once 'includes/modules/widgets/register_widgets.php';


function exm_rest_init() {
	tma_exm_log("tma_webtools_rest_init");
	$tma_rest = new \TMA\ExperienceManager\TMA_Rest();
}

//require_once 'includes/backend/class.tma_settings.php';
function exm_init() {

	do_action("experience-manager/init/before");

	tma_exm_log("tma_webtools_init");

	if (is_user_logged_in() && is_admin()) {

		new TMA\ExperienceManager\TMA_Backend_Ajax();

		require_once 'includes/backend/class.tma_settings.php';


		add_filter("tma_config", function ($tma_config) {
			$options = get_option('tma_webtools_option');
			$siteid = isset($options['webtools_siteid']) ? $options["webtools_siteid"] : get_option('blogname');
			$apikey = isset($options['webtools_apikey']) ? $options["webtools_apikey"] : "";
			$url = isset($options['webtools_url']) ? $options["webtools_url"] : "";
			$tma_config['apikey'] = $apikey;
			$tma_config['site'] = $siteid;
			$tma_config['url'] = $url;

			return $tma_config;
		});
	}

	add_action('wp_head', 'tma_js_variables', -100);
	add_action('admin_head', 'tma_js_variables', -100);

	tma_init_cookie();

	if (\TMA\ExperienceManager\Plugins::getInstance()->woocommerce()) {
		//new TMA\ExperienceManager\Modules\ECommerce\Ecommerce_Woo();
		new TMA\ExperienceManager\Modules\Ajax\EcommerceAjax();
		//new \TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Settings();


		\TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Product_Integration::getInstance()->add_settings();
		\TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Category_Integration::getInstance()->add_settings();
		\TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Shop_Integration::getInstance()->add_settings();
		
		\TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Product_Integration::getInstance()->init();
		\TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Category_Integration::getInstance()->init();
		\TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Shop_Integration::getInstance()->init();
		
		new \TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Settings();
		new \TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Hooks();
	}

	do_action("experience-manager/init/after");
}


/**
 * This script has to be in page as early as possible, so usage of wp_enqueue_script is not an option
 */
function tma_js_variables() {
	$tma_config = [];
	$tma_config['plugin_url'] = plugins_url('', __FILE__);
	$tma_config['rest_url'] = get_rest_url();

	$tma_config = apply_filters("tma_config", $tma_config);
	?>
	<script type='text/javascript'>
		var TMA_CONFIG = <?php echo json_encode($tma_config); ?>;
	</script><?php
}

function tma_init_cookie() {
	/**
	 * cookies are only used if set via js, 
	 * so the option implementation is easier
	 */
	if (!session_id()) {
		session_start();
	}
	$_REQUEST[\TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_REQUEST] = \TMA\ExperienceManager\UUID::v4();
}
