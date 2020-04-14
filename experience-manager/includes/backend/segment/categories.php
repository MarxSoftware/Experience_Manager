<?php ?>
<div id="exm_segment_editor_categores">
	<a name="exm_categories"></a>
	<p>
		Generate category pathes to use in the category rule <b>&quot;{ "conditional" : "category", "field" : "c_categories", "path" : "..." }&quot;</b>.
		Copy the value with leading und ending slash.
	</p>
	<h2><?php echo __('Wordpress Categories:', "tma-webtools"); ?></h2>
	
	<div id="exm-wp-category-select-categories">
		<?php wp_dropdown_categories('show_count=1&hierarchical=1$'); ?>
		<button id="exm-category-select"><?php echo __("Category path", "tma-webtools") ?></button>
		<b id="exm_wp_cat_path"></b>
	</div>
	<script>
		EXM.Dom.ready(function () {
			EXM.Dom.on(document.getElementById("exm-category-select"), "click", e => {
				e.preventDefault();
				var $element = document.querySelector("#exm-wp-category-select-categories select");

				var value = $element.options[$element.selectedIndex].value;
				fetch(TMA_CONFIG.rest_url + "experience-manager/v1/category-path?taxonomy=category&category=" + value).then(function (response) {
					response.json().then(data => {
						document.getElementById("exm_wp_cat_path").innerHTML = data.path;
					});
				});

				return false;
			});
		});
	</script>
	
	<?php if (\TMA\ExperienceManager\Plugins::getInstance()->woocommerce()) { ?>
	<h2><?php echo __('WooCommerce Product Categories:', "tma-webtools"); ?></h2>
	
	<div id="exm-wc-category-select-categories">
		<?php wp_dropdown_categories('show_count=1&hierarchical=1&taxonomy=product_cat'); ?>
		<button id="exm-wc-category-select"><?php echo __("Category path", "tma-webtools") ?></button>
		<b id="exm_wc_cat_path"></b>
	</div>
	
	<script>
		EXM.Dom.ready(function () {
			EXM.Dom.on(document.getElementById("exm-wc-category-select"), "click", e => {
				e.preventDefault();
				var $element = document.querySelector("#exm-wc-category-select-categories select");

				var value = $element.options[$element.selectedIndex].value;
				window.fetch(TMA_CONFIG.rest_url + "experience-manager/v1/category-path?taxonomy=product_cat&category=" + value).then(function (response) {
					response.json().then(data => {
						document.getElementById("exm_wc_cat_path").innerHTML = data.path;
					});
				});

				return false;
			});
		});
	</script>
	<?php } ?>
	
	<?php if (\TMA\ExperienceManager\Plugins::getInstance()->easydigitaldownloads()) { ?>
	<h2><?php echo __('Easy Digital Downloads Categories:', "tma-webtools"); ?></h2>
	
	<div id="exm-edd-category-select-categories">
		<?php wp_dropdown_categories('show_count=1&hierarchical=1&taxonomy=download_category'); ?>
		<button id="exm-edd-category-select"><?php echo __("Category path", "tma-webtools") ?></button>
		<b id="exm_edd_cat_path"></b>
	</div>
	
	<script>
		EXM.Dom.ready(function () {
			EXM.Dom.on(document.getElementById("exm-edd-category-select"), "click", e => {
				e.preventDefault();
				var $element = document.querySelector("#exm-edd-category-select-categories select");

				var value = $element.options[$element.selectedIndex].value;
				window.fetch(TMA_CONFIG.rest_url + "experience-manager/v1/category-path?taxonomy=download_category&category=" + value).then(function (response) {
					response.json().then(data => {
						document.getElementById("exm_edd_cat_path").innerHTML = data.path;
					});
				});

				return false;
			});
		});
	</script>
	<?php } ?>
</div>