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
class ContentAjax {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function __construct() {
		
	}

	private static $engine;

	public function register() {
		self::$engine = new \Mustache_Engine();
		add_action('wp_ajax_exm_user', array($this, 'exm_user'));
		add_action('wp_ajax_nopriv_exm_user', array($this, 'exm_user'));

		add_action('wp_ajax_exm_content', array($this, 'exm_content'));
		add_action('wp_ajax_nopriv_exm_content', array($this, 'exm_content'));

		add_action('wp_ajax_exm_random_products', array($this, 'exm_random_products'));
	}

	public function exm_random_products() {
		$count = filter_input(INPUT_POST, 'count', FILTER_DEFAULT);
		if ($count === FALSE || $count === NULL) {
			$count = 3;
		} else {
			$count = intval($count);
		}
		$products = [];
		if (\TMA\ExperienceManager\Plugins::getInstance()->woocommerce()) {
			$ecom = new \TMA\ExperienceManager\Modules\ECommerce\Ecommerce_Woo();
			$products = $ecom->random_products($count);
		}

		wp_send_json($products);
	}

	public function exm_content() {
		$response = [];

		$content_id = FALSE;
		$post_id = FALSE;
		if ($_POST['id']) {
			$content_id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
		}
		if ($_POST['post_id']) {
			$post_id = filter_input(INPUT_POST, 'post_id', FILTER_DEFAULT);
		}
		if (!$content_id) {
			$response["error"] = true;
			$response["message"] = __("No flex content id", "tma-webtools");

			wp_send_json($response);
		}

		$settings_string = get_post_meta($content_id, 'exm_content_settings', true);
		$settings = json_decode($settings_string);

		$html = get_post_meta($content_id, 'exm_content_editor_html', true);
		$css = get_post_meta($content_id, 'exm_content_editor_css', true);
		$js = get_post_meta($content_id, 'exm_content_editor_js', true);

		$response["html"] = $this->compile_template($html, $settings, $content_id, $post_id);
		$response["js"] = $this->compile_template($js, $settings, $content_id, $post_id);
		$response["css"] = $this->compile_template($css, $settings, $content_id, $post_id);
		$response["error"] = false;

		wp_send_json($response);
	}

	public function exm_user() {
		wp_send_json($this->get_user());
	}

	private function get_user() {
		$user = [
			"logged_in" => is_user_logged_in(),
			"segments" => tma_exm_get_user_segments()
		];

		return $user;
	}

	private function get_context($settings, $content_id, $post_id) {
		$context = [
			"user" => $this->get_user(),
			"content_id" => $content_id,
			"unique_id" => uniqid()
		];
		tma_exm_log("settings: " . json_encode($settings));
		if ($settings->recommendation && $settings->recommendation->enabled) {
			$context["recommendation"] = $this->get_recommendations($settings->recommendation->type, $settings->recommendation->count, $post_id);
//			$context["recommendation"] = [];
		}

		return $context;
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

	private function compile_template($template, $settings, $content_id, $post_id) {


		$context = $this->get_context($settings, $content_id, $post_id);

		return self::$engine->render($template, $context);
	}

}
