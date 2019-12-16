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
class SegmentEditorMetaBoxes {

	protected static $_instance = null;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function register() {
		add_action('add_meta_boxes', [$this, 'add_meta_box']);
	}

	public function add_meta_box() {
		if (!SegmentType::isAudienceEditor()) {
			return;
		}
		add_meta_box(
				'tma_segment_editor', // Unique ID
				'Target segment editor', // Box title
				[$this, 'html'], // Content callback, must be of type callable
				SegmentType::$TYPE   // Post type
		);

		add_meta_box(
				'tma_segment_editor_help', // Unique ID
				'Segment editor help', // Box title
				[$this, 'description'], // Content callback, must be of type callable
				SegmentType::$TYPE   // Post type
		);
		add_meta_box(
				'tma_segment_editor_categories', // Unique ID
				'Categorie Helper', // Box title
				[$this, 'categories'], // Content callback, must be of type callable
				SegmentType::$TYPE   // Post type
		);
		add_meta_box(
				'tma_segment_editor_timewindow', // Unique ID
				'Time window', // Box title
				[$this, 'time_meta_box'], // Content callback, must be of type callable
				SegmentType::$TYPE   // Post type
		);
	}

	public function description($post) {
		include 'description.php';
	}

	public function categories($post) {
		include 'categories.php';
	}

	function time_meta_box($post) {
		$unit = get_post_meta($post->ID, 'tma_segment_editor_unit', true);
		$count = get_post_meta($post->ID, 'tma_segment_editor_count', true);
		
		?>
		<div id="exm_timewindow">
			<div>
				<label for="exm_audience_editor_tw_unit">Unit</label>
				<select name="exm_audience_editor_tw_unit" id="tma_segment_editor_tw_unit" class="postbox">
					<option value="YEAR" <?php selected($unit, 'YEAR'); ?> >YEAR</option>
					<option value="MONTH" <?php selected($unit, 'MONTH'); ?> >MONTH</option>
					<option value="WEEK" <?php selected($unit, 'WEEK'); ?> >WEEK</option>
					<option value="DAY" <?php selected($unit, 'DAY'); ?> >DAY</option>
					<option value="HOUR" <?php selected($unit, 'HOUR'); ?> >HOUR</option>
					<option value="MINUTE" <?php selected($unit, 'MINUTE'); ?> >MINUTE</option>
				</select>
			</div>
			<div>
				<label for="exm_audience_editor_tw_unit">Count</label>
				<input type="number" min="1" name="exm_audience_editor_tw_count" class="postbox" value="<?php echo empty($count) ? 1 : $count ?>" />
			</div>
		</div>
		<?php
	}

	public function html($post) {
		$value = get_post_meta($post->ID, 'tma_segment_editor', true);
		?>
		<textarea name="exm_audience_editor" id="exm_audience_editor" cols="50" rows="10"><?php
			if ($value && $value !== "") {
				echo $value;
			}
			?></textarea>
		<script type="text/javascript">
			window.exmSegmentEditor = CodeMirror.fromTextArea(document.getElementById("exm_audience_editor"), {
				lineNumbers: true,
				matchBrackets: true,
				mode: "javascript"
			});
		</script>
		<?php
	}

}
