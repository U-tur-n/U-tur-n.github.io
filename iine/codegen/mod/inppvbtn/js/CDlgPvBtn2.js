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

(function($){

CDlgPvBtn = {

	sendRequ : function( pidx, keyword ) {
		var requ = {
			cmd:"load_page",
			form:{
				pidx:pidx,
				keyword:keyword
			}
		};

		this.cajax.send(requ,this,function(resp){
			if ( resp.result == "OK" ) {
				this.update(resp);
			} else {
				this.cajax.printError(resp.result);
			}
		});
	},

	setup : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;
		this.cajax = new CCAjax();

		if ( !this.jqo_ctar ) {
			this.jqo_ctar = $(".dlgpvbtn");
		}

		this.jqo_body = this.jqo_ctar.find(".dlg-body");
		this.jqo_btn_ok = this.jqo_ctar.find(".btn-ok");
		this.jqo_btn_cancel = this.jqo_ctar.find(".btn-cancel");

		this.jqo_title = this.jqo_ctar.find(".dlgpvbtn-title");
		this.jqo_itotal = this.jqo_ctar.find(".dlgpvbtn-itotal");
		this.jqo_itotal_cnt = this.jqo_itotal.find(".dlgpvbtn-itotal-cnt");

		this.jqo_nav_dir = this.jqo_ctar.find(".dlgpvbtn-nav-dir");
		this.jqo_nav_first = this.jqo_ctar.find(".dlgpvbtn-nav-first");
		this.jqo_nav_prev = this.jqo_ctar.find(".dlgpvbtn-nav-prev");
		this.jqo_nav_next = this.jqo_ctar.find(".dlgpvbtn-nav-next");
		this.jqo_nav_last = this.jqo_ctar.find(".dlgpvbtn-nav-last");
		this.jqo_nav_pidx = this.jqo_ctar.find(".dlgpvbtn-nav-pidx");
		this.jqo_nav_ptotal = this.jqo_ctar.find(".dlgpvbtn-nav-ptotal");
		this.jqo_btn_search = this.jqo_ctar.find(".dlg-searchbar-tcell-search");
		this.jqo_keyword = this.jqo_ctar.find(".keyword");
		this.pidx = 0;
		this.ptotal = 0;
		this.keyword = "";

		//-- set title
		var lca = CJRLdr.locale('inppvbtn/dlgpvbtn');
		this.jqo_title.html(lca["title:"+this.dtype]);

		//-- make inital request
		this.b_init_load = true;
		this.sendRequ(0,"");
		this.b_init_load = false;

		this.jqo_nav_dir
			.click(function(e){
				e.preventDefault();
				_this.pc_nav($(this).attr("data-dir"));
			})
			.keydown(function(e){
				var cc = e.which;
				if (( cc == 13 ) || ( cc == 32 )) {
					e.preventDefault();
					$(this).click();
				}
			});

		this.jqo_btn_search
			.click(function(e){
				e.preventDefault();
				_this.pc_search();
			})
			.keydown(function(e){
				var cc = e.which;
				if (( cc == 13 ) || ( cc == 32 )) {
					e.preventDefault();
					$(this).click();
				}
			});

		this.jqo_keyword
			.keydown(function(e){
				var cc = e.which;
				if (( cc == 13 ) || ( cc == 32 )) {
					e.preventDefault();
					_this.pc_search();
				}
			})
			.focus(function(){
				$(this).get(0).select();
			});

		this.jqo_ctar.find(".btn-ok")
			.click( function(e){
				e.preventDefault();
				_this.pc_ok();
			})
			.keydown(function(e){
				var cc = e.which;
				if (( cc == 13 ) || ( cc == 32 )) {
					e.preventDefault();
					$(this).click();
				}
			});

		this.jqo_ctar.find(".btn-cancel,.btn-close")
			.click( function(e){
				e.preventDefault();
				_this.pc_cancel();
			})
			.keydown(function(e){
				var cc = e.which;
				if (( cc == 13 ) || ( cc == 32 )) {
					e.preventDefault();
					$(this).click();
				}
			});

		this.rwin = new CRWindow({
			cwin:this,
			min_w:300,
			max_w:550,
			max_h:550,
			min_h:230
		});
	},

	open : function( opt ) {
		if ( !this.b_init_updated ) { return; }
		for ( var key in opt ) { this[key] = opt[key]; }

		//-- remove "updated" class
		this.jqo_ctar.removeClass("dlgpvbtn-updated");
		this.jqo_ctar.get(0).offsetWidth;

		//-- open
		this.rwin.open();

		//-- scroll to top
		if ( !this.b_to_top ) {
			this.b_to_top = true;
			this.jqo_list.get(0).scrollTop = 0;
		}

		//-- focus keyword
		this.jqo_keyword.val(this.keyword);
		if ( !CDuan.isTouchDevice() ) {
			this.jqo_keyword.focus();
		}
	},

	updateListHeight : function() {
		//-- remove bottom paddings
		var h = this.jqo_body.outerHeight() - 15;
		this.jqo_list.css({
			height:h + "px"
		});
	},

	update : function( resp ) {
		this.b_init_updated = true;

		this.jqo_body.html("");
		this.jqo_body.html(resp.html);
		this.jqo_list = this.jqo_body.find(".dlgpvbtn-list");
		this.jqo_list.find(".aiin-vcnt").html(999);
		this.updateListHeight();

		//-- keyword changes?
		var b_keyword_changed = ( this.keyword != resp.keyword );

		//-- setup total
		this.jqo_itotal_cnt.html(resp.itotal);
		if ( b_keyword_changed ) {
			this.jqo_ctar.removeClass("dlgpvbtn-updated");
			this.jqo_ctar.get(0).offsetWidth;
			this.jqo_ctar.addClass("dlgpvbtn-updated");
		}

		//-- setup naviations
		this.keyword = resp.keyword;
		this.pidx = resp.pidx;
		this.ptotal = resp.ptotal;

		this.jqo_keyword.val(resp.keyword);
		this.jqo_nav_pidx.html(resp.pidx);
		this.jqo_nav_ptotal.html(resp.ptotal);

		this.jqo_nav_dir.removeClass("dlgpvbtn-nav-dir-enabled");
		if ( 0 < resp.ptotal ) {
			if ( resp.pidx > 1 ) {
				this.jqo_nav_first.addClass("dlgpvbtn-nav-dir-enabled");
				this.jqo_nav_prev.addClass("dlgpvbtn-nav-dir-enabled");
			}
			if ( resp.pidx < resp.ptotal ) {
				this.jqo_nav_next.addClass("dlgpvbtn-nav-dir-enabled");
				this.jqo_nav_last.addClass("dlgpvbtn-nav-dir-enabled");
			}
		}

		//-- add event handlers
		var _this = this;
		this.jqo_list.find(".dlgpvbtn-box")
			.click( function(e){
				_this.pc_ok($(this).attr("data-key"));
			})
			.keydown(function(e){
				var cc = e.which;
				if (( cc == 13 ) || ( cc == 32 )) {
					e.preventDefault();
					$(this).click();
				}
			});

		//-- focus on keyword input box
		if ( !this.b_init_load ) {
			if ( !CDuan.isTouchDevice() ) {
				this.jqo_keyword.focus();
			}
		}
	},

	pc_search : function() {
		this.sendRequ(0,this.jqo_keyword.val());
	},

	pc_nav : function( dir ) {
		var pidx = this.pidx;
		var ptotal = this.ptotal;
		if (
			( ptotal == 0 ) ||
			(( pidx == 1 ) && (( dir == "first" )||( dir == "prev" ))) ||
			(( pidx == ptotal ) && (( dir == "last" )||( dir == "next" )))
		) { return; }

		switch(dir){
		case "first": pidx = 1; break;
		case "prev": pidx--; break;
		case "next": pidx++; break;
		case "last": pidx = ptotal; break;
		}

		this.sendRequ(pidx,this.keyword);
	},

	pc_ok : function( tid ) {
		this.rwin.close();
		if ( this.onOK ) {
			this.onOK( tid );
		}
	},

	pc_cancel : function() {
		this.rwin.close();
		if ( this.onCancel ) {
			this.onCancel();
		}
	},

	onRedraw : function() {
		this.jqo_ctar.css({
			width:this.rwin.jqo_rwin.width() + "px",
			height:this.rwin.jqo_rwin.height() + "px"
		});

		// 50 for heading, searchbar, footer 
		var h = (this.jqo_ctar.height()-(50+50+50));
		this.jqo_body.css({
			top:"100px",
			height:h + "px"
		});

		this.updateListHeight();
	}
};

}(jQuery));
