/*js
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
*/

//-- pollyfill for "toFixed"
if (!Number.prototype.toFixed) {
	Number.prototype.toFixed = function(decimals) {
		return Math.round(this * Math.pow(10, decimals)) / (Math.pow(10, decimals)); 
	};
}

//-- pollyfill for "isArray"
if (!Array.isArray) {
	Array.isArray = function(arg) {
		return Object.prototype.toString.call(arg) === '[object Array]';
	};
}

//-- pollyfill for "includes"
if (!Array.prototype.includes) {
	Array.prototype.includes = function( findme ) {
		for( var i=0; i<this.length; i++ ) {
			if ( this[i] === findme ) { return true; }
		}
		return false;
	};
}

//-- pollyfill for "trim"
if (!String.prototype.trim) {
	String.prototype.trim = function() {
		return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
	};
}

//-- pollyfill for "lastIndexOf"
if (!String.prototype.lastIndexOf) {
	String.prototype.lastIndexOf = function(a,c) {
		for(c=this.length;this[--c]!==a&&~c;);
		return c;
	};
}

//-- pollyfill for "sb" (smart break)
if (!String.prototype.sb) {
	String.prototype.sb = function() {
		if ( this.indexOf("<sb>") == -1 ) {
			return this.toString();
		} else {
			return this
				.replace(/<sb>/g,'<span style="display:inline-block;word-break:break-all;">')
				.replace(/<\/sb>/g,'</span>');
		}
	};
}

//-- polyfill for JSON 
if (!window.JSON) {
	window.JSON = {
		parse: function(sJSON) { return eval('(' + sJSON + ')'); },
		stringify: (function () {
			var toString = Object.prototype.toString;
			var isArray = Array.isArray || function (a) { return toString.call(a) === '[object Array]'; };
			var escMap = {'"': '\\"', '\\': '\\\\', '\b': '\\b', '\f': '\\f', '\n': '\\n', '\r': '\\r', '\t': '\\t'};
			var escFunc = function (m) { return escMap[m] ||
				'\\u' + (m.charCodeAt(0) + 0x10000).toString(16).substr(1); };
			var escRE = /[\\"\u0000-\u001F\u2028\u2029]/g;
			return function stringify(value) {
				if (value == null) {
					return 'null';
				} else if (typeof value === 'number') {
					return isFinite(value) ? value.toString() : 'null';
				} else if (typeof value === 'boolean') {
					return value.toString();
				} else if (typeof value === 'object') {
					if (typeof value.toJSON === 'function') {
						return stringify(value.toJSON());
					} else if (isArray(value)) {
						var res = '[';
						for (var i = 0; i < value.length; i++) {
							res += (i ? ', ' : '') + stringify(value[i]);
						}
						return res + ']';
					} else if (toString.call(value) === '[object Object]') {
						var tmp = [];
						for (var k in value) {
							if (value.hasOwnProperty(k)) {
								tmp.push(stringify(k) + ': ' + stringify(value[k]));
							}
						}
						return '{' + tmp.join(', ') + '}';
					}
				}
				return '"' + value.toString().replace(escRE, escFunc) + '"';
			};
		})()
	};
}
