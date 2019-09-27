var onElementorReady = function() {
  return new Promise((resolve) => {
    var waitForElement = function() {
		if (typeof window.elementor === "object" && typeof window.elementor.channels === "object") {
        resolve();
      } else {
        window.requestAnimationFrame(waitForElement);
      }
    };
    waitForElement();
  })
};

onElementorReady().then(function () {
	console.log("Hallo Leute");
	console.log("exm", window.elementor);

	window.elementor.channels.editor.on("exm:editor:preview", function () {
		console.log("event");
	});

});
//webtools.domReady(function (event) {
//	console.log("Hallo Leute");
//	console.log("exm", window.elementor);
//
//	window.elementor.channels.editor.on("exm:editor:preview", function () {
//		console.log("event");
//	});
//
//});
