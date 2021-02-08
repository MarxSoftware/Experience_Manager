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
            'Foo_Widget', // Name
            array( 'description' => __( 'A Foo Widget', 'text_domain' ), ) // Args
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
			"title" => "Das ist der Titel",
			"type" => "recently-viewed",
			"size" => 1,
			"template" => "product/woocommerce-default"
		];
		exm_get_template("recommendation.widget.html", $arguments);
		
        echo $after_widget;
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
		if ( ! isset( $instance['number'] ) || ! $number = (int) $instance['number'] ) {
			$number = 5;
		}

		if (!isset($instance['activity'])) {
		    $instance['activity'] = 'completed';
        }

		if ( is_array( $instance['activity'] ) ) {
			$instance['activity'] = array_shift( $instance['activity'] );
		}

		?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'woocommerce' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/></p>

        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of products to show:', 'woocommerce' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $number ); ?>" size="3"/></p>

        <p>
        <p>
            <label for="<?php echo $this->get_field_id( 'activity' ); ?>"><?php _e( 'Show recommendations based on:', 'woocommerce' ); ?></label>
			<?php
			$activities = array( 'viewed' => 'View History', 'completed' => 'Purchase History' );
			echo '<select id="' . $this->get_field_id( 'activity' ) . '" name="' . $this->get_field_name( 'activity' ) . '">';
			?>
			<?php foreach ( $activities as $activity => $label ): ?>
                <option <?php selected( $activity, $instance['activity'] ); ?>
                        value="<?php echo $activity; ?>"><?php echo $label; ?></option>
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
 
        return $instance;
    }
 
} // class Foo_Widget