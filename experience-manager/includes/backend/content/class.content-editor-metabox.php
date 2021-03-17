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
class ContentEditorMetaBox {

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
				'tma_content_editor', // Unique ID
				'Flex Content editor', // Box title
				[$this, 'editor'], // Content callback, must be of type callable
				ContentType::$TYPE   // Post type
		);
		add_meta_box(
				'tma_content_editor_preview', // Unique ID
				'Flex Content Preview', // Box title
				[$this, 'preview'], // Content callback, must be of type callable
				ContentType::$TYPE   // Post type
		);
		
	}

	
	public function preview($post) {
		include 'preview-box.php';
	}

	public function editor($post) {
		include 'editor-box.php';
		$content = new Flex_Content($post->ID);
		$html = $content->get_meta_editor_html();
		$css = $content->get_meta_editor_css();
		$js = $content->get_meta_editor_js();
		
		$editor = [
			"js" => $js,
			"css" => $css,
			"html" => $html
		];
		?>
		<script type="text/javascript">
			window.exmContentEditorValue = <?php echo json_encode($editor) ?>
		</script>
		<?php
	}

}
