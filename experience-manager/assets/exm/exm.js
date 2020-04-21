var EXM =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./src/exm.scss":
/*!***************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./src/exm.scss ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// Imports\nvar ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../node_modules/css-loader/dist/runtime/api.js */ \"./node_modules/css-loader/dist/runtime/api.js\");\nexports = ___CSS_LOADER_API_IMPORT___(false);\n// Module\nexports.push([module.i, \".exm .popup {\\n  position: absolute;\\n  transition: transform 0.5s ease; }\\n  .exm .popup.animation-fade-in {\\n    opacity: 1;\\n    -webkit-transition: opacity 0.5s ease-out;\\n    -moz-transition: opacity 0.5s ease-out;\\n    -o-transition: opacity 0.5s ease-out;\\n    transition: opacity 0.5s ease-out; }\\n  .exm .popup.animation-fade-out {\\n    opacity: 0;\\n    -webkit-transition: opacity 0.5s ease-out;\\n    -moz-transition: opacity 0.5s ease-out;\\n    -o-transition: opacity 0.5s ease-out;\\n    transition: opacity 0.5s ease-out; }\\n  .exm .popup.animation-slide-out-left {\\n    transform: translateX(-200%);\\n    -webkit-transform: translateX(-200%); }\\n  .exm .popup.animation-slide-out-right {\\n    transform: translateX(200%);\\n    -webkit-transform: translateX(200%); }\\n  .exm .popup.animation-slide-out-top {\\n    transform: translateY(-200%);\\n    -webkit-transform: translateY(-200%); }\\n  .exm .popup.animation-slide-out-bottom {\\n    transform: translateY(200%);\\n    -webkit-transform: translateY(200%); }\\n  .exm .popup.show {\\n    transform: translateX(0);\\n    -webkit-transform: translateX(0); }\\n\\n.exm .popup-container {\\n  position: absolute;\\n  overflow: hidden; }\\n  .exm .popup-container.position-top-left {\\n    left: 0px;\\n    top: 0px; }\\n  .exm .popup-container.position-top-right {\\n    right: 0px;\\n    top: 0px; }\\n  .exm .popup-container.position-top-center {\\n    top: 0px;\\n    left: 50%;\\n    /* position the left edge of the element at the middle of the parent */\\n    transform: translateX(-50%); }\\n  .exm .popup-container.position-middle-center {\\n    top: 50%;\\n    /* position the top  edge of the element at the middle of the parent */\\n    left: 50%;\\n    /* position the left edge of the element at the middle of the parent */\\n    transform: translate(-50%, -50%);\\n    /* This is a shorthand of translateX(-50%) and translateY(-50%) */ }\\n  .exm .popup-container.position-middle-left {\\n    top: 50%;\\n    /* position the top  edge of the element at the middle of the parent */\\n    left: 0px;\\n    transform: translateY(-50%); }\\n  .exm .popup-container.position-middle-right {\\n    top: 50%;\\n    /* position the top  edge of the element at the middle of the parent */\\n    right: 0px;\\n    transform: translateY(-50%); }\\n  .exm .popup-container.position-bottom-left {\\n    left: 0px;\\n    bottom: 0px; }\\n  .exm .popup-container.position-bottom-right {\\n    right: 0px;\\n    bottom: 0px; }\\n  .exm .popup-container.position-bottom-center {\\n    bottom: 0px;\\n    left: 50%;\\n    /* position the left edge of the element at the middle of the parent */\\n    transform: translateX(-50%); }\\n\\n.exm .overlay {\\n  position: fixed;\\n  display: none;\\n  width: 100%;\\n  height: 100%;\\n  top: 0;\\n  left: 0;\\n  right: 0;\\n  bottom: 0;\\n  background-color: rgba(0, 0, 0, 0.5);\\n  z-index: 1900;\\n  cursor: pointer; }\\n\\n/**\\r\\nSTART HIGHLIGHT\\r\\n**/\\nbody.exm-highlight-is-active {\\n  pointer-events: none; }\\n\\n.exm-highlight {\\n  box-shadow: 0 0 0 99999px rgba(0, 0, 0, 0.8);\\n  position: relative;\\n  z-index: 9999;\\n  pointer-events: auto;\\n  transition: all 0.5s ease; }\\n\\n/**\\r\\n  END Highlight\\r\\n  **/\\n\", \"\"]);\n// Exports\nmodule.exports = exports;\n\n\n//# sourceURL=webpack://EXM/./src/exm.scss?./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js");

