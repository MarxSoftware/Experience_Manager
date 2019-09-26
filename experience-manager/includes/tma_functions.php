<?php

function tma_exm_get_segments() {
	$request = new \TMA\ExperienceManager\TMA_Request();
	$response = $request->getAllSegments();
	if ($response !== NULL && $response->status === "ok") {
		return $response->segments;
	}

	return FALSE;
}

function tma_exm_get_segments_as_array2() {
	$segments = [];

	$response_segments = tma_exm_get_segments();
	if ($response_segments !== FALSE) {
		foreach ($response_segments as $segment) {
			$segments[] = (object) [
						'id' => $segment->id,
						'name' => $segment->name
			];
		}
	}

	return $segments;
}

function tma_exm_get_segments_as_array() {

	$segments = wp_cache_get('tma_webtools_get_segments_as_array');
	if (false === $segments) {
		$segments = [];

		$args = array('post_type' => \TMA\ExperienceManager\Segment\SegmentType::$TYPE, 'orderby' => 'title');
		$loop = new WP_Query($args);

		foreach ($loop->posts as $post) {
			$segments[] = (object) [
						'id' => $post->ID,
						'name' => $post->post_title
			];
		}

		wp_cache_set('tma_webtools_get_segments_as_array', $segments, "", 5);
	}
	return $segments;
}

function tma_exm_get_segments_as_array_flat() {
	$segments = [];

	$segments_objects = tma_exm_get_segments_as_array();
	foreach ($segments_objects as $segment) {
		$segments[$segment->id] = $segment->name;
	}

	return $segments;
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

function tma_exm_is_elementor_preview() {
	if (class_exists('\Elementor\Plugin')) {
//return \Elementor\Plugin::$instance->preview->is_preview_mode();
		return isset($_GET['preview_nonce']);
	}

	return false;
}

function tma_exm_is_beaver_preview() {
	return \TMA\ExperienceManager\Plugins::getInstance()->beaverBuilder() && \FLBuilderModel::is_builder_active();
}

function tma_exm_is_elementor_active () {
	return \TMA\ExperienceManager\Plugins::getInstance()->elementor() 
			&& (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode());
}

function tma_exm_is_editor_active() {
	if (isset($_GET['action'])  && ($_GET['action'] === 'edit')) { // || $_GET['action'] === 'elementor')
		tma_exm_log("editor is active gutenberg");
		return true;
	} else if (tma_exm_is_elementor_active()) {
		tma_exm_log("editor is active elementor");
		return true;
	} else if(tma_exm_is_beaver_preview()) {
		tma_exm_log("editor is active beaver");
		return true;
	}
	
	return false;
}

function tma_exm_is_frontend_mode_enabled() {
	$options = get_option('tma_webtools_option_targeting');
	if ($options !== false && is_array($options) && array_key_exists("webtools_backend_mode", $options)) {
		return !$options['webtools_backend_mode'] === "on";
	} else {
		return true;
	}
}

/**
 * the WP is_preivew did not always return the correct value
 * 
 * @return true if in preview otherwise false
 */
function tma_exm_is_preview() {
	return is_preview() || (isset($_GET['preview']) && $_GET['preview'] == true) || tma_exm_is_elementor_preview();
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