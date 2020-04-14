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
class ContentEditor {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function register() {
		add_action('save_post_exm_content', [$this, 'save']);
		add_filter('gutenberg_can_edit_post_type', [$this, "disable_gutenberg"], 10, 2);
		add_action('admin_enqueue_scripts', [$this, "query_editor_scripts"]);
	}
	

	function query_editor_scripts($hook_suffix) {
		if (in_array($hook_suffix, array('post.php', 'post-new.php'))) {
			if (ContentType::isContentEditor()) {

//				wp_enqueue_script('tma-webtools-backend');
				wp_enqueue_script('experience-manager-ace', TMA_EXPERIENCE_MANAGER_URL . 'assets/ace/ace.js', array(), "1.4.8", false);
				wp_enqueue_script('experience-manager-mustache', TMA_EXPERIENCE_MANAGER_URL . 'assets/mustache/mustache.min.js', array(), "4.0.1", false);
				wp_enqueue_script('experience-manager-content-tabs', TMA_EXPERIENCE_MANAGER_URL . 'assets/content-editor/content-tabs.js', array(), "1", false);
				wp_enqueue_script('experience-manager-content-editor-js', TMA_EXPERIENCE_MANAGER_URL . 'assets/content-editor/content-editor.js', array("experience-manager-ace", "experience-manager-mustache", "jquery", "experience-manager-content-tabs"), "1", false);
				wp_enqueue_script('experience-manager-content-settings-js', TMA_EXPERIENCE_MANAGER_URL . 'assets/content-editor/content-settings.js', array("jquery"), "1", false);
				wp_enqueue_style('experience-manager-content-editor-css', TMA_EXPERIENCE_MANAGER_URL . 'assets/content-editor/css/content-editor.css', array(), "1", false);
			}
		}
	}

	public function disable_gutenberg($is_enabled, $post_type) {
		if ($post_type === ContentType::$TYPE) {
			return false; // change book to your post type
		}

		return $is_enabled;
	}


	public function save($post_id) {
		$content = new Flex_Content($post_id);
		if (array_key_exists('exm_content_editor_html', $_POST)) {
			$editor_value = filter_input(INPUT_POST, 'exm_content_editor_html');
			$content->set_meta_editor_html($editor_value);
		}
		if (array_key_exists('exm_content_editor_js', $_POST)) {
			$content->set_meta_editor_js($_POST['exm_content_editor_js']);
		}
		if (array_key_exists('exm_content_editor_css', $_POST)) {
			$content->set_meta_editor_css($_POST['exm_content_editor_css']);
		}
		if (array_key_exists('exm_content_settings', $_POST)) {
			$content->set_meta_settings($_POST['exm_content_settings']);
		}
	}
}