/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n/*\n  MIT License http://www.opensource.org/licenses/mit-license.php\n  Author Tobias Koppers @sokra\n*/\n// css base code, injected by the css-loader\n// eslint-disable-next-line func-names\nmodule.exports = function (useSourceMap) {\n  var list = []; // return the list of modules as css string\n\n  list.toString = function toString() {\n    return this.map(function (item) {\n      var content = cssWithMappingToString(item, useSourceMap);\n\n      if (item[2]) {\n        return \"@media \".concat(item[2], \" {\").concat(content, \"}\");\n      }\n\n      return content;\n    }).join('');\n  }; // import a list of modules into the list\n  // eslint-disable-next-line func-names\n\n\n  list.i = function (modules, mediaQuery, dedupe) {\n    if (typeof modules === 'string') {\n      // eslint-disable-next-line no-param-reassign\n      modules = [[null, modules, '']];\n    }\n\n    var alreadyImportedModules = {};\n\n    if (dedupe) {\n      for (var i = 0; i < this.length; i++) {\n        // eslint-disable-next-line prefer-destructuring\n        var id = this[i][0];\n\n        if (id != null) {\n          alreadyImportedModules[id] = true;\n        }\n      }\n    }\n\n    for (var _i = 0; _i < modules.length; _i++) {\n      var item = [].concat(modules[_i]);\n\n      if (dedupe && alreadyImportedModules[item[0]]) {\n        // eslint-disable-next-line no-continue\n        continue;\n      }\n\n      if (mediaQuery) {\n        if (!item[2]) {\n          item[2] = mediaQuery;\n        } else {\n          item[2] = \"\".concat(mediaQuery, \" and \").concat(item[2]);\n        }\n      }\n\n      list.push(item);\n    }\n  };\n\n  return list;\n};\n\nfunction cssWithMappingToString(item, useSourceMap) {\n  var content = item[1] || ''; // eslint-disable-next-line prefer-destructuring\n\n  var cssMapping = item[3];\n\n  if (!cssMapping) {\n    return content;\n  }\n\n  if (useSourceMap && typeof btoa === 'function') {\n    var sourceMapping = toComment(cssMapping);\n    var sourceURLs = cssMapping.sources.map(function (source) {\n      return \"/*# sourceURL=\".concat(cssMapping.sourceRoot || '').concat(source, \" */\");\n    });\n    return [content].concat(sourceURLs).concat([sourceMapping]).join('\\n');\n  }\n\n  return [content].join('\\n');\n} // Adapted from convert-source-map (MIT)\n\n\nfunction toComment(sourceMap) {\n  // eslint-disable-next-line no-undef\n  var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));\n  var data = \"sourceMappingURL=data:application/json;charset=utf-8;base64,\".concat(base64);\n  return \"/*# \".concat(data, \" */\");\n}\n\n//# sourceURL=webpack://EXM/./node_modules/css-loader/dist/runtime/api.js?");

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nvar isOldIE = function isOldIE() {\n  var memo;\n  return function memorize() {\n    if (typeof memo === 'undefined') {\n      // Test for IE <= 9 as proposed by Browserhacks\n      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805\n      // Tests for existence of standard globals is to allow style-loader\n      // to operate correctly into non-standard environments\n      // @see https://github.com/webpack-contrib/style-loader/issues/177\n      memo = Boolean(window && document && document.all && !window.atob);\n    }\n\n    return memo;\n  };\n}();\n\nvar getTarget = function getTarget() {\n  var memo = {};\n  return function memorize(target) {\n    if (typeof memo[target] === 'undefined') {\n      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself\n\n      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {\n        try {\n          // This will throw an exception if access to iframe is blocked\n          // due to cross-origin restrictions\n          styleTarget = styleTarget.contentDocument.head;\n        } catch (e) {\n          // istanbul ignore next\n          styleTarget = null;\n        }\n      }\n\n      memo[target] = styleTarget;\n    }\n\n    return memo[target];\n  };\n}();\n\nvar stylesInDom = [];\n\nfunction getIndexByIdentifier(identifier) {\n  var result = -1;\n\n  for (var i = 0; i < stylesInDom.length; i++) {\n    if (stylesInDom[i].identifier === identifier) {\n      result = i;\n      break;\n    }\n  }\n\n  return result;\n}\n\nfunction modulesToDom(list, options) {\n  var idCountMap = {};\n  var identifiers = [];\n\n  for (var i = 0; i < list.length; i++) {\n    var item = list[i];\n    var id = options.base ? item[0] + options.base : item[0];\n    var count = idCountMap[id] || 0;\n    var identifier = \"\".concat(id, \" \").concat(count);\n    idCountMap[id] = count + 1;\n    var index = getIndexByIdentifier(identifier);\n    var obj = {\n      css: item[1],\n      media: item[2],\n      sourceMap: item[3]\n    };\n\n    if (index !== -1) {\n      stylesInDom[index].references++;\n      stylesInDom[index].updater(obj);\n    } else {\n      stylesInDom.push({\n        identifier: identifier,\n        updater: addStyle(obj, options),\n        references: 1\n      });\n    }\n\n    identifiers.push(identifier);\n  }\n\n  return identifiers;\n}\n\nfunction insertStyleElement(options) {\n  var style = document.createElement('style');\n  var attributes = options.attributes || {};\n\n  if (typeof attributes.nonce === 'undefined') {\n    var nonce =  true ? __webpack_require__.nc : undefined;\n\n    if (nonce) {\n      attributes.nonce = nonce;\n    }\n  }\n\n  Object.keys(attributes).forEach(function (key) {\n    style.setAttribute(key, attributes[key]);\n  });\n\n  if (typeof options.insert === 'function') {\n    options.insert(style);\n  } else {\n    var target = getTarget(options.insert || 'head');\n\n    if (!target) {\n      throw new Error(\"Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.\");\n    }\n\n    target.appendChild(style);\n  }\n\n  return style;\n}\n\nfunction removeStyleElement(style) {\n  // istanbul ignore if\n  if (style.parentNode === null) {\n    return false;\n  }\n\n  style.parentNode.removeChild(style);\n}\n/* istanbul ignore next  */\n\n\nvar replaceText = function replaceText() {\n  var textStore = [];\n  return function replace(index, replacement) {\n    textStore[index] = replacement;\n    return textStore.filter(Boolean).join('\\n');\n  };\n}();\n\nfunction applyToSingletonTag(style, index, remove, obj) {\n  var css = remove ? '' : obj.media ? \"@media \".concat(obj.media, \" {\").concat(obj.css, \"}\") : obj.css; // For old IE\n\n  /* istanbul ignore if  */\n\n  if (style.styleSheet) {\n    style.styleSheet.cssText = replaceText(index, css);\n  } else {\n    var cssNode = document.createTextNode(css);\n    var childNodes = style.childNodes;\n\n    if (childNodes[index]) {\n      style.removeChild(childNodes[index]);\n    }\n\n    if (childNodes.length) {\n      style.insertBefore(cssNode, childNodes[index]);\n    } else {\n      style.appendChild(cssNode);\n    }\n  }\n}\n\nfunction applyToTag(style, options, obj) {\n  var css = obj.css;\n  var media = obj.media;\n  var sourceMap = obj.sourceMap;\n\n  if (media) {\n    style.setAttribute('media', media);\n  } else {\n    style.removeAttribute('media');\n  }\n\n  if (sourceMap && btoa) {\n    css += \"\\n/*# sourceMappingURL=data:application/json;base64,\".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), \" */\");\n  } // For old IE\n\n  /* istanbul ignore if  */\n\n\n  if (style.styleSheet) {\n    style.styleSheet.cssText = css;\n  } else {\n    while (style.firstChild) {\n      style.removeChild(style.firstChild);\n    }\n\n    style.appendChild(document.createTextNode(css));\n  }\n}\n\nvar singleton = null;\nvar singletonCounter = 0;\n\nfunction addStyle(obj, options) {\n  var style;\n  var update;\n  var remove;\n\n  if (options.singleton) {\n    var styleIndex = singletonCounter++;\n    style = singleton || (singleton = insertStyleElement(options));\n    update = applyToSingletonTag.bind(null, style, styleIndex, false);\n    remove = applyToSingletonTag.bind(null, style, styleIndex, true);\n  } else {\n    style = insertStyleElement(options);\n    update = applyToTag.bind(null, style, options);\n\n    remove = function remove() {\n      removeStyleElement(style);\n    };\n  }\n\n  update(obj);\n  return function updateStyle(newObj) {\n    if (newObj) {\n      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {\n        return;\n      }\n\n      update(obj = newObj);\n    } else {\n      remove();\n    }\n  };\n}\n\nmodule.exports = function (list, options) {\n  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>\n  // tags it will allow on a page\n\n  if (!options.singleton && typeof options.singleton !== 'boolean') {\n    options.singleton = isOldIE();\n  }\n\n  list = list || [];\n  var lastIdentifiers = modulesToDom(list, options);\n  return function update(newList) {\n    newList = newList || [];\n\n    if (Object.prototype.toString.call(newList) !== '[object Array]') {\n      return;\n    }\n\n    for (var i = 0; i < lastIdentifiers.length; i++) {\n      var identifier = lastIdentifiers[i];\n      var index = getIndexByIdentifier(identifier);\n      stylesInDom[index].references--;\n    }\n\n    var newLastIdentifiers = modulesToDom(newList, options);\n\n    for (var _i = 0; _i < lastIdentifiers.length; _i++) {\n      var _identifier = lastIdentifiers[_i];\n\n      var _index = getIndexByIdentifier(_identifier);\n\n      if (stylesInDom[_index].references === 0) {\n        stylesInDom[_index].updater();\n\n        stylesInDom.splice(_index, 1);\n      }\n    }\n\n    lastIdentifiers = newLastIdentifiers;\n  };\n};\n\n//# sourceURL=webpack://EXM/./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js?");

/***/ }),

/***/ "./src/ajax.js":
/*!*********************!*\
  !*** ./src/ajax.js ***!
  \*********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Ajax = function () {\n\n\tvar request = function (ajax_action, callback, parameters) {\n\t\tfetch(EXMCONFIG.ajax_url, {\n\t\t\tmethod: \"POST\",\n\t\t\tmode: \"cors\",\n\t\t\tcache: \"no-cache\",\n\t\t\tcredentials: \"same-origin\",\n\t\t\tbody: \"action=\" + ajax_action + (typeof parameters !== \"undefined\" ? parameters : \"\"),\n\t\t\theaders: new Headers({'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'}),\n\t\t}).then((resp) => resp.json())\n\t\t\t\t.then(function (data) {\n\t\t\t\t\tcallback(data);\n\t\t\t\t}).catch(function (error) {\n\t\t\tconsole.log(error);\n\t\t});\n\t};\n\n\treturn {\n\t\trequest: request\n\t}\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (Ajax);\n\n//# sourceURL=webpack://EXM/./src/ajax.js?");

/***/ }),

