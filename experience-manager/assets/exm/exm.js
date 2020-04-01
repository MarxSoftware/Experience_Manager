if (typeof EXM === "undefined") {
	window.EXM = {};
}

if (typeof EXM.WOO == "undefined") {
	EXM.WOO = {};
}
EXM.WOO.addToBasket = function (product_id, product_sku, quantity, callback) {
	var data = {
		'product_sku': product_sku,
		'product_id': product_id,
		'quantity': quantity
	};

	let response = {};
	jQuery.post(wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'), data, function (response) {
		if (!response) {
			return;
		}

		if (response.error && response.product_url) {
			window.location = response.product_url;
			return;
		}

		// Redirect to cart option
		if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
//			window.location = wc_add_to_cart_params.cart_url;
			response.redirect = wc_add_to_cart_params.cart_url;
//			return;
		} else {
			jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash]);
		}
		response.error = false;
	}).error(function () {
		response.error = true;
	}).always(function () {
		callback(response);
	});
};

if (typeof EXM.AJAX == "undefined") {
	EXM.AJAX = {};
}
EXM.AJAX.request = function (ajax_action, callback, parameters) {
	fetch(EXM.ajax_url, {
		method: "POST",
		mode: "cors",
		cache: "no-cache",
		credentials: "same-origin",
		body: "action=" + ajax_action + (typeof parameters !== "undefined" ? parameters : ""),
		headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'}),
	}).then((resp) => resp.json())
	.then(function (data) {
		callback(data);
	}).catch(function (error) {
		console.log(JSON.stringify(error));
	});
};

if (typeof EXM.DOM == "undefined") {
	EXM.DOM = {};
}
EXM.DOM.insertElement = function (name, type, content) {
	var headElement = document.createElement(name);
	headElement.type = type;
	headElement.innerText = content;
	document.head.appendChild(headElement);
};

document.addEventListener('exm_loaded', function (e) {
	console.log(EXM.User.logged_in);
}, false);

EXM.AJAX.request("exm_user", (data) => {
	EXM.User = data;
	document.dispatchEvent(new Event("exm_loaded"));
});