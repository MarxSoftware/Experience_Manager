this["block-targeting"]=this["block-targeting"]||{},this["block-targeting"].main=function(t){function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}var e={};return n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:r})},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},n.p="",n(n.s=10)}([function(t,n){var e=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=e)},function(t,n){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},function(t,n,e){t.exports=!e(3)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},function(t,n){t.exports=function(t){try{return!!t()}catch(t){return!0}}},function(t,n){var e=t.exports={version:"2.5.3"};"number"==typeof __e&&(__e=e)},function(t,n,e){var r=e(6),o=e(7);t.exports=function(t){return r(o(t))}},function(t,n,e){var r=e(29);t.exports=Object("z").propertyIsEnumerable(0)?Object:function(t){return"String"==r(t)?t.split(""):Object(t)}},function(t,n){t.exports=function(t){if(void 0==t)throw TypeError("Can't call method on  "+t);return t}},function(t,n){var e=Math.ceil,r=Math.floor;t.exports=function(t){return isNaN(t=+t)?0:(t>0?r:e)(t)}},function(t,n){!function(){t.exports=this.wp.element}()},function(t,n,e){"use strict";function r(t){return t.attributes=Object(u.assign)(t.attributes,p.a),t}function o(t,n,e){var r=e.tma_personalization,o=e.tma_matching,a=e.tma_group,i=e.tma_default,c=e.tma_segments,f={};return r&&(f["data-tma-personalization"]=r?"enabled":"disabled",f["data-tma-matching"]=o,f["data-tma-group"]=a,f["data-tma-default"]=i?"yes":"no",Array.isArray(c)?f["data-tma-segments"]=c.join(","):f["data-tma-segments"]=[],i||(f.class="tma-hide"),Object(u.assign)(t,f)),t}Object.defineProperty(n,"__esModule",{value:!0});var a=e(11),i=e.n(a),u=e(40),c=(e.n(u),e(41)),f=(e.n(c),e(42)),l=(e.n(f),e(9)),s=(e.n(l),e(43)),p=(e.n(s),e(44)),m=e(45),d=e(49),g=(e.n(d),Object(s.createHigherOrderComponent)(function(t){return function(n){return wp.element.createElement(l.Fragment,null,n.isSelected&&wp.element.createElement(m.a,i()({},n)),wp.element.createElement(t,n))}},"withInspectorControl"));Object(s.createHigherOrderComponent)(function(t){return function(n){var e=n.wrapperProps;return e=i()({},e),wp.element.createElement(t,i()({},n,{wrapperProps:e}))}},"withBackground");Object(f.addFilter)("blocks.registerBlockType","tma/targeting/attribute",r),Object(f.addFilter)("editor.BlockEdit","tma/targeting/inspector",g),Object(f.addFilter)("blocks.getSaveContent.extraProps","lubus/background/addAssignedBackground",o)},function(t,n,e){"use strict";n.__esModule=!0;var r=e(12),o=function(t){return t&&t.__esModule?t:{default:t}}(r);n.default=o.default||function(t){for(var n=1;n<arguments.length;n++){var e=arguments[n];for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&(t[r]=e[r])}return t}},function(t,n,e){t.exports={default:e(13),__esModule:!0}},function(t,n,e){e(14),t.exports=e(4).Object.assign},function(t,n,e){var r=e(15);r(r.S+r.F,"Object",{assign:e(25)})},function(t,n,e){var r=e(0),o=e(4),a=e(16),i=e(18),u=function(t,n,e){var c,f,l,s=t&u.F,p=t&u.G,m=t&u.S,d=t&u.P,g=t&u.B,v=t&u.W,b=p?o:o[n]||(o[n]={}),h=b.prototype,y=p?r:m?r[n]:(r[n]||{}).prototype;p&&(e=n);for(c in e)(f=!s&&y&&void 0!==y[c])&&c in b||(l=f?y[c]:e[c],b[c]=p&&"function"!=typeof y[c]?e[c]:g&&f?a(l,r):v&&y[c]==l?function(t){var n=function(n,e,r){if(this instanceof t){switch(arguments.length){case 0:return new t;case 1:return new t(n);case 2:return new t(n,e)}return new t(n,e,r)}return t.apply(this,arguments)};return n.prototype=t.prototype,n}(l):d&&"function"==typeof l?a(Function.call,l):l,d&&((b.virtual||(b.virtual={}))[c]=l,t&u.R&&h&&!h[c]&&i(h,c,l)))};u.F=1,u.G=2,u.S=4,u.P=8,u.B=16,u.W=32,u.U=64,u.R=128,t.exports=u},function(t,n,e){var r=e(17);t.exports=function(t,n,e){if(r(t),void 0===n)return t;switch(e){case 1:return function(e){return t.call(n,e)};case 2:return function(e,r){return t.call(n,e,r)};case 3:return function(e,r,o){return t.call(n,e,r,o)}}return function(){return t.apply(n,arguments)}}},function(t,n){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},function(t,n,e){var r=e(19),o=e(24);t.exports=e(2)?function(t,n,e){return r.f(t,n,o(1,e))}:function(t,n,e){return t[n]=e,t}},function(t,n,e){var r=e(20),o=e(21),a=e(23),i=Object.defineProperty;n.f=e(2)?Object.defineProperty:function(t,n,e){if(r(t),n=a(n,!0),r(e),o)try{return i(t,n,e)}catch(t){}if("get"in e||"set"in e)throw TypeError("Accessors not supported!");return"value"in e&&(t[n]=e.value),t}},function(t,n,e){var r=e(1);t.exports=function(t){if(!r(t))throw TypeError(t+" is not an object!");return t}},function(t,n,e){t.exports=!e(2)&&!e(3)(function(){return 7!=Object.defineProperty(e(22)("div"),"a",{get:function(){return 7}}).a})},function(t,n,e){var r=e(1),o=e(0).document,a=r(o)&&r(o.createElement);t.exports=function(t){return a?o.createElement(t):{}}},function(t,n,e){var r=e(1);t.exports=function(t,n){if(!r(t))return t;var e,o;if(n&&"function"==typeof(e=t.toString)&&!r(o=e.call(t)))return o;if("function"==typeof(e=t.valueOf)&&!r(o=e.call(t)))return o;if(!n&&"function"==typeof(e=t.toString)&&!r(o=e.call(t)))return o;throw TypeError("Can't convert object to primitive value")}},function(t,n){t.exports=function(t,n){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:n}}},function(t,n,e){"use strict";var r=e(26),o=e(37),a=e(38),i=e(39),u=e(6),c=Object.assign;t.exports=!c||e(3)(function(){var t={},n={},e=Symbol(),r="abcdefghijklmnopqrst";return t[e]=7,r.split("").forEach(function(t){n[t]=t}),7!=c({},t)[e]||Object.keys(c({},n)).join("")!=r})?function(t,n){for(var e=i(t),c=arguments.length,f=1,l=o.f,s=a.f;c>f;)for(var p,m=u(arguments[f++]),d=l?r(m).concat(l(m)):r(m),g=d.length,v=0;g>v;)s.call(m,p=d[v++])&&(e[p]=m[p]);return e}:c},function(t,n,e){var r=e(27),o=e(36);t.exports=Object.keys||function(t){return r(t,o)}},function(t,n,e){var r=e(28),o=e(5),a=e(30)(!1),i=e(33)("IE_PROTO");t.exports=function(t,n){var e,u=o(t),c=0,f=[];for(e in u)e!=i&&r(u,e)&&f.push(e);for(;n.length>c;)r(u,e=n[c++])&&(~a(f,e)||f.push(e));return f}},function(t,n){var e={}.hasOwnProperty;t.exports=function(t,n){return e.call(t,n)}},function(t,n){var e={}.toString;t.exports=function(t){return e.call(t).slice(8,-1)}},function(t,n,e){var r=e(5),o=e(31),a=e(32);t.exports=function(t){return function(n,e,i){var u,c=r(n),f=o(c.length),l=a(i,f);if(t&&e!=e){for(;f>l;)if((u=c[l++])!=u)return!0}else for(;f>l;l++)if((t||l in c)&&c[l]===e)return t||l||0;return!t&&-1}}},function(t,n,e){var r=e(8),o=Math.min;t.exports=function(t){return t>0?o(r(t),9007199254740991):0}},function(t,n,e){var r=e(8),o=Math.max,a=Math.min;t.exports=function(t,n){return t=r(t),t<0?o(t+n,0):a(t,n)}},function(t,n,e){var r=e(34)("keys"),o=e(35);t.exports=function(t){return r[t]||(r[t]=o(t))}},function(t,n,e){var r=e(0),o=r["__core-js_shared__"]||(r["__core-js_shared__"]={});t.exports=function(t){return o[t]||(o[t]={})}},function(t,n){var e=0,r=Math.random();t.exports=function(t){return"Symbol(".concat(void 0===t?"":t,")_",(++e+r).toString(36))}},function(t,n){t.exports="constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",")},function(t,n){n.f=Object.getOwnPropertySymbols},function(t,n){n.f={}.propertyIsEnumerable},function(t,n,e){var r=e(7);t.exports=function(t){return Object(r(t))}},function(t,n){!function(){t.exports=this.lodash}()},function(t,n,e){var r,o;/*!
  Copyright (c) 2017 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
!function(){"use strict";function e(){for(var t=[],n=0;n<arguments.length;n++){var r=arguments[n];if(r){var o=typeof r;if("string"===o||"number"===o)t.push(r);else if(Array.isArray(r)&&r.length){var i=e.apply(null,r);i&&t.push(i)}else if("object"===o)for(var u in r)a.call(r,u)&&r[u]&&t.push(u)}}return t.join(" ")}var a={}.hasOwnProperty;void 0!==t&&t.exports?(e.default=e,t.exports=e):(r=[],void 0!==(o=function(){return e}.apply(n,r))&&(t.exports=o))}()},function(t,n){!function(){t.exports=this.wp.hooks}()},function(t,n){!function(){t.exports=this.wp.compose}()},function(t,n,e){"use strict";var r={tma_personalization:{type:"boolean",default:!1},tma_matching:{type:"string",default:"all"},tma_group:{type:"string",default:"default"},tma_default:{type:"boolean",default:!1},tma_segments:{type:"array",default:[]}};n.a=r},function(t,n,e){"use strict";var r=e(46),o=(e.n(r),e(47)),a=(e.n(o),e(48)),i=(e.n(a),e(9)),u=(e.n(i),function(t){var n=t.attributes,e=t.setAttributes,u=n.tma_personalization,c=n.tma_matching,f=n.tma_group,l=n.tma_default,s=n.tma_segments,p=function(t){e({tma_personalization:t})},m=function(t){e({tma_matching:t})},d=function(t){e({tma_group:t})},g=function(t){e({tma_default:t})},v=function(t){e({tma_segments:t})},b=wp.element.createElement(i.Fragment,null,wp.element.createElement(a.SelectControl,{label:Object(r.__)("Matching mode:"),value:c,onChange:m,options:[{value:"all",label:"All"},{value:"any",label:"Any"},{value:"none",label:"None"}]}),wp.element.createElement(a.TextControl,{label:Object(r.__)("Group name?"),value:f,onChange:d}),wp.element.createElement(a.ToggleControl,{label:Object(r.__)("Group default?"),checked:!!l,onChange:g}),wp.element.createElement(a.SelectControl,{multiple:!0,label:Object(r.__)("Audiences"),value:s,onChange:v,options:TMA_CONFIG.segments.map(function(t){return{value:t.id,label:t.name}})}));return wp.element.createElement(o.InspectorControls,null,wp.element.createElement(a.PanelBody,{title:Object(r.__)("Targeting"),initialOpen:!0},wp.element.createElement(a.ToggleControl,{label:Object(r.__)("Enable"),checked:!!u,onChange:p}),u&&b))});n.a=u},function(t,n){!function(){t.exports=this.wp.i18n}()},function(t,n){!function(){t.exports=this.wp.editor}()},function(t,n){!function(){t.exports=this.wp.components}()},function(t,n){}]);