<?php

/**
 * Performs an add_filter only once. Helpful for factory constructors where an action only
 * needs to be added once. Because of this, there will be no need to do a static variable that
 * will be set to true after the first run, ala $firstLoad
 *
 * @since 1.9
 *
 * @param string   $tag             The name of the filter to hook the $function_to_add callback to.
 * @param callback $function_to_add The callback to be run when the filter is applied.
 * @param int      $priority        Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed. Default 10.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action.
 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
 *
 * @return true
 */
function add_filter_once( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
	global $_gambitFiltersRan;

	if ( ! isset( $_gambitFiltersRan ) ) {
		$_gambitFiltersRan = array();
	}

	// Since references to $this produces a unique id, just use the class for identification purposes
	$idxFunc = $function_to_add;
	if ( is_array( $function_to_add ) ) {
		$idxFunc[0] = get_class( $function_to_add[0] );
	}
	$idx = _wp_filter_build_unique_id( $tag, $idxFunc, $priority );

	if ( ! in_array( $idx, $_gambitFiltersRan ) ) {
		add_filter( $tag, $function_to_add, $priority, $accepted_args );
	}

	$_gambitFiltersRan[] = $idx;

	return true;
}


function exm_get_page_permalink( $page, $fallback = null ) {
	$page_id   = wc_get_page_id( $page );
	$permalink = 0 < $page_id ? get_permalink( $page_id ) : '';

	if ( ! $permalink ) {
		$permalink = is_null( $fallback ) ? get_home_url() : $fallback;
	}

	return apply_filters( 'exm_get_' . $page . '_page_permalink', $permalink );
}

function exm_get_template($template_name, $arguments) {
	// Set our template to be the override template in the theme.
	$tmpl = get_stylesheet_directory() . '/experience-manager/' . $template_name . ".php";

	if (!file_exists($tmpl)) {
		$tmpl = TMA_EXPERIENCE_MANAGER_DIR . 'templates/' . $template_name . ".php";
	}
	tma_exm_log("load template: " . $tmpl);
	extract($arguments);
	include $tmpl;
}

function exm_get_template_html($template_name, $arguments) {
	ob_start();
	exm_get_template($template_name, $arguments);
	return ob_get_clean();
}

function exm_get_userid() {
	return \TMA\ExperienceManager\TMA_Request::getUserID();
}

function tma_exm_get_site() {
	if (isset(get_option('tma_webtools_option')['webtools_siteid'])) {
		return get_option('tma_webtools_option')['webtools_siteid'];
	}
	return FALSE;
}

/*
 * debug method, used only for development
 */

function tma_exm_log($message) {
	if (!tma_exm_is_debug()) {
		return;
	}
	if (is_array($message)) {
		$message = implode("", $message);
	}
// open file
	$fd = fopen(TMA_EXPERIENCE_MANAGER_DIR . "/tma-webtools.log", "a");
// append date/time to message
	$str = "[" . date("Y/m/d h:i:s", time()) . "] " . $message;
// write string
	fwrite($fd, $str . "\n");
// close file
	fclose($fd);
}

function tma_exm_is_debug() {

	$debug = false;

	if (defined('WP_DEBUG') && WP_DEBUG) {
		$debug = true;
	}

	return $debug;
}

function tma_exm_is_editor_active() {
	if (isset($_GET['action']) && ($_GET['action'] === 'edit')) { // || $_GET['action'] === 'elementor')
		tma_exm_log("editor is active gutenberg");
		return true;
	} else if (tma_exm_is_elementor_active()) {
		tma_exm_log("editor is active elementor");
		return true;
	} else if (tma_exm_beaver_is_preview()) {
		tma_exm_log("editor is active beaver");
		return true;
	}

	return false;
}

function tma_exm_is_frontend_mode_enabled() {
	/*
	  $options = get_option('tma_webtools_option_targeting');
	  if ($options !== false && is_array($options) && array_key_exists("webtools_backend_mode", $options)) {
	  return !$options['webtools_backend_mode'] === "on";
	  } else {
	  return true;
	  }
	 */
	return true;
}

/**
 * the WP is_preivew did not always return the correct value
 * 
 * @return true if in preview otherwise false
 */
function tma_exm_is_preview() {
	return is_preview() || (isset($_GET['preview']) && $_GET['preview'] == true);
}

/**
 * in some cases the adminbar integration must be disabled.
 * 
 * 1. Beaver Builder is active
 * 
 * @return boolean
 */
function tma_exm_admin_bar_visible() {
	if (isset($_GET['fl_builder'])) {
		tma_exm_log("beaver enabled");
		return false;
	}

	return true;
}

function tma_startsWith($haystack, $needle) {
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

function tma_endsWith($haystack, $needle) {
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}

	return (substr($haystack, -$length) === $needle);
}
