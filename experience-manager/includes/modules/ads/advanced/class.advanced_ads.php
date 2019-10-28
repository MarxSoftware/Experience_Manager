<?php

namespace TMA\ExperienceManager;

/**
 * Advanced Ads Integration
 *
 * @since 2.0
 */
final class TMA_AdvancedAdsIntegration {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	const FORM_NAME = 'advanced_ad[visitors]';
	
	/**
	 * Initialize hooks.
	 *
	 * @since 2.0
	 * @return void
	 */
	public function init() {
		add_filter('advanced-ads-visitor-conditions', array($this, "conditions"));
	}

	function visible($options) {
		tma_exm_log("ad visible: " . json_encode($options));
		/*
		 * {"type":"tma-personalization","operator":"is","value":["148b454a-1c25-448b-80a9-4d416d2efaf6"]}
		 */
		$settings = [];
		$settings["segments"] = $options["value"];
		
		if ($options["operator"] === "is") {
			return $this->matching($settings);
		} else {
			return !$this->matching($settings);
		}
	}

	private function matching($settings) {

		if (!isset($settings['segments']) || !is_array($settings['segments'])) {
			$settings['segments'] = array();
		}

		$settings_segments = $settings['segments'];

		$uid = TMA_COOKIE_HELPER::getCookie(TMA_COOKIE_HELPER::$COOKIE_USER, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE);
		$request = new TMA_Request();
		$response = $request->getSegments($uid);

		$user_segments = [];
		if ($response !== NULL) {
			if (sizeof($response->user->actionSystem->segments) > 0) {
				$user_segments = $response->user->actionSystem->segments;
			}
		}

		$user_segments = array_map('trim', $user_segments);
		$settings_segments = array_map('trim', $settings_segments);
		return ShortCode_TMA_CONTENT::matching_mode_all($user_segments, $settings_segments);
	}

	function segment_meta($options, $index = 0) {
		tma_exm_log("segment_meta called");
		// get values and select operator based on previous settings
		$operator = ( isset($options['operator']) && $options['operator'] === 'is_not' ) ? 'is_not' : 'is';
		$values = ( isset($options['value']) && is_array($options['value']) ) ? $options['value'] : array();

		if (!isset($options['type']) || '' === $options['type']) {
			return;
		}
		$type_options = \Advanced_Ads_Visitor_Conditions::get_instance()->conditions;
		if (!isset($type_options[$options['type']])) {
			return;
		}
		// form name basis
		$name = \Advanced_Ads_Visitor_Conditions::get_instance()::FORM_NAME . '[' . $index . ']';

		// options
		?><input type="hidden" name="<?php echo $name; ?>[type]" value="<?php echo $options['type']; ?>"/>
		<select name="<?php echo $name; ?>[operator]">
			<option value="is" <?php selected('is', $operator); ?>><?php _e('is', 'tma-webtools'); ?></option>
			<option value="is_not" <?php selected('is_not', $operator); ?>><?php _e('is not', 'tma-webtools'); ?></option>
		</select><?php
		// set defaults
		$post_types = tma_exm_get_segments_as_array_flat();
		?><div class="advads-conditions-single advads-buttonset"><?php

		foreach ($post_types as $_type_id => $_type_name) {
			if (in_array($_type_id, $values)) {
				$_val = 1;
			} else {
				$_val = 0;
			}

			$_label = $_type_name;

			?><label class="button" for="advads-conditions-<?php echo $index; ?>-<?php echo $_type_id;
			?>"><?php echo $_label ?></label><input type="checkbox" id="advads-conditions-<?php echo $index; ?>-<?php echo $_type_id; ?>" name="<?php echo $name; ?>[value][]" <?php checked($_val, 1); ?> value="<?php echo $_type_id; ?>"><?php
		}
		?><p class="advads-conditions-not-selected advads-error-message"><?php _ex('Please select some target segments.', 'You should select at least one segment!', 'tma-webtools'); ?></p></div><?php
	}

	function conditions($conditions) {

		tma_exm_log("ad: " . json_encode($conditions));

		$conditions["tma-personalization"] = array(
			'label' => __('Audience', 'tma-webtools'),
			'description' => __('The target audience', 'tma-webtools'),
			'metabox' => array($this, 'segment_meta'), // callback to generate the metabox
			'check' => array($this, 'visible') // callback for frontend check
		);

		return $conditions;
	}

}
