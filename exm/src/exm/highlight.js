
var Highlight = function () {


    var HIGHLIGHT_CLASS = "exm-highlight";
    var HIGHLIGHT_ACTIVE_CLASS = "exm-highlight-is-active";
    var highlightIsActive = false;
    var $highlightedElements = [];

    var $highlightCanvas = null;

    // HIGHLIGHT HELPERS
    var activate = function ($element) {
        if (Array.isArray($element)) {
            $highlightedElements = $element
        } else {
            $highlightedElements.push($element);    
        }
        if ($highlightedElements.length === 0) {
            return;
        }
        highlightIsActive = true;
       

        $highlightCanvas = document.createElement("canvas");
        $highlightCanvas.style.position = "absolute";
        $highlightCanvas.id = "exm_highlight_canvas";
        $highlightCanvas.style.top = 0;
        $highlightCanvas.style.left = 0;
        $highlightCanvas.style.width = document.body.clientWidth;
        $highlightCanvas.style.height = document.body.clientHeight;
        $highlightCanvas.style.zIndex = 10000; 
        $highlightCanvas.width  = document.body.clientWidth;
        $highlightCanvas.height = document.body.clientHeight;
        document.body.appendChild($highlightCanvas);

        var context = $highlightCanvas.getContext("2d");
        context.fillStyle = 'black';
        context.globalAlpha = 0.7;
        context.fillRect(0, 0, $highlightCanvas.width, $highlightCanvas.height);
        context.globalAlpha = 1.0;
        context.globalCompositeOperation = 'destination-out';
        $highlightedElements.forEach (function ($e) {
            var elementRect = $e.getBoundingClientRect();
            var offset = _getOffset($e);
            // translate to fit into document.body.style.width and document.body.style.height;
            var rect   =  $highlightCanvas.getBoundingClientRect();
            var xMouse =  elementRect.left  - rect.left;
            var yMouse =  elementRect.top  - rect.top;
            context.fillRect(offset.left, offset.top, elementRect.width, elementRect.height);
        });
    }

    var _getOffset = function (el) {
        el = el.getBoundingClientRect();
        return {
          left: el.left + window.scrollX,
          top: el.top + window.scrollY
        }
      }

    var deactivate = function () {
        if ($highlightCanvas) {
            $highlightCanvas.remove();
        }

        $highlightedElements = [];
        highlightIsActive = false;
    }
    var is = function () {
        return $highlightedElements.length > 0;
    }
    

    return {
        activate: activate
        , deactivate: deactivate
        , is: is
    }
}();

export default Highlight;