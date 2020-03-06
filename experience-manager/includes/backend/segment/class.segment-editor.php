<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMA\ExperienceManager\Segment;

/**
 * Description of class
 *
 * @author marx
 */
class SegmentEditor {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function register() {
		add_action('save_post_tma_segment', [$this, 'save']);

		add_action('delete_post', [$this, "delete"], 10);
		/* add_action('publish_tma_segment', [$this, 'publish'], 10, 2);


		  add_action('post_action_trash', [$this, "trash"], 10); */
		add_action('transition_post_status', [$this, "transition_status"], 10, 3);
		add_action('post_updated', [$this, "update"], 10, 3);

		add_filter('gutenberg_can_edit_post_type', [$this, "disable_gutenberg"], 10, 2);


		add_action('admin_enqueue_scripts', [$this, "query_editor_scripts"]);

		add_action('post_submitbox_start', [$this, "state"]);

		add_action('admin_notices', [$this, 'message']);

	}
	function message() {
		$user_id = get_current_user_id();
		$post_id = get_the_ID();
		if ($error = get_transient("tma_segment_errors_{$post_id}_{$user_id}")) {
			?>
			<div class="error notice notice-error">
				<p><?php echo $error->get_error_message('error'); ?></p>
			</div><?php
			delete_transient("tma_segment_errors_{$post_id}_{$user_id}");
		}
	}

	function state($post) {
		if (!SegmentType::isAudienceEditor()) {
			return;
		}

		$segment = SegmentRequest::getInstance()->load_segment($post->ID);
		
		$value = FALSE;
		if ($segment && property_exists($segment, "attributes") && property_exists($segment->attributes, "modified") && 
				$post->post_modified === $segment->attributes->modified) {
			$value = true;
		}
		if ($value) {
			?>
			<div class="">
				<span style="color:green;">Synced</span>
			</div>
			<?php
		} else {
			?>
			<div class="">
				<span style="color:red;">Out of sync</span>
			</div>
			<?php
		}
	}

	function query_editor_scripts($hook_suffix) {
		if (in_array($hook_suffix, array('post.php', 'post-new.php'))) {
			if (SegmentType::isAudienceEditor()) {
				/*
				  wp_enqueue_script('experience-manager-query-editor_init', TMA_EXPERIENCE_MANAGER_URL . 'assets/query-editor/init.js', array(), "1.2", true);
				  wp_enqueue_script('experience-manager-query-editor_1', TMA_EXPERIENCE_MANAGER_URL . 'assets/query-editor/js/1.5939a542.chunk.js', array('experience-manager-query-editor_init'), "1.2", true);
				  wp_enqueue_script('experience-manager-query-editor_main', TMA_EXPERIENCE_MANAGER_URL . 'assets/query-editor/js/main.5891b828.chunk.js', array('experience-manager-query-editor_1'), "1.2", true);

				  wp_enqueue_style('experience-manager-query-editor-styles_1', TMA_EXPERIENCE_MANAGER_URL . 'assets/query-editor/css/1.f9d3e7cc.chunk.css', array(), "1.2");
				  wp_enqueue_style('experience-manager-query-editor-styles_main', TMA_EXPERIENCE_MANAGER_URL . 'assets/query-editor/css/main.8881f70e.chunk.css', array('experience-manager-query-editor-styles_1'), "1.2");
				 */

				wp_enqueue_script('tma-webtools-backend');
				wp_enqueue_style('experience-manager-codemirror-styles', TMA_EXPERIENCE_MANAGER_URL . 'assets/codemirror/codemirror.css', array(), "5.48.4", false);
				wp_enqueue_script('experience-manager-codemirror', TMA_EXPERIENCE_MANAGER_URL . 'assets/codemirror/codemirror.js', array(), "5.48.4", false);
				wp_enqueue_script('experience-manager-codemirror-javascript', TMA_EXPERIENCE_MANAGER_URL . 'assets/codemirror/mode/javascript/javascript.js', array("experience-manager-codemirror"), "5.48.4", false);
			}
		}
	}

	public function disable_gutenberg($is_enabled, $post_type) {
		if ($post_type === SegmentType::$TYPE) {
			return false; // change book to your post type
		}

		return $is_enabled;
	}

