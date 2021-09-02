<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

include_once( dirname(dirname(__FILE__)) . "/config/config.env.inc.php" );
include_once( dirname(dirname(__FILE__)) . "/lib/sys/index.inc.php" );
include_once( dirname(__FILE__) . "/include/index.inc.php" );

CEnv::useLib("app");
CEnv::useLib("client");
CEnv::useLib("poll");

CPreProc::reverseMagicQuote();
CEnv::setUrlRoot( dirname(dirname(CPreProc::getCurrentPageUrl())) . "/" );

?>