/***/ "./src/cookie.js":
/*!***********************!*\
  !*** ./src/cookie.js ***!
  \***********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Cookie = function () {\n\n\tvar cookie_domain = null;\n\n\tvar setDomain = (domain) => {\n\t\tcookie_domain = domain\n\t};\n\n\tvar set = (name, value, expire) => {\n\t\tvar d = new Date();\n        d.setTime(d.getTime() + expire);\n        var expires = \"expires=\" + d.toUTCString();\n        var domain = \"\";\n        if (cookie_domain != null) {\n            domain = \";domain=\" + cookie_domain;\n        }\n        document.cookie = name + \"=\" + value + \"; \" + expires + \";path=/\" + domain + \";SameSite=Strict\";\n\t};\n\n\tvar get = (name) => {\n\t\tif (document.cookie.length > 0) {\n            var c_start = document.cookie.indexOf(name + \"=\");\n            if (c_start !== -1) {\n                c_start = c_start + name.length + 1;\n                var c_end= document.cookie.indexOf(\";\", c_start);\n                if (c_end === -1) {\n                    c_end = document.cookie.length;\n                }\n                return unescape(document.cookie.substring(c_start, c_end));\n            }\n        }\n        return null;\n\t}\n\n\treturn {\n\t\tsetDomain: setDomain,\n\t\tset: set,\n\t\tget: get\n\t}\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (Cookie);\n\n//# sourceURL=webpack://EXM/./src/cookie.js?");

/***/ }),

/***/ "./src/dom.js":
/*!********************!*\
  !*** ./src/dom.js ***!
  \********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Dom = function () {\r\n\r\n\tvar insertHeadElement = function (name, type, content) {\r\n\t\tvar headElement = document.createElement(name);\r\n\t\theadElement.type = type;\r\n\t\theadElement.innerText = content;\r\n\t\tdocument.head.appendChild(headElement);\r\n\t}\r\n\tvar ready = function (callbackFunc) {\r\n\t\tif (document.readyState !== 'loading') {\r\n\t\t\t// Document is already ready, call the callback directly\r\n\t\t\tcallbackFunc();\r\n\t\t} else if (document.addEventListener) {\r\n\t\t\t// All modern browsers to register DOMContentLoaded\r\n\t\t\tdocument.addEventListener('DOMContentLoaded', callbackFunc);\r\n\t\t} else {\r\n\t\t\t// Old IE browsers\r\n\t\t\tdocument.attachEvent('onreadystatechange', function () {\r\n\t\t\t\tif (document.readyState === 'complete') {\r\n\t\t\t\t\tcallbackFunc();\r\n\t\t\t\t}\r\n\t\t\t});\r\n\t\t}\r\n\t}\r\n\r\n\tvar on = function ($element, type, callback) {\r\n        $element.addEventListener(type, callback);\r\n    };\r\n\r\n\treturn {\r\n\t\tinsertHeadElement: insertHeadElement,\r\n\t\tready : ready\r\n\t}\r\n}();\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (Dom);\n\n//# sourceURL=webpack://EXM/./src/dom.js?");

/***/ }),

/***/ "./src/exm.scss":
/*!**********************!*\
  !*** ./src/exm.scss ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var api = __webpack_require__(/*! ../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ \"./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js\");\n            var content = __webpack_require__(/*! !../node_modules/css-loader/dist/cjs.js!../node_modules/sass-loader/dist/cjs.js!./exm.scss */ \"./node_modules/css-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./src/exm.scss\");\n\n            content = content.__esModule ? content.default : content;\n\n            if (typeof content === 'string') {\n              content = [[module.i, content, '']];\n            }\n\nvar options = {};\n\noptions.insert = \"head\";\noptions.singleton = false;\n\nvar update = api(content, options);\n\nvar exported = content.locals ? content.locals : {};\n\n\n\nmodule.exports = exported;\n\n//# sourceURL=webpack://EXM/./src/exm.scss?");

