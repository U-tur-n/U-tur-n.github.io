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

var CCmp = this.CCmp = {

	scopes:[],
	register : function( scope, cmp ) {
		if ( !this.scopes[scope] ) {
			this.scopes[scope] = [];
		}
		this.scopes[scope].push(cmp);
	},

	load : function( scope ) {
		var ls = this.scopes[scope];
		for( var i=0; i<ls.length; i++ ) {
			var cmp = ls[i];
			cmp.init.call(cmp);
		}
	}

};
