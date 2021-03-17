<?php

namespace TMA\ExperienceManager\Modules\Widgets;

/**
 * Adds Foo_Widget widget.
 */
class FlexContent_Widget extends \WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
				'flex_content_widget', // Base ID
				'Flex Content', // Name
				array('description' => __('Flex Content widget', 'experience-manager'),) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		$arguments = [
			"title" => $title,
			"type" => $instance['type'],
			"size" => $instance['size'],
			"template" => "widget/" . $instance['template']
		];
		exm_get_template("recommendation.widget.html", $arguments);

		echo $after_widget;
	}

	private function get_recommendation_types() {
		return [
			"popular-products" => __("Popular products in category", "experience-manager"),
			"frequently-bought" => __("Frequently bought in category", "experience-manager"),
			"recently-viewed" => __("Recently viewed", "experience-manager"),
			"most-viewed" => __("Most viewed", "experience-manager")
		];
	}

	private function get_recommendation_templates() {
		return apply_filters("experience-manager/woocommerce/widget/templates", [
			"default" => __("Default", "experience-manager"),
			"simple" => __("Simple", "experience-manager"),
			"slider" => __("Slider", "experience-manager")
		]);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		if (!isset($instance['size']) || !$size = (int) $instance['size']) {
			$size = 1;
		}
		
		if (!isset($instance['flex_content'])) {
		    $instance['flex_content'] = 'none';
        }
		
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'experience-manager'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
				   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
				   value="<?php echo esc_attr($title); ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flex_content'); ?>"><?php _e('Recommendation template:', 'experience-manager'); ?></label>
			<br/>
			<?php
			wp_dropdown_pages(array(
				'id' => $this->get_field_id('flex_content'),
				'name' => $this->get_field_name('flex_content'),
				'selected' => $instance['flex_content'],
				'post_type' => \TMA\ExperienceManager\Content\ContentType::$TYPE,
				'depth' => 1,
			));
			?>
		</p>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
		$instance['flex_content'] = (!empty($new_instance['flex_content']) ) ? strip_tags($new_instance['flex_content']) : '';
		return $instance;
	}

}

// class Foo_Widget