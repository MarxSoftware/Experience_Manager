EXM.Dom.ready(function (event) {
	console.log("und los");
	EXM.Ajax.request("exm_ecom_load_products", function (data) {
		console.log(data);
	}, "&type=recently-viewed-products");
});