<?php

namespace TMA\ExperienceManager\Modules\ECommerce;

/**
 * Description of class
 *
 * @author marx
 */
abstract class Ecommerce {

	public function __construct() {
		add_action("wp_ajax_nopriv_exm_ecom_load_products", [$this, "load_products"]);
		add_action("wp_ajax_exm_ecom_load_products", [$this, "load_products"]);
	}

	protected abstract function _load_product($product_id);

	protected abstract function _random_products($count);

	protected abstract function _popular_products($count);

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

	protected function update_products(&$products, $count) {
		$popular = $this->_popular_products($count - sizeof($products));
		foreach ($popular as $product) {
			$products[] = $this->_load_product($product->ID);
		}
		if (sizeof($products) < $count) {
			$random = $this->_random_products($count - sizeof($products));
			foreach ($random as $product) {
				$products[] = $this->_load_product($product->ID);
			}
		}
	}

	public function popular_products($count = 3) {
		$values = $this->shop_profile($count);

		$products = [];
		if (!$values) {
			
		} else {
			if (property_exists($values, "popularProducts")) {
				$products = $this->load_products($values->popularProducts);
			}
		}

		if (sizeof($products) < $count) {
			$this->update_products($products, $count);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}

	public function recently_viewed($count = 3) {
		$values = $this->user_profile($count);

		$products = [];
		if (!$values) {
			
		} else {
			if (property_exists($values, "recentlyViewedProducts")) {
				$products = $this->load_products($values->recentlyViewedProducts);
			}
		}

		if (sizeof($products) < $count) {
			$this->update_products($products, $count);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}

	public function frequently_purchased($count = 3) {
		$values = $this->user_profile($count);

		$products = [];
		if (!$values) {
			
		} else {
			if (property_exists($values, "frequentlyPurchasedProducts")) {
				$products = $this->load_products($values->frequentlyPurchasedProducts);
			}
		}

		if (sizeof($products) < $count) {
			$this->update_products($products, $count);
		} else if (sizeof($products) > $count) {
			$products = array_slice($products, 0, $count);
		}
		return $products;
	}
	
	public function bought_together($product, $count = 3) {
		$values = $this->recommendations_bought_together($product);

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

	private function shop_profile($count) {
		$parameters = [
			"userid" => exm_get_userid(),
			"site" => tma_exm_get_site()
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->module("module-ecommerce", "/shopprofile", $parameters);
	}

	private function user_profile($count) {
		$parameters = [
			"userid" => exm_get_userid(),
			"site" => tma_exm_get_site()
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->module("module-ecommerce", "/userprofile", $parameters);
	}
	
	private function recommendations_bought_together($product) {
		$parameters = [
			"product" => $product,
			"site" => tma_exm_get_site()
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->module("module-ecommerce", "/recommendations/bought_together", $parameters);
	}
	
	private function recommendations_similar_users() {
		$parameters = [
			"userid" => exm_get_userid(),
			"site" => tma_exm_get_site()
		];

		$request = new \TMA\ExperienceManager\TMA_Request();
		return $request->module("module-ecommerce", "/recommendations/similar_users", $parameters);
	}

}
