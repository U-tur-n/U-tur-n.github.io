<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CBend_codegen extends CBend_crud {

	public function init() {
		$this->bind("hd_gen_code");
	}

	protected function validate( $data ) {

		//-- locale
		$lca = CEnv::locale( "codegen/validate" );

		//-- vali macro
		CValiMacro::setup($data, $lca);
		CValiMacro::vStr("pid");
		CValiMacro::vStr("tid");
	}

	public function hd_gen_code( $data ) {
		$data->vx = array();
		$data->fm = $data->requ["form"];

		//-- validate
		$this->validate( $data );
		if ( !CFRes::isValidated() ) {
			$this->ret($data);
			return;
		}

		$pid = $data->vx["pid"];
		$tid = $data->vx["tid"];
		CInstCode::setup( $pid, $tid );

		self::obStart();
		CInstCode::printCss();
		include("tpl.code.inc.php");
		$html = self::obEnd();

		//-- resp
		$data->resp["html"] = $html;
		$this->ret($data);
	}

}

?>