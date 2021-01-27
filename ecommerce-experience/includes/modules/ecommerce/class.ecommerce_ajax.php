<?php

namespace TMA\ExperienceManager\Modules\ECommerce;

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
		$count = filter_input(INPUT_POST, 'count', FILTER_DEFAULT);
		$resolution = filter_input(INPUT_POST, 'resolution', FILTER_DEFAULT);
		$template = filter_input(INPUT_POST, 'template', FILTER_DEFAULT);
		$title = filter_input(INPUT_POST, 'title', FILTER_DEFAULT);
		$product = filter_input(INPUT_POST, 'product', FILTER_DEFAULT);


		tma_exm_log("load products: " . $type);

		if ($count === FALSE || $count === NULL) {
			$count = 3;
		} else {
			$count = intval($count);
		}

		try {
			$ecom = new \TMA\ExperienceManager\Modules\ECommerce\Ecommerce_Woo();
			$products = $ecom->bought_together($product);
			$args = [];
			$args['related_products'] = $products;
			$args['heading'] = $title;

			$response = [];
			$response["error"] = false;
			$response['content'] = exm_get_template_html($template, $args);

			wp_send_json($response);
		} catch (Exception $ex) {
			$reponse = [
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
				$ecom = new Ecommerce_Woo();
				$recentlyViewedProducts = $ecom->recently_viewed($count);
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
