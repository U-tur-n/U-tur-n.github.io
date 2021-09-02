<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

$mods = array();

//-- default entry
$mods["main"] = array(
	"vrtp"=>"/^$/",
);

//-- bootstrap template
$mods["btpl"] = null;

//-- application pages
$mods["codegen"] = null;
$mods["run-demo"] = array(
	"dir"=>"codegen"
);
$mods["inppvbtn"] = null;

?>