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

CCodeGen = {

	createRandomString : function ( n ) {
		var s = "";
		var pat = "abcdefghijklmnopqrstuvwxyz0123456789";

		for( var i=0; i < n; i++ ) {
			s += pat.charAt(Math.floor(Math.random() * pat.length));
		}

		return s;
	},

	init : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;

		this.jqo_ctar_form = this.jqo_ctar.find(".ctar-form");
		this.jqo_pid = this.jqo_ctar.find("input[name='pid']");
		this.jqo_btn_gen_pid = this.jqo_ctar.find(".btn-gen-pid");
		this.jqo_btn_enter_memo = this.jqo_ctar.find(".btn-enter-memo");
		this.jqo_btn_gen_code = this.jqo_ctar.find(".btn-gen-code");

		this.cajax = new CCAjax();

		this.jqo_btn_gen_pid.click(function(e){
			e.preventDefault();
			_this.pc_btn_gen_pid();
		});

		this.jqo_btn_enter_memo.click(function(e){
			e.preventDefault();
			_this.pc_btn_enter_memo();
		});

		this.jqo_btn_gen_code.click(function(e){
			e.preventDefault();
			_this.pc_btn_gen_code(); 
		});

		//-- page init
		CPageStack.init(this.jqo_ctar);

		//-- init components
		initCInpPvBtn();
	},

	setPidInputBox : function( str ) {
		this.jqo_ctar.find("input[name='pid']")
			.val(str)
			.select()
			.addClass("blink");

		var _this = this;
		setTimeout(function(){
			_this.jqo_ctar.find("input[name='pid']")
				.removeClass("blink");
		},1000);
	},

	pc_btn_gen_pid : function() {
		var str = this.createRandomString(20);
		this.setPidInputBox(str);
	},

	pc_btn_enter_memo : function() {
		var lca = CJRLdr.locale("codegen/reminder");
		var str = lca["text:enter-key-here"];
		this.setPidInputBox(str);
	},

	pc_btn_gen_code : function() {
		var form = CForm.get(this.jqo_ctar_form);
		var requ = {
			cmd:"gen_code",
			form:form
		};
		this.cajax.send(requ,this,function(resp){
			if ( CFRes.execute(resp,this.jqo_ctar_form) ) {
				var jqo = CPageStack.pushPage( resp.html );
				initCInpCopy2Clip();
				CScrollBtn.update();

				var _this = this;
				jqo.find(".btn-back").click( function(e){
					e.preventDefault();
					CPageStack.popPage();
					CScrollBtn.update();
				});
			}
		});
	}

};

$(document).ready(function(){
	CCodeGen.init({jqo_ctar:$(".spage-form")});
});

}(jQuery));