/***/ }),

/***/ "./src/frontend.ts":
/*!*************************!*\
  !*** ./src/frontend.ts ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Frontend = function () {\r\n    var CLASS_HIDDEN = \"tma-hide\";\r\n    var SELECTOR_HIDDEN = \".\" + CLASS_HIDDEN;\r\n    let update = function (selectedSegments) {\r\n        document.querySelectorAll(SELECTOR_HIDDEN).forEach(function (element) {\r\n            element.classList.remove(CLASS_HIDDEN);\r\n        });\r\n        var groups = collectGroups();\r\n        groups.forEach(function (group) {\r\n            var matches = [];\r\n            document.querySelectorAll(\"[data-tma-group=\" + group + \"]\").forEach(function (element) {\r\n                if (element.dataset.tmaPersonalization !== \"enabled\") {\r\n                    return;\r\n                }\r\n                if (!matchs(element, selectedSegments)) {\r\n                    element.classList.add(CLASS_HIDDEN);\r\n                }\r\n                else {\r\n                    matches.push(element);\r\n                }\r\n            });\r\n            //console.log(matches);\r\n            // remove the default\r\n            if (matches.length > 1) {\r\n                matches.filter(function (item) {\r\n                    return item.dataset.tmaDefault === \"yes\";\r\n                }).forEach(function (item) {\r\n                    item.classList.add(CLASS_HIDDEN);\r\n                });\r\n            }\r\n        });\r\n    };\r\n    let matchs = function ($element, selectedSegments) {\r\n        if ($element.dataset.tmaDefault === \"yes\") {\r\n            return true;\r\n        }\r\n        else if ($element.dataset.tmaMatching === \"all\") {\r\n            var segments = $element.dataset.tmaSegments.split(\",\");\r\n            var matching = true;\r\n            segments.forEach(function (s) {\r\n                if (!selectedSegments.includes(s)) {\r\n                    matching = false;\r\n                }\r\n            });\r\n            return matching;\r\n        }\r\n        else if ($element.dataset.tmaMatching === \"any\") {\r\n            var segments = $element.dataset.tmaSegments.split(\",\");\r\n            var matching = false;\r\n            segments.forEach(function (s) {\r\n                if (selectedSegments.includes(s)) {\r\n                    matching = true;\r\n                }\r\n            });\r\n            return matching;\r\n        }\r\n        else if ($element.dataset.tmaMatching === \"none\") {\r\n            var segments = $element.dataset.tmaSegments.split(\",\");\r\n            var matching = false;\r\n            segments.forEach(function (s) {\r\n                if (selectedSegments.includes(s)) {\r\n                    matching = false;\r\n                }\r\n            });\r\n            return matching;\r\n        }\r\n        return false;\r\n    };\r\n    let collectGroups = function () {\r\n        var groups = [];\r\n        document.querySelectorAll(\"[data-tma-group]\").forEach(function (element) {\r\n            var group = element.getAttribute(\"data-tma-group\").trim();\r\n            if (!groups.includes(group) && group !== \"\") {\r\n                groups.push(group);\r\n            }\r\n        });\r\n        return groups;\r\n    };\r\n    return {\r\n        update: update\r\n    };\r\n}();\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (Frontend);\r\n\n\n//# sourceURL=webpack://EXM/./src/frontend.ts?");

/***/ }),

/***/ "./src/highlight.js":
/*!**************************!*\
  !*** ./src/highlight.js ***!
  \**************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n\nvar Highlight = function () {\n\n\n    var HIGHLIGHT_CLASS = \"exm-highlight\";\n    var HIGHLIGHT_ACTIVE_CLASS = \"exm-highlight-is-active\";\n    var highlightIsActive = false;\n    var $highlightedElements = [];\n\n    var $highlightCanvas = null;\n\n    // HIGHLIGHT HELPERS\n    var activate = function ($element) {\n        if (Array.isArray($element)) {\n            $highlightedElements = $element\n        } else {\n            $highlightedElements.push($element);    \n        }\n        if ($highlightedElements.length === 0) {\n            return;\n        }\n        highlightIsActive = true;\n       \n\n        $highlightCanvas = document.createElement(\"canvas\");\n        $highlightCanvas.style.position = \"absolute\";\n        $highlightCanvas.id = \"exm_highlight_canvas\";\n        $highlightCanvas.style.top = 0;\n        $highlightCanvas.style.left = 0;\n        $highlightCanvas.style.width = document.body.clientWidth;\n        $highlightCanvas.style.height = document.body.clientHeight;\n        $highlightCanvas.style.zIndex = 10000; \n        $highlightCanvas.width  = document.body.clientWidth;\n        $highlightCanvas.height = document.body.clientHeight;\n        document.body.appendChild($highlightCanvas);\n\n        var context = $highlightCanvas.getContext(\"2d\");\n        context.fillStyle = 'black';\n        context.globalAlpha = 0.7;\n        context.fillRect(0, 0, $highlightCanvas.width, $highlightCanvas.height);\n        context.globalAlpha = 1.0;\n        context.globalCompositeOperation = 'destination-out';\n        $highlightedElements.forEach (function ($e) {\n            var elementRect = $e.getBoundingClientRect();\n            var offset = _getOffset($e);\n            // translate to fit into document.body.style.width and document.body.style.height;\n            var rect   =  $highlightCanvas.getBoundingClientRect();\n            var xMouse =  elementRect.left  - rect.left;\n            var yMouse =  elementRect.top  - rect.top;\n            context.fillRect(offset.left, offset.top, elementRect.width, elementRect.height);\n        });\n    }\n\n    var _getOffset = function (el) {\n        el = el.getBoundingClientRect();\n        return {\n          left: el.left + window.scrollX,\n          top: el.top + window.scrollY\n        }\n      }\n\n    var deactivate = function () {\n        if ($highlightCanvas) {\n            $highlightCanvas.remove();\n        }\n\n        $highlightedElements = [];\n        highlightIsActive = false;\n    }\n    var is = function () {\n        return $highlightedElements.length > 0;\n    }\n    \n\n    return {\n        activate: activate\n        , deactivate: deactivate\n        , is: is\n    }\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (Highlight);\n\n//# sourceURL=webpack://EXM/./src/highlight.js?");

/***/ }),

