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

		tma_exm_log("register backend ajax");

		add_action('wp_ajax_exm_get_products', array($this, 'exm_get_products'));
	}

	function exm_get_products() {
		tma_exm_log("exm_get_products");
		$page = 0;
		if ($_POST['page']) {
			$page = filter_input(INPUT_POST, 'page', FILTER_DEFAULT);
		}

		$args = array(
			'post_type' => "product",
			'post_status' => 'any',
			'posts_per_page' => 10,
			'paged' => $page,
		);
		$wp_query = new \WP_Query($args);

		$result = [];
		$result["products"] = [];

		$result["page"] = $page;
		$result["total_pages"] = $wp_query->max_num_pages;

		while ($wp_query->have_posts()) {
			$wp_query->the_post();
			$post = [];
			$post['id'] = get_the_ID();
			$post['title'] = get_the_title();

			$product = wc_get_product(get_the_ID());
			$terms = get_the_terms($product->get_id(), 'product_cat');
			$post['ecom_categories'] = [];
			$ecom_categories_parents = [];
			if ($terms) {
				foreach ($terms as $term) {
					$post['ecom_categories'][] = $term->term_id;
					
					$cat_result = TMAScriptHelper::custom_get_term_parents_list($term->term_id, "product_cat", []);
					$ecom_categories_parents = array_merge($ecom_categories_parents, $cat_result["parents"]);
				}
			}
			$post['ecom_categories_parents'] = array_unique($ecom_categories_parents);
			$post['ecom_categories_all'] = array_unique(array_map("strval", array_merge($post['ecom_categories'], $ecom_categories_parents)));

			$result["products"][] = $post;
		}
		wp_reset_query();

		wp_send_json($result);
	}

}
