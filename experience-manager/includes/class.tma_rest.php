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
		register_rest_route('experience-manager/v1', '/segments', array(
			'methods' => \WP_REST_Server::READABLE,
			'callback' => array($this, 'segments'),
		));
		
		register_rest_route('experience-manager/v1', '/events', array(
			'methods' => \WP_REST_Server::READABLE,
			'callback' => array($this, 'events'),
		));
		
		register_rest_route('experience-manager/v1', '/category-path', array(
			'methods' => \WP_REST_Server::READABLE,
			'callback' => array($this, 'category_path'),
		));
	}
	
	function category_path ($data) {
		$result = [];
		
		$result["path"] = "/" . get_term_parents_list($data['category'], $data['taxonomy'], ["format" => "slug", "link" => false, "inclusive" => true]);
		
		return $result;
	}
	
	/**
	 * returns all trackable events
	 * /wp-json/experience-manager/v1/events
	 * 
	 * @param type $data
	 * 
	 */
	function events ($data) {
		$events = [];
		$events[] = ["name" => "PageView", "id" => "pageview"];
		$events[] = ["name" => "Order", "id" => "ecommerce_order"];
		$events[] = ["name" => "CartItemAdd", "id" => "ecommerce_cart_item_add"];
		$events[] = ["name" => "CartItemRemove", "id" => "ecommerce_cart_item_remove"];
		
		$events = apply_filters("experience-manager/rest/events", $events);
		
		return ["events" => $events];
	}

	/**
	 * /wp-json/experience-manager/v1/segments
	 * 
	 * @param type $data
	 * @return type
	 */
	function segments($data) {

		$segments = [];

		$segments['segments'] = tma_exm_get_segments_as_array();
		
		$request = new \TMA\ExperienceManager\TMA_Request();
		$response = $request->getSegments(\TMA\ExperienceManager\TMA_Request::getUserID());
		if ($response !== NULL && $response->status === "ok" && $response->user->actionsSystem) {
			$segments['user_segments'] = $response->user->actionsSystem->segments;
		}

		return apply_filters("experience-manager/rest/segments", $segments);
	}

}

