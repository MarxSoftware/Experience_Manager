<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager;

/**
 * Description of class
 *
 * @author marx
 */
class TMA_Rest {

	public function __construct() {
		$this->init_rest();
	}

	function init_rest() {
		register_rest_route('experience-manager/v1', '/recommendations', array(
			'methods' => \WP_REST_Server::READABLE,
			'callback' => array($this, 'recommendations'),
		));
	}

	/**
	 * /wp-json/experience-manager/v1/segments
	 * 
	 * @param type $data
	 * @return type
	 */
	function recommendations(\WP_REST_Request $request) {

		$type = $request->get_param('type');
		$count = $request->get_param('size');
		$resolution = $request->get_param('resolution');
		$template = $request->get_param('template');
		$title = $request->get_param('title');
		$product = $request->get_param('product');
		$category = $request->get_param('category');

		try {
			$id = uniqid();
			$args = [];
			$args['heading'] = $title;
			$args['id'] = $id;

			$engine = \TMA\ExperienceManager\Modules\Ajax\Recommendation_Engine::create_instance($type, $count, $resolution, $category, $product);
			$content = $engine->render_template($template, $args);

			$response = [];
			$response["error"] = false;
			$response['content'] = $content;
			$response['id'] = $id;
			$response['template'] = $template;

			return apply_filters("experience-manager/rest/recommendations", $response);
		} catch (Exception $ex) {
			$response = [
				"error" => true,
				"message" => $ex->getMessage()
			];
			return apply_filters("experience-manager/rest/recommendations", $response);
		}
	}

}
