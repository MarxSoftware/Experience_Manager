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

	public function validate_conditions() {
		$conditions = $this->content->get_conditions();

		if (!$this->validate_weekday($conditions)) {
			return false;
		}
		if (!$this->validate_homepage($conditions)) {
			return false;
		}
		if (!$this->validate_post_type($conditions)) {
			return false;
		}

		return true;
	}

	private function validate_homepage($conditions) {
		if (property_exists($conditions, "homepage")) {
			if ($conditions->homepage) {
				return filter_var($this->frontpage, FILTER_VALIDATE_BOOLEAN);
				;
			}
		}
		return true;
	}

	private function validate_post_type($conditions) {
		if (property_exists($conditions, "post_types")) {
			$current_post_type = get_post_type($this->post_id);
			return in_array($current_post_type, $conditions->post_types);
		}
		return true;
	}

	private function validate_weekday($conditions) {
		if (property_exists($conditions, "weekdays")) {
			$current_day_of_week = date('N');
			return in_array($current_day_of_week, $conditions->weekdays);
		}
		return true;
	}

}
