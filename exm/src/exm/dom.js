var Dom = function () {

	var insertHeadElement = function (name, type, content) {
		var headElement = document.createElement(name);
		headElement.type = type;
		headElement.innerText = content;
		document.head.appendChild(headElement);
	}
	var ready = function (callbackFunc) {
		if (document.readyState !== 'loading') {
			// Document is already ready, call the callback directly
			callbackFunc();
		} else if (document.addEventListener) {
			// All modern browsers to register DOMContentLoaded
			document.addEventListener('DOMContentLoaded', callbackFunc);
		} else {
			// Old IE browsers
			document.attachEvent('onreadystatechange', function () {
				if (document.readyState === 'complete') {
					callbackFunc();
				}
			});
		}
	}

	var on = function ($element, type, callback) {
        $element.addEventListener(type, callback);
    };

	return {
		insertHeadElement: insertHeadElement,
		ready : ready
	}
}();

export default Dom;