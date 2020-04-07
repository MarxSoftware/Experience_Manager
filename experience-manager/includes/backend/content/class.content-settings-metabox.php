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
class ContentSettingsMetaBox {

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
		if (!ContentType::isContentEditor()) {
			return;
		}
		add_meta_box(
				'tma_content_settings', // Unique ID
				'Flex Content settings', // Box title
				[$this, 'settings'], // Content callback, must be of type callable
				ContentType::$TYPE   // Post type
		);
	}

	

	public function settings($post) {
		$content = new Flex_Content($post->ID);
		$settings = $content->get_meta_settings();
		tma_exm_log("loaded: " . $settings);
		$settings_json = json_decode($settings);
		?>
		
		<script type="text/javascript">
			window.exmContentSettingsValue = <?php echo $settings ?>;
		</script>
		<?php
		include 'settings-box.php';
	}

}
