<?php

namespace TMA\ExperienceManager\Modules\Ajax;

/**
 * Description of class
 *
 * @author marx
 */
abstract class Ajax_Base {

	public $options;
	
	public function __construct() {
		//add_action("wp_ajax_nopriv_exm_ecom_load_products", [$this, "ajax_load_products"]);
		//add_action("wp_ajax_exm_ecom_load_products", [$this, "ajax_load_products"]);
	
		$this->options = new \TMA\ExperienceManager\Options('exm_options_recommendations');
	}

	public function ajax_load_products() {
		$type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);
		$count = filter_input(INPUT_POST, 'count', FILTER_DEFAULT);

		if ($count === FALSE || $count === NULL) {
			$count = 3;
		} else {
			$count = intval($count);
		}

		try {
			$recentlyViewedProducts = [];
			$frequentlyPurchasedProducts = [];
			if ($type === "recently-viewed-products") {
				$recentlyViewedProducts = $this->recently_viewed($count);
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

	protected abstract function _load_product($product_id);

	protected abstract function _random_products($count, $category="none");

	protected abstract function _popular_products($count);

	protected abstract function _map_product($product);

	public function random_products($count, $category="none") {
		$products = $this->_random_products($count, $category);
		$result = [];
		foreach ($products as $product) {
			$prod = $this->_load_product($product->ID);
			if ($prod !== FALSE) {
				$result[] = $prod;
			}
		}
		return $result;
	}

	protected function load_products($exp_products) {
		$products = [];
		foreach ($exp_products as $product) {
			$prod = $this->_load_product($product->id);
			if ($prod !== FALSE) {
				$products[] = $prod;
			}
		}
		return $products;
	}

	protected function update_products(&$products, $count, $category="none") {
		if (!$this->options->is_toggle_on('add_random_products')) {
			tma_exm_log("do not fill up with random products");
			return;
		}
		
		$popular = $this->_popular_products($count - sizeof($products), $category);
		foreach ($popular as $product) {
			$products[] = $this->_load_product($product->ID);
		}
		if (sizeof($products) < $count) {
			$random = $this->random_products($count - sizeof($products), $category);
			foreach ($random as $product) {
				$products[] = $this->_load_product($product->ID);
			}
		}
	}

	public function popular_products($count = 3, $category="none", $resolution="ALL") {
		$values = $this->shop_profile($count, $category, $resolution);

		$products = [];
		if (!$values) {
			
		} else {
			if (property_exists($values, "popularProducts")) {
				$products = $this->load_products($values->popularProducts);
			}
		}
		
		if (sizeof($products) < $count) {
			$this->update_products($products, $count, $category);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}

	public function recently_viewed($count = 3, $category="none", $resolution="ALL") {
		$values = $this->user_profile($count, $category, $resolution);

		
		$products = [];
		if (!$values) {
			tma_exm_log("no values");
		} else {
			tma_exm_log("values");
			if (property_exists($values, "recentlyViewedProducts")) {
				$products = $this->load_products($values->recentlyViewedProducts);
			}
		}

		if (sizeof($products) < $count) {
			$this->update_products($products, $count, $category);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}
	
	public function most_viewed($count = 3, $category="none", $resolution="ALL") {
		$values = $this->user_profile($count, $category, $resolution);

		
		$products = [];
		if (!$values) {
			
		} else {
			
			if (property_exists($values, "mostViewedProducts")) {
				$products = $this->load_products($values->mostViewedProducts);
			}
		}

		if (sizeof($products) < $count) {
			$this->update_products($products, $count, $category);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}

	public function frequently_purchased($count = 3, $category="none", $resolution="ALL") {
		$values = $this->user_profile($count, $category, $resolution);

		$products = [];
		if (!$values) {
			
		} else {
			if (property_exists($values, "frequentlyPurchasedProducts")) {
				$products = $this->load_products($values->frequentlyPurchasedProducts);
			}
		}

		if (sizeof($products) < $count) {
			$this->update_products($products, $count, $category);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}

	public function bought_together($product_id, $count = 3) {
		
		tma_exm_log("bought_together for product: " . $product_id);
		
		$values = $this->recommendations_bought_together($product_id);

		
		
		$products = [];
		if (!$values) {
			
		} else {
			if (property_exists($values, "bought_together")) {
				$products = $this->load_products($values->bought_together);
			}
		}
		
		if (sizeof($products) < $count) {
			$this->update_products($products, $count);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}
	
	public function viewed_together($product_id, $count = 3) {
		
		tma_exm_log("viewed_together for product: " . $product_id);
		
		$values = $this->recommendations_viewed_together($product_id);

		
		
		$products = [];
		if (!$values) {
			
		} else {
			if (property_exists($values, "viewed_together")) {
				$products = $this->load_products($values->bought_together);
			}
		}
		
		if (sizeof($products) < $count) {
			$this->update_products($products, $count);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}

	public function similar_user($count = 3) {
		$values = $this->recommendations_similar_users();

		$products = [];
		if (!$values) {
			
		} else {
			if (property_exists($values, "similar_users")) {
				$products = $this->load_products($values->similar_users);
			}
		}

		if (sizeof($products) < $count) {
			$this->update_products($products, $count);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}

	private function shop_profile($count, $category, $resolution) {
		$parameters = [
			"query" => [
				"userid" => exm_get_userid(),
				"site" => tma_exm_get_site(),
				"count" => $count,
				"category" => $category,
				"resolution" => $resolution
			]
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->get_body_object("json/profiles/shop", $parameters);
	}

	private function user_profile($count, $category, $resolution) {
		$parameters = [
			"query" => [
				"userid" => exm_get_userid(),
				"site" => tma_exm_get_site(),
				"count" => $count,
				"category" => $category,
				"resolution" => $resolution
			]
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->get_body_object("json/profiles/user", $parameters);
	}
	
	private function recommendations_viewed_together($product_id) {
		$parameters = [
			"query" => [
				"product" => $product_id,
				"site" => tma_exm_get_site()
			]
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->get_body_object("json/profiles/product", $parameters);
	}

	private function recommendations_bought_together($product_id) {
		$parameters = [
			"query" => [
				"product" => $product_id,
				"site" => tma_exm_get_site()
			]
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->get_body_object("json/recommendations/bought_together", $parameters);
	}

	private function recommendations_similar_users() {
		$parameters = [
			"userid" => exm_get_userid(),
			"site" => tma_exm_get_site()
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->get_body_object("json/recommendations/similar_users", $parameters);
	}

}
