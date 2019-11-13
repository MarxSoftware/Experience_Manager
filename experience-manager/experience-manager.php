<?php
/*
  Plugin Name: Experience Manager
  Plugin URI: https://wp-digitalexperience.com/experience-manager/
  Description: The integration for the experience platform.
  Author: Thorsten Marx
  Version: 2.1.0
  Author URI: https://wp-digitalexperience.com/
  Text Domain: tma-webtools
  Domain Path: /languages
 */
if (!defined('ABSPATH')) {
	exit;
}

define("TMA_EXPERIENCE_MANAGER_VERSION", "2.1.0");
define("TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_ALL", "all");
define("TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_ANY", "any");
define("TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_NONE", "none");

define("TMA_EXPERIENCE_MANAGER_DIR", plugin_dir_path(__FILE__));
define("TMA_EXPERIENCE_MANAGER_URL", plugins_url('/', __FILE__));

require_once 'tma-autoload.php';
require_once 'includes/tma_functions.php';
require_once 'tma-scripts.php';

add_action('plugins_loaded', 'tma_load_textdomain');

function tma_load_textdomain() {
	load_plugin_textdomain('tma-webtools', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action("init", "tma_webtools_init");
add_action("rest_api_init", "tma_webtools_rest_init");
add_action("plugins_loaded", "tma_webtools_plugins_loaded");

\TMA\ExperienceManager\Segment\SegmentType::getInstance()->register();
\TMA\ExperienceManager\Segment\SegmentEditor::getInstance()->register();

function tma_webtools_plugins_loaded() {
	tma_exm_log("load editor plugins");

	if (\TMA\ExperienceManager\Plugins::getInstance()->elementor()) {
		new \TMA\ExperienceManager\Elementor_Integration();
		//new \TMA\ExperienceManager\Elementor_Preview();
	}
	if (\TMA\ExperienceManager\Plugins::getInstance()->popup_maker()) {
		\TMA\ExperienceManager\TMA_PopupMakerIntegration::getInstance()->init();
	}
	if (\TMA\ExperienceManager\Plugins::getInstance()->advanced_ads()) {
		\TMA\ExperienceManager\TMA_AdvancedAdsIntegration::getInstance()->init();
	}
	if (\TMA\ExperienceManager\Plugins::getInstance()->gutenberg()) {
		new \TMA\ExperienceManager\Gutenberg_Integration();
	}

	if (\TMA\ExperienceManager\Plugins::getInstance()->beaverBuilder()) {
		new \TMA\ExperienceManager\BeaverBuilder_Integration();
		//\TMA\TMA_BeaverBuilderPreview::getInstance()->init();
	}
}

function tma_webtools_rest_init() {
	$tma_rest = new \TMA\ExperienceManager\TMA_Rest();

//	register_rest_route('experience-manager/v1', '/test', array(
//			'methods' => \WP_REST_Server::READABLE,
//			'callback' => function () {
//				return "test";
//		
//			},
//	));
}

function tma_webtools_init() {

	tma_exm_log("init");
	wp_register_style('experience-manager', plugins_url('css/experience-manager.css', __FILE__));
	wp_enqueue_style('experience-manager');
	// has to be global
	// Settings
//	require_once 'includes/frontend/class.tma_script_helper.php';
	require_once 'includes/frontend/class.shortcode_tma_content.php';
	require_once 'includes/frontend/template_tags.php';

	new TMA\ExperienceManager\TMA_Widget_Targeting();

	require_once 'includes/modules/events/class.ecommerce_events.php';

	tma_exm_log(is_preview() ? "preview" : "no preview");
	tma_exm_log(tma_exm_is_preview() ? "tma_preview" : "no tma_preview");

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

	add_action('wp_head', 'tma_webtools_hook_js');
	add_action('wp_head', 'tma_js_variables', -100);
	add_action('admin_head', 'tma_js_variables', -100);

	tma_init_cookie();
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
	
//	$data = "var TMA_CONFIG = ". json_encode($tma_config);
//	wp_register_script( 'webtools-dummy-handle', '' );
//	wp_enqueue_script( 'webtools-dummy-handle' );
//	wp_add_inline_script( 'webtools-dummy-handle', $data );
	?>
	<script type='text/javascript'>
		var TMA_CONFIG = <?php echo json_encode($tma_config); ?>;
	</script><?php
}

function tma_webtools_hook_js() {
	$scriptHelper = new \TMA\ExperienceManager\TMAScriptHelper();
	wp_enqueue_script( "webtools-library", $scriptHelper->getLibrary(), [], "2.0.0", false );
	wp_add_inline_script( "webtools-library", $scriptHelper->getCode());
}

function tma_init_cookie() {
	\TMA\ExperienceManager\TMA_COOKIE_HELPER::getCookie(\TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_USER, \TMA\ExperienceManager\UUID::v4(), \TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE, true);
	\TMA\ExperienceManager\TMA_COOKIE_HELPER::getCookie(\TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_REQUEST, \TMA\ExperienceManager\UUID::v4(), \TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_REQUEST_EXPIRE, true);
	\TMA\ExperienceManager\TMA_COOKIE_HELPER::getCookie(\TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_VISIT, \TMA\ExperienceManager\UUID::v4(), \TMA\ExperienceManager\TMA_COOKIE_HELPER::$COOKIE_VISIT_EXPIRE, true);
}
