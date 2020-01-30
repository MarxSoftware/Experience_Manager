<?php

namespace TMA\ExperienceManager;

/**
 * Description of class
 *
 * @author marx
 */
abstract class Integration {

	private $onlySingleItemPerGroup = true;

	public function __construct() {
		$options = get_option('tma_webtools_option_targeting');
		if ($options !== false && is_array($options) && array_key_exists("webtools_shortcode_single_item_per_group", $options)) {
			$this->onlySingleItemPerGroup = $options['webtools_shortcode_single_item_per_group'];
		}
	}

	protected function isActivated($args) {
		return (is_array($args) 
		&& !empty($args['tma_personalization']) 
		&& $args['tma_personalization'] !== "np" 
		&& $args['tma_personalization'] !== "disabled"); 
	}

	protected function getGroup($args) {
		$group = 'default';

		if (is_array($args) && !empty($args['tma_group'])) {
			$group = $args['tma_group'];
		}

		return $group;
	}

	protected function isGroupDefault($args) {
		return (is_array($args) 
		&& !empty($args['tma_default']) 
		&& $args['tma_default'] !== "np" 
		&& $args['tma_default'] !== "disabled"); 
	}
	
	/**
	 * returns an array of the configured segments for the integration
	 */
	protected function getSegments ($args) {
		$attr_segments = [];
		if (array_key_exists("segments", $args)) {
			$attr_segments = explode(",", $args['segments']);
		} else if (array_key_exists("tma_segments", $args)) {
			$attr_segments = $args['tma_segments'];
		} else {
			foreach ($args as $key => $value) {
				if (!empty($args[$key]) && TMAScriptHelper::startsWith($key, "tma_segment_")) {
					$attr_segments[] = substr($key, 12);
				}
			}
		}
		
		return $attr_segments;
	}

	protected function matching($args) {

		$matching_mode = $args['tma_matching'];
		
		$attr_segments = $this->getSegments($args);

		$uid = \TMA\ExperienceManager\TMA_COOKIE_HELPER::getInstance()->getCookie(TMA_COOKIE_HELPER::$COOKIE_USER, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE);
		$request = new TMA_Request();
		$response = $request->getSegments($uid);
		
		$segments = ["default"];
		if ($response !== NULL) {
			$segments = tma_exm_get_user_segments(["default"]);
		}

		$matching = false;
//		$segments = array_map('trim', $segments);
		$attr_segments = array_map('trim', $attr_segments);
		if ($matching_mode === ShortCode_TMA_CONTENT::$match_mode_all) {
			$matching = tma_exm_array_match_all($attr_segments, $segments);
		} else if ($matching_mode === ShortCode_TMA_CONTENT::$match_mode_any) {
			$matching = tma_exm_array_match_any($attr_segments, $segments);
		} else if ($matching_mode === ShortCode_TMA_CONTENT::$match_mode_none) {
			$matching = !tma_exm_array_match_all($attr_segments, $segments);
		}

		return $matching;
	}

}
