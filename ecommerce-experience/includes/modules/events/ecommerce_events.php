<?php

function exm_modules_ecommerce_settings($fields) {

	$settings_fields = array(
		'tma-webtools-events' => array(
			array(
				'name' => 'ecommerce',
				'label' => __("e-Commerce events", "experience-manager"),
				'desc' => __("Configure the tracking of e-Commerce events", "experience-manager"),
				'type' => 'subsection',
			),
			array(
				'name' => 'wc_tracking',
				'label' => __("Track WooCommerce events?", "experience-manager"),
				'desc' => __("Tracked events are: order, add item to basket, remove item from basket.", "experience-manager"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->woocommerce(),
				'type' => 'toggle',
				'default' => ''
			),
			array(
				'name' => 'edd_tracking',
				'label' => __("Track EasyDigitalDownloads events?", "experience-manager"),
				'desc' => __("Tracked events are: order, add item to basket, remove item from basket.", "experience-manager"),
				'disable' => !\TMA\ExperienceManager\Plugins::getInstance()->easydigitaldownloads(),
				'type' => 'toggle',
				'default' => ''
			)
		)
	);
	$fields = array_merge_recursive($fields, $settings_fields);
	return $fields;
}

function exm_modules_ecommerce_section($sections) {
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
}
if (\TMA\ExperienceManager\Plugins::getInstance()->easydigitaldownloads()) {
	$edd_tracker = \TMA\ExperienceManager\Events\EDD_TRACKER::getInstance();
	if ($edd_tracker->shouldInit()) {
		tma_exm_log("tracking easydigitaldownloads events");
		$edd_tracker->init();
	} else {
		tma_exm_log("not tracking easydigitaldownloads events");
	}
}

add_filter('experience-manager/settings/fields', 'exm_modules_ecommerce_settings');
add_filter('experience-manager/settings/sections', 'exm_modules_ecommerce_section');
