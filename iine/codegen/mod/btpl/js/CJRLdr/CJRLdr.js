/*js
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
*/

(function(){

CJRLdr = {

	dx_locale : {},
	dx_config : {},

	loadLocale : function( key, dx ) {
		this.dx_locale[key] = dx;
	},

	locale : function( key ) {
		return this.dx_locale[key];
	},

	loadConfig : function( key, dx ) {
		this.dx_config[key] = dx;
	},

	config : function( key ) {
		return this.dx_config[key];
	}

};

}());
