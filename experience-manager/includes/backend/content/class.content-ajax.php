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

	public function register() {
		add_action('wp_ajax_exm_user', array($this, 'exm_user'));
		add_action('wp_ajax_nopriv_exm_user', array($this, 'exm_user'));

		add_action('wp_ajax_exm_content', array($this, 'exm_content'));
		add_action('wp_ajax_nopriv_exm_content', array($this, 'exm_content'));

		add_action('wp_ajax_exm_content_popups', array($this, 'load_popups'));
		add_action('wp_ajax_nopriv_exm_content_popups', array($this, 'load_popups'));

		add_action('wp_ajax_exm_random_products', array($this, 'exm_random_products'));
	}

	public function load_popups() {

		$post_id = FALSE;
		$frontpage = FALSE;
		if (array_key_exists('post_id', $_POST)) {
			$post_id = filter_input(INPUT_POST, 'post_id', FILTER_DEFAULT);
		}
		if (array_key_exists('frontpage', $_POST)) {
			$frontpage = filter_input(INPUT_POST, 'frontpage', FILTER_DEFAULT);
		}

		$args = array(
			'post_type' => array('exm_content'),
			'meta_key' => 'exm_content_type',
			'meta_value' => 'popup',
			'orderby' => 'rand',
			'order' => 'desc',
			'posts_per_page' => 1000
		);

		$post_list = get_posts($args);

		$popups = [];
		foreach ($post_list as $post) {
			$content = new Flex_Content($post->ID);
			
			$validator = new Flex_Content_Validator($content, $post_id, $frontpage);
			if (!$validator->validate_conditions()) {
				continue;
			}
			
			$content_engine = new Flex_Content_Engine($content);

			$popup_content = "<style>" . $content_engine->get_compiled_css($post_id) . "</style>";
			$popup_content .= $content_engine->get_compiled_html($post_id);
			$popup_content .= "<script>" . $content_engine->get_compiled_js($post_id) . "</script>";

			$popup = [
				"id" => $popup->get_id(),
				"content" => $popup_content,
				"settings" => $content->get_settings()
			];
			$popups[] = $popup;
		}
		$response = [
			"error" => false,
			"popups" => $popups
		];
		wp_send_json($response);
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

		$content = new Flex_Content($content_id);
		$content_engine = new Flex_Content_Engine($content);

		$response["html"] = $content_engine->get_compiled_html($post_id);
		$response["js"] = $content_engine->get_compiled_js($post_id);
		$response["css"] = $content_engine->get_compiled_css($post_id);
		$response["error"] = false;

		wp_send_json($response);
	}

	public function exm_user() {
		wp_send_json($this->get_user());
	}

}