/***/ "./src/hook.js":
/*!*********************!*\
  !*** ./src/hook.js ***!
  \*********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Hook = function () {\r\n\r\n\tvar hooks = [];\r\n\tvar register = function (name, callback, priority) {\r\n\t\tif (typeof hooks[name] === \"undefined\") {\r\n\t\t\thooks[name] = [];\r\n\t\t}\r\n\t\tif (parseInt(priority, 10) === priority) { // should be a valid integer\r\n\t\t\tif (hooks[name].length > priority + 1) {\r\n\t\t\t\thooks[name].splice(priority, 0, callback);\r\n\t\t\t} else {\r\n\t\t\t\thooks[name].push(callback);\r\n\t\t\t}\r\n\t\t} else {\r\n\t\t\thooks[name].push(callback);\r\n\t\t}\r\n\t};\r\n\r\n\tvar call = function (name, attributes) {\r\n\t\tif (typeof hooks[name] !== \"undefined\") {\r\n\t\t\tfor (var i = 0, len = hooks[name].length; i < len; ++i) {\r\n\t\t\t\tif (hooks[name][i](attributes) !== true)\r\n\t\t\t\t\tbreak;\r\n\t\t\t}\r\n\t\t}\r\n\t}\r\n\r\n\treturn {\r\n\t\tregister: register,\r\n\t\tcall : call\r\n\t}\r\n}();\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (Hook);\n\n//# sourceURL=webpack://EXM/./src/hook.js?");

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! exports provided: Popup, Dom, Ajax, Woo, Cookie, Tracking, Highlight, Frontend, Hook */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _popup_popup__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./popup/popup */ \"./src/popup/popup.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Popup\", function() { return _popup_popup__WEBPACK_IMPORTED_MODULE_0__[\"default\"]; });\n\n/* harmony import */ var _dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dom */ \"./src/dom.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Dom\", function() { return _dom__WEBPACK_IMPORTED_MODULE_1__[\"default\"]; });\n\n/* harmony import */ var _ajax__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ajax */ \"./src/ajax.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Ajax\", function() { return _ajax__WEBPACK_IMPORTED_MODULE_2__[\"default\"]; });\n\n/* harmony import */ var _woo__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./woo */ \"./src/woo.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Woo\", function() { return _woo__WEBPACK_IMPORTED_MODULE_3__[\"default\"]; });\n\n/* harmony import */ var _cookie__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./cookie */ \"./src/cookie.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Cookie\", function() { return _cookie__WEBPACK_IMPORTED_MODULE_4__[\"default\"]; });\n\n/* harmony import */ var _tracking__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./tracking */ \"./src/tracking.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Tracking\", function() { return _tracking__WEBPACK_IMPORTED_MODULE_5__[\"default\"]; });\n\n/* harmony import */ var _highlight__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./highlight */ \"./src/highlight.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Highlight\", function() { return _highlight__WEBPACK_IMPORTED_MODULE_6__[\"default\"]; });\n\n/* harmony import */ var _frontend__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./frontend */ \"./src/frontend.ts\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Frontend\", function() { return _frontend__WEBPACK_IMPORTED_MODULE_7__[\"default\"]; });\n\n/* harmony import */ var _hook__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./hook */ \"./src/hook.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Hook\", function() { return _hook__WEBPACK_IMPORTED_MODULE_8__[\"default\"]; });\n\n/* harmony import */ var _exm_scss__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./exm.scss */ \"./src/exm.scss\");\n/* harmony import */ var _exm_scss__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_exm_scss__WEBPACK_IMPORTED_MODULE_9__);\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\n\n//# sourceURL=webpack://EXM/./src/index.js?");

/***/ }),

/***/ "./src/popup/popup.animation.js":
/*!**************************************!*\
  !*** ./src/popup/popup.animation.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar PopupAnimation = function () {\r\n\r\n    var getOpenAnimation = function (config) {\r\n        switch (config.animation) {\r\n            case 'fade':\r\n                return 'animation-fade-in'\r\n            case 'slide':\r\n                switch (config.position) {\r\n                    case 'tl':\r\n                    case 'ml':\r\n                    case 'bl':\r\n                        return 'animation-slide-in-left'\r\n                    case 'tr':\r\n                    case 'mr':\r\n                    case 'br':\r\n                        return 'animation-slide-in-right'\r\n                    case 'bc':\r\n                        return 'animation-slide-in-bottom'\r\n                    case 'tc':\r\n                        return 'animation-slide-in-top'\r\n                }\r\n            default:\r\n                return ''\r\n        }\r\n    }\r\n    var getCloseAnimation = function (config) {\r\n        switch (config.animation) {\r\n            case 'fade':\r\n                return 'animation-fade-out'\r\n            case 'slide':\r\n                switch (config.position) {\r\n                    case 'tl':\r\n                    case 'ml':\r\n                    case 'bl':\r\n                        return 'animation-slide-out-left'\r\n                    case 'tr':\r\n                    case 'mr':\r\n                    case 'br':\r\n                        return 'animation-slide-out-right'\r\n                    case 'bc':\r\n                        return 'animation-slide-out-bottom'\r\n                    case 'tc':\r\n                        return 'animation-slide-out-top'\r\n                }\r\n            default:\r\n                return ''\r\n        }\r\n    }\r\n\r\n\r\n    return {\r\n        getCloseAnimation: getCloseAnimation,\r\n        getOpenAnimation: getOpenAnimation\r\n    }\r\n}()\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (PopupAnimation);\n\n//# sourceURL=webpack://EXM/./src/popup/popup.animation.js?");

/***/ }),

