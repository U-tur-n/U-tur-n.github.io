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

var CPoll = this.CPoll = {

	type : "def",
	init : function() {
		CAppCMS.bind("poll-bind",this,function(){
			CAppCMS.bind("poll-register:begin",this,this.register);
			CAppCMS.bind("poll-setup:end",this,this.setup);
			CAppCMS.bind("poll-vote",this,this.vote);
			CAppCMS.bind("poll-vote-done",this,this.vote_done);
			CAppCMS.unbind("poll-bind",this); 
		});
	},

	register : function( data ) {
		CApp.setPollTypeObj(this.type,this);
		CAppCMS.unbind("poll-register",this); 
	},

	setup : function( data ) {
		var tplx = data.resp.tplx;
		var typex = data.resp.typex;
		for( var type in typex ) {
			var rec = typex[type];
			var ls = rec.list;
			for( var i=0; i<ls.length; i++ ) {
				var tid = ls[i];
				var tpl = tplx[tid];
				var obj = CApp.getPollTypeObj(tpl.type);
				if ( obj ) {
					obj.setupPoll(data,tpl);
				}
			}
		}
	},

	beginServer : function( jqo ) {
		var b = jqo.data("b-busy");
		if ( b ) {
			return false;
		} else {
			jqo.data("b-busy",true);
			return true;
		}
	},

	endServer : function( jqo ) {
		jqo.data("b-busy",false);
	},

	vote : function( data ) {
		var rec = CApp.wmap[data.wid];
		if ( !rec.can_vote ) { return; }

		var requ = {
			"cmd":"vote",
			"bid":data.bid,
			"wid":data.wid,
			"pid":rec.pid,
			"tid":rec.tid
		};
		CAppCMS.trigger("poll-vote-data",{requ:requ});
		if ( CPoll.beginServer(rec.jqo_host) ) {
			CApp.ajaxSend(requ,this,function(resp){
				CPoll.endServer(rec.jqo_host);
				CAppCMS.trigger("poll-vote-done",{resp:resp});
			});
		}
	},

	vote_done : function( data ) {
		CApp.getPollTypeObjByTid(data.resp.tid)
			.redraw(data.resp);
	},

	formatVcnt : function( n, format ) {
		var s = n.toString();
		switch( format ) {
		case "c3": return s.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		case "c4": return s.replace(/\B(?=(\d{4})+(?!\d))/g, ",");
		default: return s;
		}
	},

	setVcnt : function( jqo_btns, bid, vcnt, format ) {
		var jqo_btn = ( jqo_btns.length>1 ) ? jqo_btns.filter(
			"[data-bid='"+bid+"']") : jqo_btns;
		jqo_btn.attr("data-vcnt",vcnt.toString());
		var jqo_vcnt = jqo_btn.find(".aiin-vcnt");
		jqo_vcnt.html(this.formatVcnt(vcnt,format));
	},

	setupPoll : function( data, tpl ) {
		var ls = tpl.list;
		for( var i=0; i<tpl.list.length; i++ ) {
			var poll = tpl.list[i];

			//-- get poll record
			var rec = CApp.wmap[poll.wid];
			if ( !rec.setup_done ) {
				rec.setup_done = true;
				rec.can_vote = true;

				//-- get host jquery object
				var jqo_host = rec.jqo_host;

				//-- assign template html
				if ( tpl["load-resource"] && tpl.html && tpl.html["tpl.html"] ) {
					jqo_host.html(tpl.html["tpl.html"]);
				}

				//-- button jqo
				var jqo_btn = jqo_host.find(".aiin-btn");
				jqo_btn.attr("data-wid",rec.wid);

				//-- click event
				jqo_btn.click(function(e){
					e.preventDefault();
					CAppCMS.trigger("poll-vote",{
						wid:$(this).attr("data-wid"),
						bid:"b1"
					});
				});

				//-- update vcnts & sels
				this.redraw({
					initdraw:1,
					pid:poll.pid,
					vcnts:data.resp.vcntsx[poll.pid],
					sels:data.resp.selsx[poll.pid]
				});
			}
		}
	},

	redraw : function( px, b_vcnt_only ) {
		b_vcnt_only = b_vcnt_only || 0;

		var ls = CApp.pmap[px.pid];
		for( var i=0; i<ls.length; i++ ) {
			var rec = ls[i];
			var tpl = CApp.inidata.tplx[rec.tid];
			if ( tpl ) {
				var format = tpl["vcnt-format"];
				var jqo_host = rec.jqo_host;
				var jqo_btns = jqo_host.find(".aiin-btn");

				//-- initdraw
				if ( !b_vcnt_only ) {
					if ( px.initdraw ) {
						CPoll.setVcnt(jqo_btns,"b1",0,format);
						jqo_btns.addClass("aiin-init");
					} else {
						jqo_btns.removeClass("aiin-init");
					}
				}

				//-- vcnt
				if ( px.vcnts ) {
					if ( "b1" in px.vcnts ) {
						CPoll.setVcnt(jqo_btns,"b1",
							px.vcnts["b1"],format);
					}
				}

				//-- voted
				if ( !b_vcnt_only ) {
					var b_sel = (( px.sels ) && ( "b1" in px.sels ));
					if ( b_sel ) {
						jqo_btns.attr("data-sel","1");
					} else {
						jqo_btns.attr("data-sel","0");
					}
					if ( tpl["indicate-voted"] ) {
						if ( b_sel || ( tpl["indicate-voted"] == 2 )) {
							jqo_btns.addClass("aiin-sel");
						} else {
							jqo_btns.removeClass("aiin-sel");
						}
					}
				}

				//-- undo
				if ( !b_vcnt_only ) {
					if ( px.sels && !tpl["enable-undo"] ) {
						rec.can_vote = false;
						jqo_btns.addClass("aiin-not-allowed");
					}
				}
			}
		}
	}

};

CCmp.register("poll",CPoll);
