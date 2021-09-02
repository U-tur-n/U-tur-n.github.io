<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CServer {

	public static function run() {
		CComponent::setupCmp("client");

		$requ = CJson::decode($_REQUEST["requ"]);
		$resp = array("result"=>"OK");

		$data = new CCMSData();
		$data->requ =& $requ;
		$data->resp =& $resp;

		CComponent::registerPcfClass("app",$data);
		$app = CComponent::getPcfClass("CApp");
		$app->run($data);
	}

}

?>