<?php

/*
 * enables frontend targeting if cache mode is configured
 */

add_action('admin_enqueue_scripts', "exm_enqueue_script", -99);

add_action('wp_enqueue_scripts', "exm_enqueue_script", -99);

function exm_enqueue_script() {
	wp_enqueue_script('experience-manager-exm', TMA_EXPERIENCE_MANAGER_URL . 'assets/exm/exm.js', array(), "1");
	wp_localize_script('experience-manager-exm', 'EXMCONFIG', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'post_id' => get_the_ID(),
		'taxonomy_id' => get_queried_object()->term_id
	));

	$scriptHelper = new \TMA\ExperienceManager\TMAScriptHelper();
	wp_add_inline_script("experience-manager-exm", $scriptHelper->getCode());
	
	wp_enqueue_script('experience-manager-flex-content', TMA_EXPERIENCE_MANAGER_URL . 'assets/experience-manager.js', array("experience-manager-exm"), "1");
}
