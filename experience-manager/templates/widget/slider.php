<?php
/**
 * Widget Product Slider
 *
 * This template can be overridden by copying it to yourtheme/experience-manager/widget/slider.php.
 *
 * @package     ExperienceManager\Templates
 */
if (!defined('ABSPATH')) {
	exit;
}

$slider_id = uniqid();
if ($id) {
	$slider_id = $id;
}

if ($related_products) :
	?>

	<section class="related products">
		<?php
		if ($heading) :
			?>
			<h2><?php echo esc_html($heading); ?></h2>
		<?php endif; ?>

		<?php woocommerce_product_loop_start(); ?>
		<div class="slideshow-container" data-slider="true" id="<?php echo $slider_id; ?>">
			<?php
			$index = 0;

			foreach ($related_products as $related_product) {
				$style = "";
				if ($index === 0) {
					$style = "display:block;";
				}
				$index++;
				$post_object = get_post($related_product->get_id());
				$product = wc_get_product($related_product->get_id());
				$pid = $product->get_id();

				setup_postdata($GLOBALS['post'] = & $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
				global $post;
				?>
				<div class="exm-widget-slide exm-widget-slide-fade" style="<?php echo $style; ?>">
					<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"
					   title="<?php echo esc_attr($post->post_title ? $post->post_title : $post->ID ); ?>">
						   <?php echo $product->get_image(); ?>
						   <?php
						   if ($post->post_title) {
							   echo get_the_title($post->ID);
						   } else {
							   echo $post->ID;
						   }
						   ?>

					</a>
				</div>
			<?php } ?>
		</div>
		<?php woocommerce_product_loop_end(); ?>
		<script>
			registerSlideShow(document.getElementById("<?php echo $slider_id; ?>"))
		</script>
	</section>
	<?php
endif;

wp_reset_postdata();
