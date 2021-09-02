<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CBend_setup extends CBend_crud {

	public function init() {
		$this->bind("hd_goto_page2");
		$this->bind("hd_goto_page3");
		$this->bind("hd_goto_page4");
	}

	private function outputPageTpl( $data, $tpl ) {
		self::obStart();
		include( $this->pathMod() . "tpl.page.{$tpl}.inc.php" );
		$html = self::obEnd();

		//-- resp
		$data->resp["html"] = $html;
		$this->ret($data);
	}

	public function hd_goto_page2( $data ) {
		$this->outputPageTpl( $data, "permcheck" );
	}

	public function hd_goto_page3( $data ) {
		$this->outputPageTpl( $data, "dbsetup" );
	}

	public function hd_goto_page4( $data ) {
		//-- CDBSetup
		$data->path_sql = self::pathMod() . "sql/sql.txt";
		if ( !CDBSetup::process( $data ) ) {
			$this->ret($data);
			return;
		}

		//-- application setup
		CAppSetup::run($data);

		//-- output template
		$this->outputPageTpl( $data, "done" );
	}

}

?>