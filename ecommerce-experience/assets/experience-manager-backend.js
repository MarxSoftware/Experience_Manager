EXM.Dom.ready(function (event) {
	console.log("do backend magic");
	
	//do_products(1);
});

function do_products (page, statusElement) {
	console.log("do_products page: " + page);
	EXM.Ajax.request("exm_get_products", function (data) {
		let status = "<b>Status: " + data.page + " / " + data.total_pages + "</b>";
		statusElement.innerHTML = status;
		if (page < data.total_pages) {
			do_products(page+1, statusElement);
		}
	}, "&page=" + page);
}

function exm_wc_sync_products (event) {
	let $target = document.getElementById("exm-woocommerce-settings[exm_wc_sync_products]");
	let statusID = ""+new Date().getTime();
	let statusElement = document.getElementById(statusID);
	if (!statusElement) {
		statusElement = document.createElement("p");
		statusElement.setAttribute("id", statusID);
	}
	$target.parentNode.insertBefore(statusElement, $target.nextSibling);
	
	do_products(1, statusElement);
	
	return false;
}