<?php

/*
 * enables frontend targeting if cache mode is configured
 */

add_action('admin_enqueue_scripts', "exm_frontend_scripts", -99);
add_action('admin_enqueue_scripts', "exm_backend_scripts", -99);
add_action('wp_enqueue_scripts', "exm_frontend_scripts", -99);

function exm_backend_scripts() {
	wp_enqueue_script('experience-manager-backend', TMA_EXPERIENCE_MANAGER_URL . 'assets/experience-manager-backend.js', array("experience-manager-exm"), "1");
}
function exm_frontend_scripts() {
	wp_enqueue_script('experience-manager-exm', TMA_EXPERIENCE_MANAGER_URL . 'assets/exm/exm.js', array(), "1");
	wp_localize_script('experience-manager-exm', 'EXMCONFIG', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'post_id' => get_the_ID(),
		'taxonomy_id' => get_queried_object_id() //get_queried_object() ? get_queried_object()->term_id : ""
	));

	$scriptHelper = new \TMA\ExperienceManager\TMAScriptHelper();
	wp_add_inline_script("experience-manager-exm", $scriptHelper->getCode());
	
	wp_enqueue_script('experience-manager-frontend', TMA_EXPERIENCE_MANAGER_URL . 'assets/experience-manager-frontend.js', array("experience-manager-exm"), "1");
	wp_enqueue_style('experience-manager-frontend', TMA_EXPERIENCE_MANAGER_URL . 'assets/experience-manager-frontend.css');
}
