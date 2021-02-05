<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ($product) {
	?>

<div data-exm-recommendation="<?php echo $type; ?>" 
	 data-exm-recommendation-size="<?php echo $size;?>" 
	 data-exm-product="<?php echo $product;?>"
	 data-exm-template="<?php echo $template;?>"
	 data-exm-title="<?php echo $title;?>"
	 >
	
</div>

	<?php
}