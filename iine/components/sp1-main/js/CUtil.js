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

var CUtil = this.CUtil = {

	printError : function( msg ) {
		console.log( msg );
	},

	hsc : function( s ) {
		return $("<div>").text(s).html();
	},

	recalcStyle : function( jqo ) {
		var dummy = jqo.get(0).offsetWidth;
	},

	jsShallowCopy : function( obj ) {
			return $.extend({},obj);
	},

	jsDeepCopy : function( obj ) {
			return $.extend(true,{},obj);
	},

	getFilenameFromUrl : function( url ) {
		return url.substring(url.lastIndexOf('/')+1);
	},

	isIE7or8 : function() {
		return (navigator.appVersion.indexOf("MSIE 7.")!=-1) ||
			(navigator.appVersion.indexOf("MSIE 8.")!=-1);
	},

	canCssAnim : function() {
		return ( document.createElement("div")
			.style.animationName !== undefined );
	},

	isTouchDevice : function() {
		return (("ontouchstart" in window) ||
			(navigator.MaxTouchPoints > 0) ||
			(navigator.msMaxTouchPoints > 0));
	},

	shuffleArray : function(ax) {
		var tmp, idx;
		var i = ax.length;
		while (0 !== i) {
			idx = Math.floor(Math.random() * i);
			i -= 1;
			tmp = ax[i];
			ax[i] = ax[idx];
			ax[idx] = tmp;
		}
		return ax;
	},

	ensureArray : function( s ) {
		if ( s == undefined ) {
			return [];
		} else if ( Array.isArray(s) ) {
			return s;
		} else {
			s = s.trim();
			if ( s ) {
				var sx = s.split(",");
				for( var i=0; i<sx.length; i++ ) {
					sx[i] = sx[i].trim();
				}
				return sx;
			} else {
				return [];
			}
		}
	},

	sq : function( s ) {
		if ( s == undefined ) {
			return "";
		} else {
			return "'" + s.replace(/'/g,"\\\'") + "'";
		}
	}

};
