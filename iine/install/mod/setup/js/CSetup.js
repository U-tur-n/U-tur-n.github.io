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

CSetup = {

	jqo_page : {},

	init : function( opt ) {
		for ( var key in opt ) { this[key] = opt[key]; }

		var _this = this;

		this.jqo_page[1] = this.jqo_page1;
		this.jqo_btn_start = this.jqo_page[1].find(".btn-start");

		this.cajax = new CCAjax();
		this.jms = new CJMS();

		//-- start
		this.jqo_btn_start.click( function(e){
			e.preventDefault();
			_this.pc_goto_page(2);
		});

	},

	form2wdata : function( idx ) {
		var form = CForm.get(this.jqo_page[idx]);
		var page_key = this.jqo_page[idx].find("input[name='page-key']").val();
		var json = JSON.parse($("#wdata").val());
		json[page_key] = form;
		$("#wdata").val(JSON.stringify(json));
		return form;
	},

	wdata2form : function( idx ) {
		var form = null;
		var page_key = this.jqo_page[idx].find("input[name='page-key']").val();
		var json = JSON.parse($("#wdata").val());
		if ( page_key in json ) {
			form = json[page_key];
			CForm.set(this.jqo_page[idx],form);
		}
		return form;
	},

	pc_goto_page : function( idx ) {

		var form = this.form2wdata(idx-1);

		var requ = {
			cmd:"goto_page"+idx,
			form:form,
			wdata:$("#wdata").val()
		};
		this.cajax.send(requ,this,function(resp){
			if ( CFRes.execute(resp,this.jqo_page[idx-1]) ) {
				if ( this.jqo_page[idx] ) {
					this.jqo_page[idx].remove();
				}
				this.jqo_page[idx] = $("<div>")
					.attr("class","page"+idx)
					.html(resp.html);

				this.jqo_page[idx-1]
					.after(this.jqo_page[idx])
					.hide();

				var _this = this;
				this.jqo_page[idx].find(".btn-back").click( function(e){
					e.preventDefault();
					_this.pc_backto_page(idx-1);
				});
				this.jqo_page[idx].find(".btn-next").click( function(e){
					e.preventDefault();
					_this.pc_goto_page(idx+1);
				});
				this.jqo_page[idx].find(".btn-reload").click( function(e){
					e.preventDefault();
					_this.pc_goto_page(idx);
				});

				this.wdata2form(idx);
			}
		});
	},

	pc_backto_page : function( idx ) {
		this.form2wdata(idx+1);
		this.jqo_page[idx].show();
		this.jqo_page[idx+1].hide();
	}

};

$(document).ready(function(){
	CSetup.init({ jqo_page1: $(".page1") });
});

}(jQuery));
