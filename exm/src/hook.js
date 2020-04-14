var Dom = function () {

	var hooks = [];
	var register = function (name, callback, priority) {
		if (typeof hooks[name] === "undefined") {
			hooks[name] = [];
		}
		if (parseInt(priority, 10) === priority) { // should be a valid integer
			if (hooks[name].length > priority + 1) {
				hooks[name].splice(priority, 0, callback);
			} else {
				hooks[name].push(callback);
			}
		} else {
			hooks[name].push(callback);
		}
	};

	var call = function (name, arguments) {
		if (typeof hooks[name] !== "undefined") {
			for (var i = 0, len = hooks[name].length; i < len; ++i) {
				if (hooks[name][i](arguments) !== true)
					break;
			}
		}
	}

	return {
		register: register,
		call : call
	}
}();

export default Dom;