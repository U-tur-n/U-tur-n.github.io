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

function CCMS( classname ) {
	this.classname = classname;
	this.binding = {};
};

CCMS.prototype = {

	trigger : function( ename, data, ref ) {
		if ( this.binding[ename] ) {
			if ( data == undefined ) { data = {}; }
			data.ename = ename;
			var b_skip = (ref?true:false);
			var ls = this.binding[ename];
			for( var i=0; i<ls.length; i++ ) {
				var rec = ls[i];
				if ( rec.func != null ) {
					if ( b_skip ) {
						b_skip = ( rec.obj != ref );
					} else {
						var ret = rec.func.call(rec.obj,data);
						if ( ret === false ) {
							return false;
						}
					}
				}
			}
		}

		return true;
	},

	bind : function( enames, obj, func, pos ) {
		if ( obj ) { this.unbind( enames, obj ); }
		this.binds( enames, obj, func, pos );
	},

	binds : function( enames, obj, func, pos ) {
		var ex = enames.split(",");
		for( var i=0; i<ex.length; i++ ) {
			var str = ex[i].replace(/^\s+|\s+$/g,'');
			var sx = str.split(':');
			if ( sx.length > 0 ) {
				var ename = sx[0];
				var bindex = 0;
				if ( sx.length > 1 ) {
					bindex = sx[1];
					if ( bindex == "begin" ) {
						bindex = -100;
					} else if ( bindex == "end" ) {
						bindex = 100;
					} else {
						bindex = parseFloat(sx[1]);
						if ( isNaN(bindex) ) {
							bindex = 0;
						}
					}
				}

				if (!( ename in this.binding )) {
					this.binding[ename] = [];
				}
				var insert = {
					bindex:bindex,
					obj:obj,
					func:func
				};
				var ls = this.binding[ename];
				var b_inserted = false;
				for ( var j=0; j<ls.length; j++ ) {
					if ( bindex < ls[j].bindex ) {
						ls.splice(j,0,insert);
						b_inserted = true;
						break;
					}
				}
				if ( !b_inserted ) {
					ls.push(insert);
				}
			}
		}
	},

	unbind : function( enames, obj ) {
		var ex = enames.split(",");
		for( var i=0; i<ex.length; i++ ) {
			var ename = ex[i].replace(/^\s+|\s+$/g,'');
			if ( ename in this.binding ) {
				if ( !obj ) {
					var temp = this.binding[ename];
					this.binding[ename] = [];
					return temp;
				} else {
					for( var j=0; j<this.binding[ename].length; j++ ) {
						if ( this.binding[ename][j].obj == obj ) {
							var func = this.binding[ename][j].func;
							this.binding[ename][j].obj = null;
							this.binding[ename][j].func = null;
							return func;
						}
					}
				}
			}
		}
	},

	unbindAll : function() {
		this.binding = {};
	}

};