/***/ "./src/popup/popup.js":
/*!****************************!*\
  !*** ./src/popup/popup.js ***!
  \****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _popup_trigger__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./popup.trigger */ \"./src/popup/popup.trigger.js\");\n/* harmony import */ var _popup_animation__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./popup.animation */ \"./src/popup/popup.animation.js\");\n/* harmony import */ var _popup_position__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./popup.position */ \"./src/popup/popup.position.js\");\n/* harmony import */ var _popup_overlay__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./popup.overlay */ \"./src/popup/popup.overlay.js\");\n/*\r\n\r\n{\r\n    'id' : \"#id\",\r\n    'trigger' : {\r\n        'type' : 'after<exit_intent'\r\n    },\r\n    'position' : 'tl|tc|tr|ml|mc|mr|bl|bc|br',\r\n    'animation' : 'fade|slide,\r\n    'content' : '<div></div>'\r\n    'conditions' : {\r\n        'weekdays' : ['1']\r\n    }\r\n}\r\n\r\n\r\n*/\r\n\r\n\r\n\r\n\r\n\r\n\r\nvar Popup = function () {\r\n\r\n    var popups = []\r\n\r\n    var _addContainers = function () {\r\n        let exm_container = document.getElementById(\"exm_container\")\r\n        if (exm_container == null) {\r\n            exm_container = document.createElement(\"div\")\r\n            exm_container.classList.add(\"exm\")\r\n            exm_container.id = \"exm_container\"\r\n            document.body.appendChild(exm_container)\r\n        }\r\n        _popup_overlay__WEBPACK_IMPORTED_MODULE_3__[\"default\"].addOverlay(exm_container, _closeHandler.bind(this));\r\n\r\n        return exm_container;\r\n    }\r\n\r\n    var _closeHandler = function () {\r\n        closeAll()\r\n    }\r\n\r\n    var init = function (configuration) {\r\n\r\n        let exm_container = _addContainers();\r\n\r\n        let popup_container = document.createElement(\"div\")\r\n        let popup = document.createElement(\"div\")\r\n\r\n        popup.innerHTML = configuration.content\r\n        popup.setAttribute(\"id\", configuration.id)\r\n        popup.classList.add(\"popup\")\r\n        popup.classList.add(_popup_animation__WEBPACK_IMPORTED_MODULE_1__[\"default\"].getCloseAnimation(configuration))\r\n\r\n        if (_popup_position__WEBPACK_IMPORTED_MODULE_2__[\"default\"].isLeft(configuration)) {\r\n            popup.style.right = 0\r\n        } else if (_popup_position__WEBPACK_IMPORTED_MODULE_2__[\"default\"].isRight(configuration)) {\r\n            popup.style.left = 0\r\n        } \r\n        if (_popup_position__WEBPACK_IMPORTED_MODULE_2__[\"default\"].isTop(configuration)) {\r\n            popup.style.bottom = 0\r\n        } else if (_popup_position__WEBPACK_IMPORTED_MODULE_2__[\"default\"].isBottom(configuration)) {\r\n            popup.style.top = 0\r\n        }\r\n\r\n        popup_container.classList.add(\"popup-container\")\r\n        popup_container.classList.add(_popup_position__WEBPACK_IMPORTED_MODULE_2__[\"default\"].getPosition(configuration))\r\n        popup_container.style.zIndex = \"2000\"\r\n        popup_container.appendChild(popup)\r\n\r\n\r\n        exm_container.appendChild(popup_container)\r\n\r\n        popup_container.style.width = (popup.offsetWidth + 10) + \"px\"\r\n        popup_container.style.height = (popup.offsetHeight + 10) + \"px\"\r\n\r\n        let $closeElement = document.querySelector(\"#\" + configuration.id + \" .close\");\r\n        if ($closeElement) {\r\n            $closeElement.addEventListener(\"click\", () => {\r\n                close(configuration.id)\r\n            });\r\n        }\r\n\r\n        popups.push(configuration);\r\n\r\n        if (configuration.trigger.type === \"after5\") {\r\n            _popup_trigger__WEBPACK_IMPORTED_MODULE_0__[\"default\"].after5(configuration)\r\n        } else if (configuration.trigger.type === \"exit_intent\") {\r\n            _popup_trigger__WEBPACK_IMPORTED_MODULE_0__[\"default\"].exitIntent(configuration)\r\n        }\r\n\r\n    }\r\n\r\n    var close = function (id) {\r\n        let popup = popups.find((element) => element.id === id);\r\n        if (typeof popup !== \"undefined\") {\r\n            _close(popup)\r\n            //document.querySelector(\"#\" + popup.id).closest(\".popup-container\").remove();\r\n        }\r\n    }\r\n\r\n    var _close = function (popup) {\r\n        const openAnimationClass = _popup_animation__WEBPACK_IMPORTED_MODULE_1__[\"default\"].getOpenAnimation(popup)\r\n        const closeAnimationClass = _popup_animation__WEBPACK_IMPORTED_MODULE_1__[\"default\"].getCloseAnimation(popup)\r\n        document.querySelector(\"#\" + popup.id).classList.toggle(openAnimationClass)\r\n        document.querySelector(\"#\" + popup.id).classList.toggle(closeAnimationClass)\r\n\r\n        _popup_overlay__WEBPACK_IMPORTED_MODULE_3__[\"default\"].hide()\r\n    }\r\n\r\n    var closeAll = function () {\r\n        popups.forEach(_close)\r\n    }\r\n\r\n    return {\r\n        init: init,\r\n        close: close,\r\n        closeAll: closeAll\r\n    }\r\n}()\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (Popup);\n\n//# sourceURL=webpack://EXM/./src/popup/popup.js?");

/***/ }),

/***/ "./src/popup/popup.overlay.js":
/*!************************************!*\
  !*** ./src/popup/popup.overlay.js ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n\r\nvar PopupOverlay = function () {\r\n\r\n    var addOverlay = function (exm_container, clickHandler) {\r\n        let popup_overlay = document.getElementById(\"exm_overlay\")\r\n        if (popup_overlay == null) {\r\n            popup_overlay = document.createElement(\"div\")\r\n            popup_overlay.classList.add(\"overlay\")\r\n            popup_overlay.id = \"exm_overlay\"\r\n\r\n            exm_container.appendChild(popup_overlay)\r\n        }\r\n\r\n        popup_overlay.addEventListener('click', clickHandler)\r\n    }\r\n\r\n    var show = function () {\r\n        document.getElementById(\"exm_overlay\").style.display = 'block'\r\n    }\r\n    var hide = function () {\r\n        document.getElementById(\"exm_overlay\").style.display = 'none'\r\n    }\r\n\r\n    return {\r\n        addOverlay: addOverlay,\r\n        show: show,\r\n        hide: hide\r\n    }\r\n}()\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (PopupOverlay);\n\n//# sourceURL=webpack://EXM/./src/popup/popup.overlay.js?");

/***/ }),

