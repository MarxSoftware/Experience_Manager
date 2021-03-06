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
		return $this->render_template($html, $post_id);
	}

	public function get_compiled_js($post_id) {
		$html = $this->content->get_meta_editor_js();
		return $this->render_template($html, $post_id);
	}

	public function get_compiled_css($post_id) {
		$html = $this->content->get_meta_editor_css();
		return $this->render_template($html, $post_id);
	}

	private function get_settings() {
		if ($this->settings == null) {
			$this->settings = $this->content->get_settings();
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
		$settings = $this->get_settings();
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
		$ecom = \TMA\ExperienceManager\Modules\Ajax\Ajax_Woo::instance();
		switch ($type) {
			case "recently-viewed":
				return $ecom->recently_viewed($count);
			case "frequently-purchased":
				return $ecom->frequently_purchased($count);
			case "popular":
				return $ecom->popular_products($count);
			case "bought-together":
				return $ecom->bought_together($post_id, $count);
			case "similar-user":
				return $ecom->similar_user($count);
			case "most-viewed":
				return $ecom->most_viewed($count);
			default:
				return [];
		}
	}

	private function render_template($template, $post_id) {
		$context = $this->get_context($post_id);
		$rendered_html = self::$engine->render($template, $context);
		
		if (property_exists($this->get_settings(), "shortcode") && $this->get_settings()->shortcode) {
			$rendered_html = do_shortcode($rendered_html);
		}
		
		return $rendered_html;
	}

}
