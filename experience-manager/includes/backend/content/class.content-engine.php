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
class Flex_Content_Engine {

	private static $engine;
	
	var $content;
	var $context = null;
	var $settings = null;

	public function __construct(Flex_Content $content_object) {
		self::$engine = new \Mustache_Engine();
		$this->content = $content_object;
	}

	public function get_compiled_html($post_id) {
		$html = $this->content->get_meta_editor_html();
		return $this->compile_template($html, $post_id);
	}

	public function get_compiled_js($post_id) {
		$html = $this->content->get_meta_editor_js();
		return $this->compile_template($html, $post_id);
	}

	public function get_compiled_css($post_id) {
		$html = $this->content->get_meta_editor_css();
		return $this->compile_template($html, $post_id);
	}

	private function get_settings_json() {
		if ($this->settings == null) {
			$this->settings = json_decode($this->content->get_meta_settings());
		}
		return $this->settings;
	}

	private function get_user() {
		$user = [
			"logged_in" => is_user_logged_in(),
			"segments" => tma_exm_get_user_segments()
		];

		return $user;
	}

	private function get_context($post_id) {
		$settings = $this->get_settings_json();
		if ($this->context == null) {
			$this->context = [
				"user" => $this->get_user(),
				"content_id" => $this->content->get_id(),
				"unique_id" => uniqid()
			];
			if ($settings->recommendation && $settings->recommendation->enabled) {
				$this->context["recommendation"] = $this->get_recommendations($settings->recommendation->type, $settings->recommendation->count, $post_id);
			}
		}

		return $this->context;
	}

	private function get_recommendations($type, $count, $post_id) {
		if (!\TMA\ExperienceManager\Plugins::getInstance()->woocommerce()) {
			return [];
		}
		$ecom = new \TMA\ExperienceManager\Modules\ECommerce\Ecommerce_Woo();
		switch ($type) {
			case "recently_viewed":
				return $ecom->recently_viewed($count);
			case "frequently_purchased":
				return $ecom->recently_viewed($count);
			case "popular":
				return $ecom->popular_products($count);
			case "bought_together":
				return $ecom->bought_together($post_id, $count);
			case "similar_user":
				return $ecom->similar_user($count);
			default:
				return [];
		}
	}

	private function compile_template($template, $post_id) {
		$context = $this->get_context($post_id);
		return self::$engine->render($template, $context);
	}

}
