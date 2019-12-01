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
class SegmentEditorHelp {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function register() {
		add_action('admin_enqueue_scripts', [$this, "query_editor_scripts"]);

		add_action('edit_form_top', [$this, 'intro_button']);

		add_action("admin_footer", [$this, 'intro_js']);
	}

	function intro_button($post) {
		if ($post->post_type !== SegmentType::$TYPE) {
			return;
		}
		echo "<a class='button button-primary button-hero' href='javascript::void(0);' onclick='start_exm_intro()'>" . __("Getting started", "tma-webtools") . "</a>";
	}

	function intro_js() {
		$introConfig = [];
		$introConfig['steps'] = [];
		$introConfig['steps'][] = [
			'element' => "#tma_segment_editor",
			'intro' => "This is the mein area for your segment definition."
		];
		$introConfig['steps'][] = [
			'element' => "#tma_segment_editor_timewindow",
			'intro' => "Here you can define the time window in which a user must meet the requirements to be assigned to a segment."
			. "For example, you can specify that a visitor must have bought something in the last 6 months."
			
		];
		$introConfig['steps'][] = [
			'element' => "#tma_segment_editor_categories",
			'intro' => "This little helper will help you determine the category path for the category rule."
		];
		$introConfig['steps'][] = [
			'element' => "#tma_segment_editor_help",
			'intro' => "Here you can find all events that can be used for segmentation."
		];
		?>
		<script>
			function start_exm_intro() {
				console.log("start intro");
				var intro = introJs();
				intro.setOptions(<?php echo json_encode($introConfig); ?>);
				intro.start();

			}
		</script>
		<?php
	}

	function query_editor_scripts($hook_suffix) {
		if (in_array($hook_suffix, array('post.php', 'post-new.php'))) {
			if (SegmentType::isAudienceEditor()) {

				wp_enqueue_style('experience-manager-introjs-styles', TMA_EXPERIENCE_MANAGER_URL . 'assets/introjs/introjs.min.css', array(), "2.9.3", false);
				wp_enqueue_script('experience-manager-introjs', TMA_EXPERIENCE_MANAGER_URL . 'assets/introjs/intro.min.js', array(), "2.9.3", false);
			}
		}
	}
}
