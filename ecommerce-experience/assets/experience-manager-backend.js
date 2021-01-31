EXM.Dom.ready(function (event) {
	console.log("do backend magic");
	
	do_products(1);
});

function do_products (page) {
	console.log("do_products page: " + page);
	EXM.Ajax.request("exm_get_products", function (data) {
		console.log(data);
		if (page < data.total_pages) {
			do_products(page+1);
		}
	}, "&page=" + page);
}