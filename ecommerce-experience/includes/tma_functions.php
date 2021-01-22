<?php

function exm_get_userid () {
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
