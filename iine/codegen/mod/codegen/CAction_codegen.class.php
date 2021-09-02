<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CAction_codegen extends CAction {

	public function main() {

		if ( self::isFend() ) {
			self::load(array(
				"btpl/CBaseTpl",
				"fbc/CFend",
				"inppvbtn/CFend_inppvbtn",
				"inpcopy2clip/CFend_inpcopy2clip",
				"~/CFend_codegen",
				"btpl/CMPage",
			));
		} else {
			self::load(array(
				"fbc",
				"inppvbtn/CBend_inppvbtn",
				"~/CBend_codegen",
				"fbc/CSAjax",
			));
		}
	}

}

?>