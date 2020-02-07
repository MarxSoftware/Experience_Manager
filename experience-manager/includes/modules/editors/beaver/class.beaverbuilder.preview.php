<?php

namespace TMA\ExperienceManager\Beaver;

/**
 * Handles the revisions UI for the builder.
 *
 * @since 2.0
 */
final class BeaverBuilder_Preview {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 2.0
	 * @return void
	 */
	public function init() {
		add_filter('fl_builder_ui_bar_buttons', array($this, "ui_bar_config"));
	}

	function ui_bar_config($buttons) {
		$buttons["tma-targeting"] = array(
			'label' => __('Audience', 'tma-webtools'),
			'show' => true,
		);
		$buttons["tma-highlight"] = array(
			'label' => __('Highlight', 'tma-webtools'),
			'show' => true,
		);

		return $buttons;
	}
}

add_action('wp_enqueue_scripts', function () {
	if (tma_exm_is_debug()) {
		wp_enqueue_script('tma-beaver-audiences', TMA_EXPERIENCE_MANAGER_URL . 'assets/beaver/audiences.js', array("fl-builder", "tma-webtools-backend"), "1");
	} else {
		wp_enqueue_script('tma-beaver-audiences', TMA_EXPERIENCE_MANAGER_URL . 'assets/beaver/audiences.js', array("fl-builder-min", "tma-webtools-backend"), "1");
	}
	
	wp_enqueue_style('tma-beaver-audiences', TMA_EXPERIENCE_MANAGER_URL . 'assets/beaver/beaver.css', array(), "1");
});