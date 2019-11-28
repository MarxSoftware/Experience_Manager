<?php

function tma_webtools_modules_woocommerce_settings($fields) {

	$recommendation_options = ["segment" => __("Segment based", "tma-webtools")];
	$recommendation_options = apply_filters("tma-webtools/modules/woocommerce/recommendation/options", $recommendation_options);

	$settings_fields = array(
		'tma-webtools-events' => array(
			array(
				'name' => 'ecommerce',
				'label' => __("e-Commerce events", "tma-webtools"),
				'desc' => __("Configure the tracking of e-Commerce events", "tma-webtools"),
				'type' => 'subsection',
			),
			array(
				'name' => 'wc_tracking',
				'label' => __("Track WooCommerce events?", "tma-webtools"),
				'desc' => __("Tracked events are: order, add item to basket, remove item from basket.", "tma-webtools"),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'edd_tracking',
				'label' => __("Track EasyDigitalDownloads events?", "tma-webtools"),
				'desc' => __("Tracked events are: order, add item to basket, remove item from basket.", "tma-webtools"),
				'type' => 'toggle',
				'default' => ''
			),
			
			array(
				'name' => 'newsletter',
				'label' => __("Newsletter events", "tma-webtools"),
				'desc' => __("Coming soon!", "tma-webtools"),
				'type' => 'subsection',
			),
		)
	);
	$fields = array_merge_recursive($fields, $settings_fields);
	return $fields;
}

function tma_webtools_modules_woocommerce_sections($sections) {
	$custom_sections = array(
		array(
			'id' => 'tma-webtools-events',
			'title' => __('Events', 'tma-webtools')
		)
	);
	$sections = array_merge_recursive($sections, $custom_sections);
	return $sections;
}

if (\TMA\ExperienceManager\Plugins::getInstance()->woocommerce()) {
	$tracker = new \TMA\ExperienceManager\Events\WC_TRACKER();
	if ($tracker->shouldInit()) {
		tma_exm_log("tracking woocommerce events");
		$tracker->init();
	} else {
		tma_exm_log("not tracking woocommerce events");
	}
	
	$edd_tracker = new \TMA\ExperienceManager\Events\EDD_TRACKER();
	if ($edd_tracker->shouldInit()) {
		tma_exm_log("tracking easydigitaldownloads events");
		$edd_tracker->init();
	} else {
		tma_exm_log("not tracking easydigitaldownloads events");
	}
}

add_filter('experience-manager/settings/fields', 'tma_webtools_modules_woocommerce_settings');
add_filter('experience-manager/settings/sections', 'tma_webtools_modules_woocommerce_sections');
