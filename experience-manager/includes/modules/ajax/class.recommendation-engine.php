<?php

namespace TMA\ExperienceManager\Modules\Ajax;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Recommendation_Engine {

	private $type;
	private $count;
	private $resolution;
	private $product;
	private $category;

	private function __construct($type, $count, $resolution, $product, $category) {
		$this->type = $type;
		$this->count = $count;
		$this->resolution = $resolution;
		$this->product = $product;
		$this->category = $category;
	}

	private function get_with_default($value, $defaultValue) {
		return $value !== FALSE && $value != NULL ? $value : $defaultValue;
	}

	public function render_template($template, $arguments = []) {
		$products = $this->get_products();
		$arguments["related_products"] = $products;

		if (!$products || sizeof($products) === 0) {
			return "";
		}
		
		return exm_get_template_html($template, $arguments);
	}

	public function get_products() {
		$ecom = Ajax_Woo::instance();
		$count = $this->get_with_default($this->count, 3);
		$category = $this->get_with_default($this->category, "NONE");
		$resolution = $this->get_with_default($this->resolution, "ALL");
		$product = $this->get_with_default($this->product, "ALL");

		switch ($this->type) {
			case "frequently-bought":
				tma_exm_log("frequently-bought");
				return $ecom->frequently_purchased($count, $category, $resolution);
			case "popular-products":
				tma_exm_log("popular-products");
				return $ecom->popular_products($count, $category, $resolution);
			case "recently-viewed":
				tma_exm_log("recently-viewed");
				return $ecom->recently_viewed($count);
			case "most-viewed":
				tma_exm_log("most-viewed");
				return $ecom->most_viewed($count);
			case "bought-together":
				tma_exm_log("bought-togther");
				return $ecom->bought_together($product, $count);
			default:
				break;
		}
	}

	public static function create_instance($type, $count, $resolution, $category, $product) {
		return new Recommendation_Engine($type, $count, $resolution, $category, $product);
	}

}
