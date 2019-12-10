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
		//echo "<a class='button button-primary button-hero' href='javascript::void(0);' onclick='start_exm_intro()'>" . __("Getting started", "tma-webtools") . "</a>";
		echo "<a class='ui button primary' href='#' onclick='start_exm_intro()'>" . __("Intro", "tma-webtools") . "</a>";
		echo "<a class='ui button primary' href='#' onclick='start_exm_wizard()'>" . __("Getting started", "tma-webtools") . "</a>";
	}

	function intro_js() {
		$introConfig = [];
		$introConfig['steps'] = [];
		$introConfig['steps'][] = [
			'element' => "#tma_segment_editor",
			'intro' => "This is the main area for your segment definition."
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

		include 'class.segment-editor-help-wizard.php';
		$siteid = "";
		if (isset(get_option('tma_webtools_option')['webtools_siteid'])) {
			$siteid = get_option('tma_webtools_option')['webtools_siteid'];
		}
		?>
		<script>
			var exm_siteid = "<?php echo $siteid; ?>";
			function start_exm_intro() {
				console.log("start intro");
				var intro = introJs();
				intro.setOptions(<?php echo json_encode($introConfig); ?>);
				intro.start();
			}

			function updateSegment() {
				if (window.exmSegmentEditor) {
					let segmentData = "segment().site('" + exm_siteid + "')";
					let selectedVisit = document.querySelector("input[name='exm_visit']:checked").value;
					let rules = [];
					if (selectedVisit === "first") {
						rules.push("rule(FIRSTVISIT)")
					} else if (selectedVisit === "returning") {
						rules.push("not(rule(FIRSTVISIT))")
					}
					let devices = [];
					if (document.querySelector("[name='exm_device_mobile']").checked) {
						devices.push("'Mobile Phone'");
					}
					if (document.querySelector("[name='exm_device_desktop']").checked) {
						devices.push("'Desktop'");
					}
					if (document.querySelector("[name='exm_device_tablet']").checked) {
						devices.push("'Tablet'");
					}
					if (devices.length > 0) {
						rules.push("rule(KEYVALUE).name('device.type').values([" + devices.join(",") + "])");
					}

					segmentData += ".and(" + rules.join(",") + ")";
					window.exmSegmentEditor.setValue(segmentData);
				}
			}


			function start_exm_wizard() {
				console.log("open wizard")
				jQuery("#exm_audience_wizard").modal(
						{
							onApprove: e => {
								updateSegment();
							}
						}
				).modal('show')
			}

		</script>
		<?php
	}

	function query_editor_scripts($hook_suffix) {
		if (in_array($hook_suffix, array('post.php', 'post-new.php'))) {
			if (SegmentType::isAudienceEditor()) {

				wp_enqueue_style('experience-manager-introjs-styles', TMA_EXPERIENCE_MANAGER_URL . 'assets/introjs/introjs.min.css', array(), "2.9.3", false);
				wp_enqueue_script('experience-manager-introjs', TMA_EXPERIENCE_MANAGER_URL . 'assets/introjs/intro.min.js', array(), "2.9.3", false);

				//wp_enqueue_script('experience-manager-semantic-jquery', TMA_EXPERIENCE_MANAGER_URL . 'assets/semantic/jquery-3.4.1.min.js', array(), "2.4.1", false);
				wp_enqueue_style('experience-manager-semantic-css', TMA_EXPERIENCE_MANAGER_URL . 'assets/semantic/semantic.min.css', array(), "2.4.1", false);
				wp_enqueue_script('experience-manager-semantic-js', TMA_EXPERIENCE_MANAGER_URL . 'assets/semantic/semantic.min.js', array("jquery"), "2.4.1", true);
			}
		}
	}

}
