<?php

namespace TMA\ExperienceManager\Modules\Widgets;

/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends \WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'foo_widget', // Base ID
            'EXM Recommendation', // Name
            array( 'description' => __( 'Prodcut recommendation widget', 'experience-manager' ), ) // Args
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
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
 
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
			"woocommerce-default" => __("WooCommerce Default", "experience-manager"),
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
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		if ( ! isset( $instance['size'] ) || ! $size = (int) $instance['size'] ) {
			$size = 1;
		}

		if (!isset($instance['type'])) {
		    $instance['type'] = 'recently-viewed';
        }

		if ( is_array( $instance['type'] ) ) {
			$instance['type'] = array_shift( $instance['type'] );
		}
		if (!isset($instance['template'])) {
		    $instance['template'] = 'woocommerce-default';
        }

		if ( is_array( $instance['template'] ) ) {
			$instance['template'] = array_shift( $instance['template'] );
		}

		?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'experience-manager' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/></p>

        <p>
            <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Number of products to show:', 'experience-manager' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $size ); ?>" size="3"/></p>

        <p>
        <p>
            <label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Show recommendations based on:', 'experience-manager' ); ?></label>
			<?php
			$activities = $this->get_recommendation_types();
			echo '<select id="' . $this->get_field_id( 'type' ) . '" name="' . $this->get_field_name( 'type' ) . '">';
			?>
			<?php foreach ( $activities as $activity => $label ): ?>
                <option <?php selected( $activity, $instance['type'] ); ?>
                        value="<?php echo $activity; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
            <?php echo '</select>'; ?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Recommendation template:', 'experience-manager' ); ?></label>
			<?php
			$templates = $this->get_recommendation_templates();
			echo '<select id="' . $this->get_field_id( 'template' ) . '" name="' . $this->get_field_name( 'template' ) . '">';
			?>
			<?php foreach ( $templates as $template => $label ): ?>
                <option <?php selected( $template, $instance['template'] ); ?>
                        value="<?php echo $template; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
            <?php echo '</select>'; ?>
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
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['size'] = ( !empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';
        $instance['type'] = ( !empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
        $instance['template'] = ( !empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
 
        return $instance;
    }
 
} // class Foo_Widget