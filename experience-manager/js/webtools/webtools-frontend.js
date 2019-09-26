(function (webtools, document) {
    webtools.Context = {};
}(window.webtools = window.webtools || {}, document));

/**
 * The user segments are in the global TMA_CONFIG Objekt
 * TMA_CONFIG.user_segments = ["seg1", "seg2"]
 *
 * Elemente werden unter folgenden Bedingungen angezeigt.
 * 1.
 */
(function (frontend, document) {
    var CLASS_HIDDEN = "tma-hide";
    var SELECTOR_HIDDEN = "." + CLASS_HIDDEN;
    let update = function (selectedSegments) {
        document.querySelectorAll(SELECTOR_HIDDEN).forEach(function (element) {
            element.classList.remove(CLASS_HIDDEN);
        });
        var groups = collectGroups();
        groups.forEach(function (group) {
            var matches = [];
            document.querySelectorAll("[data-tma-group=" + group + "]").forEach(function (element) {
                if (element.dataset.tmaPersonalization !== "enabled") {
                    return;
                }
                if (!matchs(element, selectedSegments)) {
                    element.classList.add(CLASS_HIDDEN);
                }
                else {
                    matches.push(element);
                }
            });
            //console.log(matches);
            // remove the default
            if (matches.length > 1) {
                matches.filter(function (item) {
                    return item.dataset.tmaDefault === "yes";
                }).forEach(function (item) {
                    item.classList.add(CLASS_HIDDEN);
                });
            }
        });
    };
    let matchs = function ($element, selectedSegments) {
        if ($element.dataset.tmaDefault === "yes") {
            return true;
        }
        else if ($element.dataset.tmaMatching === "all") {
            var segments = $element.dataset.tmaSegments.split(",");
            var matching = true;
            segments.forEach(function (s) {
                if (!selectedSegments.includes(s)) {
                    matching = false;
                }
            });
            return matching;
        }
        else if ($element.dataset.tmaMatching === "any") {
            var segments = $element.dataset.tmaSegments.split(",");
            var matching = false;
            segments.forEach(function (s) {
                if (selectedSegments.includes(s)) {
                    matching = true;
                }
            });
            return matching;
        }
        else if ($element.dataset.tmaMatching === "none") {
            var segments = $element.dataset.tmaSegments.split(",");
            var matching = false;
            segments.forEach(function (s) {
                if (selectedSegments.includes(s)) {
                    matching = false;
                }
            });
            return matching;
        }
        return false;
    };
    let collectGroups = function () {
        var groups = [];
        document.querySelectorAll("[data-tma-group]").forEach(function (element) {
            var group = element.getAttribute("data-tma-group").trim();
            if (!groups.includes(group) && group !== "") {
                groups.push(group);
            }
        });
        return groups;
    };
    frontend.update = update;
}(window.webtools.Frontend = window.webtools.Frontend || {}, document));

(function (request, document) {
    /**
     * @returns A Promise
     */
    request.get = function (url, options) {
        options = options || { method: "GET" };
        if (typeof fetch !== "undefined") {
            return fetch(url, options);
        }
        else {
            return new Promise((resolve, reject) => {
                let request = new XMLHttpRequest();
                request.open(options.method || 'get', url, true);
                for (let i in options.headers) {
                    request.setRequestHeader(i, options.headers[i]);
                }
                request.withCredentials = options.credentials == 'include';
                request.onload = () => {
                    resolve(response());
                };
                request.onerror = reject;
                request.send(options.body || null);
                function response() {
                    let keys = [], all = [], headers = {}, header;
                    request.getAllResponseHeaders().replace(/^(.*?):[^\S\n]*([\s\S]*?)$/gm, (m, key, value) => {
                        keys.push(key = key.toLowerCase());
                        all.push([key, value]);
                        header = headers[key];
                        headers[key] = header ? `${header},${value}` : value;
                    });
                    return {
                        ok: (request.status / 100 | 0) == 2,
                        status: request.status,
                        statusText: request.statusText,
                        url: request.responseURL,
                        clone: response,
                        text: () => Promise.resolve(request.responseText),
                        json: () => Promise.resolve(request.responseText).then(JSON.parse),
                        blob: () => Promise.resolve(new Blob([request.response])),
                        headers: {
                            keys: () => keys,
                            entries: () => all,
                            get: (n) => headers[n.toLowerCase()],
                            has: (n) => n.toLowerCase() in headers
                        }
                    };
                }
            });
        }
    };
}(window.webtools.Request = window.webtools.Request || {}, document));

