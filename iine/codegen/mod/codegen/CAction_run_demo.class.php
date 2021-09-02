<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CAction_run_demo extends CAction {

	public function main() {
		$pid = isset($_REQUEST["pid"]) ? $_REQUEST["pid"] : "";
		$tid = isset($_REQUEST["tid"]) ? $_REQUEST["tid"] : "";
		CInstCode::setup( $pid, $tid );
		$txt = CInstCode::getDemoSrc();

		if ( CMobile::isMobile() ) {
			$code1=<<<_EOM_
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
_EOM_;
			$code2=<<<_EOM_
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
_EOM_;
			$txt = str_replace($code1,$code2,$txt);
		}

		echo $txt;
	}

}

?>