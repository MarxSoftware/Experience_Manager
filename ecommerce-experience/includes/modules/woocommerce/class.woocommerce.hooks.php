<?php

namespace TMA\ExperienceManager\Modules\WooCommerce;

/**
 * Description of class
 *
 * @author marx
 */
class WooCommerce_Hooks {

	public function __construct() {
		add_action( 'save_post_product', [$this, save_product], 10, 3 );
		add_action( 'before_delete_post', [$this, delete_product]);
	}
	
	function delete_product( $post_id) {
		if (get_post_type($post_id) !== "product") {
			return;
		}
		$product = wc_get_product($post_id);
		
		tma_exm_log("delete_product: " . $product->get_id());
		
		$request = new \TMA\ExperienceManager\TMA_Request();
		$response = $request->delete("json/product?product_id=" . $post_id);
		if ($response) {
			tma_exm_log("product deleted");
		} else {
			tma_exm_log("error deleting product");
		}
	}
	function save_product( $post_id, $post, $update ) {
		if (!$update) {
			return;
		}
		$product = wc_get_product($post_id);
		
		tma_exm_log("save_product: " . $product->get_id());
		if ($product) {
			$product_dto = [];
			
			$product_dto["id"] = $product->get_id();
			$terms = get_the_terms($product->get_id(), 'product_cat');
			$product_dto['categories'] = [];
			$ecom_categories_parents = [];
			if ($terms) {
				foreach ($terms as $term) {
					$product_dto['categories'][] = $term->term_id;
					
					$cat_result = \TMA\ExperienceManager\TMAScriptHelper::custom_get_term_parents_list($term->term_id, "product_cat", []);
					$ecom_categories_parents = array_merge($ecom_categories_parents, $cat_result["parents"]);
				}
			}
			$product_dto['parentCategories'] = array_unique($ecom_categories_parents);
			$product_dto['allCategories'] = array_unique(array_merge($product_dto['categories'], $ecom_categories_parents));
			
			$request = new \TMA\ExperienceManager\TMA_Request();
			$response = $request->post("json/product", $product_dto);
			
			if ($response) {
				tma_exm_log("product synced");
			} else {
				tma_exm_log("error syncing product");
			}
		}
	}
}
