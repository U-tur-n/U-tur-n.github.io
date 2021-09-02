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
/*
= destroy old gate and create a new one
this.gate = CGate.create(this.gate);

= execute function if gate is open
this.gate.check(function(){
	..................
})

= close gate
if ( this.gate ) { this.gate.close(); }

= pause gate
this.gate.pause();

= resume gate
if ( this.gate.resume() ) {
	..................
}

*/
var CGate = this.CGate = {

	init : function() {
		this.b_paused = false;
		this.b_closed = false;
		this.flags = {};
	},

	create : function( obj ) {
		if ( obj ) { obj.close(); }
		obj = {};
		for( var p in this ) { obj[p] = this[p]; }
		obj.init();
		return obj;
	},

	check : function( f, caller ) {
		var _this = this;
		return function(){
			if ( _this.b_closed ) { return; }
			f.call(caller ? caller : this);
		}
	},

	isOpen : function( str ) {
		if ( this.b_paused ) {
			return false;
		} else {
			if ( str ) {
				return this.checkFlag(str);
			} else {
				return true;
			}
		}
	},

	pause : function() {
		this.b_paused = true;
	},

	resume : function() {
		if ( this.b_paused ) {
			this.b_paused = false;
			return true;
		} else {
			return false;
		}
	},

	close : function() {
		this.b_closed = true;
	},

	checkFlag : function( str ) {
		var fx = str.split(",");
		for( var i=0; i<fx.length; i++ ) {
			var f = fx[i].replace(/^\s+|\s+$/g,'');
			if ( !this.flags[f] ) { return false; }
		}
		return true;
	}

};
