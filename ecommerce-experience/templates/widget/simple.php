<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */
if (!defined('ABSPATH')) {
	exit;
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
		<ul class="product_list_widget">
			<?php foreach ($related_products as $related_product) : ?>

				<?php
				$post_object = get_post($related_product->get_id());
				$product = wc_get_product($related_product->get_id());
				$pid = $product->get_id();

				setup_postdata($GLOBALS['post'] = & $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
				global $post;
				?>
				<li><a href="<?php echo esc_url(get_permalink($post->ID)); ?>"
					   title="<?php echo esc_attr($post->post_title ? $post->post_title : $post->ID ); ?>">
						   <?php echo $product->get_image(); ?>
						   <?php
						   if ($post->post_title) {
							   echo get_the_title($post->ID);
						   } else {
							   echo $post->ID;
						   }
						   ?>

					</a> <?php echo $product->get_price_html(); ?></li>
				<?php
				?>

			<?php endforeach; ?>
		</ul>
		<?php woocommerce_product_loop_end(); ?>

	</section>
	<?php
endif;

wp_reset_postdata();
