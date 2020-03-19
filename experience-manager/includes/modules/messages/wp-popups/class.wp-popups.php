<?php

namespace TMA\ExperienceManager;

/**
 * PopUpMaker Inteegration
 *
 * @since 2.0
 */
final class WP_Popups {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	function __construct() {
		add_filter('wppopups/rules/options', [$this, "options"]);

		add_filter('wppopups_rules/rule_values/exm_audience', [$this, "choices"]);

		add_filter('wppopups_rules_rule_match_exm_audience', [$this, "match"]);
	}

	function options($rules) {
		$rules[__('Experience Manager', 'tma-webtools')] = [
			'exm_audience' => __('Audience', 'tma-webtools')
		];
		return $rules;
	}
	
	function choices ($choices) {
		return tma_exm_get_segments_as_array_flat();
	}
	
	function match ($rule) {
		tma_exm_log("match: " . json_encode($rule));
		
		$user_segments = tma_exm_get_user_segments([]);
		$segment = $rule['value'];
		$found = array_search($segment, array_column($user_segments, 'wpid'));
		if ( $rule['operator'] == "==" ) {		
			return $found !== FALSE;
		}
		return !$found === FALSE;
	}

}
