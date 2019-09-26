/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
