EXM.Dom.ready(function (event) {
	console.log("und los");
	/*
	EXM.Ajax.request("exm_ecom_load_products_html", function (data) {
		console.log(data);
	}, "&type=recently-viewed-products&product=68&template=single-product-related&title=Hallo Leute");
*/
	document.querySelectorAll("[data-exm-recommendation]").forEach(function ($item) {
		console.log("found recommendation");
		let type = $item.dataset.exmRecommendation;
		let size = $item.dataset.exmRecommendationSize;
		let product = $item.dataset.exmProduct;
		let category = $item.dataset.exmCategory;
		let template = $item.dataset.exmTemplate;
		let title = $item.dataset.exmTitle;

		EXM.Ajax.request("exm_ecom_load_products_html", function (data) {
			if (data.error === false) {
				$item.innerHTML = data.content;
			}
		}, "&type=" + type + "&size=" + size + "&category=" + category + "&product=" + product + "&template=" + template + "&title=" + title);
	});
});