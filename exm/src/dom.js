var Dom = function () {

	var insertElement = function (name, type, content) {
		var headElement = document.createElement(name);
		headElement.type = type;
		headElement.innerText = content;
		document.head.appendChild(headElement);
	}

	return {
		insertElement: insertElement
	}
}();

export default Dom;