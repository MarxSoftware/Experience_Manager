<?php

function exm_modules_woocommerce_settings($fields) {

	$settings_fields = array(
		'tma-webtools-woocommerce' => array(
			[
				'name' => 'single-product',
				'label' => __("Single product", "tma-webtools"),
				'desc' => __("Configure product recommendation on single product page", "tma-webtools"),
				'type' => 'subsection',
			],
			array(
				'name' => 'single-product-related',
				'label' => __("Single product related products", "tma-webtools"),
				'desc' => __("Configure the tracking of e-Commerce events", "tma-webtools"),
				'type' => 'select',
				'options' => [
					"default" => "Default",
					"bought_together" => "Bought together"
				]
			)
		)
	);
	$fields = array_merge_recursive($fields, $settings_fields);
	return $fields;
}

function exm_modules_woocommerce_section($sections) {
	$custom_sections = array(
		array(
			'id' => 'tma-webtools-woocommerce',
			'title' => __('WooCommerce', 'tma-webtools')
		)
	);
	$sections = array_merge_recursive($sections, $custom_sections);
	return $sections;
}

//add_filter('experience-manager/settings/fields', 'exm_modules_woocommerce_settings');
//add_filter('experience-manager/settings/sections', 'exm_modules_woocommerce_section');

function exm_woocommerce_output_related_products() {
	global $product;
	
	/*$ecom = new \TMA\ExperienceManager\Modules\ECommerce\Ecommerce_Woo();
	$products = $ecom->bought_together($product->get_id());
	$args = [];
	$args['related_products'] = $products;

	exm_get_template("single-product-related", $args);
	 */
	$arguments = [];
	$arguments["product"] = $product->get_id();
	$arguments["size"] = 3;
	$arguments["type"] = "bought-together";
	$arguments["template"] = "single-product-related";
	$arguments["title"] = "Werden häufig zusammen gekauft";
	exm_get_template("recommendation.product.html", $arguments);
}


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product_summary', 'exm_woocommerce_output_related_products', 20);

add_action("woocommerce_archive_description", function () {
	tma_exm_log("taxonomy: " . get_queried_object()->term_id);
	$ecom = new \TMA\ExperienceManager\Modules\ECommerce\Ecommerce_Woo();
	$products = $ecom->recently_viewed();
	$args = [];
	$args['related_products'] = $products;

	tma_exm_log("related_products: " . json_encode($args));

	wc_get_template('single-product/related.php', $args);
}, 20);
