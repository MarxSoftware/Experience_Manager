<?php

if (!function_exists("tma_exm_beaver_is_preview")) {
	function tma_exm_beaver_is_preview() {
		return \TMA\ExperienceManager\Plugins::getInstance()->beaver() && \FLBuilderModel::is_builder_active();
	}
}

function tma_exm_beaver_is_beaver_active() {
	if (tma_exm_beaver_is_preview()) {
		tma_exm_log("editor is active beaver");
		return true;
	}

	return false;
}

/**
 * in some cases the adminbar integration must be disabled.
 * 
 * 1. Beaver Builder is active
 * 
 * @return boolean
 */
function tma_exm_beaver_admin_bar_visible() {
	if (isset($_GET['fl_builder'])) {
		tma_exm_log("beaver enabled");
		return true;
	}

	return false;
}
