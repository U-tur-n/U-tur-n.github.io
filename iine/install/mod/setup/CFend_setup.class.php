<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CFend_setup extends CObject {

	public function init() {
		$this->unbind("CBaseTpl","hd_BodyHeader");
		$this->unbind("CBaseTpl","hd_BodyFooter");
		$this->unbind("CBaseTpl","hd_Body");

		$this->bind("hd_HtmlHead");
		$this->bind("hd_BodyHeader");
		$this->bind("hd_BodyFooter");
		$this->bind("hd_Body");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();

		$lca_ai = CEnv::locale("app/info");
		$lca_inst = CEnv::locale("install/install");
		$this->title = $lca_ai["app:name-version"] . " " . $lca_inst["installation"];
		include( dirname(__FILE__) . "/tpl.html.head.inc.php" );
	}

	public function hd_BodyHeader( $prt ) {
		$lca_ai = CEnv::locale("app/info");
		$lca = CEnv::locale("install/install");
		$title = $lca_ai["app:name"] . " " .
			'<span style="font-size:80%;">' . $lca_ai["app:version"] . "</span> " .
			$lca["installation"];
		include( dirname(__FILE__) . "/tpl.body.header.inc.php" );
	}

	public function hd_Body( $prt ) {
		if ( !CAppReq::check() ) {
			CAppReq::showErrMsgBox();
			exit;
		}
		include( dirname(__FILE__) . "/tpl.page.start.inc.php" );
	}

	public function hd_BodyFooter( $prt ) {
		$lca_ai = CEnv::locale("app/info");
		include( dirname(__FILE__) . "/tpl.body.footer.inc.php" );
	}

}

?>