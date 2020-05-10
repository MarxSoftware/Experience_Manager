<?php
/*
  Plugin Name: Experience Manager
  Plugin URI: https://wp-digitalexperience.com/experience-manager/
  Description: The integration for the experience platform.
  Author: WP-DigitalExperience - Thorsten Marx
  Version: 4.2.0
  Author URI: https://wp-digitalexperience.com/
  Text Domain: tma-webtools
  Domain Path: /languages
 */
if (!defined('ABSPATH')) {
	exit;
}

define("TMA_EXPERIENCE_MANAGER_VERSION", "4.2.0");
define("TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_ALL", "all");
define("TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_ANY", "any");
define("TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_NONE", "none");

define("TMA_EXPERIENCE_MANAGER_DIR", plugin_dir_path(__FILE__));
define("TMA_EXPERIENCE_MANAGER_URL", plugins_url('/', __FILE__));

require_once 'tma-autoload.php';
require 'dependencies/Mustache/Autoloader.php';
\Mustache_Autoloader::register();
require_once 'includes/tma_functions.php';
require_once 'tma-scripts.php';

add_action('plugins_loaded', 'tma_load_textdomain');

function tma_load_textdomain() {
	load_plugin_textdomain('tma-webtools', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

tma_exm_log("register segment postype");
\TMA\ExperienceManager\Segment\SegmentType::getInstance()->register();

tma_exm_log("register content postype");
\TMA\ExperienceManager\Content\ContentType::getInstance()->register();


add_action("init", "tma_webtools_init");
add_action("rest_api_init", "tma_webtools_rest_init");
add_action("plugins_loaded", "tma_webtools_plugins_loaded");
add_action("init", "tma_webtools_theme_loaded");

function tma_webtools_theme_loaded() {
	tma_exm_log("init - integrations");
	\TMA\ExperienceManager\Modules\Integrations::getInstance()->theme_init();
}

function tma_webtools_plugins_loaded() {
	tma_exm_log("plugins loaded - integrations");
	\TMA\ExperienceManager\Modules\Integrations::getInstance()->init();
}

function tma_webtools_rest_init() {
	tma_exm_log("tma_webtools_rest_init");
	$tma_rest = new \TMA\ExperienceManager\TMA_Rest();
}

new \TMA\ExperienceManager\TMA_Backend_Ajax();

function tma_webtools_init() {

	do_action("experience-manager/init/before");

	tma_exm_log("tma_webtools_init");
	if (!is_admin()) {
		wp_register_style('experience-manager', plugins_url('css/experience-manager.css', __FILE__));
		wp_enqueue_style('experience-manager');

//		wp_register_script("experience-manager-hooks", plugins_url('assets/hook.js', __FILE__), [], "1.0.0", false);
//		wp_enqueue_script("experience-manager-hooks", plugins_url('assets/hook.js', __FILE__), [], "1.0.0", false);
	}

	require_once 'includes/frontend/template_tags.php';

	// IS not stored
	//new TMA\ExperienceManager\TMA_Widget_Targeting();
	//tma_exm_log(is_preview() ? "preview" : "no preview");
	//tma_exm_log(tma_exm_is_preview() ? "tma_preview" : "no tma_preview");

	require_once 'includes/backend/class.tma_wpadminbar.php';
	if (is_user_logged_in() && (is_admin() || tma_exm_is_preview() )) {
		//require_once 'includes/backend/class.tma_metabox.php';
		require_once 'includes/backend/class.tma_shortcodes_plugin.php';


		require_once 'includes/backend/class.tma_ajax.php';

		require_once 'includes/backend/class.tma_settings.php';

//		require_once 'includes/backend/class.tma_hooks.php';

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

	do_action("experience-manager/init/after");
}

/*
  add_filter("tma_config", 'tma_recommendation_tma_config');
  function tma_recommendation_tma_config($tmaConfig) {
  $recConfig = array();
  $recConfig['plugin_url'] = plugins_url('', __FILE__);

  $tmaConfig['recommendation'] = $recConfig;

  return $tmaConfig;
  }
 */

/**
 * This script has to be in page as early as possible, so usage of wp_enqueue_script is not an option
 */
function tma_js_variables() {
	$tma_config = [];
	$tma_config['plugin_url'] = plugins_url('', __FILE__);
	$tma_config['rest_url'] = get_rest_url();

	$tma_config['segments'] = tma_exm_get_segments_as_array();

	$tma_config['user_segments'] = tma_exm_get_user_segments();

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
	if( !session_id() ) {
        session_start();
	}
	$_REQUEST[\TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_REQUEST] = \TMA\ExperienceManager\UUID::v4();
//	\TMA\ExperienceManager\TMA_COOKIE_HELPER::getInstance()->getCookie(\TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_USER, \TMA\ExperienceManager\UUID::v4(), \TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE, true);
//	\TMA\ExperienceManager\TMA_COOKIE_HELPER::getInstance()->getCookie(\TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_VISIT, \TMA\ExperienceManager\UUID::v4(), \TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_VISIT_EXPIRE, true);
}