/***/ "./src/popup/popup.position.js":
/*!*************************************!*\
  !*** ./src/popup/popup.position.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar PopupPosition = function () {\r\n\r\n\r\n    var getPosition = function (config) {\r\n        switch (config.position) {\r\n            case 'tl':\r\n                return 'position-top-left'\r\n            case 'tc':\r\n                return 'position-top-center'\r\n            case 'tr':\r\n                return 'position-top-right'\r\n            case 'ml':\r\n                return 'position-middle-left'\r\n            case 'mc':\r\n                return 'position-middle-center'\r\n            case 'mr':\r\n                return 'position-middle-right'\r\n            case 'bl':\r\n                return 'position-bottom-left'\r\n            case 'bc':\r\n                return 'position-bottom-center'\r\n            case 'br':\r\n                return 'position-bottom-right'\r\n            default:\r\n                return ''\r\n        }\r\n    }\r\n\r\n    var isTopCenter = function (config) {\r\n        switch (config.position) {\r\n            case 'tc':\r\n                return true\r\n            default:\r\n                return false\r\n        }\r\n    }\r\n    var isTop = function (config) {\r\n        switch (config.position) {\r\n            case 'tr':\r\n            case 'tl':\r\n            case 'tc':\r\n                return true\r\n            default:\r\n                return false\r\n        }\r\n    }\r\n    var isBottom = function (config) {\r\n        switch (config.position) {\r\n            case 'br':\r\n            case 'bl':\r\n            case 'bc':\r\n                return true\r\n            default:\r\n                return false\r\n        }\r\n    }\r\n\r\n    var isBottomCenter = function (config) {\r\n        switch (config.position) {\r\n            case 'bc':\r\n                return true\r\n            default:\r\n                return false\r\n        }\r\n    }\r\n\r\n    var isLeft = function (config) {\r\n        switch (config.position) {\r\n            case 'tl':\r\n            case 'ml':\r\n            case 'bl':\r\n                return true\r\n            default:\r\n                return false\r\n        }\r\n    }\r\n\r\n    var isRight = function (config) {\r\n        switch (config.position) {\r\n            case 'tr':\r\n            case 'mr':\r\n            case 'br':\r\n                return true\r\n            default:\r\n                return false\r\n        }\r\n    }\r\n\r\n    return {\r\n        getPosition: getPosition\r\n        , isLeft: isLeft\r\n        , isRight: isRight\r\n        , isTop: isTop\r\n        , isBottom: isBottom\r\n        , isTopCenter: isTopCenter\r\n        , isBottomCenter: isBottomCenter\r\n    }\r\n}()\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (PopupPosition);\n\n//# sourceURL=webpack://EXM/./src/popup/popup.position.js?");

/***/ }),

/***/ "./src/popup/popup.trigger.js":
/*!************************************!*\
  !*** ./src/popup/popup.trigger.js ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _popup_animation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./popup.animation */ \"./src/popup/popup.animation.js\");\n/* harmony import */ var _popup_overlay__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./popup.overlay */ \"./src/popup/popup.overlay.js\");\n\r\n\r\n\r\nvar PopupTrigger = function () {\r\n\r\n    var _after = function (popup, seconds) {\r\n        const openAnimationClass = _popup_animation__WEBPACK_IMPORTED_MODULE_0__[\"default\"].getOpenAnimation(popup);\r\n        const closeAnimationClass = _popup_animation__WEBPACK_IMPORTED_MODULE_0__[\"default\"].getCloseAnimation(popup);\r\n        _popup_animation__WEBPACK_IMPORTED_MODULE_0__[\"default\"].getCloseAnimation(popup);\r\n        setTimeout(() => {\r\n            _popup_overlay__WEBPACK_IMPORTED_MODULE_1__[\"default\"].show();\r\n            document.querySelector(\"#\" + popup.id).classList.toggle(closeAnimationClass)\r\n            document.querySelector(\"#\" + popup.id).classList.toggle(openAnimationClass)\r\n        }, seconds);\r\n    }\r\n\r\n    var after5 = function (popup) {\r\n        _after(popup, 5000);\r\n    }\r\n    var exitIntent = function (popup) {\r\n        let onMouseOut = (event) => {\r\n            if (\r\n                event.clientY < 50 &&\r\n                event.relatedTarget == null &&\r\n                event.target.nodeName.toLowerCase() !== 'select') {\r\n                // Remove this event listener\r\n                document.removeEventListener(\"mouseout\", onMouseOut);\r\n                _popup_overlay__WEBPACK_IMPORTED_MODULE_1__[\"default\"].show();\r\n                // Show the popup\r\n                const openAnimationClass = _popup_animation__WEBPACK_IMPORTED_MODULE_0__[\"default\"].getOpenAnimation(popup);\r\n                const closeAnimationClass = _popup_animation__WEBPACK_IMPORTED_MODULE_0__[\"default\"].getCloseAnimation(popup);\r\n                document.querySelector(\"#\" + popup.id).classList.toggle(closeAnimationClass)\r\n                document.querySelector(\"#\" + popup.id).classList.toggle(openAnimationClass)\r\n            }\r\n        };\r\n        document.addEventListener(\"mouseout\", onMouseOut);\r\n    }\r\n\r\n    return {\r\n        after5: after5,\r\n        exitIntent: exitIntent\r\n    }\r\n}()\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (PopupTrigger);\n\n//# sourceURL=webpack://EXM/./src/popup/popup.trigger.js?");

/***/ }),

