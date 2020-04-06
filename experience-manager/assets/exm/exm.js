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

/***/ "./src/ajax.js":
/*!*********************!*\
  !*** ./src/ajax.js ***!
  \*********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Ajax = function () {\n\n\tvar request = function (ajax_action, callback, parameters) {\n\t\tfetch(EXMCONFIG.ajax_url, {\n\t\t\tmethod: \"POST\",\n\t\t\tmode: \"cors\",\n\t\t\tcache: \"no-cache\",\n\t\t\tcredentials: \"same-origin\",\n\t\t\tbody: \"action=\" + ajax_action + (typeof parameters !== \"undefined\" ? parameters : \"\"),\n\t\t\theaders: new Headers({'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'}),\n\t\t}).then((resp) => resp.json())\n\t\t\t\t.then(function (data) {\n\t\t\t\t\tcallback(data);\n\t\t\t\t}).catch(function (error) {\n\t\t\tconsole.log(error);\n\t\t});\n\t};\n\n\treturn {\n\t\trequest: request\n\t}\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (Ajax);\n\n//# sourceURL=webpack://EXM/./src/ajax.js?");

/***/ }),

/***/ "./src/dom.js":
/*!********************!*\
  !*** ./src/dom.js ***!
  \********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Dom = function () {\r\n\r\n\tvar insertElement = function (name, type, content) {\r\n\t\tvar headElement = document.createElement(name);\r\n\t\theadElement.type = type;\r\n\t\theadElement.innerText = content;\r\n\t\tdocument.head.appendChild(headElement);\r\n\t}\r\n\r\n\treturn {\r\n\t\tinsertElement: insertElement\r\n\t}\r\n}();\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (Dom);\n\n//# sourceURL=webpack://EXM/./src/dom.js?");

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! exports provided: Popup, Dom, Ajax */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _popup__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./popup */ \"./src/popup.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Popup\", function() { return _popup__WEBPACK_IMPORTED_MODULE_0__[\"default\"]; });\n\n/* harmony import */ var _dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dom */ \"./src/dom.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Dom\", function() { return _dom__WEBPACK_IMPORTED_MODULE_1__[\"default\"]; });\n\n/* harmony import */ var _ajax__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ajax */ \"./src/ajax.js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"Ajax\", function() { return _ajax__WEBPACK_IMPORTED_MODULE_2__[\"default\"]; });\n\n\r\n\r\n \r\n\r\n\n\n//# sourceURL=webpack://EXM/./src/index.js?");

/***/ }),

/***/ "./src/popup.js":
/*!**********************!*\
  !*** ./src/popup.js ***!
  \**********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Popup = function() {\r\n\r\n    // This is private because it is not being return\r\n    var _privateFunction = function(param1, param2) {\r\n        return;\r\n    }\r\n\r\n    var function1 = function(param1, callback) {\r\n        callback(err, results);    \r\n    }\r\n\r\n    var function2 = function(param1, param2, callback) {\r\n        callback(err, results);    \r\n    }\r\n\r\n    return {\r\n        function1: function1\r\n       ,function2: function2\r\n    }\r\n}();\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (Popup);\n\n//# sourceURL=webpack://EXM/./src/popup.js?");

/***/ })

/******/ });