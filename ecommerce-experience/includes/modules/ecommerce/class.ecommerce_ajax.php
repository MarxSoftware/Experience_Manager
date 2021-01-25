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
		add_action("wp_ajax_nopriv_exm_ecom_load_products", [$this, "ajax_load_products"]);
		add_action("wp_ajax_exm_ecom_load_products", [$this, "ajax_load_products"]);
	}

	public function ajax_load_products() {
		$type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);
		$count = filter_input(INPUT_POST, 'count', FILTER_DEFAULT);

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
