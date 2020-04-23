<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager\Content;

/**
 * Description of class
 *
 * @author marx
 */
class Flex_Content_Validator {

	var $content;
	var $post_id;
	var $frontpage;

	public function __construct(Flex_Content $content_object, $post_id, $frontpage) {
		$this->content = $content_object;
		$this->post_id = $post_id;
		$this->frontpage = $frontpage;
	}

	public function validate_conditions($features = []) {
		$conditions = $this->content->get_conditions();

		tma_exm_log("flex content validation " . $this->content->ID);
		if (in_array("weekday", $features) && !$this->validate_weekday($conditions)) {
			tma_exm_log("popup not display in current day");
			return false;
		}
		if (in_array("homepage", $features) && !$this->validate_homepage($conditions)) {
			tma_exm_log("popup just visible on homepage");
			return false;
		}
		if (in_array("post_type", $features) && !$this->validate_post_type($conditions)) {
			tma_exm_log("popup not visible on current post type");
			return false;
		}
		
		if (in_array("audience", $features) && !$this->validate_audience($conditions)) {
			tma_exm_log("popup not visible for current audiences");
			return false;
		}

		return true;
	}

	private function validate_audience($conditions) {
		if (!property_exists($conditions, "audiences") || !is_array($conditions->audiences)) {
			return true;
		}
		$audiences = $conditions->audiences;
		
		if (sizeof($audiences) === 0) {
			return true;
		}
		
		$matching_mode = $conditions->audiences_matching_mode;
		
		$user_segments = tma_exm_get_user_segments(["default"]);
		$matching = false;
		if ($matching_mode === \TMA\ExperienceManager\ShortCode_TMA_CONTENT::$match_mode_all) {
			$matching = tma_exm_array_match_all($audiences, $user_segments);
		} else if ($matching_mode === \TMA\ExperienceManager\ShortCode_TMA_CONTENT::$match_mode_any) {
			$matching = tma_exm_array_match_any($audiences, $user_segments);
		} else if ($matching_mode === \TMA\ExperienceManager\ShortCode_TMA_CONTENT::$match_mode_none) {
			$matching = !tma_exm_array_match_all($audiences, $user_segments);
		}

		return $matching;
	}

	private function validate_homepage($conditions) {
		if (!property_exists($conditions, "homepage")) {
			return true;
		}
		if ($conditions->homepage === true) {
			return filter_var($this->frontpage, FILTER_VALIDATE_BOOLEAN);
		}
		return true;
	}

	private function validate_post_type($conditions) {
		if (!property_exists($conditions, "post_types")) {
			return true;
		}
		$current_post_type = get_post_type($this->post_id);
		return in_array($current_post_type, $conditions->post_types);
	}

	private function validate_weekday($conditions) {
		if (!property_exists($conditions, "weekdays")) {
			return true;
		}
		$current_day_of_week = date('N');
		return in_array($current_day_of_week, $conditions->weekdays);
	}

}
