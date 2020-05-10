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
class ContentShortCode {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function register() {
		add_shortcode('exm_content', [$this, 'exm_content']);
	}

	public function exm_content($args) {
		if (!array_key_exists("id", $args)) {
			return "";
		}

		$content = new Flex_Content($args["id"]);
		$settings = $content->get_settings();

		$current_id = get_the_ID();
		$frontpage = is_front_page() ? "true" : "false";
		$html = "<div data-exm-flex-content='${args["id"]}' data-exm-current-id='${current_id}' data-exm-frontpage='${frontpage}'>";

		if (property_exists($settings, "loading") && $settings->loading->animation === true) {
			$html .= "<div class='spinner'>
					<div class='rect1' style='background-color: {$settings->loading->color};'></div>
					<div class='rect2' style='background-color: {$settings->loading->color};'></div>
					<div class='rect3' style='background-color: {$settings->loading->color};'></div>
					<div class='rect4' style='background-color: {$settings->loading->color};'></div>
					<div class='rect5' style='background-color: {$settings->loading->color};'></div>
				</div>";
		}

		$html .= "</div>";

		return $html;
	}

}
