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
		add_action('save_post_exm_content', [$this, 'save'], 9, 2);
		add_filter('gutenberg_can_edit_post_type', [$this, "disable_gutenberg"], 9, 2);
		add_action('admin_enqueue_scripts', [$this, "query_editor_scripts"], 9);

		//add_action('edit_form_top', [$this, 'top_buttons']);
		$this->enable_revision();
	}

	function top_buttons($post) {
		if ($post->post_type !== ContentType::$TYPE) {
			return;
		}
		echo "<a class='ui button primary' id='tma_content_library' href='#'>" . __("Open library", "experience-manager") . "</a>";

		include 'content-library.php';
	}

	function query_editor_scripts($hook_suffix) {
		if (in_array($hook_suffix, array('post.php', 'post-new.php'))) {
			if (ContentType::isContentEditor()) {

//				wp_enqueue_script('tma-webtools-backend');
				wp_enqueue_script('experience-manager-ace', TMA_EXPERIENCE_MANAGER_URL . 'assets/ace/ace.js', array(), "1.4.8", false);
				wp_enqueue_script('experience-manager-mustache', TMA_EXPERIENCE_MANAGER_URL . 'assets/mustache/mustache.min.js', array(), "4.0.1", false);
				wp_enqueue_script('experience-manager-content-tabs', TMA_EXPERIENCE_MANAGER_URL . 'assets/content-editor/content-tabs.js', array(), "1", false);
				//wp_enqueue_script('experience-manager-content-library', TMA_EXPERIENCE_MANAGER_URL . 'assets/content-editor/content-library.js', array(), "1", false);
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

	public function save($post_id, $post) {
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

		//$this->pmr_save_post($post_id, $post);
	}

	private function enable_revision() {
		add_filter('_wp_post_revision_field_exm_content_editor_html', [$this, 'pmr_field'], 10, 3);
		add_filter('_wp_post_revision_field_exm_content_editor_js', [$this, 'pmr_field'], 10, 3);
		add_filter('_wp_post_revision_field_exm_content_editor_css', [$this, 'pmr_field'], 10, 3);
		add_filter('_wp_post_revision_field_exm_content_settings', [$this, 'pmr_field'], 10, 3);
		add_action('save_post', [$this, 'pmr_save_post'], 10, 2);
		add_action('wp_restore_post_revision', [$this, 'pmr_restore_revision'], 10, 2);
		add_filter('_wp_post_revision_fields', [$this, 'pmr_fields']);
	}

	function pmr_fields($fields) {
		$fields['exm_content_editor_html'] = 'Flex Content HTML';
		$fields['exm_content_editor_js'] = 'Flex Content JS';
		$fields['exm_content_editor_css'] = 'Flex Content CSS';
		$fields['exm_content_settings'] = 'Flex Content Settings';
		return $fields;
	}

// global $revision doesn't work, using third parameter $post instead
	function pmr_field($value, $field, $post) {
		return get_metadata('post', $post->ID, $field, true);
	}

	function pmr_restore_revision($post_id, $revision_id) {
		$post = get_post($post_id);
		$revision = get_post($revision_id);

		$fields = $this->pmr_fields([]);
		foreach ($fields AS $key => $value) {
			$meta = get_metadata('post', $revision->ID, $key, true);

			if (false === $meta) {
				delete_post_meta($post_id, $key);
			} else {
				update_post_meta($post_id, $key, $meta);
			}
		}
	}

	function pmr_save_post($post_id, $post) {
		$parent_id = wp_is_post_revision($post_id);
		if ($parent_id !== FALSE) {
			$parent = get_post($parent_id);
			$fields = $this->pmr_fields([]);
			foreach ($fields AS $key => $value) {
				if (array_key_exists($key, $_POST)) {
					$meta_value = filter_input(INPUT_POST, $key);
					add_metadata('post', $post_id, $key, $meta_value);
				}
			}
			/*
			  $fields = $this->pmr_fields([]);
			  foreach ($fields AS $key => $value) {
			  $meta = get_post_meta($parent->ID, $key, true);

			  if (false !== $meta) {
			  add_metadata('post', $post_id, $key, $meta);
			  }
			  } */
		}
	}

}
