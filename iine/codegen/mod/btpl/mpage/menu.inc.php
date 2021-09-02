<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

$lca_info = CEnv::locale("app/info");
$lca = CEnv::locale("codegen/menu");

$items1 = array();

$items1["phpkobo"] = array(
	"rtp"=>$lca_info["app:home:url"] . "?pid=" . $lca_info["app:pid"],
	"target"=>"_blank",
	"title"=>"<span class='glyphicon glyphicon-home'></span> " .
		$lca["label:home"],
	"roll"=>array("public"),
);

//-- doc
$doc = array(
	"items"=>$items1,
);

?>