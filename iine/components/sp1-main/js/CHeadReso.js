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

var CHeadReso = this.CHeadReso = {

	removeCss : function( id ) {
		if ( $("#"+id).length ) {
			$("#"+id).remove();
		}
		return id;
	},

	insertCss : function( id, txt ) {
		this.removeCss(id);
		var style = document.createElement("style");
		style.type = "text/css";
		style.id = id;
		if (style.styleSheet){
			style.styleSheet.cssText = txt;
		} else {
			style.appendChild(document.createTextNode(txt));
		}
		document.getElementsByTagName("head")[0].appendChild(style);
	},

	removeJs : function( id ) {
		if ( $("#"+id).length ) {
			$("#"+id).remove();
		}
		return id;
	},

	insertJs : function( id, txt ) {
		this.removeJs(id);
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.id = id;

		if ( CUtil.isIE7or8() ) {
			script.text = txt;
		} else {
			script.appendChild(document.createTextNode(txt));
		}
		document.getElementsByTagName("head")[0].appendChild(script);
	}

};
