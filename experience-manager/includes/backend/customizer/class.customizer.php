<?php

namespace TMA\ExperienceManager\Customizer;

class Customizer {

	protected static $_instance = null;

	/**
	 * 
	 * @return WooCommerce_Category_Integration
	 */
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function init() {
		tma_exm_log("init customizer");
		add_action("customize_register", [$this, "register"]);

		//add_action( 'customize_controls_print_scripts', array( $this, 'add_scripts' ), 30 );
		add_action('customize_controls_enqueue_scripts', array($this, 'add_scripts'), 30);
	}

	public function add_scripts() {
		tma_exm_log("add scripts");

		wp_register_script('exm-customizer', TMA_EXPERIENCE_MANAGER_URL . 'assets/exm-customizer.js');

		$product = $this->get_random_product();
		$category = $this->get_random_category();
		$translation_array = array(
			'shop_url' => esc_js(exm_get_page_permalink('shop')),
			'checkout_url' => esc_js(exm_get_page_permalink('checkout')),
			'cart_url' => esc_js(wc_get_page_permalink('cart')),
			'product_url' => $product != FALSE ? esc_js(get_permalink($product->ID)) : esc_js(exm_get_page_permalink('shop')),
			'category_url' => $category != FALSE ? esc_js(get_category_link($category)) : esc_js(exm_get_page_permalink('shop'))
		);
		wp_localize_script('exm-customizer', 'EXM_CUSTOMIZER', $translation_array);
		wp_enqueue_script('exm-customizer');
	}

	private function get_random_category() {
		// Get all terms
		$terms = get_terms(array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		));

		// Randomize Term Array
		shuffle($terms);

		if (sizeof($terms) > 0) {
			return $terms[0];
		}
		return FALSE;
	}

	private function get_random_product() {
		$args = array(
			'posts_per_page' => 1,
			'orderby' => 'rand',
			'post_type' => 'product');

		$random_products = get_posts($args);
		tma_exm_log(json_encode($random_products[0]));
		if (sizeof($random_products) > 0) {
			return $random_products[0];
		}
		return FALSE;
	}

	public function register(\WP_Customize_Manager $wp_customize) {
		tma_exm_log("register customizer");

		$wp_customize->add_panel('exm_recommendations', array(
			'title' => __('Recommendations'),
			'description' => "Config your product recommendations", // Include html tags such as <p>.
			'priority' => 160, // Mixed with top-level-section hierarchy.
		));
	}

}
