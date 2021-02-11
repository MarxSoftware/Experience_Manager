EXM.Hook.register("experience-manager/recommendation/added", (arguments) => {
	if (arguments.data.template && arguments.data.template === "widget/slider") {
		$element = document.getElementById(arguments.data.id);
		if ($element) {
			registerSlideShow($element);
		}
	}
}, 1);
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
				EXM.Hook.call("experience-manager/recommendation/added", {data: data});
			}
		}, "&type=" + type + "&size=" + size + "&category=" + category + "&product=" + product + "&template=" + template + "&title=" + title);
	});
});

function registerSlideShow($element) {
	console.log("registerSlideShow");
	let slideIndex = 0;
	var slides = $element.querySelectorAll('.exm-widget-slide');
	console.log(slides.length);
	if (slides.length === 0) {
		return;
	}
	let slideFunction = () => {
		slides.forEach(slide => {
			slide.style.display = "none";
		});
		slideIndex++;
		if (slideIndex > slides.length) {
			slideIndex = 1;
		}
		slides[slideIndex - 1].style.display = "block";
	}
	setInterval(slideFunction, 4000);
}