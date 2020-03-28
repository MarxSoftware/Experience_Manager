<div id="exm-content-info">
	<span><?php
		printf(
				// translators: %s is an ad ID.
				esc_html__('Content Id: %s', 'tma-webtools'),
				'<strong>' . absint($post->ID) . '</strong>'
		);
		?></span>
	<label>&nbsp;<span><?php esc_html_e('shortcode', 'tma-webtools'); ?></span>
		<input type="text" onclick="this.select();" value='[exm_content id="<?php echo absint($post->ID); ?>"]' size="20" readonly="readonly"/>
	</label>
</div>