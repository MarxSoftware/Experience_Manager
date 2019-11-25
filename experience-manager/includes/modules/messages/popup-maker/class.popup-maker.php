<?php

namespace TMA\ExperienceManager;

/**
 * PopUpMaker Inteegration
 *
 * @since 2.0
 */
final class TMA_PopupMakerIntegration {

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
		add_action('wp_enqueue_scripts', function () {
			wp_enqueue_script('jquery');
		});
		add_filter('pum_get_conditions', array($this, "conditions"));
	}

	function visible($settings) {
		tma_exm_log("popup visible: " . json_encode($settings));

		return $this->matching($settings);
	}

	private function matching($settings) {

		if (!isset($settings['segments']) || !is_array($settings['segments'])) {
			$settings['segments'] = array();
		}

		$settings_segments = $settings['segments'];

		$uid = TMA_COOKIE_HELPER::getCookie(TMA_COOKIE_HELPER::$COOKIE_USER, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE);
		$request = new TMA_Request();
		$response = $request->getSegments($uid);

		$user_segments = [];
		if ($response !== NULL) {
			$user_segments = tma_exm_get_user_segments();
		}

		//$user_segments = array_map('trim', $user_segments);
		$settings_segments = array_map('trim', $settings_segments);
//		return ShortCode_TMA_CONTENT::matching_mode_all(ShortCode_TMA_CONTENT::array_flat($user_segments), $settings_segments);
		return tma_exm_array_match_all($settings_segments, $user_segments);
	}

	function conditions($conditions) {

		$segment_options = tma_exm_get_segments_as_array_flat();

		tma_exm_log("popup: " . json_encode($segment_options));

		return array_merge($conditions, array(
			'tma-personalization' => array(
				'group' => __('Experience Manager', 'tma-webtools'),
				'name' => __('Audience', 'tma-webtools'),
				'callback' => array($this, "visible"),
				'fields' => array(
					'segments' => array(
						'placeholder' => __('Segments', 'tma-webtools'),
						'type' => 'select',
						'multiple' => true,
						'select2' => true,
						'as_array' => true,
						'options' => $segment_options,
					),
				),
			),
		));
	}

}