/***/ "./src/tracking.js":
/*!*************************!*\
  !*** ./src/tracking.js ***!
  \*************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _cookie__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./cookie */ \"./src/cookie.js\");\n\n\nvar Tracking = function () {\n\n    var isDNT = navigator.doNotTrack == \"yes\" || navigator.doNotTrack == \"1\"\n        || navigator.msDoNotTrack == \"1\" || window.doNotTrack == \"1\";\n    var DAY = 24 * 60 * 60 * 1000;\n    var HOUR = 60 * 60 * 1000;\n    var MINUTE = 60 * 1000;\n\n    var Context = {\n        site: \"\",\n        page: \"\",\n        host: \"\",\n        type: \"\",\n        uid: \"\",\n        rid: \"\",\n        vid: \"\",\n        pixelImage: null,\n        custom_parameter : null\n    }\n   \n\n    var init = function (host, site, page, type) {\n        Context.site = site;\n        Context.page = page;\n        Context.host = host;\n        Context.type = type\n        Context.uid = \"\";\t\t\t// the userid\n        Context.rid = _uuid();\t\t\t// the requestid\n        Context.vid = \"\";\t\t\t// the visitid\n        Context.pixelImage = new Image();\n    };\n    var page = function (page) {\n        Context.page = page;\n    };\n    var customParameters = function (customParameters) {\n        Context.custom_parameter = customParameters;\n    };\n    var setCookieDomain = function (domain) {\n        _cookie__WEBPACK_IMPORTED_MODULE_0__[\"default\"].setDomain(domain);\n    };\n    var optOut = function () {\n        _cookie__WEBPACK_IMPORTED_MODULE_0__[\"default\"].set('_tma_trackingcookie', \"opt-out\", 365 * Context.DAY);\n    };\n    var dnt = function () {\n        return Context.isDNT || document.cookie.indexOf(\"_tma_trackingcookie=opt-out\") !== -1;\n    }\n    var register = function () {\n        if (!dnt()) {\n            track(\"pageview\");\n        }\n    };\n    var track = function (event) {\n        if (!dnt()) {\n            // opt-out cookie is not set\n            var data = \"event=\" + event + _createDefaultParameters() + _createCustomParameters();\n            _send(Context.host + \"/tracking/pixel\", data);\n        }\n    };\n\n    var score = function (scores) {\n        if (!dnt()) {\n            var scoreParameters = \"\";\n            for (var key in scores) {\n                scoreParameters += \"&score_\" + key + \"=\" + scores[key];\n            }\n            var data = \"event=score\" + scoreParameters + _createDefaultParameters() + _createCustomParameters();\n            _send(Context.host + \"/tracking/pixel\", data);\n        }\n    };\n\n    let _createDefaultParameters = function () {\n        Context.vid = _getUniqueID(\"_tma_vid\", 1 * HOUR);\n        Context.uid = _getUniqueID(\"_tma_uid\", 365 * DAY);\n        var currentDate = new Date();\n        return \"&site=\" + Context.site\n            + \"&page=\" + Context.page\n            + \"&type=\" + Context.type\n            + \"&uid=\" + Context.uid\n            + \"&reqid=\" + Context.rid\n            + \"&vid=\" + Context.vid\n            + \"&referrer=\" + escape(document.referrer)\n            + \"&offset=\" + currentDate.getTimezoneOffset()\n            + \"&_t=\" + currentDate.getTime();\n    };\n\n    let _createCustomParameters = function () {\n        var customParameterString = \"\";\n        //var name = arguments.length === 1 ? arguments[0] + \"_\" : \"\";\n\n        if (Context.custom_parameter != null) {\n            var customParameters = Context.custom_parameter;\n            if (customParameters !== null && typeof customParameters === 'object') {\n                for (var p in customParameters) {\n                    if (customParameters.hasOwnProperty(p)) {\n                        var value = customParameters[p]\n                        if (Array.isArray(value)) {\n                            for (var item in value) {\n                                customParameterString += \"&c_\" + p + '=' + value[item];\n                            }\n                        } else {\n                            customParameterString += \"&c_\" + p + '=' + customParameters[p];\n                        }\n                    }\n                }\n            }\n        }\n        return customParameterString;\n    };\n\n    let _uuid = function () {\n        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {\n            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);\n            return v.toString(16);\n        });\n    };\n    let _getUniqueID = function (cookiename, expire) {\n        var aid = _cookie__WEBPACK_IMPORTED_MODULE_0__[\"default\"].get(cookiename);\n        if (aid === null || aid === \"\") {  \n            aid = _uuid();\n        }\n        \n        // update cookie on every request\n        _cookie__WEBPACK_IMPORTED_MODULE_0__[\"default\"].set(cookiename, aid, expire);\n        return aid;\n    };\n    let _send = function (url, data) {\n        if (navigator.sendBeacon) {\n            navigator.sendBeacon(url, data);\n        } else if (XMLHttpRequest) {\n            var xhr = new XMLHttpRequest();\n            xhr.open(\"POST\", url, true);\n            xhr.send(data);\n        } else {\n            Context.pixelImage.src = url + \"?\" + data;\n        }\n    }\n\n    return {\n        init: init\n        , page: page\n        , customParameters: customParameters\n        , setCookieDomain: setCookieDomain\n        , optOut: optOut\n        , dnt: dnt\n        , register: register\n        , track: track\n        , score: score\n    }\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (Tracking);\n\n//# sourceURL=webpack://EXM/./src/tracking.js?");

/***/ }),

/***/ "./src/woo.js":
/*!********************!*\
  !*** ./src/woo.js ***!
  \********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Woo = function () {\n\n\tvar addToBasket = function (product_id, product_sku, quantity, callback) {\n\t\tlet data = {\n\t\t\t'product_sku': product_sku,\n\t\t\t'product_id': product_id,\n\t\t\t'quantity': quantity\n\t\t};\n\n\t\tlet queryString = Object.keys(data).map(function (key) {\n\t\t\treturn key + '=' + data[key]\n\t\t}).join('&');\n\n\t\tlet ajax_url = wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart');\n\n\t\tfetch(ajax_url, {\n\t\t\tmethod: \"POST\",\n\t\t\tmode: \"cors\",\n\t\t\tcache: \"no-cache\",\n\t\t\tcredentials: \"same-origin\",\n\t\t\tbody: queryString,\n\t\t\theaders: new Headers({ 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json' }),\n\t\t}).then((resp) => resp.json())\n\t\t\t.then(function (data) {\n\t\t\t\tif (!data) {\n\t\t\t\t\treturn;\n\t\t\t\t}\n\t\t\t\tif (data.error && data.product_url) {\n\t\t\t\t\twindow.location = data.product_url;\n\t\t\t\t\treturn;\n\t\t\t\t}\n\t\t\t\tlet response = {}\n\t\t\t\t// Redirect to cart option\n\t\t\t\tif (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {\n\t\t\t\t\tresponse.redirect = wc_add_to_cart_params.cart_url;\n\t\t\t\t} else {\n\t\t\t\t\tjQuery(document.body).trigger('added_to_cart', [data.fragments, data.cart_hash]);\n\t\t\t\t}\n\t\t\t\tresponse.error = false\n\t\t\t\tcallback(response)\n\t\t\t}).catch(function (error) {\n\t\t\t\tlet response = {}\n\t\t\t\tresponse.error = true\n\t\t\t\tcallback(response)\n\t\t\t});\n\t}\n\treturn {\n\t\taddToBasket: addToBasket\n\t}\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (Woo);\n\n//# sourceURL=webpack://EXM/./src/woo.js?");

/***/ })

/******/ });