	public function transition_status($new_status, $old_status, $post) {
		if ($post->post_type !== SegmentType::$TYPE) {
			return;
		}
		tma_exm_log("transition_status: " . $new_status);

		if ($new_status === "publish") {
			$this->publish($post->ID, $post);
		} else if ($new_status === "trash") {
			$this->trash($post->ID);
		} else if ($new_status === "draft") {
			$this->trash($post->ID);
		}
	}

	public function update($post_ID, $post_after, $post_before) {
		if ($post_before->post_status === $post_after->post_status || $post_after->post_type !== SegmentType::$TYPE) {
			return;
		}
		if ($post_after->post_status === "publish") {
			$this->publish($post_after->ID, $post_after);
		}
	}

	public function publish($ID, $post) {
		tma_exm_log("publish");

		$siteid = tma_exm_get_site();
		$segment = array(
			'name' => $post->post_title,
			'externalId' => $ID,
			'site' => $siteid,
			'active' => $post->post_status === "publish",
			'dsl' => $this->get_segment_dsl($post->ID),
			'period' => $this->get_segment_period($post->ID),
			'attributes' => [
				'modified' => $post->post_modified
			]
		);

		tma_exm_log("post data");
		tma_exm_log(json_encode($segment));

		$error = SegmentRequest::getInstance()->save_segment($ID, $post, $segment);
		
		if ($error !== FALSE) {
			$user_id = get_current_user_id();
			set_transient("tma_segment_errors_{$post->ID}_{$user_id}", $error, 45);
		}
	}

	/**
	 * 1. delete in backend
	 * 
	 * @param type $ID
	 */
	public function delete($ID) {
		tma_exm_log("delete");

		$site = tma_exm_get_site();
		$request = new \TMA\ExperienceManager\TMA_Request();
		$request->delete("/rest/audience?wpid=" . $ID . "&site=" . $site);
	}

	/**
	 * 1. delete in backend
	 * 2. update meta to out of sync
	 * 
	 * @param type $ID
	 */
	public function trash($ID) {
		tma_exm_log("trash");
		$site = tma_exm_get_site();
		$request = new \TMA\ExperienceManager\TMA_Request();
		$request->delete("/rest/audience?wpid=" . $ID . "&site=" . $site);
	}

	public function get_segment_dsl($post_id) {
		if (array_key_exists('exm_audience_editor', $_POST)) {
			$editor_value = filter_input(INPUT_POST, 'exm_audience_editor');

			return $editor_value;
		} else {
			return get_post_meta($post_id, 'tma_segment_editor', true);
		}
	}

	public function get_segment_period($post_id) {
		$period = [
			'unit' => "YEAR", // MINUTE, HOUR, DAY, WEEK, MONTH, YEAR
			'count' => 1
		];
		if (array_key_exists('exm_audience_editor_tw_unit', $_POST)) {
			$period['unit'] = $_POST['exm_audience_editor_tw_unit'];
		} else {
			$period['unit'] = get_post_meta($post_id, 'tma_segment_editor_unit', true);
		}

		if (array_key_exists('exm_audience_editor_tw_count', $_POST)) {
			$period['count'] = intval($_POST['exm_audience_editor_tw_count']);
		} else {
			$period['count'] = intval(get_post_meta($post_id, 'tma_segment_editor_count', true));
		}

		return $period;
	}

	public function save($post_id) {
		tma_exm_log("save");
		if (array_key_exists('exm_audience_editor', $_POST)) {
			$editor_value = filter_input(INPUT_POST, 'exm_audience_editor');
			update_post_meta(
					$post_id,
					'tma_segment_editor',
					$editor_value
			);
		}
		if (array_key_exists('exm_audience_editor_tw_unit', $_POST)) {
			update_post_meta(
					$post_id,
					'tma_segment_editor_unit',
					$_POST['exm_audience_editor_tw_unit']
			);
		}
		if (array_key_exists('exm_audience_editor_tw_count', $_POST)) {
			update_post_meta(
					$post_id,
					'tma_segment_editor_count',
					$_POST['exm_audience_editor_tw_count']
			);
		}
	}
}
