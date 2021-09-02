<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

include_once( dirname(__FILE__) . "/startup.inc.php" );

//-- routing
$_rtc = array();
CSRouter::setupRtc($_rtc,__FILE__);

if ( !CSRouter::main($_rtc) ) {
	C404Page::main();
	header("HTTP/1.0 404 Not Found");
	exit();
}

?>