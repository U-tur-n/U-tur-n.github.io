<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

$cfg["appcfg"] = array(
	//-- script version
	"version" => "2.23",
	//-- the class name of a <div> instance
	"cls_selector" => "ajax-iine",
	//-- the id prefix for <style>
	"prefix_css" => "lkbnx-css-",
	//-- the id prefix for <script>
	"prefix_js" => "lkbnx-js-",
);

//$cfg["url_js1"] = "http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js";
//$cfg["url_js1"] = "http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js";
$cfg["url_js1"] = CEnv::urlClient() . "js/jquery-1.2.6.js";
/* inclusive version range check */
/* 2.2.4 is the last version of 2.x.x */
$cfg["jq_min_ver"] = "1.2.6";
$cfg["jq_max_ver"] = "2.2.4";

$cfg["url_js2"] = CEnv::urlClient() . "client.php";
$cfg["app_main"] = "runAjaxIineButton";

?>