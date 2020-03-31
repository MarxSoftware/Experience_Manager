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
	}

	public function exm_content() {
		$response = [];

		$content_id = FALSE;
		if ($_POST['id']) {
			$content_id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
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

		$response["html"] = $this->compile_template($html, $settings, $content_id);
		$response["js"] = $this->compile_template($js, $settings, $content_id);
		$response["css"] = $this->compile_template($css, $settings, $content_id);
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

	private function get_context ($settings, $id) {
		$context = [
			"user"			=>		$this->get_user(),
			"content_id"	=>		$id,
			"unique_id"		=>		uniqid()
		];
		if ($settings->recommendations) {
			$context["recommendation"] = [
				[
					"name" => "Turnschuh"
				],
				[
					"name" => "Handschuh"
				]
			];
		}
		
		return $context;
	}
	
	private function compile_template($template, $settings, $id) {
		

		$context = $this->get_context($settings, $id);
		
		return self::$engine->render($template, $context);
	}

}
