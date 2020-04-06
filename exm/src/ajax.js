var Ajax = function () {

	var request = function (ajax_action, callback, parameters) {
		fetch(EXMCONFIG.ajax_url, {
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
			console.log(error);
		});
	};

	return {
		request: request
	}
}();

export default Ajax;