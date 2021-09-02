<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CLoader {

	private static function printLoader( $cfg ) {
		$lca = CEnv::locale("app/info");
		echo "/* ".$lca["app:name-version"] . " */\r\n";
		echo "(function( cfg ){";
		include(CAjaxTool::pathMinJs(
			dirname(dirname(__FILE__))."/js/",
			"loader.min.js")
		);
		echo "}(" . CAjaxTool::getConfig($cfg) . "));";
	}

	public static function run() {
		CAjaxTool::printHeader();

		//-- load ajax config
		$cfg = CEnv::config("client/ajax");
		$cfg["appcfg"] = array_merge(
			$cfg["appcfg"],
			array(
				"url_server"=>CEnv::urlClient() . "server.php",
			)
		);

		//-- min.js or .js
		if ( !isset($cfg["url_js2"]) ) {
			$cfg["url_js2"] = CAjaxTool::urlMinJs(
				CEnv::pathClient()."js/",
				CEnv::urlClient()."js/",
				$cfg["fn_js2"]);
		}

		//-- send loader
		self::printLoader($cfg);
	}

}

?>