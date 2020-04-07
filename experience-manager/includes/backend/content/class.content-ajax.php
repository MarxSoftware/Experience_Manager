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
