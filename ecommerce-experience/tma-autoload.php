<?php

define("TMA_WEBTOOLS_CLASSES", array(
	"TMA\ExperienceManager\Integration" => "includes/modules/editors/class.integration.php",
	"TMA\ExperienceManager\Plugins" => "includes/class.plugins.php",
	"TMA\ExperienceManager\TMA_Request" => "includes/class.request.php",
	"TMA\ExperienceManager\TMA_COOKIE_HELPER" => "includes/class.cookie.php",
	"TMA_Settings_API" => "dependencies/class.settings-api.php",
	"TMA\ExperienceManager\TMAScriptHelper" => "includes/frontend/class.tma_script_helper.php",
	"TMA\ExperienceManager\Constants" => "includes/class.constants.php",
	"TMA\ExperienceManager\TMA_MetaBox" => "includes/backend/class.tma_metabox.php",
	"TMA\ExperienceManager\TMA_ShortCodes_Plugin" => "includes/backend/class.tma_shortcodes_plugin.php",
	"TMA\ExperienceManager\TMA_WPAdminBar" => "includes/backend/class.tma_wpadminbar.php",
	"TMA\ExperienceManager\TMA_Backend_Ajax" => "includes/backend/class.tma_ajax.php",
	"TMA\ExperienceManager\TMA_Settings" => "includes/backend/class.tma_settings.php",
	"TMA\ExperienceManager\ShortCode_TMA_CONTENT" => "includes/frontend/class.shortcode_tma_content.php",
	"TMA\ExperienceManager\TMA_Rest" => "includes/class.tma_rest.php",
	"TMA\ExperienceManager\Singleton" => "includes/class.singleton.php",
	
	// Event Tracking
	"TMA\ExperienceManager\Events\WC_TRACKER" => "includes/modules/events/class.woocommerce_tracker.php",
	"TMA\ExperienceManager\Events\EDD_TRACKER" => "includes/modules/events/class.edd_tracker.php",
	"TMA\ExperienceManager\Events\Base" => "includes/modules/events/class.ecommerce_base.php",	
	// Ecommerce Helper classes
	"TMA\ExperienceManager\Modules\ECommerce\Ecommerce" => "includes/modules/ecommerce/class.ecommerce.php",
	"TMA\ExperienceManager\Modules\ECommerce\Ecommerce_EDD" => "includes/modules/ecommerce/class.ecommerce-edd.php",
	"TMA\ExperienceManager\Modules\ECommerce\Ecommerce_Woo" => "includes/modules/ecommerce/class.ecommerce-woo.php",
));

function tma_webtools_autoload($class_name) {
	if (array_key_exists($class_name, TMA_WEBTOOLS_CLASSES)) {
		require_once TMA_EXPERIENCE_MANAGER_DIR . "/" . TMA_WEBTOOLS_CLASSES[$class_name];
	}
}

spl_autoload_register('tma_webtools_autoload');
