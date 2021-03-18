<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager\Modules\WooCommerce;

/**
 * Description of class
 *
 * @author marx
 */
abstract class Integration {
	
	private $options;
	private $option_name;
	
	public function __construct($option_name) {
		$this->option_name = $option_name;
		$this->options = get_option($option_name);
	}
    
	function get_options () {
		return $this->options;
	}
	
	function get_option_name () {
		return $this->option_name;
	}
	
	function update_options() {
		if (is_customize_preview()) {
			$this->options = get_option($this->option_name);
		}
	}

	
	protected function get_feature($feature) {
		if (isset($this->get_options()[$feature])) {
			return $this->get_options()[$feature];
		}
		return FALSE;
	}
	
	protected function get_recommendation_types() {
		return [
			"default" => __("None", "experience-manager"),
			"popular-products" => __("Popular products", "experience-manager"),
			"frequently-bought" => __("Frequently bought", "experience-manager"),
			"recently-viewed" => __("Recently viewed", "experience-manager"),
			"most-viewed" => __("Most viewed", "experience-manager")
		];
	}

}
