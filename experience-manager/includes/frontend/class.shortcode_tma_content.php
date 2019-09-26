<?php

/*
 * Copyright (C) 2016 marx
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace TMA\ExperienceManager;

class ShortCode_TMA_CONTENT {
	/*
	 * user must be in one of the segments
	 */

	public static $match_mode_any = TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_ANY; // 'any';

	/**
	 *
	 * user must be in all of the segments
	 */
	public static $match_mode_all = TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_ALL; //'all';
	/**
	 *
	 * user should match none of the segments
	 */
	public static $match_mode_none = TMA_EXPERIENCE_MANAGER_SEGMENT_MATCHING_NONE; //'none';
	
	public static $delimiter = ',';
	private static $contentGroups = array();
	private $options;
	private $options_targeting;
	private $onlySingleItemPerGroup = true;

	/**
	 * Start up
	 */
	public function __construct() {

		$this->options = get_option('tma_webtools_option');
		$this->options_targeting = get_option('tma_webtools_option_targeting');
		if ($this->options_targeting !== false && is_array($this->options_targeting) && array_key_exists("webtools_shortcode_single_item_per_group", $this->options_targeting)) {
			$this->onlySingleItemPerGroup = $this->options_targeting['webtools_shortcode_single_item_per_group'];
		}

		add_shortcode('tma_content', array($this, 'tma_content_shortcode'));
	}

	public function tma_content_shortcode($atts, $content = null) {
		if ($content == null) {
			return '';
		}
		$a = shortcode_atts(array(
			'segments' => '',
			'mode' => 'any',
			'group' => 'default',
			'default' => false,
				), $atts);


		$attrs = [];
		$attrs["data-tma-personalization"] = "enabled";
		$attrs["data-tma-matching"] = $a['mode'];
		$attrs["data-tma-group"] = $settings['group'];
		$attrs["data-tma-default"] = $settings['default'];
		$attrs["data-tma-segments"] = $a['segments'];
		$attrs["style"] = "padding:0;margin:0;";

		if (tma_exm_is_frontend_mode_enabled()) {
			if ($settings['tma_default'] === "no") {
				$attrs["class"] = 'tma-hide';
			}
		}

		$output = "<div ";
		foreach ($attrs as $key => $value) {
			$output .= $key . '="' . $value . '" ';
		}
		$output .= ">" . $content . "</div>";

		/*
		 * If the frontend mode is enabled all the logic is done via javascript in the client,
		 * we just have to add the data attributes
		 */
		if (tma_exm_is_frontend_mode_enabled()) {
			return do_shortcode($output);
		}


		$attr_segments = explode(",", $a['segments']);
		if ($a['segments'] === '' && !empty($atts)) {
			$attr_segments = [];
			foreach ($atts as $key => $value) {
				if (!empty($atts[$key]) && TMAScriptHelper::startsWith($key, "tma_segment_")) {
					$attr_segments[] = substr($key, 12);
				}
			}
		}

		$uid = TMA_COOKIE_HELPER::getCookie(TMA_COOKIE_HELPER::$COOKIE_USER, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE);
		$request = new TMA_Request();
		$response = $request->getSegments($uid);

		$segments = array();
		$segments[] = "default";
		if ($response !== NULL) {
			if (sizeof($response->user->segments) > 0) {
				$segments = $response->user->segments;
			}
		}

		// content for group allready added
		if ($this->contentAdded($a['group']) === true && $this->onlySingleItemPerGroup === true) {
			return '';
		}
		// no content added and this ist the default
		if ($a['default'] === true || $a['default'] === 'true') {
			return do_shortcode($content);
		}

		$matching = false;
		$segments = array_map('trim', $segments);
		$attr_segments = array_map('trim', $attr_segments);
		if ($a['mode'] === self::$match_mode_all) {
			$matching = $this->matching_mode_all($segments, $attr_segments);
		} else if ($a['mode'] === self::$match_mode_any) {
			$matching = $this->matching_mode_any($segments, $attr_segments);
		} else if ($a['mode'] === self::$match_mode_none) {
			$matching = !$this->matching_mode_any($segments, $attr_segments);
		}

		if (!$matching) {
			return '';
		} else {
			
		}
		// content is added
		self::$contentGroups[$a['group']] = true;
		return do_shortcode($content);
	}

	private function contentAdded($group) {
		if (array_key_exists($group, self::$contentGroups)) {
			return self::$contentGroups[$group];
		}
		return false;
	}

	/**
	 * 
	 * @param array $usersSegments
	 * @param array $tagSegments
	 * @return boolean
	 */
	public static function matching_mode_all($usersSegments, $tagSegments) {
		return array_diff($usersSegments, $tagSegments) === array_diff($tagSegments, $usersSegments);
	}

	/**
	 * 
	 * @param array $usersSegments
	 * @param array $tagSegments
	 * @return boolean
	 */
	public static function matching_mode_any($usersSegments, $tagSegments) {
		return array_diff($usersSegments, $tagSegments) !== $usersSegments;
	}

}

$tma_content_shortcode = new ShortCode_TMA_CONTENT();
