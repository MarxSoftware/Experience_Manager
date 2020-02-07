<?php

/*
 * enables frontend targeting if cache mode is configured
 */

add_action('admin_enqueue_scripts', "exm_enqueue_script", -99);

add_action('wp_enqueue_scripts', "exm_enqueue_script" , -99);


function exm_enqueue_script () {
	if (tma_exm_is_debug()) {
		wp_register_script('webtools-frontend', TMA_EXPERIENCE_MANAGER_URL . 'js/webtools/webtools-frontend.js', array(), "1");
		wp_register_script('tma-webtools-backend', TMA_EXPERIENCE_MANAGER_URL . 'js/webtools/webtools-wp-backend.js', array(), "1");
	} else {
		wp_register_script('webtools-frontend', TMA_EXPERIENCE_MANAGER_URL . 'js/webtools/webtools-frontend-min.js', array(), "1");
		wp_register_script('tma-webtools-backend', TMA_EXPERIENCE_MANAGER_URL . 'js/webtools/webtools-wp-backend-min.js', array(), "1");
	}

	if (!tma_exm_is_editor_active()) {
		/**
		 * warum wird hier auf den angemeldeten nutzer geprüft??
		 * 
		 * vielleicht, weil wir so 
		 */
//		if (tma_exm_is_frontend_mode_enabled() /*&& !is_user_logged_in()*/) {
//			wp_enqueue_script('experience-manager-frontend', TMA_EXPERIENCE_MANAGER_URL . 'js/experience-manager-frontend.js', array("jquery", "webtools-frontend", "experience-manager-hooks"), "1");
//		} else if (/*!is_user_logged_in() && */function_exists("has_blocks") && has_blocks()) {
			wp_enqueue_script('experience-manager-frontend', TMA_EXPERIENCE_MANAGER_URL . 'js/experience-manager-frontend.js', array("jquery", "webtools-frontend", "experience-manager-hooks"), "1");
//		}
	}
}