<?php

// Register Foo_Widget widget
add_action( 'widgets_init', 'register_my_widget' );
 
function register_my_widget() {
    register_widget( 'TMA\ExperienceManager\Modules\Widgets\Foo_Widget' );
}
