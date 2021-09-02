<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CClient {

	private static function obStart() {
		ob_start();
	}

	private static function obEnd() {
		$s = ob_get_contents();
		if ( !empty($s) ) {
			ob_end_clean();
		}
		return $s;
	}

	private static function makeSource( $js ) { ?>
"use strict";
window.runAjaxIineButton = function( $, appcfg ) {

	<?php echo CComponent::jscode($js,"base"); ?>

	var CAppCMS = this.CAppCMS = new CCMS("CAppCMS");

	<?php echo CComponent::jscode($js,"app"); ?>

	<?php echo CComponent::jscode($js,"poll"); ?>

	$(document).ready(function(){
		CApp.run();
	});

};
<?php }

	public static function run() {
		CAjaxTool::printHeader();

		//-- compile js for "client"
		CComponent::setupCmp("client");
		$js = CComponent::buildReso("js");

		//-- script name
		$lca = CEnv::locale("app/info");
		echo "/* ".$lca["app:name-version"] . " */\r\n";

		//-- start output buffer
		self::obStart();

		//-- source
		self::makeSource($js);

		//-- end output buffer
		$txt = self::obEnd();

		//-- compress
		$txt = CCompact::js($txt);

		//-- output
		echo $txt;
	}

}

?>