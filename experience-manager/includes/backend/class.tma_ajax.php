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
class TMA_Backend_Ajax {

	public function __construct() {
		add_action('wp_ajax_tma_post_types', array($this, 'tma_post_types'));
		add_action('wp_ajax_tma_post_search', array($this, 'tma_post_search'));
		add_action('wp_ajax_tma_product_categories', array($this, 'tma_product_categories'));
		add_action('wp_ajax_tma_categories', array($this, 'tma_categories'));

		add_action('wp_ajax_exm_dashboard_main', array($this, 'dashboard_main'));
	}

	function single_kpi () {
		
		$response = [];
		
		
		$kpi = FALSE;
		if ($_REQUEST['kpi']) {
			$kpi = filter_input(INPUT_REQUEST, 'KPI', FILTER_DEFAULT);
		}
		if ( !$kpi) {
			$response["error"] = true;
			$response["message"] = __("No kpi requested", "tma-webtools");
			
			wp_send_json($response);
		}
		
		$firstDay = new \DateTime('first day of this month 00:00:01');
		$lastDay = new \DateTime('first day of next month 23:59:59');
	}
	
	function dashboard_main() {
		$response = [];
		$response["error"] = false;

		$start_date = date_create();
		$end_date = date_create();
		$x_var = [];
		$x_var[] = "x";
		for ($i = 1; $i <= 12; $i++) {
			date_sub($end_date, date_interval_create_from_date_string('1 months'));
			$x_var[] = date_format($end_date, 'm-Y');
		}
		
		$obj = (object) [
					'data1' => 'Order Conversions',
					'data2' => 'Abondend Carts'
		];
		$response["names"] = $obj;
		
		$response["data"] = [];
		$response["data"][] = $x_var;
		$response["data"][] = ['data1', 30, 200, 100, 400, 150, 250, 130, 340, 200, 500, 250, 350];
		$response["data"][] = ['data2', 130, 340, 200, 500, 250, 350, 30, 200, 100, 400, 150, 250];
		//date_timestamp_get($date);

		wp_send_json($response);
	}

	function tma_product_categories() {
		$parent = 0;
		if ($_GET['parent']) {
			$parent = filter_input(INPUT_GET, 'parent', FILTER_DEFAULT);
		}

		$args = array(
			'taxonomy' => "product_cat",
			'parent' => $parent,
			'hide_empty' => false
		);

		$cats = get_categories($args);

		echo json_encode($cats);

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	function tma_categories() {
		$parent = 0;
		if ($_GET['parent']) {
			$parent = filter_input(INPUT_GET, 'parent', FILTER_DEFAULT);
		}

		$args = array(
			'taxonomy' => "category",
			'parent' => $parent,
			'hide_empty' => false
		);

		$cats = get_categories($args);

		echo json_encode($cats);

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	function title_like_posts_where($where, &$wp_query) {
		global $wpdb;

		if ($search_term = $wp_query->get('post_title_like')) {
			/* using the esc_like() in here instead of other esc_sql() */
			$search_term = $wpdb->esc_like($search_term);
			$search_term = ' \'%' . $search_term . '%\'';
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE ' . $search_term;
		}

		return $where;
	}

	function tma_post_types() {
		$args = array(
			'public' => true,
			'_builtin' => true,
			'show_ui' => true
		);

		$output = 'objects'; // 'names' or 'objects' (default: 'names')
		$operator = 'and'; // 'and' or 'or' (default: 'and')

		$post_types = get_post_types($args, $output, $operator);
//		$post_types = $types = get_post_types( '', 'objects' );

		echo json_encode($post_types);

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	function tma_post_search() {
		$query = filter_input(INPUT_GET, 'query', FILTER_DEFAULT);
		$type = filter_input(INPUT_GET, 'type', FILTER_DEFAULT);

		$args = array(
			'post_title_like' => $query,
			'post_type' => $type,
		);
		add_filter('posts_where', array($this, 'title_like_posts_where'), 10, 2);
		$wp_query = new \WP_Query($args);
		remove_filter('posts_where', array($this, 'title_like_posts_where'), 10, 2);

		$result = [];

		while ($wp_query->have_posts()) {
			$wp_query->the_post();
			$post = [];
			$post['id'] = get_the_ID();
			$post['title'] = get_the_title();

			$result[] = $post;
		}
		wp_reset_query();

		echo json_encode($result);

		wp_die();
	}

}
