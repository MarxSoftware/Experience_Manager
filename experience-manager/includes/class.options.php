<?php

namespace TMA\ExperienceManager;

class Options {
	
	private $options;
	public function __construct($option_name) {
		$this->options = get_option($option_name);
	}
	
	public function is_toggle_on ($toggle_name) {
		return isset($this->options[$toggle_name]) && $this->options[$toggle_name] === "on";
	}
	
	public function get_text ($setting_name, $default_value = "") {
		return isset($this->options[$setting_name]) ? $this->options[$setting_name] : $default_value;
	}
}

