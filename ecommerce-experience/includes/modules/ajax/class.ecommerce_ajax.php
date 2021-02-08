<?php

namespace TMA\ExperienceManager\Modules\Ajax;

/**
 * Description of class
 *
 * @author marx
 */
class EcommerceAjax {

	public function __construct() {
		tma_exm_log("init ajax");
		add_action("wp_ajax_nopriv_exm_ecom_load_products_html", [$this, "ajax_load_products_html"]);
		add_action("wp_ajax_exm_ecom_load_products_html", [$this, "ajax_load_products_html"]);
		add_action("wp_ajax_nopriv_exm_ecom_load_products", [$this, "ajax_load_products"]);
		add_action("wp_ajax_exm_ecom_load_products", [$this, "ajax_load_products"]);
	}

	public function ajax_load_products_html() {
		$type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);
		$count = filter_input(INPUT_POST, 'size', FILTER_DEFAULT);
		$resolution = filter_input(INPUT_POST, 'resolution', FILTER_DEFAULT);
		$template = filter_input(INPUT_POST, 'template', FILTER_DEFAULT);
		$title = filter_input(INPUT_POST, 'title', FILTER_DEFAULT);
		$product = filter_input(INPUT_POST, 'product', FILTER_DEFAULT);
		$category = filter_input(INPUT_POST, 'category', FILTER_DEFAULT);


		tma_exm_log("load products: " . $type);

//		if ($count === FALSE || $count === NULL) {
//			$count = 3;
//		} else {
//			$count = intval($count);
//		}

		try {
//			$products = Ecommerce_Woo::instance()->bought_together($product);
			$args = [];
//			$args['related_products'] = $products;
			$args['heading'] = $title;

			$engine = Recommendation_Engine::create_instance($type, $count, $resolution, $category, $product);
			$content = $engine->render_template($template, $args);
			
			$response = [];
			$response["error"] = false;
			$response['content'] = $content;

			wp_send_json($response);
		} catch (Exception $ex) {
			$response = [
				"error" => true,
				"message" => $ex->getMessage()
			];
			wp_send_json($response);
		}
	}

	public function ajax_load_products() {
		$type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);
		$count = filter_input(INPUT_POST, 'count', FILTER_DEFAULT);
		$resolution = filter_input(INPUT_POST, 'resolution', FILTER_DEFAULT);
		$template = filter_input(INPUT_POST, 'template', FILTER_DEFAULT);
		$title = filter_input(INPUT_POST, 'title', FILTER_DEFAULT);


		tma_exm_log("load products: " . $type);

		if ($count === FALSE || $count === NULL) {
			$count = 3;
		} else {
			$count = intval($count);
		}

		try {
			$recentlyViewedProducts = [];
			$frequentlyPurchasedProducts = [];
			if ($type === "recently-viewed-products") {
				$recentlyViewedProducts = Ajax_Woo::instance()->recently_viewed($count);
			}

			$response["recentlyViewedProducts"] = $recentlyViewedProducts;
			$response["frequentlyPurchasedProducts"] = $frequentlyPurchasedProducts;
			$response["error"] = false;
			wp_send_json($response);
		} catch (Exception $ex) {
			$reponse = [
				"error" => true,
				"message" => $ex->getMessage()
			];
			wp_send_json($response);
		}
	}

}
