var Woo = function () {

	var addToBasket = function (product_id, product_sku, quantity, callback) {
		let data = {
			'product_sku': product_sku,
			'product_id': product_id,
			'quantity': quantity
		};

		let queryString = Object.keys(data).map(function (key) {
			return key + '=' + data[key]
		}).join('&');

		let ajax_url = wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart');

		fetch(ajax_url, {
			method: "POST",
			mode: "cors",
			cache: "no-cache",
			credentials: "same-origin",
			body: queryString,
			headers: new Headers({ 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json' }),
		}).then((resp) => resp.json())
			.then(function (data) {
				if (!data) {
					return;
				}
				if (data.error && data.product_url) {
					window.location = data.product_url;
					return;
				}
				let response = {}
				// Redirect to cart option
				if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
					response.redirect = wc_add_to_cart_params.cart_url;
				} else {
					jQuery(document.body).trigger('added_to_cart', [data.fragments, data.cart_hash]);
				}
				response.error = false
				callback(response)
			}).catch(function (error) {
				let response = {}
				response.error = true
				callback(response)
			});
	}
	return {
		addToBasket: addToBasket
	}
}();

export default Woo;