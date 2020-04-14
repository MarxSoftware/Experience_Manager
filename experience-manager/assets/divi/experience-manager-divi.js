EXM.Hook.register("experience-manager/frontend/update/before", (arguments) => {
	// this workaround is for divi, because divi has no usable hook to add classes to an element
	let defaults = document.querySelectorAll('[data-tma-divi-default="no"]');
	for (i = 0; i < defaults.length; ++i) {
		defaults[i].removeAttribute('data-tma-divi-default');
	}
})