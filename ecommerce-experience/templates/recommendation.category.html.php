<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ($category) {
	?>

<div data-exm-recommendation="<?php echo $type; ?>" 
	 data-exm-recommendation-size="<?php echo $size;?>" 
	 data-exm-category="<?php echo $category;?>"
	 data-exm-template="<?php echo $template;?>"
	 data-exm-title="<?php echo $title;?>"
	 >
	
</div>

	<?php
}