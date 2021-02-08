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
    
	abstract function get_options ();

	
	protected function get_feature($feature) {
		if (isset($this->get_options()[$feature])) {
			return $this->get_options()[$feature];
		}
		return FALSE;
	}
}
