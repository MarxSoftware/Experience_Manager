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
class ContentShortCode {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function register() {
		add_shortcode('exm_content', [$this, 'exm_content']);
	}

	public function exm_content($args) {
		if (!array_key_exists("id", $args)) {
			return "test";
		}
		
		$html = get_post_meta( $args["id"], 'exm_content_editor_html', true );
		$css = get_post_meta( $args["id"], 'exm_content_editor_css', true );
		$js = get_post_meta( $args["id"], 'exm_content_editor_js', true );
		
		return "
			<style>${css}</style>
			${html}
			<script>${js}</script>
		";
	}
}
