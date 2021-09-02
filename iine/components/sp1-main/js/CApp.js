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

var CApp = this.CApp = {

	b_chunk:1,
	version:2.0,
	init : function() {

		this.max_chunk = -1;
		this.cnt_load = 0;
		this.poll_typex = [];

		CAppCMS.bind("app-bind",this,function(){
			CAppCMS.bind("app-setup",this,this.setup);
			CAppCMS.bind("app-start",this,this.start);
			CAppCMS.bind("app-init-done",this,this.init_done);
		});
	},

	wid:0,
	wmap:{},
	pmap:{},

	getCssId : function( key ) {
		return appcfg.prefix_css + key;
	},

	getJsId : function( key ) {
		return appcfg.prefix_js + key;
	},

	run : function() {
		//-- load app components
		CCmp.load("app");

		CAppCMS.trigger("app-bind");
		CAppCMS.trigger("app-setup");
		CAppCMS.trigger("app-start");
	},
		
	setup : function() {
		var _this = this;

		this.cnt_load++;
		this.wmap_chunk = {};
		this.b_more = false;

		var max_chunk = this.getMaxChunk();
		var cnt = 0;

		$("."+appcfg.cls_selector).each(function(){
			if ( _this.setupInstance($(this)) ) {
				if ( max_chunk > 0 ) {
					cnt++;
					if ( cnt >= max_chunk ) {
						_this.b_more = true;
						return false;
					}
				}
			}
		});
	},

	start : function() {
		this.requestToServer();
	},

	ajax : function( requ, obj, func ) {
		$.ajax({
			type:"POST",
			url:appcfg.url_server,
			data:"requ="+encodeURIComponent(JSON.stringify(requ)),
			dataType:"json",
			success:function(resp){
				func.call(obj,resp);
			},
			error:function( jqXHR, textStatus, errorThrown ){
				var s = "[$.ajax.error]\n";
				s += jqXHR.responseText+"\n";
				s += textStatus+"\n";
				s += errorThrown;
				CUtil.printError(s);
			}
		});
	},

	ajaxSend : function( requ, obj, func ) {
		this.ajax(requ,obj,function(resp){
			if ( resp.result == "OK" ) {
				func.call(obj,resp);
			} else {
				var s = "[non-OK] " + resp.result;
				CUtil.printError( s );
			}
		});
	},

	getParams : function( wid ) {
		return this.wmap[wid];
	},

	normalizeParam : function( jqo, key ) {
		var ret = jqo.attr("data-"+key);
		if ( !ret ) { ret = jqo.attr(key); }
		if ( !ret ) { ret = ""; }
		var re = new RegExp('\\\/');
		ret = ret.replace(re,'_');
		return ret;
	},

	setMaxChunk : function( n ) {
		this.max_chunk = n;
	},

	getMaxChunk : function() {
		return this.max_chunk;
	},

	setupInstance : function( jqo_host ) {
		if ( parseInt(jqo_host.attr("data-wid")) ) {
			return false;
		}

		this.wid++;
		var wid = this.wid;
		jqo_host.attr("data-wid",wid);

		var pid = this.normalizeParam(jqo_host,"pid");
		if ( !pid ) { return; }
		var tid = this.normalizeParam(jqo_host,"tid");
		if ( !tid ) { return; }

		var rec = {
			jqo_host:jqo_host,
			wid:wid,
			pid:pid,
			tid:tid
		};
		this.wmap_chunk[wid] = rec;
		if ( !this.pmap[pid] ) {
			this.pmap[pid] = [];
		}
		this.pmap[pid].push(rec);

		return true;
	},

	getCssResetFlag : function() {
		var b_css_reset;
		if ( $(".aiin-no-css-reset").length > 0 ) {
			b_css_reset = 0;
		} else {
			b_css_reset = ( this.cnt_load==1 ) ? 1 : 0;
		}
		return b_css_reset;
	},

	requestToServer : function() {

		var pollx = [];
		for( var wid in this.wmap_chunk ) {
			this.wmap[wid] = this.wmap_chunk[wid];

			var rec = this.wmap_chunk[wid];
			if ( !rec.done ) {
				var rx = {
					wid:rec.wid,
					pid:rec.pid,
					tid:rec.tid
				};
				pollx.push(rx);
			}
		}

		if ( pollx.length ) {
			var requ = {
				"cmd":"init",
				"pollx":pollx,
				"cnt_load":this.cnt_load,
				"b_css_reset":this.getCssResetFlag()
			};
			CAppCMS.trigger("app-init-data",{requ:requ});
			this.ajaxSend(requ,this,function(resp){
				CAppCMS.trigger("app-init-done",{resp:resp});
			});
		} else {
			if ( this.cnt_load > 1 ) {
				CAppCMS.trigger("app-init-done",{resp:null});
			}
		}
	},

	mergeData : function( resp ) {
		if ( this.cnt_load == 1 ) {
			this.inidata = resp;
		} else if ( resp != null ) {
			for( var cate in resp ) {
				switch( cate ) {
				case "cssx":
					if (!( cate in this.inidata )) {
						this.inidata[cate] = {};
					}
					for( var key in resp[cate] ) {
						if (!( key in this.inidata[cate] )) {
							this.inidata[cate][key] = "";
						}
						this.inidata[cate][key] += resp[cate][key];
					}
					break;
				case "tplx":
					for( var tpl in resp["tplx"] ) {
						if ( tpl in this.inidata["tplx"] ) {
							this.inidata["tplx"][tpl]["list"] = 
								this.inidata["tplx"][tpl]["list"].concat(
								resp["tplx"][tpl]["list"]);
						} else {
							this.inidata["tplx"][tpl] = resp["tplx"][tpl];
						}
					}
					break;
				case "typex":
					for( var type in resp["typex"] ) {
						if ( type in this.inidata["typex"] ) {
							this.inidata["typex"][type]["list"] = 
								this.inidata["typex"][type]["list"].concat(
								resp["typex"][type]["list"]);
						} else {
							this.inidata["typex"][type] = resp["typex"][type];
						}
					}
					break;
				case "htmlx":
				case "selsx":
				case "vcntsx":
					if (!( cate in this.inidata )) {
						this.inidata[cate] = {};
					}
					for( var key in resp[cate] ) {
						this.inidata[cate][key] = resp[cate][key];
					}
					break;
				default:
					this.inidata[cate] = resp[cate];
					break;
				}
			}
		}
	},

	init_done : function( data ) {

		this.mergeData(data.resp);

		if ( this.b_more ) {
			CAppCMS.trigger("app-setup");
			CAppCMS.trigger("app-start");
		} else {
			var resp = data.resp = this.inidata;

			for( var key in resp.cssx ) {
				CHeadReso.insertCss(this.getCssId(key),resp.cssx[key]);
			}

			for( var key in resp.jsx ) {
				CHeadReso.insertJs(this.getJsId(key),resp.jsx[key]);
			}

			//-- load poll components
			if ( !this.b_poll_loaded ) {
				this.b_poll_loaded = 1;
				CCmp.load("poll");
			}

			//-- trigger poll events
			CAppCMS.trigger("poll-bind",data);
			CAppCMS.trigger("poll-register",data);
			CAppCMS.trigger("poll-setup",data);
		}
	},

	getInitData : function() {
		return this.inidata;
	},

	setPollTypeObj : function( type, obj ) {
		this.poll_typex[type] = obj;
	},

	getPollTypeObj : function( type ) {
		return this.poll_typex[type];
	},

	getPollTypeObjByTid : function( tid ) {
		return this.getPollTypeObj(this.inidata.tplx[tid].type);
	}

};

CCmp.register("app",CApp);
