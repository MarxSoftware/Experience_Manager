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
	"TMA\ExperienceManager\Options" => "includes/class.options.php",
	
	// Event Tracking
	"TMA\ExperienceManager\Events\WC_TRACKER" => "includes/modules/events/class.woocommerce_tracker.php",
	"TMA\ExperienceManager\Events\EDD_TRACKER" => "includes/modules/events/class.edd_tracker.php",
	"TMA\ExperienceManager\Events\Base" => "includes/modules/events/class.ecommerce_base.php",	
	// Ecommerce Helper classes
	"TMA\ExperienceManager\Modules\Ajax\Ajax_Base" => "includes/modules/ajax/class.ajax.base.php",
	"TMA\ExperienceManager\Modules\Ajax\EcommerceAjax" => "includes/modules/ajax/class.ecommerce_ajax.php",
	"TMA\ExperienceManager\Modules\Ajax\Product" => "includes/modules/ajax/class.product.php",
	"TMA\ExperienceManager\Modules\Ajax\Ajax_EDD" => "includes/modules/ajax/class.ajax.edd.php",
	"TMA\ExperienceManager\Modules\Ajax\Ajax_Woo" => "includes/modules/ajax/class.ajax.woo.php",
	"TMA\ExperienceManager\Modules\Ajax\Recommendation_Engine" => "includes/modules/ajax/class.recommendation-engine.php",
	"TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Settings" => "includes/modules/woocommerce/class.woocommerce.settings.php",
	"TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Hooks" => "includes/modules/woocommerce/class.woocommerce.hooks.php",
	"TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Product_Integration" => "includes/modules/woocommerce/class.woocommerce.product.integration.php",
	"TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Category_Integration" => "includes/modules/woocommerce/class.woocommerce.category.integration.php",
	"TMA\ExperienceManager\Modules\WooCommerce\WooCommerce_Shop_Integration" => "includes/modules/woocommerce/class.woocommerce.shop.integration.php",
	"TMA\ExperienceManager\Modules\WooCommerce\Integration" => "includes/modules/woocommerce/class.integration.php",
	"TMA\ExperienceManager\Modules\Widgets\Recommendation_Widget" => "includes/modules/widgets/class.recommendation.widget.php",
	"TMA\ExperienceManager\Modules\Widgets\FlexContent_Widget" => "includes/modules/widgets/class.flex_content.widget.php",
	
	// Content Editor
	"TMA\ExperienceManager\Content\Flex_Content" => "includes/backend/content/class.content.php",
	"TMA\ExperienceManager\Content\Flex_Content_Engine" => "includes/backend/content/class.content-engine.php",
	"TMA\ExperienceManager\Content\Flex_Content_Validator" => "includes/backend/content/class.content-validator.php",
	"TMA\ExperienceManager\Content\ContentType" => "includes/backend/content/class.content-type.php",
	"TMA\ExperienceManager\Content\ContentEditor" => "includes/backend/content/class.content-editor.php",
	"TMA\ExperienceManager\Content\ContentEditorMetaBox" => "includes/backend/content/class.content-editor-metabox.php",
	"TMA\ExperienceManager\Content\ContentSettingsMetaBox" => "includes/backend/content/class.content-settings-metabox.php",
	"TMA\ExperienceManager\Content\ContentShortCode" => "includes/backend/content/class.content-shortcode.php",
	"TMA\ExperienceManager\Content\ContentAjax" => "includes/backend/content/class.content-ajax.php", 
	
	// Customizer
	"TMA\ExperienceManager\Customizer\Customizer" => "includes/backend/customizer/class.customizer.php",
));

function tma_webtools_autoload($class_name) {
	if (array_key_exists($class_name, TMA_WEBTOOLS_CLASSES)) {
		require_once TMA_EXPERIENCE_MANAGER_DIR . "/" . TMA_WEBTOOLS_CLASSES[$class_name];
	}
}

spl_autoload_register('tma_webtools_autoload');
