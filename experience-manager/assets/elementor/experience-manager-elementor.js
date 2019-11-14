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
	window.elementor.channels.editor.on("exm:editor:highlight", function () {
		tma_toggle_highlight();
	});

});
var tma_exm_elementor_highlight = false;
function tma_toggle_highlight() {
	if (tma_exm_elementor_highlight) {
		tma_exm_elementor_highlight = false;
		webtools.Highlight.deactivate();
	} else {
		tma_exm_elementor_highlight = true;
		webtools.Highlight.activate(Array.apply([], document.querySelectorAll('[data-tma-group]')));
	}
}

