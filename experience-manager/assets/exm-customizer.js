EXM.Dom.ready(function () {
	wp.customize.section('exm_recom_shoppage_header', function (section) {
		section.expanded.bind(function (isExpanded) {
			if (isExpanded) {
				wp.customize.previewer.previewUrl.set(EXM_CUSTOMIZER.shop_url);
			}
		});
	});
	wp.customize.section('exm_recom_shoppage_footer', function (section) {
		section.expanded.bind(function (isExpanded) {
			if (isExpanded) {
				wp.customize.previewer.previewUrl.set(EXM_CUSTOMIZER.shop_url);
			}
		});
	});
	wp.customize.section('exm_recom_product', function (section) {
		section.expanded.bind(function (isExpanded) {
			if (isExpanded) {
				wp.customize.previewer.previewUrl.set(EXM_CUSTOMIZER.product_url);
			}
		});
	});
	wp.customize.section('exm_recom_category_header', function (section) {
		section.expanded.bind(function (isExpanded) {
			if (isExpanded) {
				wp.customize.previewer.previewUrl.set(EXM_CUSTOMIZER.category_url);
			}
		});
	});
		wp.customize.section('exm_recom_category_footer', function (section) {
		section.expanded.bind(function (isExpanded) {
			if (isExpanded) {
				wp.customize.previewer.previewUrl.set(EXM_CUSTOMIZER.category_url);
			}
		});
	});
});