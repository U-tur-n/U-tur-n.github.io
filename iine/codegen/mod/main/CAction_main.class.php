<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CAction_main extends CAction {

	public function main() {
		$cfg = CEnv::config("admin/app");
		header('Location: ' . CApp::vurl($cfg["app-title-link"]) );
		exit;
		//CSess::exitSess();
	}

}

?>