/**
 * https://codepen.io/malyw/pen/zxKJQQ
 */
(function (highlight, document) {
    // VARS
    var HIGHLIGHT_CLASS = "webtools-highlight";
    var HIGHLIGHT_ACTIVE_CLASS = "webtools-highlight-is-active";
    var highlightIsActive = false;
    var $highlightedElements = [];
    var $highlightCanvas = null;
    // HIGHLIGHT HELPERS
    highlight.activate = function ($element) {
        if (Array.isArray($element)) {
            $highlightedElements = $element;
        }
        else {
            $highlightedElements.push($element);
        }
        if ($highlightedElements.length === 0) {
            return;
        }
        highlightIsActive = true;
        $highlightCanvas = document.createElement("canvas");
        $highlightCanvas.style.position = "absolute";
        $highlightCanvas.id = "webtools_canvas";
        $highlightCanvas.style.top = 0;
        $highlightCanvas.style.left = 0;
        $highlightCanvas.style.width = document.body.clientWidth;
        $highlightCanvas.style.height = document.body.clientHeight;
        $highlightCanvas.style.zIndex = 10000;
        $highlightCanvas.width = document.body.clientWidth;
        $highlightCanvas.height = document.body.clientHeight;
        document.body.appendChild($highlightCanvas);
        var context = $highlightCanvas.getContext("2d");
        context.fillStyle = 'black';
        context.globalAlpha = 0.7;
        context.fillRect(0, 0, $highlightCanvas.width, $highlightCanvas.height);
        context.globalAlpha = 1.0;
        context.globalCompositeOperation = 'destination-out';
        $highlightedElements.forEach(function ($e) {
            var elementRect = $e.getBoundingClientRect();
            var offset = getOffset($e);
            // translate to fit into document.body.style.width and document.body.style.height;
            var rect = $highlightCanvas.getBoundingClientRect();
            var xMouse = elementRect.left - rect.left;
            var yMouse = elementRect.top - rect.top;
            context.fillRect(offset.left, offset.top, elementRect.width, elementRect.height);
        });
    };
    function getOffset(el) {
        el = el.getBoundingClientRect();
        return {
            left: el.left + window.scrollX,
            top: el.top + window.scrollY
        };
    }
    highlight.deactivate = function () {
        if ($highlightCanvas) {
            $highlightCanvas.remove();
        }
        $highlightedElements = [];
        highlightIsActive = false;
    };
    highlight.is = function () {
        return $highlightedElements.length > 0;
    };
    /*
    webtools.domReady(function () {
        webtools.Tools.on(document, "click", function () {
            if (highlightIsActive > 0) {
                highlight.deactivate();
            }
        })
    });
    */
}(window.webtools.Highlight = window.webtools.Highlight || {}, document));

(function (exports, d) {
    function domReady(fn, context) {
        function onReady(event) {
            d.removeEventListener("DOMContentLoaded", onReady);
            fn.call(context || exports, event);
        }
        function onReadyIe(event) {
            if (d.readyState === "complete") {
                d.detachEvent("onreadystatechange", onReadyIe);
                fn.call(context || exports, event);
            }
        }
        d.addEventListener && d.addEventListener("DOMContentLoaded", onReady) ||
            d.attachEvent && d.attachEvent("onreadystatechange", onReadyIe);
    }
    exports.domReady = domReady;
})(window.webtools = window.webtools || {}, document);

(function (exports, d) {
    exports.waitFor = function (selector) {
        return new Promise((resolve) => {
            var waitForElement = function () {
                let $element = document.querySelector(selector);
                if ($element) {
                    resolve($element);
                }
                else {
                    window.requestAnimationFrame(waitForElement);
                }
            };
            waitForElement();
        });
    };
})(window.webtools.Element = window.webtools.Element || {}, document);
