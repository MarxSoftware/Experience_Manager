var EXM_Hook = {
	hooks: [],
	register: function (name, callback, priority) {
		if (typeof EXM_Hook.hooks[name] === "undefined") {
			EXM_Hook.hooks[name] = [];
		}
		if (parseInt(priority, 10) === priority) { // should be a valid integer
			if (EXM_Hook.hooks[name].length > priority + 1) {
				EXM_Hook.hooks[name].splice(priority, 0, callback);
			} else {
				EXM_Hook.hooks[name].push(callback);
			}
		} else {
			EXM_Hook.hooks[name].push(callback);
		}
	},
	call: function (name, arguments) {
		if (typeof EXM_Hook.hooks[name] !== "undefined") {
			for (var i = 0, len = EXM_Hook.hooks[name].length; i < len; ++i) {
				if (EXM_Hook.hooks[name][i](arguments) !== true)
					break;
			}
		}
	}
};