<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager\Content;

/**
 * Description of class
 *
 * @author marx
 */
class Flex_Content {
	
	var $content_id = 0;
	
    public function __construct($post_id) {
		$this->content_id = $post_id;
	}
	
	public function get_id () {
		return $this->content_id;
	}
	
	public function get_meta_settings () {
		$settings = $this->get_meta('exm_content_settings');
		tma_exm_log("loaded settings: " . $settings);
		return $settings;
	}
	public function get_meta_editor_html () {
		return $this->get_meta('exm_content_editor_html');
	}
	public function get_meta_editor_css () {
		return $this->get_meta('exm_content_editor_css');
	}
	public function get_meta_editor_js () {
		return $this->get_meta('exm_content_editor_js');
	}
	
	public function set_meta_settings ($value) {
		$this->update_meta('exm_content_settings', $value);
	}
	public function set_meta_editor_html ($value) {
		$this->update_meta('exm_content_editor_html', $value);
	}
	public function set_meta_editor_css ($value) {
		$this->update_meta('exm_content_editor_css', $value);
	}
	public function set_meta_editor_js ($value) {
		$this->update_meta('exm_content_editor_js', $value);
	}
	
	private function get_meta ($key) {
		return get_post_meta($this->content_id, $key, true);
	}
	private function update_meta ($key, $value) {
		update_post_meta(
					$this->content_id,
					$key,
					$value
			);
	}
}
