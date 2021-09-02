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

function CInpPvBtn( opt ) {
	for( var key in opt ) { this[key] = opt[key]; }
	this.setup();
};

CInpPvBtn.prototype = {

	setup : function() {
		var _this = this;

		var dtype = this.jqo_inp.attr("data-type");
		var jqo_prt = this.jqo_inp.parents(".form-group");
		this.jqo_preview = jqo_prt.find(".inppvbtn-preview");
		this.jqo_preview_css = this.jqo_preview.find(".inppvbtn-preview-css");
		this.jqo_preview_header = this.jqo_preview.find(".inppvbtn-preview-header");
		this.jqo_preview_body = this.jqo_preview.find(".inppvbtn-preview-body");
		this.jqo_btn_sel = jqo_prt.find(".btn-inppvbtn-sel");

		CDlgPvBtn.setup({dtype:dtype});

		this.jqo_btn_sel
			.click(function(e){
				e.preventDefault();
				CDlgPvBtn.open({
					jqo_ctar:$(".dlgpvbtn"),
					data:_this.data,
					dtype:dtype,
					onOK:function( data ){
						_this.pc_ok(data);
					},
					onCancel:function(){
						_this.jqo_preview.focus();
					}
				});
			});

		this.jqo_preview_body
			.click(function(e){
				_this.jqo_btn_sel.click();
			});

		//-- set data
		this.setData(this.jqo_inp.val().trim());
	},

	pc_ok : function( data ) {
		this.setVal(data);
		var jqo = this.jqo_preview;
		jqo
			.focus()
			.addClass("inppvbtn-preview-flash");
		setTimeout(function(){
			jqo.removeClass("inppvbtn-preview-flash");
		},2000);
	},

	setVal : function(data) {
		this.setData(data);
		this.updateInput();
		this.updatePreview();
	},

	setData : function( data ) {
		this.data = data;
	},

	updateInput : function() {
		this.jqo_inp.val(this.data);
	},

	updatePreview : function() {
		var jqo = $(".dlgpvbtn-box[data-key='"+this.data+"']");
		this.jqo_preview_header.html(jqo.find(".dlgpvbtn-box-header").html());
		this.jqo_preview_body.html(jqo.find(".dlgpvbtn-box-body").html());
		this.jqo_preview_css.html($(".inppvbtn-css-"+this.data).clone());
	}

};

window.initCInpPvBtn = function() {
	$(".inppvbtn").each( function(){
		if ( !$(this).data("_obj_") ) {
			var obj = new CInpPvBtn({jqo_inp:$(this)});
			$(this).data("_obj_",obj);
		}
	});
};

}(jQuery));
